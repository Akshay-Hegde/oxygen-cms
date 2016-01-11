
<?php if ( isset($rss_items) ) : ?>
<div class="col-lg-12">
	<div class="box box-solid">
	    <div class="box-header">
	      <h3 class="box-title"><?php echo lang('cp:news_feed_title') ?></h3>
	    </div><!-- /.box-header -->

	    <div class="box-body">

	        <ul class='list-group'>
	            <?php foreach($rss_items as $rss_item): ?>
	            <li class='list-group-item'>
	                           
	                <?php
	                    $item_date  = strtotime($rss_item->get_date());
	                    $item_month = date('M', $item_date);
	                    $item_day   = date('j', $item_date);
	                ?>
	                <div class="date">
	                    <div class="time">
	                        <span class="month">
	                            <?php echo $item_month ?>
	                        </span>
	                        <span class="day">
	                            <?php echo $item_day ?>
	                        </span>
	                    </div>
	                </div>
	                <div class="post">
	                    <h4><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"') ?></h4>           
	                    <p class='item_body'><?php echo $rss_item->get_description() ?></p>
	                </div>
	            </li>
	            <?php endforeach ?>
	        </ul>
	    </div>
	</div>      
</div>
<?php endif ?>    