<?php 


//
// See if we need to display options/buttons
//
 if (isset($buttons) && is_array($buttons))
 {


		$btn_class = 'btn btn-flat ';

		//
		// Setup meta-info for later on
		//
		$buttons_array = [];

		$button_count = count($buttons);;
	

		foreach ($buttons as $key => $button):

			$extra	= NULL; 
			$button	= ! is_numeric($key) && ($extra = $button) ? $key : $button; 

			switch ($button):

				case 'delete': 		
					$butn = '<button type="submit" name="btnAction" value="delete" class="btn bg-red btn-flat confirm">';
					$butn .= '<span>'.lang('buttons:delete').'</span>';
					$butn .= '</button>';								
					break;
				case 're-index':
					$butn 	= '<button type="submit" name="btnAction" value="re-index" class="btn btn-flat bg-blue">';
					$butn  .= '<span>'.lang('buttons:re-index').'</span>';
					$butn  .= '</button>';			
					break;
				case 'activate':
				case 'deactivate':
				case 'approve':
				case 'unapprove':
				case 'upload':
					$butn 	= '<button type="submit" name="btnAction" value="'.$button.'" class="btn btn-flat bg-blue">';
					$butn  .= '<span>'.lang("buttons:" . $button).'</span>';
					$butn  .= '</button> ';				
					break;	
				case 'save':
				case 'save_exit':
				case 'publish_save':
					$butn 	= '<button type="submit" name="btnAction" value="'.$button.'" class="btn btn-flat bg-green">';
					$butn  .= '<span>'.lang("buttons:" . $button).'</span>';
					$butn  .= '</button> ';
										
					break;
				case 'cancel':
					$do_drop = false;					
				case 'close':

					$uri = 'admin/' . $this->module_details['slug'];
					$active_section = $this->load->get_var('active_section');

					if ($active_section && isset($this->module_details['sections'][$active_section]['uri']))
					{
						$uri = $this->module_details['sections'][$active_section]['uri'];
					}
					$butn = anchor($uri, lang('buttons:' . $button), 'class="'.$btn_class. ' btn-default"');
					break;

				case 'preview':	
					if($btn_class == 'btn') $btn_class .= ' btn-default';
					$id = $this->uri->segment(4) ? $this->uri->segment(4) : $this->uri->segment(count($this->uri->segments));
					$uri = 'admin/' . $this->module_details['slug'].'/preview/'.$id;
					$butn = anchor($uri, lang('buttons:' . $button), 'class="'.$btn_class.'"');
					break;
				/**
				 * @var		$id scalar - optionally can be received from an associative key from array $extra
				 * @since	1.2.0-beta2
				 */
				case 'edit':
					$id = is_array($extra) && array_key_exists('id', $extra) ? '/' . $button . '/' . $extra['id'] : NULL;
					$butn = anchor('admin/' . $this->module_details['slug'] . $id, lang('buttons:' . $button), 'class="btn btn-flat bg-blue"');
					break; 
				case 'publish':
				case 'pull_down':		
					$id = $this->uri->segment(4) ? $this->uri->segment(4) : $this->uri->segment(count($this->uri->segments));

					$pushpullaction = ($button=='publish')?'/push_up/':'/pull_down/';
					$butn = anchor('admin/' . $this->module_details['slug'].$pushpullaction. $id, lang('buttons:' . $button), 'class="btn btn-flat bg-blue"');

					break; 
			endswitch; 

			//add the button
			$buttons_array[] = [ 'form' => $butn ];
			

		endforeach;


		foreach ($buttons_array as $key => $button):
			echo $button['form'] .' ';
		endforeach;
	

}
