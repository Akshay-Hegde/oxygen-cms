
<?php $t_title = 'Manage Admin profile fields for :' . $member->username; ?>


<?php echo form_open_multipart(uri_string(), 'class="crud" autocomplete="off"') ?>


<div class="row">
<div class="col-md-12">

              <!-- general form elements -->
			<div class="col-md-6">
             <div class="box box-primary">

                <div class="box-header">
                  <h3 class="box-title"><?php echo $t_title;?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                  <div class="box-body">

                  		<table class='table'>
                  			<tr>
                  				<td><?php echo lang('user:username') ?></td>
                  				<td><?php echo $member->username;?></td>
                  			</tr>
                  			<tr>
                  				<td><?php echo lang('profile_display_name') ?></td>
                  				<td><?php echo $member->display_name;?></td>
                  			</tr>
                  			<tr>
                  				<td>Email</td>
                  				<td><?php echo $member->email;?></td>
                  			</tr>
                  			<tr>
                  				<td><?php echo lang('user:group_label') ?></td>
                  				<td><?php echo form_dropdown('group_id', array(0 => lang('global:select-pick')) + $groups_select, $member->group_id, 'disabled=disabled class="form-control" id="group_id"') ?></td>
                  			</tr>  
                  			<tr>
                  				<td>Activated</td>
                  				<td>
									<?php $options = array(0 => lang('user:do_not_activate'), 1 => lang('user:active'), 2 => lang('user:send_activation_email')) ?>
									<?php echo form_dropdown('active', $options, $member->active, 'disabled=disabled class="form-control" id="active"') ?>				                  					

                  				</td>
                  			</tr> 
                  			<tr>
                  				<td></td>
                  				<td></td>
                  			</tr>
                  			<tr>
                  				<td></td>
                  				<td></td>
                  			</tr>  
                  			<tr>
                  				<td></td>
                  				<td></td>
                  			</tr>                       			                   			                  			                  			
                  		</table>


	                </div>

	                <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
            </div>
        </div>




	</div>
</div>

<?php echo form_close() ?>
