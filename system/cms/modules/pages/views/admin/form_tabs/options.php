				<fieldset>

						<label for="is_home"><?php echo lang('pages:is_home_label') ?></label>
						<div class="input">
						<?php echo form_checkbox('is_home', true, $page->is_home == true, 'class="" id="is_home"') ?>
						</div>

										
					<?php if ( ! module_enabled('comments')): ?>
						<?php echo form_hidden('comments_enabled'); ?>
					<?php else: ?>
					
							<label for="comments_enabled"><?php echo lang('pages:comments_enabled_label') ?></label>
							<div class="input"><?php echo form_checkbox('comments_enabled', true, $page->comments_enabled == true, 'id="comments_enabled"') ?></div>
					
					<?php endif; ?>
									
						<label for="rss_enabled"><?php echo lang('pages:rss_enabled_label') ?></label>
						<div class="input"><?php echo form_checkbox('rss_enabled', true, $page->rss_enabled == true, 'id="rss_enabled"') ?></div>
	

						<label for="strict_uri"><?php echo lang('pages:strict_uri_label') ?></label>
						<div class="input"><?php echo form_checkbox('strict_uri', 1, $page->strict_uri == true, 'id="strict_uri"') ?></div>


						<label for="meta_robots_no_index"><?php echo lang('pages:meta_robots_no_index_label') ?></label>
						<div class="input"><?php echo form_checkbox('meta_robots_no_index', true, $page->meta_robots_no_index == true, 'id="meta_robots_no_index"') ?></div>

						<label for="meta_robots_no_follow"><?php echo lang('pages:meta_robots_no_follow_label') ?></label>
						<div class="input"><?php echo form_checkbox('meta_robots_no_follow', true, $page->meta_robots_no_follow == true, 'id="meta_robots_no_follow"') ?></div>

				</fieldset>