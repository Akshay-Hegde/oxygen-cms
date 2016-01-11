				<div class="tab-pane" id="page-layout-fields">
				
					<fieldset>							

						<h3>Fields</h3>
						<br>
						<a class='btn btn-flat btn-default' href='admin/pages/types/fields/<?php echo ($page_type->id);?>/new_field'>Create a field</a>
						<a class='btn btn-flat btn-default' href='admin/pages/types/fields/<?php echo ($page_type->id);?>/assign_field'>Assign existing field</a>

							<br>
							<br>

						<?php echo $fields_table; ?>

					</fieldset>
		
				</div>

