

<?php if ($fields): ?>

		<?php echo form_open_multipart(uri_string(), 'class="streams_form"'); ?>


			<?php foreach ($fields as $field ) { ?>

				<div style="<?php echo in_array($field['input_slug'], $hidden) ? 'display:none;' : ''; ?>">

					<label for="<?php echo $field['input_slug'];?>">
						<?php echo $this->fields->translate_label($field['input_title']);?> <?php echo $field['required'];?>
						<?php if( $field['instructions'] != '' ): ?>
							<br><small><?php echo $this->fields->translate_label($field['instructions']); ?></small>
						<?php endif; ?>
					</label>
					
					<div class="input">
						<?php echo $field['input']; ?>
					</div>

				</div>

			<?php } ?>
			
			<?php if ($mode == 'edit'){ ?>
					<input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" />
			<?php } ?>

			<br>


			<div class="float-right buttons">
				<button type="submit" name="btnAction" value="save" class="btn btn-flat bg-blue"><span><?php echo lang('buttons:save'); ?></span></button>
				<button type="submit" name="btnAction" value="save_another" class="btn btn-flat bg-blue"><span><?php echo lang('buttons:save_another'); ?></span></button>	
				<a href="<?php echo site_url(isset($cancel_url) ? $cancel_url : 'admin/flows/entries/view/'.$stream->id); ?>" class="btn btn-flat btn-default"><?php echo lang('buttons:cancel'); ?></a>
			</div>

			<br>

		<?php echo form_close();?>

<?php else: ?>


			<?php
				
				if (isset($no_fields_message) and $no_fields_message)
				{
					echo lang_label($no_fields_message);
				}
				else
				{
					echo lang('streams:no_fields_msg_first');
				}

			?>


<?php endif; ?>