(function ($) {
	$(function () {

		$('.select-row').change(function (e) {
			$(e.target)
				.parents('tr')
				.find('input[type=checkbox].select-rule')
				.attr('checked', e.target.checked);
		});

		
		// On rule checkbox click
		$('input[type=checkbox].select-rule').change( function(e) {
			_check_disable_first_checkbox(e.target);
		});
		
		// On DOM ready
		$('input.select-rule').each(function(i,v) {
			_check_disable_first_checkbox(this);
		});
		
		// On form submission
		$('form#edit-permissions').on('submit', function(e){
			// We need to remove the disabled state for every checkbox,
			// it will not go through to the POST.
			$('input[type=checkbox]').each(function() {
				if (this.disabled === true) {
					this.disabled = false;
				}
			})
		});
	});
})(jQuery);