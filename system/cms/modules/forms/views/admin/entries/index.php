<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo lang('flows:name');?></h3>
			</div>
			<div class="box-body">
				<?php if(isset($entries)):?>
				<?php if($total>0):?>
					<table class='table'>

						<?php foreach($entries as $entry):?>
							<tr>
								<td>
									<?php echo $entry['id'];?>
								</td>
								<td>
									<?php echo $entry['image']['thumb_img'];?>
								</td>                                       
								<td>
									<?php echo $entry['title'];?>
								</td>
							 
								<td>
									<a href='admin/forms/entries/edit/<?php echo $entry['id'];?>/<?php echo $list_id;?>' class='btn btn-flat bg-olive'>Edit</a>
									<a href='admin/forms/entries/delete/<?php echo $entry['id'];?>/<?php echo $list_id;?>' class='btn btn-flat bg-red confirm'>Delete</a>
								</td>                                                                       
							</tr>
						<?php endforeach;?>
					</table>
				<?php else:?>
					No entries found here.
				<?php endif;?>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>