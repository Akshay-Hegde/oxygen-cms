
<input name='type' type="hidden"  value='<?php echo $file->type;?>'>

<div class="row">

    <div class="col-xs-12">

        <div class="col-xs-3">

            <div class="box box-solid">

                  <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $file->name;?></h3>
                    <div class="box-tools pull-right">
                      <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body">

 
                    <img class='img-responsive  center-block' src='<?php echo $file->path;?>'>


                </div><!-- /.box-body -->

            </div>

            <div class="box box-solid">

                  <div class="box-header with-border">
                    <h3 class="box-title">Metadata</h3>
                    <div class="box-tools pull-right">
                      <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body">

                    <ul class="products-list">

                      <li class="item">
                        <div class="product">
                          <a class="product-title" href="javascript::;">Permalink </a>
    
                           

     
                                <input type="text" class="form-control" readonly=readonly value='{{url:site}}files/large/<?php echo $file->id;?>'>
              
           
                        </div>
                      </li><!-- /.item -->
                     
                      <?php $data_n = 'Direct Access';?>
                      <?php echo $this->load->view('files/admin/partials/item',['data_name'=>$data_n,'data_value'=>$file->direct_access]); ?>

                      <?php $data_n = 'Dimentions';?>
                      <?php $data_v = $file->height . ' &times; ' . $file->width;?>
                      <?php echo $this->load->view('files/admin/partials/item',['data_name'=>$data_n,'data_value'=>$data_v]); ?>

                      <?php $data_n = 'MimeType';?>
                      <?php $data_v = $file->mimetype;?>
                      <?php echo $this->load->view('files/admin/partials/item',['data_name'=>$data_n,'data_value'=>$data_v]); ?>


                      <?php $data_n = 'FileSize [Kb]';?>
                      <?php $data_v = $file->filesize;?>
                      <?php echo $this->load->view('files/admin/partials/item',['data_name'=>$data_n,'data_value'=>$data_v]); ?>

                      <?php $data_n = 'Download Count';?>
                      <?php $data_v = $file->download_count;?>
                      <?php echo $this->load->view('files/admin/partials/item',['data_name'=>$data_n,'data_value'=>$data_v]); ?>
                    </ul>

                  </div><!-- /.box-body -->
                  <div class="box-footer text-center">
                    <a class="uppercase" href="admin/files/browse">Back to file list</a>
                  </div><!-- /.box-footer -->
            </div>
           
            <div class=''>
                <!--<a href='{{url:site}}files/large/<?php echo $file->id;?>' class='as_modal btn-block btn bg-green'>Preview</a>-->
                <a href='{{url:site}}files/download/<?php echo $file->id;?>' class='btn-block btn bg-green'>Download</a>
                <a href='admin/files/file/delete/<?php echo $file->id;?>' class='btn-block btn bg-red confirm'><i class="fa fa-times"></i> Delete</a>
            </div>
            <br> 

        </div>

        <div class="col-xs-9">
            <?php echo form_open('admin/files/file/update/'.$file->id);?>
            <div class="box box-solid">

                  <div class="box-header with-border">
                    <h3 class="box-title">Details</h3>
                    <div class="box-tools pull-right">
                    
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body">

                    <ul class="products-list">

                      <li class="item">
                        <div class="product">
                          <a class="product-title" href="javascript::;">Name </a>
                          <span class="product-description">
                            <input name='name' type="text" placeholder="Enter ..." class="form-control" value='<?php echo $file->name;?>'>
                          </span>
                        </div>
                      </li><!-- /.item -->


                      <li class="item">
                        <div class="product">
                          <a class="product-title" href="javascript::;">ALT Text </a>
                          <span class="product-description">
                            <input name='alt_attribute' type="text" placeholder="Enter ..." class="form-control" value='<?php echo $file->alt;?>'>
                          </span>
                        </div>
                      </li><!-- /.item -->


                      <li class="item">
                        <div class="product">
                          <a class="product-title" href="javascript::;">Description </a>
                          <span class="product-description">
                            <textarea name='description'  type="text" placeholder="Enter ..." class="form-control" ><?php echo $file->description;?></textarea>
                          </span>
                        </div>
                      </li><!-- /.item -->


                      <li class="item">
                        <div class="product">
                          <a class="product-title" href="javascript::;">Keywords </a>
                          <span class="product-description">
                             <input id='keywords' name='keywords' type="text" class="keywords" value='<?php echo $file->keywords;?>'>
                          </span>
                        </div>
                      </li><!-- /.item -->

                    </ul>


                  </div><!-- /.box-body -->
                  <div class="box-footer text-center">
                    <div class="pull-left">
                    <input type='submit' value='Save File' class='btn btn-flat bg-blue '>

                    </div>                  
                    <div class="pull-right">
                         
                         
                     </div>
                  </div><!-- /.box-footer -->
            </div>
            <?php echo form_close();?>

        </div>

        <div class="col-xs-9">

            <div class="box box-solid">

                  <div class="box-header with-border">
                    <h3 class="box-title">Replace <?php echo $file->name;?></h3>
                    <div class="box-tools pull-right">
                      <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body">
                    <div>
                        <p>
                            Replace the file by uploading a new one, while keeping the file_id the same.
                        </p>
                        <!-- Main data panel-->
                        <?php echo form_open_multipart('admin/files/file/replace/'.$file->id);?>
                            <input type="hidden" name='file_id'     value='<?php echo $file->id;?>'>
                            <input type="hidden" name='folder_id'   value='<?php echo $file->folder_id;?>'>
                            <div class='input-group input-group-sm'>
                                <input id='userfile' name='userfile' type="file" class="form-control">
                                <span class='input-group-btn'>
                                    <input type='submit' value='Replace File' class='btn btn-flat bg-blue'>
                                </span>
                            </div>
                            <br>
                        <?php echo form_close();?>
                    </div>
                  </div>
            </div>
        </div>        

    </div>

</div>

<script>
(function($) {
  $(function(){

    // needed so that Keywords can return empty JSON
    $.ajaxSetup({
        allowEmpty: true
    });


    $("#keywords").tagsInput({
        autocomplete_url: SITE_URL + 'admin/keywords/autocomplete'
    });

  });
})(jQuery);
</script>