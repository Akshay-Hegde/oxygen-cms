<h1><?php echo $page->title ?></h1>
<p><?php echo anchor($page->preview_uri, null, 'target="_blank"') ?></p>
<iframe src="<?php echo site_url($page->preview_uri) ?>" width="99%" height="400"></iframe>