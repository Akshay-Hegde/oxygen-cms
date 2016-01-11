
<?php echo form_open_multipart(uri_string(), 'class="streams_form"'); ?>



	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<?php $first_tab = true; ?>
			<?php foreach($tabs as $tab): ?>
					<li class="<?php echo ($first_tab)?'active':'';?>">
						<a data-toggle="tab" href="#<?php echo $tab['id']; ?>">
							<?php echo $tab['title']; ?>
						</a>
					</li>
				<?php $first_tab = false; ?>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content">
			<?php $first_tab = true; ?>
			<?php foreach($tabs as $tab): ?>
			 	<div id="<?php echo $tab['id']; ?>" class="tab-pane <?php echo ($first_tab)?'active':'';?>">
					<fieldset>

						<ul class='form-list'>

							<?php foreach( $tab['fields'] as $field ) { ?>

								<li class="<?php echo in_array($fields[$field]['input_slug'], $hidden) ? 'hidden' : null; ?>">
									<label for="<?php echo $fields[$field]['input_slug'];?>"><?php echo $this->fields->translate_label($fields[$field]['input_title']);?> <?php echo $fields[$field]['required'];?>
									
									<?php if( $fields[$field]['instructions'] != '' ): ?>
										<br><small><?php echo $this->fields->translate_label($fields[$field]['instructions']); ?></small>
									<?php endif; ?>
									</label>
									
									<div class="input"><?php echo $fields[$field]['input']; ?></div>
								</li>

							<?php } ?>
						
						</ul>
					</fieldset>
				</div>
				<?php $first_tab = false; ?>
			<?php endforeach; ?>
		</div>
	</div>



	<?php if ($mode == 'edit'){ ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

	<div class="float-right buttons">
		<button type="submit" name="btnAction" value="save" class="btn btn-flat bg-blue"><span><?php echo lang('buttons:save'); ?></span></button>	
		<a href="<?php echo site_url(isset($return) ? $return : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn gray"><?php echo lang('buttons:cancel'); ?></a>
	</div>

<?php echo form_close();?>