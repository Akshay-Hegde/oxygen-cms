<?php if(isset($todo_tasks)):?>
<div class="col-md-6">

      <div class="box box-solid">


          <div class="box-header with-border">
             <i class="ion ion-clipboard"></i>
            <h3 class="box-title">To Do List</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <a href="{{url:site}}admin/dashboard/toggle/<?php echo $id;?>" class="btn btn-box-tool" ><i class="fa fa-times"></i></a>
            </div>
          </div>



          <div class="box-body">


            <ul class="todo-list ui-sortable">

              <?php foreach($todo_tasks as $task): ?>

              <li style="" class="" id='line_<?php echo $task->id;?>'>
                <span class="handle ui-sortable-handle">
                  <i class="fa fa-ellipsis-v"></i>
                  <i class="fa fa-ellipsis-v"></i>
                </span>
                <input type="checkbox" name="" value="">
                <span class="text"><?php echo $task->name;?></span>
                <div class="tools">
                  <a data-id='<?php echo $task->id;?>' class='task_del'  href='admin/tasks/del_ajax/<?php echo $task->id;?>'><i class="fa fa-trash-o"></i></a>
                </div>
              </li>

              <?php endforeach;?>

            </ul>
          </div><!-- /.box-body -->


          <div class="box-footer clearfix no-border">
            <div class="input-group">
              <input placeholder="Add a task" class="form-control task_adder_task">
              <div class="input-group-btn">
                <a href='#' class="btn btn-flat btn-success task_adder"><i class="fa fa-plus"></i></a>
              </div>
            </div>
          </div>


      </div>
</div>
<?php endif;?>