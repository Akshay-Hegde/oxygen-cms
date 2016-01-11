(function ($) {
	$(function () {

		
		$(document).on("keyup", "#categories.create" ,function(event) {
        	oxy.generate_slug($(this).find('input[name="title"]'), $(this).find('input[name="slug"]'));
        	event.preventDefault();
        });

		// generate a slug when the user types a title in
		oxy.generate_slug('#blog-content-tab input[name="title"]', '#blog-content-tab input[name="slug"]');

		// needed so that Keywords can return empty JSON
		$.ajaxSetup({
			allowEmpty: true
		});

		oxy.tagsInput('#keywords', SITE_URL + 'admin/keywords/autocomplete');		

	});
})(jQuery);