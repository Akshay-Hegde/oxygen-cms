<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * Oxygen-CMS 
 *
 * @author Sal McDonald (2013-2016)
 *
 * @package OxygenCMS\Core\
 *
 *
 * @copyright  Copyright (c) 2013-2016
 * @copyright  Oxygen-CMS
 * @copyright  oxygen-cms.com
 * @copyright  Sal McDonald
 *
 * @contribs PyroCMS Dev Team, PyroCMS Community, Oxygen-CMS Community
 *
 */
class Timeline_library 
{
	static $TimeOrderFormat     = 'YmdH'; 
	const MAX_PER_ITEMGROUP     = 8;
	const MAX_DAYS_TO_COLLECT   = 20;

	public function __construct($params = [])
	{
		$this->timelineData=[];
	}

	public function __get($var)
	{
		if (isset(get_instance()->$var))
		{
			return get_instance()->$var;
		}
	}

	public function getTimelineData($user_id) 
	{
		
		$timelineData = $this->db
						->limit(self::MAX_DAYS_TO_COLLECT)
						->select('tl_day,tl_date')
						->where('user_id',$user_id)
						->order_by('tl_day','desc')
						->group_by('tl_date')
						->get('timeline')->result();

		foreach($timelineData as $key => $dateinfo) 
		{
			$timelineData[$key]->results = $this->db
					->limit(self::MAX_PER_ITEMGROUP)
					->select('actions,id,color,icon,tl_date AS date,tl_time AS time,description,name,tl_timestamp as timestamp')
					->where('user_id',$user_id)
					->where('tl_day',$dateinfo->tl_day)
					->order_by('tl_timestamp','desc')
					->get('timeline')->result(); 
		}

		return $timelineData;
	}

	public function importHistory() {
		//this function no longer is needed.
		//@todo, remove ref to this func
	}
}