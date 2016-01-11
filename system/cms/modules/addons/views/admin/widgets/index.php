<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title"><?php echo lang('addons:widgets') ?></h3>
            </div>
            <div class="box-body">
				<?php if ($widgets): ?>
					<?php echo form_open(uri_string(), 'class="crud"') ?>
					<table id="widgets-list" class="table">
						<thead>
						<tr>
							<th width="30"></th>
							<th width="20%"><?php echo lang('global:title') ?></th>
							<th><?php echo lang('desc_label') ?></th>
							<th width="130"><?php echo lang('global:author') ?></th>
							<th width="80" class="align-center"><?php echo lang('version_label') ?></th>
							<th width="150"></th>
						</tr>
						</thead>
						<tbody>
							<?php foreach ($widgets as $widget): ?>
							<tr>
								<td><span class="move-handle"></span></td>
								<td><?php echo $widget->title ?></td>
								<td><?php echo $widget->description ?></td>
								<td>
									<?php echo $widget->website ? anchor($widget->website, $widget->author, array('target' => '_blank')) : $widget->author ?>
								</td>
								<td class="align-center"><?php echo $widget->version ?></td>
								<td class="align-center buttons buttons-small actions">
								<?php if ($widget->enabled == '1'): ?>
									<?php echo anchor('admin/addons/widgets/disable/' . $widget->id, lang('buttons:disable'), 'class="btn btn-flat bg-red disable"') ?>
								<?php else: ?>
									<?php echo anchor('admin/addons/widgets/enable/' . $widget->id, lang('buttons:enable'), 'class="btn btn-flat bg-green enable"') ?>
								<?php endif ?>
								</td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					<?php echo form_close() ?>
				<?php else: ?>
					<p><?php echo lang('widgets:no_available_widgets') ?></p>
				<?php endif ?>
       		</div>
    	</div>
	</div>
</div>