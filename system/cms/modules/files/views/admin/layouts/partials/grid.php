      
    <div class="box-body">

            <div class="row" >
                <div class="col-xs-12">
                <?php foreach ($files as $key => $value):?>
                    <div class="col-lg-2 col-sm-3 col-xs-4 " style='margin:5px;overflow:hidden'>
                            <a class="" href="{{url:site}}admin/files/file/view/<?php echo $value->id;?>">
                            <?php if($value->type=='i'):?> 
                                <div class='img-div'>
                                <img alt="Attachment" class='img-responsive' style='' src="{{url:site}}files/thumb/<?php echo $value->filename;?>/400">
                                </div>
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
                                <div class='img-div'>
                                <img alt="" class='img-responsive' style='' src="<?php echo $icon_image_filename;?>">
                                </div>
                            <?php endif?>
                                <?php echo truncate_string($value->name,20);?>
                            </a>
                    </div>
                <?php endforeach;?> 
                </div>
            </div>
                             
        <div>
          {{pagination:links}}</th>
        </div>

    </div>
