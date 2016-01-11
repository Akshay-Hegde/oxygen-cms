<div class="row">
    
    <div class="col-xs-12">

		<?php if (validation_errors()):?>
		<div class="error-box">
			<?php echo validation_errors();?>
		</div>
		<?php endif;?>    

        <!-- Section details-->
        <div class="col-xs-12">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo lang('user:password_section') ?>
                    </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>

                <div class="box-body">

					<?php echo form_open_multipart('', array('id'=>'user_edit'));?>


						<table>
							<tr>
								<td>
									Old Password
								</td>
								<td>
									<?php echo form_password('password_old', '', 'autocomplete="off"') ?>
								</td>
							</tr>
							<tr>
								<td>
									New Password
								</td>
								<td>
									<?php echo form_password('password', '', 'autocomplete="off"') ?>
								</td>
							</tr>
							<tr>
								<td>
									Repeat new password
								</td>
								<td>
									<?php echo form_password('password_repeat', '', 'autocomplete="off"') ?>
								</td>
							</tr>
						</table>
						
					<?php echo form_submit('', lang('profile_save_btn')) ?>
					<?php echo form_close() ?>

				</div>
			</div>
		</div>
	</div>
</div>
