/**
 * This file will need some work before its compatile 
 * with all stream states. There are
 * multiple table sorting which will be the biggest issue.
 *
 *
 */
(function($) {
	$(function(){

		///
		/// Assignments.js
		///
		$('table tbody').sortable({
			handle: 'td',
			helper: 'clone',
			start: function(event, ui) {
				$('tr').removeClass('alt');
			},
			update: function() {
				order = new Array();
				$('tr', this).each(function(){
					order.push( $(this).find('input[name="action_to[]"]').val() );
				});
				order = order.join(',');
	
				$.ajax({
					dataType: 'text',
					type: 'POST',
					data: 'order='+order+'&offset='+fields_offset+'&csrf_hash_name='+$.cookie(oxy.csrf_cookie_name),
					url:  SITE_URL+'streams/ajax/update_field_order',
					success: function() {
						$('tr').removeClass('alt');
						$('tr:even').addClass('alt');
					}
				});

			},
			stop: function(event, ui) {
		
				$("tbody tr:nth-child(even)").livequery(function () {
					$(this).addClass("alt");
				});
			
			}
		}).disableSelection();
		///
		///
		///


		///
		/// entry_form.js
		///
		$(document).ready(function() {
		  	$('.input :input:visible:first').focus();
		});
		///
		///
		///		


		///
		/// entry_sorting.js
		///	
		$('table tbody').sortable({
			handle: 'td',
			helper: 'clone',
			start: function(event, ui) {
				$('tr').removeClass('alt');
			},
			update: function() {
				order = new Array();
				$('tr', this).each(function(){
					order.push( $(this).find('input[name="action_to[]"]').val() );
				});
				order = order.join(',');
				
				$.post(SITE_URL+'streams/ajax/ajax_entry_order_update', { order: order, offset: stream_offset, stream_id: stream_id, streams_module: streams_module, csrf_hash_name: $.cookie('csrf_cookie_name')}, function() {
				});
			},
			stop: function(event, ui) {
			
				$("tbody tr:nth-child(even)").livequery(function () {
					$(this).addClass("alt");
				});
			
			}
		}).disableSelection();
		///
		///
		///		


		///
		/// fields.js
		///	
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
		///
		///
		///								
	});
})(jQuery);
