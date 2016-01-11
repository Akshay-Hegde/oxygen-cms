<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title"><?php echo lang('global:field_types');?> : <?php echo lang('addons:plugins:add_on_field_types') ?></h3>
			</div>
			<div class="box-body">
				<?php if ( ! empty($addon)): ?>
					<table id="standard_data_table" class="table table-bordered">
						<thead>
							<tr>
								<th><?php echo lang('name_label');?></th>
								<th><?php echo lang('version_label');?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($addon as $a_ft): ?>
								<tr>
									<td width="60%"><?php echo $a_ft['name'] ?></td>
									<td><?php echo $a_ft['version'] ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title"><?php echo lang('global:field_types');?> : <?php echo lang('addons:plugins:core_field_types') ?></h3>
			</div>
			<div class="box-body">
				<?php if ($core): ?>
				<table id="standard_data_table" class="table table-bordered">
					<thead>
						<tr>
							<th><?php echo lang('name_label');?></th>
							<th><?php echo lang('version_label');?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($core as $c_ft): ?>
					<tr>
						<td width="60%"><?php echo $c_ft['name'] ?></td>
						<td><?php echo $c_ft['version'] ?></td>
					</tr>
					<?php endforeach ?>
					</tbody>
				</table>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>