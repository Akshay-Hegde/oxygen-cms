<?php defined('BASEPATH') or exit('No direct script access allowed');


class Field_global_regions
{
	public $field_type_slug			= 'global_regions';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0.0';

	public $author					= array('name' => 'Store Dev Team', 'url' => 'http://oxygen-cms.com');
	
	//valid options are alpha2,alpha3,numeric
	public $custom_parameters		= array('dv','group');


   
	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data, $entry_id, $field)
	{
		$value = $data['value'];
		
		//var_dump($data);die;
		$myoptions = $data['custom'];
		if(	isset($myoptions['dv']) )
		{
			$type = $myoptions['dv']; 
		}	
		else
		{
			$type = 'Europe'; 
		}
		if(	isset($myoptions['group']) )
		{
			$group_type = $myoptions['group']; 
		}	
		else
		{
			$group_type = 'simple'; 
		}		

		$regions = ($group_type =='uncg')? $this->united_nations_country_grouping : $this->regions ;

		return form_dropdown($data['form_slug'], $regions , $value, 'id="'.$data['form_slug'].'"');
	}




	public function param_dv($value = null)
	{	
		return form_dropdown('dv', $this->regions, $value);
	}

	public function param_group($value = null)
	{	
		if(	! isset($value) )
		{
			$value = 'simple'; 
		}		

		return form_dropdown('group', $this->groups, $value);
	}	

	protected $regions =  array(
			'Europe' => 'Europe',
			'Americas' => 'Americas',
			'Africa' => 'Africa',		
			'Asia' => 'Asia',	
			'Oceania' =>'Oceania',
	);

	protected $groups =array(
		'uncg' =>'uncg',
		'simple' => 'simple',
	);

	protected $united_nations_country_grouping = array(
		    'Africa' => 'Africa',
		    'Asia' => 'Asia',
		    'Central America' =>'Central America',
		    'Eastern Europe' =>'Eastern Europe' ,
		    'European Union' => 'European Union',
		    'Middle East' =>  'Middle East',
		    'North America' => 'North America',
		    'Oceania' =>'Oceania',
		    'South America' =>'South America' ,
		    'The Caribbean' =>'The Caribbean'
	);

}