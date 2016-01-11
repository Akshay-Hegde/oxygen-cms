<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">

				<!-- box-header -->
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('maintenance:importer') ?></h3>
                </div>
                <!-- /box-header -->

                <!-- box-body -->
                <div class="box-body">
					<table class='table'>
						<?php echo form_open_multipart('admin/maintenance/importer/redirects', 'class="crud"'); ?>
						<tr>
							<td>
								<p>
									<i>Import Redirects</i>
								</p>
								<p>
									<small>
										Import the JSON Redirect file
									</small>
								</p>								
							</td>
							<td class='input'>	
								<input type='file' name='jsonFile'>					
							</td>							
							<td class='input'>					
								<input type='submit' value='Import' class='btn bg-green btn-flat'>	
							</td>
						</tr>					
						<?php echo form_close();?>	
						<?php echo form_open_multipart('admin/maintenance/importer/navigation', 'class="crud"'); ?>
						<tr>
							<td>
								<p>
									<i>Import navigation</i>
								</p>
								<p>
									<small>
										Import the JSON navigation file
									</small>
								</p>								
							</td>
							<td class='input'>	
								<input type='file' name='jsonFile'>					
							</td>							
							<td class='input'>					
								<input type='submit' value='Import' class='btn bg-green btn-flat'>	
							</td>
						</tr>					
						<?php echo form_close();?>																			
					</table>
				</div>
				<!-- /box-body -->

		</div>
	</div>
</div>