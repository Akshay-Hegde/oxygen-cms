<div class="row">
    <div class='col-xs-12'>

        <div class="col-sm-3 col-xs-12">
        	<a href='admin/subscriptions/' class='btn-block btn btn-primary'>All Subscriptions</a>
            <a href='admin/subscriptions/subscribe/<?php echo $subscription_id;?>' class='btn-block btn btn-warning as_modal'>Add Subscriber</a>
        </div>


        <div class='col-sm-9 col-xs-12'>
            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">Subscriptions</h3>
                </div>          
                <div class="box-body">

					<?php if ( ! empty($subscribers)): ?>
						<table class='table'>
							<?php foreach ($subscribers as $list): ?>
									<tr>
						             	<td><?php echo $list->id;?></td>
						             	<td><?php echo $list->email;?></td>
						             	<td>
						             		<span class='pull-right'>
						             			<a href='admin/subscriptions/unsubscribe/<?php echo $list->id;?>' class='btn btn-danger btn-flat'>Unsubscribe</a>
						             		</span>
						             	</td>
						             </tr>
						     <?php endforeach ?>
					     </table>
					<?php else: ?>
						No subscribers
					<?php endif ?>
                </div>

            </div>
        </div>
    </div>
</div>
