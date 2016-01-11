/*
 * Add a totl inbox value to an element
/*
$.fn.indicator = function(value) {
    $(this).first('span').html(value);
};
*/
var mailbox_require_update = false;
var mailbox_interval_minutes = 15;


function update_mail_interval(min)
{
    mailbox_interval_minutes = min;

    console.log('Updated interval');

    clearInterval(checker);

    var interval = ((mailbox_interval_minutes * 1000) * 60);

    var checker = setInterval(check_mailbox_status,interval);  

    //just for the first time
    setTimeout(check_mailbox_status,500); 

}

function check_mailbox_status()
{
    var url = BASE_URL + 'admin/email/maintenance/import';
    $.post( url, function() {

    	var url = BASE_URL + 'admin/email/ajax_check_status';
        $.post(url, function( data ) {
            var o = jQuery.parseJSON(data);
            if( o.status =='success' ) {

                if(o.notify =='notify') {
                    show_message_status(o.message);
                }

                $('span#mailbox_inbox_count').html(o.mailboxdata.new);
                
                //for both notify and non-notify
                console.log(o.message);
                
            }
        });

    });
}

function show_message_status(message)
{
    $('#remote_dismissable').remove();
    
	var str = "<div id='remote_dismissable' class='alert alert-info alert-dismissable'><h4>";
	str += "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><i class='icon fa fa-info'></i> Alert!</h4>";
	str += message + "</div>";

	$('.mailbox_status_message_area').append(str)
}

if(mailbox_require_update == false)
{
	var interval = ((mailbox_interval_minutes * 1000) * 60);

	//now set as timer/interval
	var checker = setInterval(check_mailbox_status,interval);
}


$(function(){

    $(document).on('click','.delete_mail', function(event) {

        var url = $(this).attr('url');
        var uid = $(this).attr('uid');

        bootbox.confirm({ 
            size: 'small',
            message: "Are you sure you want to delete this item ?", 
            callback: function(result){ 
                if(result==true)
                {
                   
                    $.post(url, function( data ) {
                        var o = jQuery.parseJSON(data);
                        if( o.status =='success' ) {
                            $('table tr#'+uid).remove();
                        }
                    });
                }
            }
        });

        event.preventDefault();
    });

    $(document).on('click','.toggle_star_link', function(event) {

        var url = $(this).attr('url');
        var star = $(this);

        $.post(url, function( data ) {
            var o = jQuery.parseJSON(data);
            if( o.status =='success' ) {


                console.log('removing classes');
                console.log($(this).attr('class'));

                if( o.is_star == true ) {
                     star.attr("class","toggle_star_link fa fa-star text-yellow");
                }
                else  {
                     star.attr("class","toggle_star_link fa fa-star-o");
                }
            }
        });

        event.preventDefault();
    });



});       