<style>
p.read-only {
	background:#eee;
}
</style>
<div class="row">
    <div class="col-xs-12">

        <div class="box box-solid">

            <div class="box-header with-border">
                <h3 class="box-title">
					<?php echo sprintf(lang('comments:edit_title'), $comment->id) ?>
                </h3>
            </div>  

            <div class="box-body">      
				<?php echo form_open($this->uri->uri_string(), 'class="form_inputs"') ?>

					<?php echo form_hidden('user_id', $comment->user_id) ?>
					<?php echo form_hidden('active', $comment->is_active) ?>

					<ul class="fields">
						<?php if ( ! $comment->user_id): ?>
						<li>
							<label for="user_name"><?php echo lang('comments:name_label') ?>:</label>
							<div class="input">
								<?php echo form_input('user_name', $comment->user_name, 'class="form-control" maxlength="100"') ?>
							</div>
						</li>

						<li>
							<label for="user_email"><?php echo lang('global:email') ?>:</label>
							<div class="input">
								<?php echo form_input('user_email', $comment->user_email, 'class="form-control" maxlength="100"') ?>
							</div>
						</li>
						<?php else: ?>
						<li>
							<label for="user_name"><?php echo lang('comments:name_label') ?>:</label>
							<p class='read-only form-control'><?php echo $comment->user_name ?></p>
						</li>
						<li>
							<label for="user_email"><?php echo lang('global:email') ?>:</label>
							<p class='read-only form-control'><?php echo $comment->user_email ?></p>
						</li>
						<?php endif ?>

						<li>
							<label for="user_website"><?php echo lang('comments:website_label') ?>:</label>
							<div class="input">
								<?php echo form_input('user_website', $comment->user_website,'class="form-control"') ?>
							</div>
						</li>

						<li>
							<label for="comment"><?php echo lang('comments:message_label') ?>:</label><br>
							<?php echo form_textarea(array('name'=>'comment', 'value' => $comment->comment, 'rows' => 5,'class'=>'form-control')) ?>
						</li>

						<li>
							
						</li>



					</ul>

					<div>
						<br>
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
					</div>

				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>
