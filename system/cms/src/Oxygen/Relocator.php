<?php namespace Oxygen;

class Relocator 
{
	static protected function RelocateIf( $condition=true , $redirect_url = '/', $status='error',$message='' )
	{
		if($condition)
		{
			if($status!=null)
				get_instance()->session->set_flashdata($status,$message);
			
			redirect($redirect_url);
		}
	}	
}