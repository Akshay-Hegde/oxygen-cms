<div class="row">
	<div class='col-xs-12'>
			<div class="box box-solid">
			    <div class="box-header">
			      	<h3 class="box-title"><?php echo lang('pages:list_title') ?></h3>
			    </div> 			
		        <div class="box-body">

					<p>
						<?php echo lang('pages:tree_explanation') ?>
					</p>

					<div class='col-sm-6 col-xs-12'>
						<div id="page-list">
							<ul class="sortable">
								<?php echo tree_builder($pages, '<li id="page_{{ id }}"><div><a href="#" class="{{ status }}" rel="{{ id }}">{{ title }}</a> </div>{{ children }}</li>') ?>
							</ul>
						</div>			
					</div>

					<div class='col-sm-6 col-xs-12'>
						<div id="page-details-view">
						</div>
					</div>


				</div>
			</div>
	</div>
</div>