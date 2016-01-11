
	<div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">System notification and Messages</h3>
            <div class="box-tools">
                <div class="input-group">
                      
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
			<?php if (!empty($items)): ?>
				<?php echo form_open('admin/notifications/delete');?>
			
						<table class="table table-hover">
								<?php foreach( $items as $item ): ?>
								<tr>
									<td><?php echo form_checkbox('action_to[]', $item->id); ?></td>
									<td><?php echo $item->name; ?></td>
									<td>
										<?php echo $item->description; ?>
									</td>
									<td class="actions">
										<?php echo
										anchor('admin/notifications/delete/'.$item->id, 'Delete', array('class'=>'btn btn-flat bg-red')); ?>
									</td>
								</tr>
								<?php endforeach; ?>						        
						</table>

						<div class="inner">
							<?php $this->load->view('admin/partials/pagination'); ?>
						</div>            

		        <?php echo form_close(); ?>
			<?php else: ?>
				<p><?php echo lang('notifications:no_items'); ?></p>
			<?php endif;?> 
		</div>     
    </div>
      