

<div class="col-lg-12">
	<div class="box box-solid">

	    <div class="box-header">
	      <h3 class="box-title"><?php echo lang('comments:recent_comments') ?></h3>
	    </div><!-- /.box-header -->

	    <div class="box-body">

	    	<?php if (count($recent_comments)): ?>
	        <ul class='list-group'>	                           
				<?php foreach ($recent_comments as $comment): ?>
					<li class='list-group-item'>
						<div class="comments-gravatar"><?php echo gravatar($comment->user_email) ?></div>
						<div class="comments-date"><?php echo format_date($comment->created_on) ?></div>
						<p>
							<?php echo sprintf(lang('comments:list_comment'), $comment->user_name, $comment->entry_title) ?> 
							<span><?php echo (Settings::get('comment_markdown') AND $comment->parsed > '') ? strip_tags($comment->parsed) : $comment->comment ?></span>
						</p>
					</li>
				<?php endforeach ?>
	        </ul>
			<?php else: ?>
				<?php echo lang('comments:no_comments') ?>
			<?php endif ?>	   	        
     
	  
	    </div>

	</div>      
</div>
