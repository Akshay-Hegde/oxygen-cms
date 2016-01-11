(function($) {

	$(function() {

		// generate a slug for new navigation groups
		//oxy.generate_slug('input[name="title"]', 'input[name="slug"]');

		/*
		var open_sections = $.cookie('nav_groups');
		
		if (open_sections) {
			$('section[rel="'+open_sections+'"] .item').slideDown(200).removeClass('collapsed');
		} else {
			// show the first box with js to get around page jump
			$('.box .item:first').slideDown(200).removeClass('collapsed');			
		}
		*/
		
		// show and hide the sections
		/*
		$('.box .title').on('click',function(event){
			event.preventDefault();
			window.scrollTo(0, 0);
			if ($(this).next('section.item').hasClass('collapsed')) {
				$('.box .item').slideUp(200).addClass('collapsed');
				$.cookie('nav_groups', $(this).parents('.box').attr('rel'), { expires: 1, path: window.location.pathname });
				$(this).next('section.collapsed').slideDown(200).removeClass('collapsed');
			}
		});
		*/

		// load edit via ajax
		$(document).on('click','a.as_modal_link', function(){
			// make sure we load it into the right one
			var id = $(this).attr('rel');
			if ($(this).hasClass('add')) {
				// if we're creating a new one remove the selected icon from link in the tree
				$('.group-'+ id +' #link-list a').removeClass('selected');
			}

			//display the modal with info
			$('#dyna-modal').modal('hide');
			// Load the details box in
			$('#dyna-modal .modal-content').load($(this).attr('href'), function(){
				//$('div#link-details.group-'+ id +'').fadeIn();
				$('#dyna-modal').modal('show');
			});	



			return false;

		});
	

		// submit edit form via ajax
		$(document).on('click','#nav-edit button:submit', function(e){
			e.preventDefault();
			var url = SITE_URL + 'admin/navigation/edit/' + $('input[name="link_id"]').val();
			var senddata = $('#nav-edit').serialize();

			//check we have the right data
			var title = $('input[name="title"]').val();
			if(title=='' || title=='underfined') {
				alert('Please enter a title for this links');
				return;
			}

			$.post(url, senddata, function(message){

				// if message is simply "success" then it's a go. Refresh!
				if (message == 'success') {
					window.location.href = window.location
				}
				else {
					$('.notification').remove();
					$('div#content-body').prepend(message);
					// Fade in the notifications
					$(".notification").fadeIn("slow");
				}
			});	
			

			e.preventDefault();

		});

		// Pick a rule type, show the correct field
		$(document).on('change','input[name="link_type"]', function(event){

			$(this).parents('ul').find('#navigation-' + $(this).val())

			// Show only the selected type
			.show().siblings().hide()

			// Reset values when switched
			.find('input:not([value="http://"]), select').val('');
			
			event.preventDefault();

		// Trigger default checked
		}).filter(':checked').change();

	
		// show link details
		$('#link-list li a').livequery('click', function()
		{
			// gather required info
			var id = $(this).attr('rel');
			link_id = $(this).attr('alt');

			//update the ui on selection
			$('.group-'+ id +' #link-list a').removeClass('selected');
			$(this).addClass('selected');

			//display the modal with info
			$('#dyna-modal').modal('hide');
			// Load the details box in
			$('#dyna-modal .modal-content').load(SITE_URL + 'admin/navigation/ajax_link_details/' + link_id, '', function(){
				//$('div#link-details.group-'+ id +'').fadeIn();
				$('#dyna-modal').modal('show');
			});	

			return false;
		});
		
		$('.box:visible ul.sortable').livequery(function(){
			$item_list		= $(this);
			$url			= 'admin/navigation/order';
			$cookie			= 'open_links';
			$data_callback	= function(event, ui) {
				// Grab the group id so we can update the right links
				return { 'group' : ui.item.parents('section.box').attr('rel') };
			}
			// $post_callback is available but not needed here
			
			// Get sortified
			oxy.sort_tree($item_list, $url, $cookie, $data_callback);
		});

	});

})(jQuery);
