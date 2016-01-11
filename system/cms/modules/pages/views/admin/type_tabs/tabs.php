

	<li class="active"><a data-toggle="tab" href="#page-layout-basic"><?php echo lang('page_types:basic_info') ?></a></li>
	<?php
	/*
	<li><a data-toggle="tab"  href="#page-layout-layout"><?php echo lang('page_types:layout') ?></a></li>
	*/ ?>
	<li><a data-toggle="tab"  href="#page-layout-meta"><?php echo lang('pages:meta_label') ?></a></li>
	<li><a data-toggle="tab"  href="#page-layout-css"><?php echo lang('pages:css_label') ?></a></li>
	<li><a data-toggle="tab"  href="#page-layout-script"><?php echo lang('pages:script_label') ?></a></li>

	<?php if (($this->method == 'edit') OR ($this->method == 'view')): ?>
		<li><a data-toggle="tab"  href="#page-layout-fields">Fields</a></li>
	<?php endif; ?>		
	

