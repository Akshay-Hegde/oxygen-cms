<?php echo form_open(uri_string(), 'class="crud"') ?>
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
             
              <h4 class="modal-title">
						<?php if ($this->method == 'edit'): ?>
							<?php echo sprintf(lang('keywords:edit_title'), $keyword->name) ?>
						<?php else: ?>
						    <?php echo lang('keywords:add_title') ?>
						<?php endif ?>
              </h4>
            </div>
            <div class="modal-body">

					<div class="form_inputs">
						<label for="name"><?php echo lang('keywords:name');?> <span>*</span></label>
						<div class="input"><?php echo form_input('name', $keyword->name);?></div>
						<br>
					</div>
                
            </div>
            <div class="modal-footer">
						<?php if ($this->method == 'edit'): ?>
							<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save','cancel') )) ?>
						<?php else: ?>
						    <a href="#" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</a>
						    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
						<?php endif ?>

            	
            	
            </div>
        </div>
      </div> 

<?php echo form_close();?>


<script type="text/javascript">
	jQuery(function($) {
		$('form input[name="name"]').on('keyup',$.debounce(100, function(){
			$(this).val( this.value.toLowerCase().replace(',', '') );
		}));
	});
</script>