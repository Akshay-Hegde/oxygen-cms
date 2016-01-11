    <?php echo form_open('admin/files/folders/create');?>
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Create Folder</h4>
            </div>
            <div class="modal-body">

                <input type='text' name='name'>
                
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</a>
              <button class='btn btn-flat bg-blue'>Create Folder</button> 
            </div>
        </div>
      </div> 
      <?php echo form_close();?> 
