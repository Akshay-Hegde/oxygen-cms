
<div class="row">

    <div class="col-xs-12">

		<div class="col-xs-3">

			<input type='hidden' name='widget_area_id' id='widget_area_id' value='<?php echo $widget_area;?>' />

	        <a href='<?php echo site_url('admin/widgets/');?>' class='btn btn-block btn-primary'>All Areas</a>
	        <br>

	        <?php echo form_open(site_url().'admin/widgets/instances/add/'.$widget_area, 'class="crud"') ?>

	         	<?php echo $available_widgets; ?>

		        <div class='' id='widget_create_block'></div>
		        <br>

		        <button class='btn btn-block btn-warning margin-top'>Add widget</button>

	        <?php echo form_close();?>

		</div>

		<div class="col-xs-9">

	        <div class="box box-solid">
	            <div class="box-header">
	                <h3 class="box-title">Widgets in area :</h3>
	            </div>
	            <div class="box-body">

						<table class='table'>
							<?php if ($widgets): ?>
								
								<?php foreach($widgets as $widget): ?>

								<tr>
									<td>
										<?php echo $widget->instance_title; ?>
									</td>
									<td>
										<?php echo $widget->instance_id; ?>
									</td>
									<td>
										<code>{{ widgets:display name="<?php echo $widget->name ?>"}} </code>
									</td>								
									<td>
										<div class='pull-right'>
											<a href='<?php echo site_url('admin/widgets/instances/edit/'.$widget_area.'/'.$widget->instance_id); ?>' class='btn btn-default btn-flat bg-green'>Edit</a>
											<a href='<?php echo site_url('admin/widgets/instances/delete/'.$widget_area.'/'.$widget->instance_id); ?>' class='confirm btn btn-default btn-flat bg-red'>Delete</a>
										</div>
									</td>
								</tr>
								<?php endforeach ?>
							<?php endif ?>
						</table>

				</div>
			</div>
		</div>

	</div>
</div>
