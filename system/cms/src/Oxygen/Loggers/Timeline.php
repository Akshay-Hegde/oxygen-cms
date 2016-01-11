<?php namespace Oxygen\Loggers;

class Timeline 
{
	protected $_icon = '';
	protected $_color = '';	
	protected $_name = '';	
	protected $_message = '';
	protected $_userid = null;



	public function __construct() 
	{
		$this->_icon = 'fa fa-edit';
		$this->_color = 'blue';	
		$this->_name = '';	
		$this->_message = '';
		$this->_userid = null;
	}

	//$this->timeline->icon('pages')->user(1)->name('Authentication')->message('User has logged in')->commit();

	/**
	 * Set the icon to use for ui display
	 */
	public function icon($icon)
	{
		$icon_to_use ='fa fa-edit';
		switch($icon) {
			case 'usergroup':
				$icon_to_use ='fa fa-users';	
				break;		
			case 'user':
				$icon_to_use ='fa fa-user';
				break;
			case 'cart':
				$icon_to_use ='fa fa-shopping-cart';
				break;
			case 'page':				
			case 'edit':
				$icon_to_use ='fa fa-pencil-square-o';
				break;				
			case 'add':				
			case 'plus':
				$icon_to_use ='fa fa-plus';
				break;
			case 'minus':
				$icon_to_use ='fa fa-minus';
				break;				
			case 'mail':
				$icon_to_use ='fa fa-envelope';
				break;
			case 'message':
				$icon_to_use ='fa fa-comment-o';
				break;
			case 'key':
				$icon_to_use ='fa fa-key';
				break;			
			case 'folder':
				$icon_to_use ='fa fa-folder-o';
				break;			 																		
		}

		$this->_icon = $icon_to_use;
		return $this;
	}

	public function user($user)
	{
		$this->_userid = $user;
		return $this;
	}

	public function name($name)
	{
		$this->_name = $name;
		return $this;
	}

	public function color($color)
	{
		$this->_color = $color;
		return $this;
	}


	public function message($message)
	{
		$this->_message = $message;
		return $this;
	}

	public function commit()
	{
		$date = new \DateTime( 'now',  new \DateTimeZone( 'UTC' ) );
		$date->setTimestamp($date->getTimestamp());

		//write log
		$input=[];
		$input['name'] = $this->_name;
		$input['icon'] = $this->_icon;
		$input['color'] = $this->_color;
		$input['description'] = $this->_message;
		$input['user_id'] = $this->_userid;
		//$input['actions'] = self::$ACTIONS;

		$input['tl_timestamp'] 	= $date->getTimestamp();
		$input['tl_datetime'] 	= $date->format('Y-m-d h:i:s');
		$input['tl_day']		= $date->format('ymd');
		$input['tl_date']		= $date->format('d M');
		$input['tl_time']		= $date->format('g:i a');

		//now log message
		get_instance()->db->insert('timeline',$input);

		//do not return the obj, just bool
		return true;
	}	
}