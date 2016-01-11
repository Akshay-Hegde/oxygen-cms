				<fieldset>
			

						<label for="meta_title"><?php echo lang('pages:meta_title_label') ?></label>
						<div class="input">
							<input class='form-control' type="text" id="meta_title" name="meta_title" maxlength="255" value="<?php echo $page->meta_title ?>" />
							</div>
		
									
					<?php if ( ! module_enabled('keywords')): ?>
						<?php echo form_hidden('keywords'); ?>
					<?php else: ?>
	
							<label for="meta_keywords"><?php echo lang('pages:meta_keywords_label') ?></label>
							<div class="input"><input type="text" id="meta_keywords" name="meta_keywords" maxlength="255" value="<?php echo $page->meta_keywords ?>" /></div>
		
					<?php endif; ?>

							<label for="meta_description"><?php echo lang('pages:meta_desc_label') ?></label>
							<br>
							<?php echo form_textarea(array('class'=>'form-control','name' => 'meta_description', 'value' => $page->meta_description, 'rows' => 5)) ?>

	
				</fieldset>	