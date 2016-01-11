
<div id="filters">

<?php
  echo form_open(current_url()); 
  echo form_hidden('f_module', $module_details['slug']); 
  ?>
        <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
            
            <a class="btn btn-primary btn-block as_modal" href="admin/files/upload/ajax_display">Upload Files</a>
            <a class="btn btn-primary btn-block margin-bottom as_modal" href="admin/files/folders/create">New Folder</a>
            

            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">Filters</h3>
                </div>          
                <div class="box-body">
                       <?php echo form_open('admin/files/browse/filter');?>
                       Filter by Folder:<br><?php echo form_dropdown('f_filter_folder',$folders,$folder,'class="form-control"');?>
                       View per page:<?php echo form_dropdown('f_filter_count',$filter_count_values,$per_page,'class="form-control"');?>
                       <br>
                       View:<?php echo form_dropdown('f_filter_view_method',['list'=>'List','grid'=>'Grid'],$f_filter_view_method,'class="form-control"');?>
                       <br>                       
                       <?php echo form_close();?>
                </div>
            </div>
        </div>

<?php      
  echo form_close();
?>
</div>  