// Notify top header widget
function notifyDashboard(count) {
    $('.dash_task_count').html(count);
}

// Helper to get HTML for dashboard widget
function taskHtml(name,id) {

    var str = '';
    str += '<li style="" class="" id="line_'+id+'" >';
    str += '<span class="handle ui-sortable-handle">';
    str += '<i class="fa fa-ellipsis-v"></i>';
    str += '<i class="fa fa-ellipsis-v"></i>';
    str += '</span>';
    str += '<input type="checkbox" name="" value="">';
    str += '<span class="text">'+name+'</span>';
    str += '<div class="tools">';
    str += '<a data-id="'+id+'" class="task_del" href="admin/tasks/del_ajax/'+id+'"><i class="fa fa-trash-o"></i></a>';
    str += '</div>';
    str += '</li>';
    return str;
}

// Helper to get HTML for dashboard header
function taskDashNotificationHtml(name,id,pcent,desc) {

    var str = '';
    str += '<li id="dash_task_item_'+id+'"><a href="admin/tasks/edit/'+id+'"><h3>' + name +'<small class="pull-right">'+desc+'</small></h3>';
    str += '<div class="progress xs">';
    str += '<div class="progress-bar progress-bar-aqua" style="width: '+pcent+'%" role="progressbar" aria-valuenow="'+pcent+'" aria-valuemin="0" aria-valuemax="100">';
    str += '<span class="sr-only">'+pcent+' % Complete</span>';
    str += '</div></div></a></li>';
    return str;
}



$(function() {

    // 
    // Code starts here
    //

    // Add items to the task list
    $(document).on('click','.task_adder', function(e){

        var task_n = $('.task_adder_task').val();
        var url = SITE_URL + 'admin/tasks/via_ajax';
        var cct = $("input[name=csrf_token_name]").val();

        var senddata = {csrf_token_name:cct,task:task_n};


        //now post to add
        $.post(url,senddata).done(function(data)
        {
            var obj = jQuery.parseJSON(data);

            if(obj.status == 'success') {

                html = taskHtml(task_n,obj.id);

                htmlDash = taskDashNotificationHtml(task_n,obj.id,'0','');
                //alert(htmlDash);
                $('.todo-list').append(html);
                $('#taskDashUL').append(htmlDash);

                $('.task_adder_task').val('');

                notifyDashboard(obj.count);
            }
            else {
                alert("Failed:"+ obj.message);
            }

        });
    
        e.preventDefault();
    });

    // Remove items from Task list
    $(document).on('click','.task_del', function(e){

        var id = $(this).attr('data-id');
        var url = SITE_URL + 'admin/tasks/del_ajax/' + id;

        $.post(url).done(function(data)
        {
            var obj = jQuery.parseJSON(data);

            if(obj.status == 'success') {
                $('#line_'+id).remove();
                $('#dash_task_item_'+id).remove();
                notifyDashboard(obj.count);

            }
            else {
                alert("Failed:"+ obj.message);
            }

        });
    
        e.preventDefault();
    });

    
    //
    // Code ends here
    //

});
