
<div class="row">

    <div class="col-xs-12">

		<div class="col-xs-3">
	        <a href='<?php echo site_url('admin/widgets/areas/create');?>' class='btn btn-block btn-primary as_modal'>Create Area</a>
		</div>

		<div class="col-xs-9">
	        <div class="box box-solid">
	            <div class="box-header">
	                <h3 class="box-title">Areas</h3>
	            </div>
	            <div class="box-body">

					<?php if ($areas): ?>
	            	<table class='table'>
	            			<tr>
	            				<th>Name</th>
	            				<th>Slug</th>
	            				<th>Usage</th>
	            				<th><span class='pull-right'>Actions</span></th>
	            			</tr>
							<?php foreach($areas as $area): ?>
							<tr>
								<td>
									<?php echo $area->name; ?>
								</td>
								<td>
									<?php echo $area->slug; ?>
								</td>								
								<td>
									<code>{{ widgets:display area="<?php echo $area->slug; ?>" }}</code>
								</td>								
								<td>
									<span class='pull-right'>
										<a href='<?php echo site_url('admin/widgets/areas/edit/'.$area->id); ?>' class='btn btn-flat bg-blue as_modal'>Edit</a>
										<a href='<?php echo site_url('admin/widgets/areas/widgets/'.$area->id); ?>' class='btn btn-flat bg-blue'>Widgets</a>
										<a href='<?php echo site_url('admin/widgets/areas/delete/'.$area->id); ?>' class='btn btn-flat bg-red confirm'>Delete</a>
									</span>
								</td>
							</tr>
							<?php endforeach ?>
					</table>
					<?php endif ?>
				</div>
			</div>
		</div>

	</div>

</div>
