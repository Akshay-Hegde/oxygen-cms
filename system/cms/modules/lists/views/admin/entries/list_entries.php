<div class="row">
    <div class="col-xs-3">

        <a class='btn btn-block bg-green' href='<?php echo site_url('admin/lists/entries/create/'.$list_slug)?>'>New Entry</a>

        <a class='btn btn-block btn-primary as_modal' href='<?php echo site_url('admin/lists/manage/viewoptions/'.$list_slug)?>'>View Options</a>

        <a class='btn btn-block btn-primary ' href='<?php echo site_url('admin/lists/admin_fields/listing/'.$list_slug)?>'>Manage Fields</a>

        <br>
        <div class="box box-solid">
        <?php echo form_open('admin/lists/lists/edit/'.$list->id);?>
            <form name='' action= method='post'>
                <div class="box-body">
                    <p>List Name</p>
                    <div>
                        <?php echo form_input('stream_name',$list->stream_name,'class="form-control"');?>
                    </div>
                    <p>Description</p>
                    <div>
                        <?php echo form_input('about',$list->about,'class="form-control"');?>
                    </div> 
                    <p>Slug</p>
                    <div>
                        <pre><?php echo $list->stream_slug;?></pre>
                    </div>                     
                    <div>
                        <br>
                        <button class='btn btn-flat btn-primary'>Save</button>
                    </div>               
                </div>
            <?php echo form_close();?>
        </div>

    </div>
    <div class="col-xs-9">
        <div class="box box-solid">

                <div class="box-header">
                  <h3 class="box-title"><?php echo $title;?></h3>
                </div>
                <div class="box-body">

                    <?php echo $html;?>

                </div>
        </div>
    </div>
</div>