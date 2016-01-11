<div class="row">
    <div class="col-xs-12">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title"><?php echo $module_details['name'] ?></h3>
                <p><?php echo lang('permissions:introduction') ?></p>
            </div>
            <div class="box-body">


                <table class="table table-striped">
                  <tr>
                    <th>#</th>
                    <th style="width: 70%"><?php echo lang('permissions:group') ?></th>
                    <th style="width: 20%"><div style='float:right'>Action</div></th>
                  </tr>
                  <?php foreach ($groups as $group): ?>
                  <tr>
                    <td><?php echo $group->id ?></td>
                    <td><a href='admin/groups/edit/<?php echo $group->id ?>'><?php echo $group->description ?></a></td>
                    <td>
                    		<div style='float:right'>
          							<?php if ($admin_group != $group->name):?>
          								<?php echo anchor('admin/permissions/group/' . $group->id, lang('permissions:edit'), ['class'=>'btn bg-blue btn-flat']) ?>
          							<?php else: ?>
          								<?php echo lang('permissions:admin_has_all_permissions') ?>
          							<?php endif ?>
          						</div>
                    </td>
                  </tr>
                  <?php endforeach ?>
                </table>
                 
           </div><!-- /.box -->

      </div><!-- /.col -->

  </div><!-- /.row -->
</div>