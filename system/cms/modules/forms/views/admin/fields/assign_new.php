<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">

            <div class="box-header">
              <h3 class="box-title">

				<?php if( $method == 'new' ): ?>
				<?php echo $stream->stream_name;?> &rarr; <?php echo lang('streams:assign_field');?></h4>
				<?php else: ?>
				<?php echo $stream->stream_name;?></a> &rarr; <?php echo lang('streams:edit_assign');?>
				<?php endif; ?>

              </h3>
            </div>
            <div class="box-body">




				<?php if( count($available_fields) > 1 or $method == 'edit' ): ?>

				<?php echo form_open(uri_string(), 'class="crud"'); ?>

					<?php if( $method == 'edit' ): ?><input type="hidden" name="field_id" value="<?php echo $row->field_id;?> "/><?php endif; ?>

				<div class="form_inputs">
					
					<ul>
						
						<li>
							<label for="field_id"><?php echo lang('streams:label.field');?></label>
							<div class="input"><?php
							
							if($method == 'edit'):
							
								echo '<em>'.$all_fields[$row->field_id].'</em>';
							
							else:
							
								echo form_dropdown('field_id', $available_fields, $row->field_id, 'data-placeholder="'.lang('streams:choose_a_field').'" id="field_id"'); 
								
							endif;
							
							?></div>
						</li>

						<li>
							<label for="is_required"><?php echo lang('streams:label.field_required');?></label>
							<div class="input"><?php echo form_checkbox('is_required', 'yes', $values->is_required, 'id="is_required"');?></div>
						</li>

						<li>
							<label for="is_unique"><?php echo lang('streams:label.field_unique');?></label>
							<div class="input"><?php echo form_checkbox('is_unique', 'yes', $values->is_unique, 'id="is_unique"'); ?></div>
						</li>

						<li>
							<label for="field_instructions"><?php echo lang('streams:label.field_instructions');?><br><small><?php echo lang('streams:instr.field_instructions');?></small></label>
							<div class="input"><?php echo form_textarea('instructions', $values->instructions, 'id="field_instructions"');?></div>
						</li>

						<li>
							<label for="title_column"><?php echo lang('streams:label.make_field_title_column');?></label>
							<div class="input"><?php echo form_checkbox('title_column', 'yes', $title_column_status, 'id="title_column"');?></div>
						</li>
							
					</ul>

				</div>

					<div class="float-right buttons">
						<button type="submit" name="btnAction" value="save" class="btn btn-flat bg-blue"><span><?php echo lang('buttons:save'); ?></span></button>	
						<a href="<?php echo site_url('admin/forms/admin_fields/listing/'.$stream->stream_slug); ?>" class="btn gray cancel"><?php echo lang('buttons:cancel'); ?></a>
					</div>
					
				</form>

				<?php else: ?>

					<div class="no_data">
					<?php echo lang('streams:start.no_fields_to_assign');?> <?php echo anchor('admin/streams/admin_fields/create', lang('streams:start.create_field_here'))?>.
					</div>

				<?php endif; ?>

</div>
</div>
</div>
</div>


