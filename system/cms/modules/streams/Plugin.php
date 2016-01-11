<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!class_exists("Plugin_Streams"))
{

	class Plugin_Streams extends Plugin
	{
		public $version = '1.0.0';

		public $name = 
		[
			'en' => 'Streams',
		];

		public $description = 
		[
			'en' => 'Get Stream information.',
		];

		/**
		 * Returns a PluginDoc array that PyroCMS uses 
		 * to build the reference in the admin panel
		 *
		 * All options are listed here but refer 
		 * to the Blog plugin for a larger example
		 *
		 * @todo fill the  array with details about this plugin, then uncomment the return value.
		 *
		 * @return array
		 */
		public function _self_doc()
		{
			$info = 
			[
				'your_method' => 
				[
					'description' => 
					[
						'en' => 'Displays some data from some module.'
					],
					'single' => true,
					'double' => false,
					'variables' => '',
					'attributes' => 
					[
						'order-dir' => 
						[
							'type' => 'flag',// Can be: slug, number, flag, text, array, any.
							'flags' => 'asc|desc|random',// flags are predefined values like this.
							'default' => 'asc',// attribute defaults to this if no value is given
							'required' => false,// is this attribute required?
						],
						'limit' => 
						[
							'type' => 'number',
							'flags' => '',
							'default' => '20',
							'required' => false,
						],
					],
				],
			];
		
			//return $info;
			return array();
		}

		public function __construct()
		{
			$this->load->driver('Streams');
			$this->load->config('streams/streams');
			$this->load->config('streams/flows');
			$this->namespace = $this->config->item('flows:namespace');
		}


		public function first()
		{
			$params = [];
			$params['limit'] = 1;
			$this->flow = $this->stream_slug = $this->attribute('flow', '');
			return $this->flow($params);
		}

		/*
		 * {{flows:flow where="field=value|"}}
		 *

		{{streams:flow slug=links.list_slug  with_meta='yes' namespace='lists' }}
			{{if exists =='yes' }}
				<div class='row'>
					{{results}}
						{{image:thumb_img}}
					{{/results}}
				</div>
			{{else}}
			Some html when no existing
			{{endif}}

		{{/streams:flow }}

		*/


		/**
		 * The default plugin that can be overloaded by parent classes
		 */
		public function flow(array $params = [])
		{

			$this->_where			= $this->attribute('where', '' );

			$this->namespace		= $this->attribute('namespace', $this->namespace );
			$this->field_prefix		= $this->attribute('prefix','');
			$this->stream_slug		= $this->attribute('slug','');
			$this->_display			= $this->attribute('display','');

			$this->with_meta 		= strtolower(trim($this->attribute('with_meta', 'no')));

			//init after we have some info
			$this->init();

			return $this->_flow($params);
		}

		//
		// Get the stream or flow
		//
		protected function init()
		{
			$this->stream = $this->streams_m->get_stream($this->stream_slug, true, $this->namespace);
		}

		/**
		 * Cant call directly
		 */
		protected function _flow( array $params)
		{

			//
			// If we dont have a stream, we still want to produce
			// the null output in same fashion/format as designer expects
			//
			if ( ! $this->stream)
			{
				return $this->_output([],'false');	
			}
		
			//
			// get the fields of the stream
			//
			$this->fields = $this->streams_m->get_stream_fields($this->stream->id);


			// Handle where clause
			if(trim($this->_where)!='')
			{
				$wheres = explode('|',$this->_where);
				foreach ($wheres as $k=>$value)
				{
					$field_val = explode('=',$value);

					if(count($field_val)>=2)
					{
					
						$_table = $this->stream->stream_prefix.$this->stream->stream_slug;
						$_table = '`'.$this->db->dbprefix($_table).'`.'.$field_val[0];
						$query = $_table.'='.$field_val[1];

						$params['where'][] = $query;
					}
				}	
			}

			$results 	= [];

			//$params['paginate'] = 'no';
			//$params['limit'] = 25;
			
			$this->rows = $this->row_m->get_rows($params, $this->fields, $this->stream);


			//
			// Re-name
			//
			foreach($this->rows as $row)
			{
				foreach($row as $row_index => $row_value)
				{
					$row_data = [];
					foreach($row_value as $key => $value)
					{
						$row_data[$this->field_prefix.$key] = $value;
					}
					$results[] = $row_data;
				}
			}

			$results =  $this->_output( $results,'true');

			return $results;

		}

		private function _output( array $results, $has_stream = 'true')
		{

			//
			// if we HTML_ALL is present, and no results, this lets us show the HTML
			// if not set (thats the default action) then we dont show the html code.
			//
	 		if(($this->_display=='HTML_ALL') AND ((count($results)<=0)))
	 		{
	 			return $this->content();
	 		}


			if($this->with_meta == 'debug')
			{
				return 
				[
					'has_stream'	=> $has_stream,
				];
			}

			if($this->with_meta == 'yes')
			{
				return 
				[
					[
						'results'		=> $results,
						'count'			=> count($results),
						'exists'		=> ((count($results)>0)?'yes':'no'),
					]
				];
			}


			//just return the array directly
			return $results;
					
		}	



		/**
		 * Field Function
		 * 
		 * Calls the plugin override function
		 */ 
		public function field()
		{
			$attr = $this->attributes();

			// Setting this in a separate var so we can unset it
			// from the array later that is passed to the parse_override function.
			$field_type = $attr['field_type'];

			// Call the field method
			if (method_exists($this->type->types->{$field_type}, 'plugin_override'))
			{
				// Get the actual field.
				$field = $this->fields_m->get_field_by_slug($attr['field_slug'], $attr['namespace']);

				if ( ! $field) return null;

				// We don't need these anymore
				unset($attr['field_type']);
				unset($attr['field_slug']);
				unset($attr['namespace']);

				return $this->type->types->{$field_type}->plugin_override($field, $attr);	
			}
		}

		/**
		 * Multiple Related Entries
		 *
		 * This works with the multiple relationship field
		 *
		 * @access	public
		 * @return	array
		 */
		public function multiple()
		{
			$rel_field      = $this->attribute('field');
			$entry_id       = $this->attribute('entry');
			$namespace      = $this->attribute('namespace');
			$base_namespace = $this->attribute('base_namespace');

			// If there isn't a namespace, we'll just use 'streams'
			// to see if that works.
			if ( ! $namespace) $namespace = $base_namespace;

			// -------------------------------------
			
			if ( ! $field = $this->fields_m->get_field_by_slug($rel_field, $base_namespace)) return 'fu';

			// Get the stream
			$join_stream = $this->streams_m->get_stream($field->field_data['choose_stream']);
			
			// Get the fields		
			$fields = $this->streams_m->get_stream_fields($join_stream->id);

			$stream = $this->streams_m->get_stream($this->attribute('stream'), true, $base_namespace);

			if ( ! $stream) return 'by';
			
			// Add the join_multiple hook to the get_rows function
			$this->row_m->get_rows_hook = array($this, 'join_multiple');
			$this->row_m->get_rows_hook_data = array(
				'join_table'  => $stream->stream_prefix . $stream->stream_slug . '_' . $join_stream->stream_slug,
				'join_stream' => $join_stream,
				'row_id'      => $this->attribute('entry')
			);
			
			$params = array(
				'arbitrary'        => $entry_id, // For the cache
				'namespace'        => $namespace,
				'stream'           => $join_stream->stream_slug,
				'limit'            => $this->attribute('limit'),
				'offset'           => $this->attribute('offset', 0),
				'id'               => $this->attribute('id', null),
				'date_by'          => $this->attribute('date_by', 'created'),
				'exclude'          => $this->attribute('exclude'),
				'show_upcoming'    => $this->attribute('show_upcoming', 'yes'),
				'show_past'        => $this->attribute('show_past', 'yes'),
				'year'             => $this->attribute('year'),
				'month'            => $this->attribute('month'),
				'day'              => $this->attribute('day'),
				'restrict_user'    => $this->attribute('restrict_user', 'no'),
				'where'            => $this->attribute('where', null),
				'exclude'          => $this->attribute('exclude', null),
				'exclude_by'       => $this->attribute('exclude_by', 'id'),
				'disable'          => $this->attribute('disable', null),
				'order_by'         => $this->attribute('order_by'),
				'sort'             => $this->attribute('sort', 'asc'),
				'exclude_called'   => $this->attribute('exclude_called', 'no'),
				'paginate'         => $this->attribute('paginate', 'no'),
				'pag_segment'      => $this->attribute('pag_segment', 2),
				'partial'          => $this->attribute('partial', null)
			);

			$rows = $this->row_m->get_rows($params, $fields, $join_stream);

			return $rows['rows'];
		}


		/**
		 * Join multiple
		 *
		 * Multiple join callback
		 *
		 * @access	public
		 * @param	array - array of settings
		 * @return	void
		 */
		public function join_multiple($data)
		{
			$this->row_m->sql['join'][] = "LEFT JOIN `{$this->db->dbprefix($data['join_table'])}` ON `{$this->db->dbprefix($data['join_table'])}`.`{$data['join_stream']->stream_slug}_id` = `{$this->db->dbprefix($data['join_stream']->stream_prefix.$data['join_stream']->stream_slug)}`.`id`";
			$this->row_m->sql['where'][] = "`{$this->db->dbprefix($data['join_table'])}`.`row_id` = '{$data['row_id']}'";
		}

	}
}