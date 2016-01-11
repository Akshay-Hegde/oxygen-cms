function add_field_parameters()
{
	var data = $('#field_type').val();
	var namespace = $('#fields_current_namespace').val();
	
	jQuery.ajax({
		dataType: "text",
		type: "POST",
		data: 'data='+data+'&namespace='+namespace+'&csrf_hash_name='+$.cookie('csrf_cookie_name'),
		url: SITE_URL+'streams/ajax/build_parameters',
		success: function(dynamic_html) {

			//remove the contents of the container
			jQuery('.streams_param_input').remove();

			//select and add to the list
			jQuery('.form_inputs > ul').append(dynamic_html);

		},
		error: function() {alert('hold on there..')}

	});
}


(function($)
{
	$(function() {

		oxy.generate_slug('#field_name','#field_slug');

	});
})(jQuery);