
/**
* Pyro object
*
* The Pyro object is the foundation of all OxygenUI enhancements
*/

// It may already be defined in metadata partial
if (typeof(oxy) == 'undefined') {
	var oxy = {};
}



jQuery(function($) 
{

	// Set up an object for caching things
	oxy.cache = {
		// used for the slug generator
		url_titles	: {}
	}

	// Is Mobile?
	// @todo bug#7: Add the windows phone userAgent
	oxy.is_mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);

	// Overload the json converter to avoid error when json is null or empty.
	$.ajaxSetup({
		converters: {
			'text json': function(text) {
				var json = $.parseJSON(text);
				if (!$.ajaxSettings.allowEmpty && (json == null || $.isEmptyObject(json)))
				{
					$.error('The server is not responding correctly, please try again later.');
				}
				return json;
			}
		},
		data: {
			csrf_hash_name: $.cookie(oxy.csrf_cookie_name)
		}
	});


	// This initializes all JS goodness
	oxy.init = function() {

		//$("#datepicker, .datepicker").datepicker({dateFormat: 'yy-mm-dd'});

		// Enable/Disable table action buttons
		// Add class "btn-action-all" to all group action buttons
		$(document).on('click','input[name="action_to[]"], .check-all' ,function () {
			if( $('input[name="action_to[]"]:checked, .check-all:checked').length >= 1 ){
				$(".btn-action-all").prop('disabled', false);
			} else {
				$(".btn-action-all").prop('disabled', true);
			}
		});
		
		//
		// Confirmation Dialog on .confirm btns
		//
		$(document).on('click','a.confirm', function(e){
			e.preventDefault();

			var href		= $(this).attr('href');
			var	removemsg	= ($(this).attr("confirm-text")) ? $(this).attr('confirm-text') : $(this).attr('title') ;

			var message = removemsg || oxy.lang.dialog_message;

				bootbox.dialog({
				  message: message,
				  title: "Please confirm this action",
				  buttons: {
				    success: {
				      label: "Yes",
				      className: "btn btn-flat btn-success bg-red",
				      callback: function() {
							$(this).trigger('click-confirmed');

							if ($.data(this, 'stop-click')){
								$.data(this, 'stop-click', false);
								return;
							}
							window.location.replace(href);
				      }
				    },
				    error: {
				      label: "No",
				      className: "btn btn-flat bg-white",
				      callback: function() {
	
				      }
				    },
				}
		
				});		
		});
		

		//use a confirm dialog on "delete many" buttons
		$(document).on('click', ':submit.confirm', function(e, confirmation){

			if (confirmation)
			{
				return true;
			}

			e.preventDefault();

			var removemsg = $(this).attr('title');
			var message = removemsg || oxy.lang.dialog_message;

			if (confirm(removemsg))
			{
				$(this).trigger('click-confirmed');

				if ($(this).data('stop-click')){
					$(this).data('stop-click', false);
					return;
				}

				$(this).trigger('click', true);
			}


		});

		/**	
		 * Built in hiodden filters and toggle diaplay
		 */
	    $(document).on('click', 'a.filterToggleBtn', function(event) {

	    	//set default id, then check if one exist
	    	var div = '.oxygen_hidden_filters';
			var attr = $(this).attr('data-filter-div');

			// For some browsers, `attr` is undefined; for others,
			// `attr` is false.  Check for both.
			if (typeof attr !== typeof undefined && attr !== false) {
			    div = attr;
			}

			$(div).toggle();

	        event.preventDefault();
	    });





		//use a confirm dialog on "delete many" buttons
		$(':submit.confirm').on('click',':submit.confirm', function(e, confirmation){

			if (confirmation) {
				return true;
			}

			e.preventDefault();

			var removemsg = $(this).attr('title');

			if (confirm(removemsg || oxy.lang.dialog_message))
			{
				$(this).trigger('click-confirmed');

				if ($(this).data('stop-click')){
					$(this).data('stop-click', false);
					return;
				}

				$(this).trigger('click', true);
			}
		});
	};


	//	
	// Somehow we need to get the details of the module
	// perhaps the metadata could set this and this 
	// function could get thatvalue stored in js meta
	oxy.currntModule = function()
	{

	}

	oxy.myFunction = function()
	{
		if( oxy.is_mobile ){
			
		} else {

		}
	}




	/**
	 * Autocomplete Search
	 * @deprecated
	 */
	/*
	oxy.init_autocomplete_search = function() {
		var cache = {}, lastXhr;
		$(".search-query").autocomplete({
			minLength: 2,
			delay: 250,
			source: function( request, response ) {
				var term = request.term;
				if ( term in cache ) {
					response( cache[ term ] );
					return;
				}
				lastXhr = $.getJSON(SITE_URL + 'admin/search/ajax_autocomplete', request, function( data, status, xhr ) {
					cache[ term ] = data.results;
					if ( xhr === lastXhr ) {
						response( data.results );
					}
				});
			},
			
			open: function (event, ui) {
				$(this).data("autocomplete").menu.element.addClass("search-results animated-zing dropDown");
			},
			
			focus: function(event, ui) {
				// $("#searchform").val( ui.item.label);
				return false;
			},
			select: function(event, ui) {
				window.location.href = ui.item.url;
				return false;
			}
		});
	};
	*/

	/* 
	 * @requires 	TagsInput.js and css
	 *  			We should load this up everty admin page load
	 */
	oxy.tagsInput = function(txt_object, url)
	{
		$(txt_object).tagsInput({
			autocomplete_url: url
		});
	};

	/**
	 * This func needs a re-write
	 *
	 */
	oxy.add_notification = function(notification, options, callback)
	{
		var defaults = {
			clear	: true,
			ref		: '#content-body',
			method	: 'prepend'
		}, opt;

		// extend options
		opt = $.isPlainObject(options) ? $.extend(defaults, options) : defaults;

		// clear old notifications
		//opt.clear && oxy.clear_notifications();

		// display current notifications
		$(opt.ref)[opt.method](notification);

		// call callback
		$(window).one('notification-complete', function(){
			callback && callback();
		});

		return oxy;
	};

	// Used by Pages and Navigation and is available for third-party add-ons.
	// Module must load jquery/jquery.ui.nestedSortable.js and jquery/jquery.cooki.js
	oxy.sort_tree = function($item_list, $url, $cookie, data_callback, post_sort_callback, sortable_opts)
	{
		// set options or create a empty object to merge with defaults
		sortable_opts = sortable_opts || {};
		
		// collapse all ordered lists but the top level
		$item_list.find('ul').children().hide();

		// this gets ran again after drop
		var refresh_tree = function() {

			// add the minus icon to all parent items that now have visible children
			$item_list.find('li:has(li:visible)').removeClass().addClass('minus');

			// add the plus icon to all parent items with hidden children
			$item_list.find('li:has(li:hidden)').removeClass().addClass('plus');
			
			// Remove any empty ul elements
			$('.plus, .minus').find('ul').not(':has(li)').remove();
			
			// remove the class if the child was removed
			$item_list.find("li:not(:has(ul li))").removeClass();

			// call the post sort callback
			post_sort_callback && post_sort_callback();
		}
		refresh_tree();

		// set the icons properly on parents restored from cookie
		$($.cookie($cookie)).has('ul').toggleClass('minus plus');

		// show the parents that were open on last visit
		$($.cookie($cookie)).children('ul').children().show();

		// show/hide the children when clicking on an <li>
		$item_list.find('li').on('click', function()
		{
			$(this).children('ul').children().slideToggle('fast');

			$(this).has('ul').toggleClass('minus plus');

			var items = [];

			// get all of the open parents
			$item_list.find('li.minus:visible').each(function(){ items.push('#' + this.id) });

			// save open parents in the cookie
			$.cookie($cookie, items.join(', '), { expires: 1 });

			 return false;
		});
		
		// Defaults for nestedSortable
		var default_opts = {
			delay: 100,
			disableNesting: 'no-nest',
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .4,
			placeholder: 'placeholder',
			tabSize: 25,
			listType: 'ul',
			tolerance: 'pointer',
			toleranceElement: '> div',
			update: function(event, ui) {

				post = {};
				// create the array using the toHierarchy method
				post.order = $item_list.nestedSortable('toHierarchy');

				// pass to third-party devs and let them return data to send along
				if (data_callback) {
					post.data = data_callback(event, ui);
				}

				// Refresh UI (no more timeout needed)
				refresh_tree();

				$.post(SITE_URL + $url, post );
			}
		};

		// Init nestedSortable with options
		// But first check if its available, 
		// some admins do not get sortable rights
		if (typeof $item_list.nestedSortable !== 'undefined' && $.isFunction($item_list.nestedSortable)) {
			$item_list.nestedSortable($.extend({}, default_opts, sortable_opts));
		}
	}

	// 
	// Create a clean slug from whatever garbage is in the title field
	// Requires slugify jq extention function
	//
	oxy.generate_slug = function(input_form, output_form, space_character, disallow_dashes)
	{
		space_character = space_character || '-';
		/*
		var ivalue = $(input_form).val();
		var ovalue = slugify(ivalue);
		$(output_form).val(ovalue);
		*/

		$(document).on('keyup',input_form,function(event) {
 	 		$(output_form).val(slugify($(input_form).val(),space_character));
		});

	}


	$(document).ajaxError(function(e, jqxhr, settings, exception) {
		if (exception != 'abort' && exception.length > 0) {
			oxy.add_notification($('<div class="alert error">'+exception+'</div>'));
		}
	});

	$(document).ready(function() {
		oxy.init();
		//oxy.init_autocomplete_search();
	});


	// Draggable / Droppable
	$("#sortable").sortable({
		placeholder : 'dropzone',
	    handle : '.draggable',
	    update : function () {
	      var order = $('#sortable').sortable('serialize');
	    }
	});

	//functions for codemirror
	$('.html_editor').each(function() {
		CodeMirror.fromTextArea(this, {
		    mode: 'text/html',
		    tabMode: 'indent',
			height : '500px',
			width : '500px',
		});
	});

	$('.css_editor').each(function() {
		CodeMirror.fromTextArea(this, {
		    mode: 'css',
		    tabMode: 'indent',
			height : '500px',
			width : '500px',
		});
	});

	$('.js_editor').each(function() {
		CodeMirror.fromTextArea(this, {
		    mode: 'javascript',
		    tabMode: 'indent',
			height : '500px',
			width : '500px',
		});
	});
});


////
//
//
//
//
////
jQuery(function($) 
{
	//
	// OxygenCMS auto filter API
	//
	oxy.filter = {
		$content		: $('#filter-stage'),
		// filter form object
		$filter_form	: $('#filters form'),

		//lets get the current module,  we will need to know where to post the search criteria
		f_module		: $('input[name="f_module"]').val(),

		//auto_filter_enabled is `disabled` or other, if other then auto filter is enabled,
		//place a hidden filter_mode with `disabled` to disable the auto filter
		mode		: $('input[name="auto_filter_enabled"]').val(),


		/**
		 * Constructor
		 */
		init: function(){

			//$('a.cancel').button();

			//listener for select elements
			$('select', oxy.filter.$filter_form).on('change', function(){

				//build the form data
				form_data = oxy.filter.$filter_form.serialize();

				//fire the query
				oxy.filter.do_filter(oxy.filter.f_module, form_data);
			});

			//listener for keywords
			$('input[type="text"]', oxy.filter.$filter_form).on('keyup', $.debounce(500, function(){

				//build the form data
				form_data = oxy.filter.$filter_form.serialize();

				oxy.filter.do_filter(oxy.filter.f_module, form_data);
			
			}));
	
			//listener for pagination
			//allows links to ajax_post filter, but its buggy and needs work. 
			// currently it works, but on some lists it just doesnt filter if the filter-stage is setup incorrectly
			//also only do this for pagination within the filter field-set?
			$('body').on('click', '.pagination a', function(e){

				if(oxy.filter.mode == 'disabled') {

				} else {
					//do not do page load
					e.preventDefault();
					//get the location to load
					url = $(this).attr('href');
					form_data = oxy.filter.$filter_form.serialize();
					oxy.filter.do_filter(oxy.filter.f_module, form_data, url);
				}

			});
			
			
			//clear filters
			$(document).on('click','a.cancel', oxy.filter.$filter_form,function(event){
				//reset the defaults
				//$('select', filter_form).children('option:first').addAttribute('selected', 'selected');
				$('select', oxy.filter.$filter_form).val('0');
				
				//clear text inputs
				$('input[type="text"]').val('');
		
				//build the form data
				form_data = oxy.filter.$filter_form.serialize();
		
				oxy.filter.do_filter(oxy.filter.f_module, form_data);

				event.preventDefault();
			});
			
			//prevent default form submission
			oxy.filter.$filter_form.submit(function(e){
				e.preventDefault(); 
			});

			// trigger an event to submit immediately after page load
			oxy.filter.$filter_form.find('select').first().trigger('change');
		},
	
		//launch the query based on module
		do_filter: function(module, form_data, url){
			form_action	= oxy.filter.$filter_form.attr('action');
			post_url	= form_action ? form_action : SITE_URL + 'admin/' + module;

			if (typeof url !== 'undefined'){
				post_url = url;
			}

			//oxy.clear_notifications();

			oxy.filter.$content.fadeOut('fast', function(){
				//send the request to the server
				$.post(post_url, form_data, function(data, response, xhr) {
					
					var ct		= xhr.getResponseHeader('content-type') || '',
						html	= '';

					if (ct.indexOf('application/json') > -1 && typeof data == 'object')
					{
						html = 'html' in data ? data.html : '';

						oxy.filter.handler_response_json(data);
					}
					else {
						html = data;
					}

					//success stuff here
					oxy.filter.$content.html(html).fadeIn('fast');
				});
			});
		},

		handler_response_json: function(json)
		{
			if ('update_filter_field' in json && typeof json.update_filter_field == 'object')
			{
				$.each(json.update_filter_field, oxy.filter.update_filter_field);
			}
		},

		update_filter_field: function(field, data)
		{
			var $field = oxy.filter.$filter_form.find('[name='+field+']');

			if ($field.is('select'))
			{
				if (typeof data == 'object')
				{
					if ('options' in data)
					{
						var selected, value;

						selected = $field.val();
						$field.children('option').remove();

						for (value in data.options)
						{
							$field.append('<option value="' + value + '"' + (value == selected ? ' selected="selected"': '') + '>' + data.options[value] + '</option>');
						}
					}
				}
			}
		}
	};

	oxy.filter.init();
});
	//
	//
	//

// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
//@deprecated: I think this can now be removed
/*
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console) {
    arguments.callee = arguments.callee.caller;
    var newarr = [].slice.call(arguments);
    (typeof console.log === 'object' ? log.apply.call(console.log, console, newarr) : console.log.apply(console, newarr));
  }
}
*/

// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,timeStamp,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try
{console.log();return window.console;}catch(err){return window.console={};}})());

String.prototype.ucfirst = function() {
  return this.charAt(0).toUpperCase() + this.slice(1);
}

/*
//create slug
    // using functions/slugify.js
    $(document).on('keyup',from_field_id,function(event) {
      $(to_field_id).val(slugify($(from_field_id).val()));
    });
*/




jQuery(function($) {

	// Modal Window event listener
	$(document).on('click','.as_modal',function(event) {
		//we need to communicate to server
		var link_href = $(this).attr('href');

		event.preventDefault();

		//hide if one exists
		$('#dyna-modal').modal('hide');
		
		// Load the details box in
		$('#dyna-modal .modal-content').load(link_href, function(){
			//$('div#link-details.group-'+ id +'').fadeIn();
			$('#dyna-modal').modal('show');
		});

	});

});	

function slugify(str,special_char) {

  special_character = special_char || '-';
  str = str.replace(/^\s+|\s+$/g, ''); // trim
  str = str.toLowerCase();
  
  // remove accents, swap ñ for n, etc
  var from = "ĺěščřžýťňďàáäâèéëêìíïîòóöôùůúüûñç·/_,:;";
  var to   = "lescrzytndaaaaeeeeiiiioooouuuuunc------";
  for (var i=0, l=from.length ; i<l ; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }

  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, special_character) // collapse whitespace and replace by _
    .replace(/-+/g, special_character); // collapse dashes

  return str;
}


//////
//////

// Search //

//////
//////


    $(function(){

        //listen for search result as they are posted.
        $(document).on('click','#sidebar-search-form #sq_btn',function(event){

            $('#sidebar-search-form #q').val('');
            reset_search();
            event.preventDefault();
        });

        //listener for keywords
        $(document).on('input propertychange paste','#sidebar-search-form #q', $.debounce(550, function(event){

            //replace search button with close
            //var text = $('#sidebar-search-form #q').val().trim().toLowerCase();
            var text = $(this).val().trim().toLowerCase();

            //not quite working, also this should be 550
            do_oxysearch(text);
        }));

    });

    function do_oxysearch(text)
    {
        // init
        var found = false;

        //
        // Reset the filters
        //
        reset_search();

        //exit early if blank search
        if(text=='') {
            event.preventDefault();
            return;
        }

        // 
        // Search Menus
        //
        $('ul.control-panel-menu li.nav_filter').each(function() {
                var listitem = $(this);
                var listterms = listitem.attr('search-terms').toLowerCase().trim();
                if(listterms.indexOf(text)>-1)
                {
                    found = true;
                    var cloned = listitem.clone();
                    console.log(cloned.find('ul').remove());
                    $('ul.results-display-menu').append(cloned);
                }
        });


        //
        // Search modules
        //
        $.post('admin/search',{'q':text},function(data){
            x = jQuery.parseJSON(data);
            results = x.results;
            if(results.length > 0) {
                found = true;
                var li = '<li class="fs_reset admin_menu"> <a style="color:#3c8dbc"> <i class="fa fa-search"></i> Other Results</a></li>';
                var mli = '<li class="fs_reset admin_menu"> <a style="color:#3c8dbc"> <i class="fa fa-search"></i> Menu Results</a></li>';
                $('ul.results-display-menu').append(li);
                $('ul.results-display-menu').prepend(mli);
            }
            for(i=0;i<results.length;i++) {
                var li = '<li class="fs_reset admin_menu"><a href="'+ results[i].admin_url+'"><i class="'+ results[i].icon+'"></i>'+ results[i].module+': '+ results[i].title+'</a></li>';
                $('ul.results-display-menu').append(li);
            }
        });

        if(!found) {
            var li = '<li class="fs_reset admin_menu"> <a><i class="fa fa-exclamation-triangle"></i> No results found</a></li>';
            $('ul.results-display-menu').append(li);
        }

        //
        // Show results
        //
        $('ul.results-display-menu').show();
        $('ul.control-panel-menu').hide();



        //
        // addons/plugins (Displays modal for docs)
        //
        $(document).on('click','a.plugin_doc_anchor', function(event) {
            var slug = $(this).attr('data-slug');
            $('#plugin-doc-'+slug.toLowerCase()).modal('show');
            event.preventDefault();
        });     

    }

    function reset_search()
    {
        //
        // Reset the filters
        //
        $('li.nav_filter').show();
        $('ul li.fs_reset.admin_menu').remove();
        $('ul.results-display-menu').empty();
        $('ul.results-display-menu').hide();
        $('ul.control-panel-menu').show();
        //clear the results menu
        $('ul.results-display-menu li.fs_reset.admin_menu').each(function() {
            var listitem = $(this);
            listitem.remove();
        });
    }

