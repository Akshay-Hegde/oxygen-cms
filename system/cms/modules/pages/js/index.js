(function($) {
	$(function() {

		// set values for oxy.sort_tree (we'll use them below also)
		$item_list	= $('ul.sortable');
		$url		= 'admin/pages/order';
		$cookie		= 'open_pages';

		// store some common elements
		$details 	= $('div#page-details');
		$details_id	= $('div#page-details #page-id');

		// show the page details pane
		$item_list.find('li a').on('click', function(e) {
			e.preventDefault();

			$a = $(this);

			page_id 	= $a.attr('rel');
			page_title 	= $a.text();
			$('#page-list a').removeClass('selected');
			$a.addClass('selected');

			$('#page-details-view').load(SITE_URL + 'admin/pages/ajax_page_details/' + page_id);

			//for mobile devises
		    $('html, body').animate({
		        scrollTop: $('#page-details-view').offset().top
		    }, 2500);


			// return false to keep the list from toggling when link is clicked
			return false;
		});

		// retrieve the ids of root pages so we can POST them along
		data_callback = function(even, ui) {
			// In the pages module we get a list of root pages
			root_pages = [];
			// grab an array of root page ids
			$('ul.sortable').children('li').each(function(){
				root_pages.push($(this).attr('id').replace('page_', ''));
			});
			return { 'root_pages' : root_pages };
		}

		// the "post sort" callback
		post_sort_callback = function() {

			$details 	= $('div#page-details');
			$details_id	= $('div#page-details #page-id');

			// refresh pane if it exists
			if($details_id.val() > 0)
			{
				$details.load(SITE_URL + 'admin/pages/ajax_page_details/' + $details_id.val());
			}
		}

		// And off we go
		oxy.sort_tree($item_list, $url, $cookie, data_callback, post_sort_callback);

	});
})(jQuery);