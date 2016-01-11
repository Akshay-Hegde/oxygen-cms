<?php if ($comments): ?>


			<?php foreach ($comments as $item): ?>
				<div class='row'>

		        	<div class='col-xs-2'>
		        		<?php echo gravatar($item->user_email, 60) ?>
		        	</div>
		        	<div class='col-xs-10'>
						<div class="details">
							<div class="name">
								<?php echo $item->user_name ?>
							</div>
							<div class="date">
								<p><?php echo format_date($item->created_on) ?></p>
							</div>
							<div class="content_toberem">
								<?php if (Settings::get('comment_markdown') and $item->parsed): ?>
									<?php echo $item->parsed ?>
								<?php else: ?>
									<p><?php echo nl2br($item->comment) ?></p>
								<?php endif ?>
							</div>
						</div>
		        	</div>
		        </div>
        	<?php endforeach ?>        	


<?php else: ?>
	<p><?php echo lang('comments:no_comments') ?></p>
<?php endif ?>