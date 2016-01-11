
        <?php if (Settings::get('enable_comments') && ! $this->current_user): ?>

            <article class="container" id="comments">
                <div class="col-sm-10 col-sm-offset-1 m-center">
                    <h3>Add a first comment</h3>
                    <p>You must be <a href="{{url:site}}users/login">logged in</a> to post a comment.</p>
                </div>
            </article>

        <!-- CONTAINER -->
        <?php elseif (Settings::get('enable_comments')): ?>

        <article class="container" id="comments">
            <div class="col-sm-10 col-sm-offset-1 m-center">
                <h3>{{comment_count}} comments</h3>
            </div>

           
            <?php foreach($this->comments->as_array() as $comment):?>

            <section class="comments">
                <div class="comment clearfix">
                    <div class="col-xs-2 col-sm-offset-1">
                        <a href="#">
                        	<?php echo gravatar_alt($comment->user_email, ['size'=>100, 'class' => 'img-rounded']);?>
                        </a>
                    </div>
                    <div class="col-sm-8 col-xs-9 no-padding">
                        <div class="comment-line">
                            <p><?php echo $comment->user_name;?>, <?php echo format_date($comment->created_on);?></p>
                        </div>
                        <p><?php echo $comment->comment;?></p>
                    </div>
                </div>
            </section>
            <?php endforeach;?>
				
					<?php if ($form_display): ?>
				            <section class="addcomment" id="addcomment">
				                <div class="col-sm-offset-1 col-sm-7 m-center">
				                    <?php echo $this->comments->form() ?>
				                </div>
				            </section>

					<?php else: ?>
					<?php echo sprintf(lang('blog:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post[0]['comments_enabled'])))) ?>
					<?php endif ?>


			<?php endif ?>
        </article>
        <!-- /.container -->

