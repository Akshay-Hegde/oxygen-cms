<?php echo form_open(uri_string(), 'class="crud"') ?>
<div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
					<?php if ($this->method == 'edit'): ?>
					    	Edit
					<?php else: ?>
					    	Create
					<?php endif ?>
              </h4>
            </div>
            <div class="modal-body">
		    	<?php echo form_open();?>

		    		<?php if(isset($subscription)):?>
		    			<input type='hidden' name='id' value='<?php echo $subscription->id;?>'>
		    		<?php endif; ?>

		    		Name: <input type='text' name='name' class='form-control' value='<?php echo (isset($subscription))?$subscription->name:"";?>'>

		    		<?php if(isset($subscription)):?>
		    		
		    		<?php endif; ?>

		    		<button>Save</button>
		    	<?php echo form_close();?>
            </div>
        </div>
</div>
