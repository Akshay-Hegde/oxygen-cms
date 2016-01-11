
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">

            <div class="box-header">
              <h3 class="box-title">Settings</h3>
            </div>
            <div class="box-body">


					<?php if ($setting_sections): ?>
						<?php echo form_open('admin/settings/edit', 'class="crud"');?>

			              <!-- Custom Tabs -->
				            <div class="nav-tabs-custom">
				                <ul class="nav nav-tabs">

										<?php $first = true;?>
										<?php foreach ($setting_sections as $section_slug => $section_name): ?>
										    <li class="<?php echo (($first)?'active':'') ?>">
										    	<a data-toggle="tab" href="#<?php echo $section_slug ?>" title="<?php printf(lang('settings:section_title'), $section_name) ?>">
										    		<?php echo $section_name ?><span></span>
										   		</a>
										    </li>
										<?php $first = false; ?>
										<?php endforeach ?>

				                </ul>
				                <div class="tab-content">

									<?php $first = true;?>
									<?php foreach ($setting_sections as $section_slug => $section_name): ?>
									 <div id="<?php echo $section_slug;?>" class="tab-pane <?php echo (($first)?'active':'') ?>">
									 <?php $first = false; ?>
									 	
										<div class='form-group'>
											<?php foreach ($settings[$section_slug] as $setting): ?>
											
													<label for="<?php echo $setting->slug ?>">
														<?php echo $setting->title ?>
														<?php if($setting->description):?>
															<small>
																<?php echo $setting->description;?>
															</small>
														<?php endif; ?>										
													</label>
													<div class='form-group'>
													<?php echo $setting->form_control ?>
													<div class=''></div>
													</div>
											
											<?php endforeach ?>
											</div>
										
										
									</div>
									<?php endforeach ?>
						
								</div>
						
								<div class="buttons padding-top">
									<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
								</div>
							</div>
					
						<?php echo form_close() ?>
					<?php else: ?>
						<div>
							<p><?php echo lang('settings:no_settings');?></p>
						</div>
					<?php endif ?>

		
			</div>
		</div>
	</div>
</div>






