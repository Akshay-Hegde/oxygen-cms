				<div class="tab-pane" id="page-layout-layout">
				
					<fieldset>
						
						<ul>

							<li>
								<label for="html_editor"><?php echo lang('page_types:layout'); ?> <span>*</span></label>
								<?php echo form_textarea(array('class'=>'editor', 'id'=>'html_editor', 'name'=>'body', 'value' => ($page_type->body == '' ? '<h2>{{ title }}</h2>' : $page_type->body), 'rows' => 50)); ?>
							</li>
						</ul>
		
					</fieldset>
		
				</div>