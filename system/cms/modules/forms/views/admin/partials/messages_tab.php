<!-- Form meta data and messages-->
<div class="box-body">
	<label for="form_email" class='text-red'>
		Error URL
	</label>
	<div class="input">
		<?php echo form_input('redir_error', $metadata->redir_error, 'placeholder="Redirect to on error" class="form-control" autocomplete="off" id="redir_error"'); ?>
	</div>


	<label for="form_email" class='text-red'>
		Error Message
	</label>
	<div class="input">
		<?php echo form_input('msg_error', $metadata->msg_error, 'placeholder="Message on error input" class="form-control" autocomplete="off" id="msg_error"'); ?>
	</div>
</div>