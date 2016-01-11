(function ($) {
	$(function () {

		$(document).on('change','.select-row',function(event) {
			$(event.target)
				.parents('tr')
				.find('input[type=checkbox].select-rule')
				.attr('checked', event.target.checked);

		});
		
		// On rule checkbox click
		$(document).on('change','input[type=checkbox].select-rule',function(e) {
			//_check_disable_first_checkbox(e.target);
		});
		
		// On DOM ready
		$('input.select-rule').each(function(i,v) {
			//_check_disable_first_checkbox(this);
		});
		
		// On form submission
		$(document).on('submit','form#edit-permissions', function(e){
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