
	<h4><?php echo lang('tasks:'.$this->method); ?></h4>


	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		

				<label for="name"><?php echo lang('tasks:name'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('name', set_value('name', $tasks->name), 'class="width-15"'); ?></div>

				<?php echo form_textarea('description',$tasks->description);?>

				<?php $pcnts = ['0'=>'0','20'=>'20','50'=>'50','70'=>'70','100'=>'100'] ;?>

				<?php echo form_dropdown('pcent',$pcnts, $tasks->pcent);?>

	
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>
