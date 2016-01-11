<script>
    var _token_name = "<?php echo $this->security->get_csrf_token_name();?>";
    var _token_value = "<?php echo $this->security->get_csrf_hash();?>";
</script>

<div class="row">
    <div class='col-xs-12'>

        <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
            
            <a class="btn btn-primary btn-block margin-bottom as_modal" href="admin/files/upload/ajax_display">Upload Files</a>
            <a class="btn btn-warning btn-block margin-bottom as_modal" href="admin/files/folders/create">Create Folder</a>

            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">Filters</h3>
                </div>          
                <div class="box-body">
                       <?php echo form_open('admin/files/browse/filter');?>
                       Filter by Folder:<br><?php echo form_dropdown('filter_folder',$folders,$folder,'class="form-control"');?>
                       View per page:<?php echo form_dropdown('filter_count',$filter_count_values,$per_page,'class="form-control"');?>
                       <br>
                       <button class='btn btn-sm btn-flat bg-blue'><i class='fa fa-refresh'></i> Reload</button>
                       <?php echo form_close();?>
                </div>
            </div>
        </div>

       <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Files</h3>
                </div>          
                <div class="box-body">

                    
                    <ul class="mailbox-attachments clearfix">
                        <?php foreach ($files as $key => $value):?>
                            <li>

                                <?php if($value->type=='i'):?>
                                    <span class="mailbox-attachment-icon has-img" style='height:200px;min-width:100px;'>
                                        <img alt="Attachment" style='min-height:100px;min-width:100px;' src="{{url:site}}files/thumb/<?php echo $value->filename;?>/150/150">
                                    </span>
                                <?php else:?>
                                    <span class="mailbox-attachment-icon" style='height:200px;min-width:100px;'>
                                         <?php  $ticon = 'text';
                                         switch($value->type) {
                                            case 'v':
                                                $ticon = 'video';
                                                break;
                                            case 'a':
                                                $ticon = 'sound';
                                                break;                                                    
                                            case 'doc':
                                                $ticon = 'word';
                                                break;
                                         } ?>
                                         <i class="fa fa-file-<?php echo $ticon;?>-o"></i>
                                    </span>
                                <?php endif?>

                                <div class="mailbox-attachment-info"  style='height:100px;min-width:100px;'>
                                    <a class="mailbox-attachment-name" href="#">
                                        <?php echo ($value->type=='i')?'<i class="fa fa-camera"></i>':'<i class="fa fa-paperclip"></i>'; ?>
                                        <?php echo $value->name;?></a>
                                    </a>
                                    <div class="">
                                        <span class="mailbox-attachment-size">
                                            <?php echo $value->filesize;?> KB
                                            <a href='{{url:site}}admin/files/file/delete/<?php echo $value->id;?>' class="btn btn-default btn-xs pull-right" href="#"><i class="fa fa-times"></i></a>
                                            <a href='{{url:site}}admin/files/file/view/<?php echo $value->id;?>' class="btn btn-default btn-xs pull-right" href="#"><i class="fa fa-pencil"></i></a>  
                                            <a href='{{url:site}}files/download/<?php echo $value->id;?>' class="btn btn-default btn-xs pull-right" href="#"><i class="fa fa-cloud-download"></i></a>                                                                              
                                        </span>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach;?> 
                    </ul>                               

                    <div>
                      {{pagination:links}}</th>
                    </div>

                </div>
            </div>

        </div>
        
    </div>
</div>