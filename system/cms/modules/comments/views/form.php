<?php echo form_open("comments/create/{$module}", 'id="create-comment"') ?>

	<noscript><?php echo form_input('d0ntf1llth1s1n', '', 'style="display:none"') ?></noscript>

	<h3><?php echo lang('comments:your_comment') ?></h3>

	<?php echo form_hidden('entry', $entry_hash) ?>

	<?php if ( ! is_logged_in()): ?>

	<div class="form_name">
		<label for="name"><?php echo lang('comments:name_label') ?><span class="required">*</span>:</label>
		<input class='form-control' type="text" name="name" id="name" maxlength="40" value="<?php echo $comment['name'] ?>" />
	</div>

	<div class="form_email">
		<label for="email"><?php echo lang('global:email') ?><span class="required">*</span>:</label>
		<input class='form-control' type="text" name="email" maxlength="40" value="<?php echo $comment['email'] ?>" />
	</div>

	<div class="form_url">
		<label for="website"><?php echo lang('comments:website_label') ?>:</label>
		<input class='form-control' type="text" name="website" maxlength="40" value="<?php echo $comment['website'] ?>" />
	</div>

	<?php endif ?>

	<div class="form_textarea">
		<label for="comment">Comment:</label>
		<textarea name="comment" placeholder='<?php echo lang('comments:your_comment') ?>' id="comment" rows="5" cols="30" class="form-control"><?php echo $comment['comment'] ?></textarea>
	</div>

	<div class="form_submit">
		<?php echo form_submit('submit', lang('comments:send_label')) ?>
	</div>

<?php echo form_close() ?>