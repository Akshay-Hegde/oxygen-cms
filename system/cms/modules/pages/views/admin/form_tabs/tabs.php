

	<?php if ($stream_fields): ?>
		<li class="active">
			<a data-toggle="tab"  href="#page-content">
			<?php if ($page_type->content_label):?>
				<?php echo lang_label($page_type->content_label); ?>
			<?php else:?>
				<?php echo lang('pages:content_label');?>
			<?php endif; ?>
			</a>
		</li>
	<?php endif ?>

	<?php if ($this->method != 'create'): ?>
	<li><a data-toggle="tab"  href="#page-public">Public View</a></li>
	<?php endif;?>

	<li class='<?php echo ($stream_fields)?'':'active'; ?>'><a data-toggle="tab" href="#page-meta">SEO</a></li>

	<li><a data-toggle="tab"  href="#page-options"><?php echo lang('pages:options_label') ?></a></li>
	<li><a data-toggle="tab"  href="#page-security">Security</a></li>

	<li class='pull-right'><a data-toggle="tab"  href="#page-design"><?php echo lang('pages:design_label') ?></a></li>
	<li class='pull-right'><a data-toggle="tab"  href="#page-script"><?php echo lang('pages:script_label') ?></a></li>