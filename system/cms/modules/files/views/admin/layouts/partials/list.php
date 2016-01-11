
    <div class="box-body">

        <div>
          {{pagination:links}}</th>
        </div>

        <table class="table">
            <?php foreach ($files as $key => $value):?>
                <tr>
                    <td width='10%'>
                        <div class="img-div">
                            <?php if($value->type=='i'):?> 
                                <img alt="Attachment" class='' style='width:100px;' src="{{url:site}}files/thumb/<?php echo $value->filename;?>/400">
                            <?php else:?>

                                <?php

                                $icon_image_filename = ''; 

                                //if we have the extention use it
                                if(file_exists(FCPATH.'/system/cms/themes/oxygen_admin/img/file_types/'.str_replace('.','',$value->extension).'.png'))
                                {
                                    $icon_image_filename = site_url('system/cms/themes/oxygen_admin/img/file_types/'.str_replace('.','',$value->extension).'.png');
                                }
                                else
                                {
                                     switch($value->type) 
                                     {
                                        case 'v':
                                            $icon_image_filename = site_url('system/cms/themes/oxygen_admin/img/file_types/mp4.png');
                                            break;
                                        case 'a':
                                            $icon_image_filename = site_url('system/cms/themes/oxygen_admin/img/file_types/mp3.png');
                                            break;                                                    
                                        case 'doc':
                                            $icon_image_filename = site_url('system/cms/themes/oxygen_admin/img/file_types/doc.png');
                                            break;
                                        default:
                                            $icon_image_filename = site_url('system/cms/themes/oxygen_admin/img/file_types/generic.png');
                                     }
                                }

                                 ?>
                                
                                <img alt="" class='' style='width:100px;' src="<?php echo $icon_image_filename;?>">
                            <?php endif?>
                        </div>
                    </td>
                    <td width=''>
                        <a class="" href="{{url:site}}admin/files/file/view/<?php echo $value->id;?>">
                            <?php if ($value->type=='i'):?>
                                <i class="fa fa-camera"></i>
                            <?php else: ?>
                                <i class="fa fa-paperclip"></i>
                            <?php endif;?>
                            <?php echo $value->name;?>
                        </a>
                        <br>
                        <span class='calm_color'>
                            <?php echo $value->filesize;?> KB
                        </span>
                        <br>
                        <span style='color:#999'>
                            <?php echo $value->description;?>
                        </span>

                        <br>
                        <a class='download_file_link' href='{{url:site}}files/download/<?php echo $value->id;?>' class="" href="#">
                        <small>Download</small> 
                        </a> / <small style='color:#aaa'>Folder:<?php echo $value->folder;?></small>

                    </td>
                    <td>
                        <code>
                            {{noparse}}{{ files:image id="<?php echo $value->id;?>" }}{{/noparse}}
                        </code>
                    </td>
                    <td width=''>
                        <div class="pull-right">
       
                            <a href='{{url:site}}admin/files/file/view/<?php echo $value->id;?>' class="btn btn-flat btn-primary" href="#">
                                <i class="fa fa-pencil"></i>
                                Edit
                            </a>  
                                
                                <?php 
                                /*
                                <a href='{{url:site}}admin/files/file/delete/<?php echo $value->id;?>' class="btn btn-default btn-xs pull-right" href="#"><i class="fa fa-times"></i></a>
                                <a href='{{url:site}}admin/files/file/view/<?php echo $value->id;?>' class="btn btn-default btn-xs pull-right" href="#"><i class="fa fa-pencil"></i></a>  
                                <a href='{{url:site}}files/download/<?php echo $value->id;?>' class="btn btn-default btn-xs pull-right" href="#"><i class="fa fa-cloud-download"></i></a>                                                                              
                                */?>
              
                        </div>
                    </td>
                </tr>
            <?php endforeach;?> 
        </table>                               

        <div>
          {{pagination:links}}</th>
        </div>

    </div>
