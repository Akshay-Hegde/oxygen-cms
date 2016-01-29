
{{ layout:partial name="title" }}
	<h1>
		<small></small>
	</h1>
{{ /layout:partial }}
		
		
<div class="box box-solid">

	<div class="box-header with-border">
		<h3 class="box-title">{{ page:title }}</h3>
	</div>

	<div class="box-body">

		<div class="error-page">
			<h2 class="headline text-yellow"> {{helper:lang line="public:label:404"}}</h2>
			<div class="error-content">
				<h3>
					<i class="fa fa-warning text-yellow"></i>
					{{helper:lang line="public:message:404"}}
				</h3>
				<p>
					{{body}}
				</p>
			</div>
		</div>



	  {{ widgets:display area="top-page" }}

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





