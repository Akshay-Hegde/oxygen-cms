
{{ layout:partial name="title" }}
	<h1>
		<small></small>
	</h1>
{{ /layout:partial }}
		
		
<div class="box box-primary">

	<div class="box-header with-border">
		<h3 class="box-title">{{ page:title }}</h3>
	</div>

	<div class="box-body">

	  <?php echo $page->layout->body; ?>

	  <?php if (Settings::get('enable_comments') and $page->comments_enabled): ?>
		  <div class="box box-default">
				<div class="box-header with-border">
				  	<h3 class="box-title"><?php echo lang('comments:title') ?></h3>
				</div>
				<div class="box-body">
					 <?php echo $this->comments->display() ?>
					 <?php echo $this->comments->form() ?>
				</div>
		  </div>
	  <?php endif ?>

	</div>

</div>    