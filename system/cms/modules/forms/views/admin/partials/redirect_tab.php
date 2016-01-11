	           		<!-- Stream data and notify info (metadata)-->
					<div class="box-body">

						<label for="form_email" class='text-success'>
							Success URL
						</label>
						<div class="input">
							<?php echo form_input('redir_success', $metadata->redir_success, 'placeholder="Redirect to on Success" class="form-control" autocomplete="off" id="redir_success"'); ?>
						</div>

						<label for="form_email" class='text-success'>
							Success Message
						</label>
						<div class="input">
							<?php echo form_input('msg_success', $metadata->msg_success, 'placeholder="Message on success input" class="form-control" autocomplete="off" id="msg_success"'); ?>
						</div>
					</div>