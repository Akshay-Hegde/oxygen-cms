
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Pages: Please select a page type
                </h4>
            </div>
            <div class="modal-body">

                    <table class="table" cellspacing="0">
                        <thead>
                            <th width="20%"><?php echo lang('global:title');?></th>
                            <th><?php echo lang('global:description');?></th>
                            <th width="20%"></th>
                        </thead>
                        <tbody>
                            <?php foreach ($page_types as $pt): ?>
                            <tr>
                                <td>
                                    <?php echo anchor('admin/pages/create?page_type='.$pt->id.$parent, $pt->title);?>
                                </td>
                                <td>
                                    <?php echo $pt->description;?>
                                </td>
                                <td class="actions">
                                    <?php echo anchor('admin/pages/create?page_type='.$pt->id.$parent, lang('pages:select_type'), array('class'=>'btn btn-flat bg-green'));?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                
            </div>
            <div class="modal-footer">
             
            </div>
        </div>
      </div> 
