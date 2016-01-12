<div class="row">
    <div class='col-xs-12'>
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">All subscriptions</h3>
                </div>          
                <div class="box-body">
					<?php if ( ! empty($subscriptions)): ?>
						<table class='table'>
							<?php foreach ($subscriptions as $list): ?>
								<tr>
					             	<td><input type='checkbox' name='subscription[<?php echo $list->id;?>]'></td>
					             	<td><?php echo $list->id;?></td>
					             	<td><?php echo $list->name;?></td>
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