
		<label for="<?php echo $field['field_slug'];?>"><?php echo $field['field_name'];?> 

		<?php if ($field['required']): ?>
			<span>*</span>
		<?php endif; ?>
		
		<?php if( $field['instructions'] != '' ): ?>
			<br><small><?php echo $field['instructions']; ?></small>
		<?php endif; ?>
		</label>

		<div class="input">
			<?php echo $field['input']; ?>
		</div>
