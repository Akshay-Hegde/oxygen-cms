<?php namespace Oxygen\Models;

use Oxygen\Models\Model;
 
/**
 * @author Sal McDonald
 */
class StreamModel extends \Oxygen\Models\Model {

	/**
	 * @constructor
	 */
	public function __construct() {
		parent::__construct();
	}

	public static function GetStreamFields($stream,$stream_namespace) {
		get_instance()->load->driver('Streams');		
		return get_instance()->streams->streams->get_assignments($stream, $stream_namespace);
	}

}