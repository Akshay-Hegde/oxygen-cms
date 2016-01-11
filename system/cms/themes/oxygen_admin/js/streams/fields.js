(function($) {

	$(function(){

		oxy.generate_slug('input[name="field_name"]', 'input[name="field_slug"]', '_', true);

		$(document).on('change', '#field_type', function() {

			var field_type = $(this).val();

			$.ajax({
				dataType: 'text',
				type: 'POST',
				data: 'data='+field_type+'&csrf_hash_name='+$.cookie(oxy.csrf_cookie_name),
				url:  SITE_URL+'streams/ajax/build_parameters',
				success: function(returned_html){
					//clear decks
					$('#parameters').html(returned_html);

				}
			});

		});
		
		$(document).ready(function() {
		  	$('[name="field_name"]').focus();
		});
	
	});

})(jQuery);
