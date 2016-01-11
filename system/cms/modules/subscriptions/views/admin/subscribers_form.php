<?php echo form_open(site_url('admin/subscriptions/subscribe/'.$subscription_id), 'class="crud"') ?>
<div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
              		Subscribe to list
              </h4>
            </div>
            <div class="modal-body">

			    		<input type='hidden' name='subscription_id' value='<?php echo $subscription_id;?>'>

			    		Email: <input type='text' name='subscriber_email' class='form-control' value=''>

			    		<button>Save</button>

		    	
            </div>
        </div>
</div>
<?php echo form_close();?>
