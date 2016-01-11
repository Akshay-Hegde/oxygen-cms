
	<!-- Meta data tab -->
	<div class="tab-pane" id="page-layout-meta">
	
		<fieldset>
	

			<label for="meta_title"><?php echo lang('pages:meta_title_label');?></label>
			<div class="input">
			<input class='form-control' type="text" id="meta_title" name="meta_title" maxlength="255" value="<?php echo $page_type->meta_title; ?>" />
			</div>

			<label for="meta_keywords"><?php echo lang('pages:meta_keywords_label');?></label>
			<div class="input">
			<input type="text" class='tagsinput' id="meta_keywords" name="meta_keywords" maxlength="255" value="<?php echo $page_type->meta_keywords; ?>" />
			</div>

			<label for="meta_description"><?php echo lang('pages:meta_desc_label');?></label><br>
			<?php echo form_textarea(array('name' => 'meta_description', 'value' => $page_type->meta_description, 'rows' => 5,'class'=>'form-control')); ?>

		
		</fieldset>

	</div>

<script>
	(function($) {
	$(function(){

			$('#meta_keywords').tagsInput({
				autocomplete_url: SITE_URL + 'admin/keywords/autocomplete'
			});
			
		});

	})(jQuery);
</script>