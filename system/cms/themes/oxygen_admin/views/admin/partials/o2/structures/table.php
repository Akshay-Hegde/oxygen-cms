<div class="row">

    <div class="col-xs-12">

        <div class="box">

                <div class="box-header">
                  <h3 class="box-title">{{title}}</h3>
                </div>
                <div class="box-body">


                      <table id="standard_data_table" class="table table-bordered">
                        <thead>
                          <tr>
                            {{tableHeader}}
                              <th>{{value}}</th>
                            {{/tableHeader}}
                          </tr>
                        </thead>

                        <tbody>

                            <?php foreach($tableRows as $rowdata): ?>
                                <tr>
                                    <?php foreach($rowdata['rowdata'] as $td):?>
                                        <td><?php echo $td['td'];?></td>
                                    <?php endforeach; ?>
                                     <?php if(count($rowdata['actions']) ):?>
                                                                       
                                        <td>
                                            <span style=''>
                                            </span>
                                            <span style='float:right'>
                                                <?php foreach($rowdata['actions'] as $action):?>
                                                    <?php if($action['type'] =='red'):?>
                                                        <a href='<?php echo $action['url'];?>' class='btn btn-sm btn-flat bg-red <?php echo $action['class'];?>'><?php echo $action['label'];?></a>
                                                    <?php else: ?>
                                                        <a href='<?php echo $action['url'];?>' class='btn btn-sm btn-flat btn-default <?php echo $action['class'];?>'><?php echo $action['label'];?></a>
                                                    <?php endif; ?>
                                                 <?php endforeach; ?>
                                            </span>
                                        </td>
                                        <?php endif; ?>
                                </tr>
    
                            <?php endforeach; ?>
                        </tbody>

                      </table>

                        <div>
                          {{pagination:links}}</th>
                        </div> 

                </div>


        </div>


    </div><!-- /.col -->

</div><!-- /.row -->