	           		<!-- Stream data and notify info (metadata)-->
					<div class="box-body">

						<ul class='form-list'>
							<li>
								<div class='form-label'>
									<label for="form_email" class='text-success'>
										Success URL
										<small>
											{{url:site}}
										</small>
									</label>
								</div>
								<div class='form-item'>	
									<?php echo form_input('redir_success', $metadata->redir_success, 'placeholder="Redirect to on Success" class="form-control" autocomplete="off" id="redir_success"'); ?>
								</div>
							</li>
							<li>
								<div class='form-label'>
									<label for="form_email" class='text-success'>
										Success Message
										<small>
											
										</small>
									</label>
								</div>
								<div class='form-item'>	
									<?php echo form_input('msg_success', $metadata->msg_success, 'placeholder="Message on success input" class="form-control" autocomplete="off" id="msg_success"'); ?>
								</div>
							</li>
							<li>
								<div class='form-label'>
									<label for="form_email">
										Reply-to
										<small>
											If you would like to have a reply to, specify the field SLUG that we will use as the reply-to field. eg `email`
										</small>
									</label>
								</div>
								<div class='form-item'>	
									<?php echo form_input('replyto_field', $metadata->replyto_field, 'placeholder="email" class="form-control" autocomplete="off" id="replyto_field"'); ?>
								</div>
							</li>
						</ul>


					</div>