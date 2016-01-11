
				<fieldset>
			

						<label for="title"><?php if ($page_type->title_label): echo lang_label($page_type->title_label); else: echo lang('global:title'); endif ?> <span>*</span></label>
						<div class="input"><?php echo form_input('title', $page->title, 'class="form-control" id="title" maxlength="60"') ?></div>

						<label for="slug"><?php echo lang('global:slug') ?>  <span>*</span></label>
						
						<div class="input">
							<?php if ( ! empty($page->parent_id)): ?>
								<?php echo site_url($parent_page->uri) ?>/
							<?php else: ?>
								<?php echo site_url() . (config_item('index_page') ? '/' : '') ?>
							<?php endif ?>
		
							<?php if ($this->method == 'edit'): ?>
								<?php echo form_hidden('old_slug', $page->slug) ?>
							<?php endif ?>
		
							<?php if (in_array($page->slug, array('home', '404'))): ?>
								<?php echo form_hidden('slug', $page->slug) ?>
								<?php echo form_input('', $page->slug, 'id="slug" size="20" disabled="disabled"') ?>
							<?php else: ?>
								<?php echo form_input('slug', $page->slug, 'id="slug" size="20" class="'.($this->method == 'edit' ? ' disabled' : '').'"') ?>
							<?php endif ?>
		
							<?php echo config_item('url_suffix') ?> <br>

							<?php if ($this->method == 'edit'): ?>
								<a target='_new' href='<?php echo site_url().$page->slug; ?>'>Preview the public page</a>
							<?php endif ?>
						</div>
			

					<?php if(isset($page->page_type_title)):?>

						<label for="category_id"><?php echo lang('pages:type_id_label') ?></label>
						<div class="input">
							<?php echo $page->page_type_title;?>
						</div>

					<?php endif;?>
			
						<label for="category_id"><?php echo lang('pages:status_label') ?></label>
						<div class="input"><?php echo form_dropdown('status', array('draft'=>lang('pages:draft_label'), 'live'=>lang('pages:live_label')), $page->status, 'class="form-control" id="category_id"') ?></div>
	
					
					<?php if ($this->method == 'create'): ?>
		
						<label for="navigation_group_id"><?php echo lang('pages:navigation_label') ?></label>
						<div class="input"><?php echo form_multiselect('navigation_group_id[]', array(lang('global:select-none')) + $navigation_groups, $page->navigation_group_id) ?></div>
		
					<?php endif ?>
			
	
				</fieldset>	
