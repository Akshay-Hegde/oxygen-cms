
<!-- Bootstrap Modal content-->
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              	<h4 class="modal-title">
            	  Rename {{name}}
          		</h4>
            </div>
            <div class="modal-body">

				<form id='renameform' action='admin/files/file/rename_post/{{id}}' method='post'>

					<input type='hidden' id='file_id' name='file_id' value='{{id}}'>
				    <div class="product">
				      <span class="product-description">
				      		<p>Enter new name here</p>
				         	<input type='text' class='form-control' id='newname' name='newname' value='{{name}}'>
				      </span>
				    </div>
				</form>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Cancel</button>
              <a class="mediSaveRenameFile btn btn-flat bg-blue btn-default pull-left" data-dismiss="modal">Save</a>
            </div>
        </div>
      </div>   
<script>

		$(document).on('click', 'a.mediSaveRenameFile',
			function(event) {
				event.preventDefault();

				//the uri to post to
				var uri 	= $('#renameform').attr('action');
				var file_id 	= $('#file_id').val();

				//build the object of info to post
				var sendinfo = { new_name:$('#newname').val() };
				
				//start posting
				$.post(uri,sendinfo).done(function(data)
				{
					var obj = jQuery.parseJSON(data);
	                if(obj.status == 'success') {
						$('#mediaListItem_'+file_id).html(sendinfo.new_name);
	                }
	                else {
	                	bootbox.alert('Error updating name');
	                }

				});

			}
		);

</script>