<div class="row">
    
    <div class="col-xs-12">

		<?php if (validation_errors()): ?>
		<div class="error-box">
			<?php echo validation_errors();?>
		</div>
		<?php endif ?>


        <!-- Section details-->
        <div class="col-xs-12">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo lang('user:login_header') ?>
                    </h3>
                    <div class="box-tools pull-right">
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body">
					<?php echo form_open('users/login', array('id'=>'login'), array('redirect_to' => $redirect_to)) ?>
					<table>
						<tr>
							<td>
								<label for="email"><?php echo lang('global:email') ?></label>
							</td>
							<td>
								<?php echo form_input('email', $this->input->post('email') ? escape_tags($this->input->post('email')) : '')?>
							</td>
						</tr>
						<tr>
							<td>
								<label for="password"><?php echo lang('global:password') ?></label>
							</td>
							<td>							
								<input type="password" id="password" name="password" maxlength="20" />
							</td>
						</tr>
						<tr>
							<td>
								<label><?php echo lang('user:remember') ?></label>
							</td>
							<td>							
								<?php echo form_checkbox('remember', '1', false) ?>
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" value="<?php echo lang('user:login_btn') ?>" name="btnLogin" /> <span class="register"> | <?php echo anchor('register', lang('user:register_btn'));?></span>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo anchor('users/reset_pass', lang('user:reset_password_link'));?>
							</td>
						</tr>
					</table>
					<?php echo form_close() ?>
                </div>


            </div>
        </div>
    </div>
</div>




