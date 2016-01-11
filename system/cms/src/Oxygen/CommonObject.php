<?php namespace Oxygen;

abstract class CommonObject 
{
	function talk()
	{
		echo "You are talking to " . get_class($this);
	}
}