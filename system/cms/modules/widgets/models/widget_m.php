<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Model to handle widgets
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Widgets\Models
 */
class Widget_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('date');
	}

	public function get_all_areas()
	{
		return $this->db->get('widget_areas')->result();
	}

	public function create_area($widget_name,$widget_slug)
	{

		if(trim($widget_slug)=='')
		{
			$this->load->helper('inflector');
			$widget_slug = slugify($widget_name);
		}

		//if not, lets go
		return $this->db->insert('widget_areas', 
			[
				'name' 		=> $widget_name,
				'slug' 		=> $widget_slug,
			]
		);
	}

	public function update_area($area_id, $widget_name ='',$widget_slug='')
	{
		if(trim($widget_slug)=='')
		{
			$this->load->helper('inflector');
			$widget_slug = slugify($widget_name);
		}

		//if not, lets go
		return $this->db->where('id',$area_id)->update('widget_areas', 
			[
				'name' 		=> $widget_name,
				'slug' 		=> $widget_slug,
			]
		);
	}

	public function delete_area( $area_id = null )
	{
		//delete all instances where the area-id matches the area-id we are dleteing
		if($this->db->where('area_id',$area_id)->delete('widget_instances'))
		{
			return $this->db->where('id',$area_id)->delete('widget_areas');
		}

		return false;	
	}

	public function get_area( $area_id = null )
	{

		return $this->db->where('id',$area_id)->get('widget_areas')->row();

	}

	/**
	 * Get all instances
	 */
	public function get_all_instances()
	{
		return $this->db->get('widget_instances')->result();
	}
	
	public function get_instances_by_widget($widget_id)
	{
		return $this->db->where('widget_id',$widget_id)->get('widget_instances')->result();
	}

	public function get_instance($id)
	{
		$this->db
			->select('w.id, w.slug, wi.id as instance_id, wi.area_id, wi.name as instance_name, wi.title as instance_title, w.title, wi.options')
			->from('widget_instances wi')
			->join('widgets w', 'wi.widget_id = w.id')
			->where('wi.id', $id);

		$result = $this->db->get()->row();

		if ($result)
		{
			$this->unserialize_fields($result);
		}

		return $result;
	}

	public function get_instance_by_name($name)
	{
		$this->db
			->select('w.id,  w.slug, wi.id as instance_id, wi.area_id, wi.name,wi.title as instance_title, w.title, wi.options')
			->from('widget_instances wi')
			->join('widgets w', 'wi.widget_id = w.id')
			->where('wi.name', $name);

		$result = $this->db->get()->row();

		if ($result)
		{
			$this->unserialize_fields($result);
		}

		return $result;
	}
	public function get_by_area($area_id)
	{
		$this->db
			->select('w.id,  w.slug, wi.id as instance_id, wi.area_id, wi.name,wi.title as instance_title, w.title, wi.options')
			->from('widget_instances wi')
			->join('widgets w', 'wi.widget_id = w.id')
			->where('wi.area_id', $area_id);

		$result = $this->db->get()->result();

		if ($result)
		{
			$this->unserialize_fields($result);
		}

		return $result;
	}
	public function get_by_area_slug($area_slug)
	{
		// get the area row
		if($area = $this->db->where('slug',$area_slug)->get('widget_areas')->row())
		{

			return $this->get_by_area($area->id);
		}
		return [];
	}
	/**
	 * Get a widget by whatever
	 */
	public function get_widget_by($field, $id)
	{
		$result = $this->db->get_where('widgets', array($field => $id))->row();

		if ($result)
		{
			$this->unserialize_fields($result);
		}

		return $result;
	}

	/**
	 * hmm
	 */
	public function unserialize_fields($obj)
	{
		foreach (array('title', 'description') as $field)
		{
			if (isset($obj->{$field}))
			{

				$_field = @unserialize($obj->{$field});

				if ($_field === false)
				{
					isset($obj->slug) && $this->widgets->reload_widget($obj->slug);
				}

				else
				{
					$obj->{$field} = is_array($_field)
						? isset($_field[CURRENT_LANGUAGE])
							? $_field[CURRENT_LANGUAGE] : $_field['en']
						: $_field;
				}
			}
		}

		return $obj;
	}

	/**
	 * hmm
	 */
	public function get_all()
	{

		$this->db->order_by('order');

		$result = parent::get_all();

		if ($result)
		{
			array_map(array($this, 'unserialize_fields'), $result);
		}

		return $result;
	}
	
	public function get_all_enabled()
	{
		//
		$this->db->where('enabled', 1)->order_by('order');
		$this->db->order_by('order');

		$result = parent::get_all();

		if ($result)
		{
			array_map(array($this, 'unserialize_fields'), $result);
		}

		return $result;
	}
	/**
	 * hmm
	 */
	public function insert_widget($input = array())
	{
		// Merge defaults
		$input = array_merge(array(
			'enabled' => 1
		), (array) $input);

		$last_widget = $this->db
			->select('`order`')
			->order_by('`order`', 'desc')
			->limit(1)
			->get_where('widgets', array('enabled' => $input['enabled']))
			->row();

		$input['order'] = isset($last_widget->order) ? $last_widget->order + 1 : 1;

		return $this->db->insert('widgets', array(
			'title' 		=> serialize($input['title']),
			'slug' 			=> $input['slug'],
			'description' 	=> serialize($input['description']),
			'author' 		=> $input['author'],
			'website' 		=> $input['website'],
			'version' 		=> $input['version'],
			'enabled' 		=> $input['enabled'],
			'order' 		=> $input['order'],
			'updated_on'	=> now()
		));
	}

	public function update_widget($input)
	{
		if ( ! isset($input['slug']))
		{
			return false;
		}

		return $this->db
			->where('slug', $input['slug'])
			->update('widgets', array(
				'title' 		=> serialize($input['title']),
				'slug' 			=> $input['slug'],
				'description' 	=> serialize($input['description']),
				'author' 		=> $input['author'],
				'website' 		=> $input['website'],
				'version' 		=> $input['version'],
				'updated_on'	=> now()
			));
	}

	public function update_widget_order($id, $order)
	{
		$this->db->where('id', $id);

		return $this->db->update('widgets', array(
        	'order' => (int) $order
		));
	}

	public function enable_widget($id = 0)
	{
		return $this->db->where('id', $id)->update('widgets', 
			[
        	'enabled' => 1
			]
		);
	}

	public function disable_widget($id = 0)
	{
		return $this->db->where('id', $id)->update('widgets', 
			[
        	'enabled' => 0
			]
		);
	}

	public function insert_instance($input)
	{
		$this->load->helper('date');

		$order = time();

		return $this->db->insert('widget_instances', 
			[
				'name'				=> $input['name'],
				'area_id'			=> $input['area_id'],
				'title'				=> $input['title'],
				'description'		=> '', //$input['description'],
				'widget_id'			=> $input['widget_id'],
				'options'			=> $input['options'],
				'order'				=> $order,
				'created_on'		=> now(),
			]
		);
	}

	public function update_instance($instance_id, $input)
	{
		$this->db->where('id', $instance_id);

		return $this->db->update('widget_instances', 
			[
	        	'name'				=> $input['name'],
	        	'area_id'			=> $input['area_id'],
	        	'title'				=> $input['title'],
				'options'			=> $input['options'],
				'updated_on'		=> now()
			]
		);
	}

	public function update_instance_order($id, $order)
	{
		$this->db->where('id', $id);

		return $this->db->update('widget_instances', 
			[
        		'order' => (int) $order
			]
		);
	}

	public function delete_widget($slug)
	{
		$widget = $this->db
			->select('id')
			->get_where('widgets', array('slug' => $slug))
			->row();

		if (isset($widget->id))
		{
			$this->db->delete('widget_instances', array('widget_id' => $widget->id));
		}

		return $this->db->delete('widgets', array('slug' => $slug));
	}

	public function delete_instance($id)
	{
		return $this->db->delete('widget_instances', array('id' => $id));
	}
}
