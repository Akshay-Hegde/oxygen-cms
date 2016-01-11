<aside class="control-sidebar control-sidebar-light">
		<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
		  <li class='active'>
			  <a href="#control-sidebar-widgets-tab" data-toggle="tab">
			  	<i class="fa fa-cubes"></i> Widgets
			  </a>
		  </li>	 
		</ul>
		<div class="tab-content">
			  <!-- Home tab content -->
			  <div class="tab-pane active" id="control-sidebar-widgets-tab">

					<?php  
					/*
					<h3 class="control-sidebar-heading">Profile Setup</h3> 
					<ul class="control-sidebar-menu">
						  <li>
								<a href="javascript::;">               
								  <h4 class="control-sidebar-subheading">
										Your system is not quite setup yet.
										<span class="label label-primary pull-right">68%</span>
								  </h4>
								  <div class="progress progress-xxs">
										<div class="progress-bar progress-bar-primary" style="width: 68%"></div>
								  </div>                                    
								</a>
						  </li>               
					</ul>
					*/
					?>
					<?php $dashboard_widgets = $this->db->get('widgets_admin')->result();?>
					<?php echo form_open('admin/dashboard/widget_post/');?>
					<?php foreach($dashboard_widgets as $widget):?>			
						<div class="form-group">
							<label class="control-sidebar-subheading">
								<input <?php echo ($widget->is_visible)?'checked=checked':'';?> name="widgets[<?php echo($widget->id);?>]" class="pull-right" type="checkbox" data-layout="layout-boxed"> 
								<?php echo($widget->name);?>
							</label>
							<p>
								<?php echo($widget->module);?>
							</p>
						</div>
					<?php endforeach; ?>
					<button class='btn btn-flat btn-xs bg-blue'>Save</button>
					<?php echo form_close();?>
			  </div>
		</div>
</aside>
<div class="control-sidebar-bg" style="height: auto; position: fixed;"></div>