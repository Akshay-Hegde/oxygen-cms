<script>
    var _token_name = "<?php echo $this->security->get_csrf_token_name();?>";
    var _token_value = "<?php echo $this->security->get_csrf_hash();?>";
</script>

<div class="row">

        <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
            <a class="btn btn-primary btn-block margin-bottom as_modal" href="admin/files/folders/create">New Folder</a>
        </div>

        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">


            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">Folders</h3>
                </div>          
                <div class="box-body">

                        
                      <table id="standard_data_table" class="table table-striped">
                        <thead>
                          <tr>
                              <th></th>
                              <th>Name</th>
                              <th>Description</th>
                          </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($folders as $key => $folder):?>
                                <tr>
                                    <td><?php echo $folder->id;?></td>   
                                    <td><?php echo $folder->name;?></td>                    
                                    <td>
                                        <span style='float:right'> 
                                              <a href='{{url:site}}admin/files/folders/delete/<?php echo $folder->id;?>' class='btn btn-sm btn-flat bg-red confirm '>Delete</a>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach;?>                                
                        </tbody>

                      </table>

                        <div>
                          {{pagination:links}}</th>
                        </div> 

                </div>
            </div>
      
    </div><!-- /.col -->

</div><!-- /.row -->