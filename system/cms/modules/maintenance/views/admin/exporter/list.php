<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title"><?php echo lang('maintenance:export_data') ?></h3>
            </div>
            <div class="box-body">
						<?php if ( ! empty($tables)): ?>
						 <table id="standard_data_table" class="table table-bordered">
							
								<thead>
									<tr>
										<th style='width:20%'><?php echo lang('maintenance:table_label') ?></th>
										<th><?php echo lang('maintenance:record_label') ?></th>
										<th style='width:40%'></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($tables as $table): ?>
									<tr>
										<td><?php echo $table['name'] ?></td>
										<td class=""><?php echo $table['count'] ?></td>
										<td class="">
											<?php if ($table['count'] > 0):
												echo anchor('admin/maintenance/export/'.$table['name'].'/xml', lang('maintenance:export_xml'), array('class'=>'btn btn-flat bg-olive')).' ';
												echo anchor('admin/maintenance/export/'.$table['name'].'/csv', lang('maintenance:export_csv'), array('class'=>'btn btn-flat bg-blue')).' ';
												echo anchor('admin/maintenance/export/'.$table['name'].'/json', lang('maintenance:export_json'), array('class'=>'btn btn-flat bg-orange')).' ';
											endif ?>
										</td>
									</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						<?php endif;?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
                <div class="box-header">
                  <h3 class="box-title">Advanced <?php echo lang('maintenance:exporter') ?></h3>
                </div><!-- /.box-header -->

                <div class="box-body">
					<table class='table'>	
						<tr>
							<td>
								<p>
									<i>Export navigation</i>
								</p>
								<p>
									<small>
										Export The navigation in the system
									</small>
								</p>								
							</td>
							<td class='input-group'>						
								<a class='btn btn-flat bg-green' href='admin/maintenance/exporter/navigation'>Export</a>	
							</td>
						</tr>																		
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
