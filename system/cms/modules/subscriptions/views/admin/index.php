<div class="row">
    <div class='col-xs-12'>

        <div class="col-sm-3 col-xs-12">
            <a href='admin/subscriptions/create/' class='btn-block btn btn-primary as_modal'>Create Subscription</a>
        </div>


        <div class='col-sm-9 col-xs-12'>
            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">All Subscriptions</h3>
                </div>          
                <div class="box-body">

					<?php if ( ! empty($subscriptions)): ?>
						<table class='table'>
							<?php foreach ($subscriptions as $list): ?>
									<tr>
						             	<td><?php echo $list->id;?></td>
						             	<td><?php echo $list->name;?></td>
						             	<td>
						             		<span class='pull-right'>
						             			<a href='admin/subscriptions/subscribers/<?php echo $list->id;?>' class='btn btn-primary btn-flat'>Subscribers</a>
						             			<a href='admin/subscriptions/edit/<?php echo $list->id;?>' class='btn bg-green btn-flat as_modal'>Edit</a>
						             			<a href='admin/subscriptions/delete/<?php echo $list->id;?>' class='btn btn-danger btn-flat confirm'>Delete</a>
						             		</span>
						             	</td>
						             </tr>
						     <?php endforeach ?>
					     </table>
					<?php else: ?>
						No subscriptions
					<?php endif ?>
                </div>

            </div>
        </div>
    </div>
</div>
