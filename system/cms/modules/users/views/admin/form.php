<style>
label
{
	font-weight:normal !important;
}
</style>
<?php $t_title ='';?>
<?php if ($this->method === 'create'): ?>
	<?php $t_title = lang('user:add_title') ?>
<?php else: ?>
	<?php $t_title =sprintf(lang('user:edit_title'), $member->username) ?>
	<?php echo form_hidden('row_edit_id', isset($member->row_edit_id) ? $member->row_edit_id : $member->profile_id); ?>
<?php endif ?>

<?php echo form_open_multipart(uri_string(), 'class="crud" autocomplete="off"') ?>
<div class="row">


	<div class="col-lg-3 col-md-3 col-sm-12">

     	<div class="box box-solid">

            <div class="box-header">
              <h3 class="box-title">
              	<?php echo $t_title;?>
              </h3>
            </div><!-- /.box-header -->
        	<!-- form start -->

          	<div class="box-body">

				<label for="username"><?php echo lang('user:username') ?> *</label>
				<div class="input-group">
					<span class="input-group-addon">@</span>
					<input name="username" type="text" id="username" placeholder="Username" class="form-control" value='<?php echo $member->username;?>'>
				</div>
				<br>


				<label for="display_name"><?php echo lang('profile_display_name') ?> *</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input name="display_name" type="text" id="display_name" placeholder="display_name" class="form-control" value='<?php echo $member->display_name;?>'>
				</div>
				<br>


				<label for="email">Email *</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
					<input name="email" type="email" id="email" placeholder="Email" class="form-control" value='<?php echo $member->email;?>'>
				</div>
				<br>

				<label for="password">
				<?php echo lang('global:password') ?>
				<?php if ($this->method == 'create'): ?> 
					<span>*</span><?php endif ?></label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
						<?php echo form_password('password', '', 'class="form-control" id="password" autocomplete="off"') ?>
					</div>
				<br> 

				
				
					<label for="group_id"><?php echo lang('user:group_label') ?> *</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-users"></i></span>
						<?php echo form_dropdown('group_id', array(0 => lang('global:select-pick')) + $groups_select, $member->group_id, 'class="form-control" id="group_id"') ?>
					</div>
					<br>
				
				
					<label for="active"><?php echo lang('user:activate_label') ?> *</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-smile-o"></i></span>
						<?php $options = array(0 => lang('user:do_not_activate'), 1 => lang('user:active'), 2 => lang('user:send_activation_email')) ?>
						<?php echo form_dropdown('active', $options, $member->active, 'class="form-control" id="active"') ?>				
					</div>
					<br>
				
            </div>

            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
            <br>
    	</div>
	</div>

    <!-- general form elements -->
	<div class="col-lg-9 col-md-9 col-sm-12">
     	<div class="box box-solid">

            <div class="box-header">
              <h3 class="box-title">
              		Profile Information
              </h3>
            </div><!-- /.box-header -->
        	<!-- form start -->

          	<div class="box-body">

				<?php foreach($profile_fields as $field): ?>

					<?php if( ($this->method === 'create')): ?>
						<?php if ($field['required']): ?>
							<label for="<?php echo $field['field_slug'] ?>">
								<?php echo (lang($field['field_name'])) ? lang($field['field_name']) : $field['field_name'];  ?> *
							</label>
							<div class="">
								<?php echo $field['input'] ?>
							</div>
						<?php endif; ?>
					<?php else: ?>
						<label for="<?php echo $field['field_slug'] ?>">
							<?php echo (lang($field['field_name'])) ? lang($field['field_name']) : $field['field_name'];  ?>
							<?php if ($field['required']){ ?> <span>*</span><?php } ?>
						</label>
						<div class="">
							<?php echo $field['input'] ?>
						</div>
					<?php endif; ?>

				<?php endforeach ?>
            </div>
    	</div>
	</div>

</div>

<?php echo form_close() ?>
