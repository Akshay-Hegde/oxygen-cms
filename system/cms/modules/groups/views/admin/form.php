<?php echo form_open(uri_string(), 'class="crud"') ?>
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
			<?php if ($this->method == 'edit'): ?>
			    	
			<?php else: ?>
			    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php endif ?>

              
              <h4 class="modal-title">
					<?php if ($this->method == 'edit'): ?>
					    	<?php echo sprintf(lang('groups:edit_title'), $group->name) ?>
					<?php else: ?>
					    	<?php echo lang('groups:add_title') ?>
					<?php endif ?>
              </h4>
            </div>
            <div class="modal-body">
				<label for="description"><?php echo lang('groups:name');?> <span>*</span></label>
				<div class="input">
					<?php echo form_input('description', $group->description,'class="form-control"');?>
				</div>
				<label for="name"><?php echo lang('groups:short_name');?> <span>*</span></label>
				<div class="input">
					<?php if ( ! in_array($group->name, array('user', 'admin'))): ?>
						<?php echo form_input('name', $group->name,'class="form-control"');?>
					<?php else: ?>
						<code><?php echo $group->name ?></code>
					<?php endif ?>
					<br><br>
				</div>

				<label for="authority">Authority Level<span>*</span></label>


				<?php if($can_edit AND $group->name != 'admin'): ?>
					<div class="input">
							<?php 
								if (!isset($group->authority)) $group->authority = 10; 
								$authority_list = 
								[
									'High - For administrators' =>
									[
										0  => '0 - (Highest)',
										1  => '1',
										2  => '2',
										3  => '3',
									],
									'Medium - For Content Editors' =>
									[		
										4  => '4',															
										5  => '5',
										6  => '6',
										7  => '7',
									],
									'Low - For everyone else' =>
									[									
										8  => '8',
										9  => '9',
										10 => '10',
									],
								];

								// lets remove the items that are not allowed
								if($this->current_user->group !=='admin'):
									foreach($authority_list as &$auth_group):
										foreach($auth_group as $authority_item => $text):
											if($max_auth>=$authority_item):
												unset($auth_group[$authority_item]);
											endif;
										endforeach;
									endforeach;
								endif;
								echo form_dropdown('authority',$authority_list ,$group->authority,'class="form-control"');
								?>
						<br><br>
					</div>						
				<?php else: ?>
					<p>
						You can not change the authority level for this group
					</p>
					<?php echo form_hidden('authority',$group->authority);?>
				<?php endif; ?>
			
            </div>
            <div class="modal-footer">
				<?php if ($this->method == 'edit'): ?>
				    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save','cancel') )) ?>
				<?php else: ?>
				  <a href="#" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</a>
				  <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
				<?php endif ?>
            </div>
        </div>
      </div> 
<?php echo form_close();?> 

<script type="text/javascript">
	jQuery(function($) {
		$('form input[name="description"]').on('keyup',$.debounce(300, function(){
			var slug = $('input[name="name"]');
			//we are generating a slug from server,
			//it might be best that ALL slugify comes from server so we should look into this for oxy.generate_slug
			$.post(SITE_URL + 'ajax/url_title', { title : $(this).val() }, function(new_slug){
				slug.val( new_slug );
			});
		}));
	});
</script>