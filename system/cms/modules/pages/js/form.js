(function($) {
	$(function(){

		// Generate a slug from the title
		if ($('#page-form').data('mode') == 'create') {
			oxy.generate_slug('input[name="title"]', 'input[name="slug"]');
		}

		// needed so that Keywords can return empty JSON
		$.ajaxSetup({
			allowEmpty: true
		});

		oxy.tagsInput('#meta_keywords', SITE_URL + 'admin/keywords/autocomplete');
		
	});

})(jQuery);