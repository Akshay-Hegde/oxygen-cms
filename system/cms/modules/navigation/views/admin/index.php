
<div class="row">
    <div class='col-xs-12'>

    	<div class="col-sm-3 col-xs-12">

    		<a href='<?php echo site_url() . 'admin/navigation/groups/create';?>' class='btn btn-block btn-primary as_modal'>Create Group</a>

    	</div>

        <div class="col-sm-9 col-xs-12">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">Navigation Groups</h3>
                </div>          
                <div class="box-body">

					<?php if ( ! empty($groups)): ?>

						<table id='section_table' class="table table_sortable">
							<thead>
									<tr class=''>
										<td>ID</td>
										<td>
											Title
										</td>
										<td>
											Slug
										</td>								
										<td>
											<span class='pull-right'>
												Actions
											</span>
										</td>
									</tr>
							</thead>						
							<tbody id='#sortable' class='uf_sortable'>

								<?php foreach ($groups as $group): ?>
									<tr class='qfield' group-id="<?php echo $group->id;?>">
										<td><?php echo $group->id;?></td>
										<td>
											<a class='xeditable' data-type="text" data-pk="<?php echo $group->id;?>" data-name="title" data-value="<?php echo $group->title;?>" data-url="admin/navigation/editx/" data-title="Title"  href='#'><?php echo $group->title;?></a>
										</td>
										<td>
											<a class='xeditable' data-type="text" data-pk="<?php echo $group->id;?>" data-name="slug" data-value="<?php echo $group->slug;?>" data-url="admin/navigation/editx/" data-title="Slug"  href='#'><?php echo $group->slug;?></a>
										</td>								
										<td>
											<span class='pull-right'>
												<a href='<?php echo site_url();?>admin/navigation/links/<?php echo $group->id;?>' class='btn btn-flat bg-blue'>Manage Group</a>
												<a href='<?php echo base_url().'admin/navigation/groups/delete/'.$group->id;?>'    		  class="confirm btn btn-danger btn-flat"><i class="fa fa-times"></i> Delete</a>
											</span>
										</td>
									</tr>

								<?php endforeach ?>
								</tbody>
						</table>

					 <?php endif ?>
                </div>
            </div>
        </div>

	</div>
</div>

<script>

    //sort the order of sections
    (function($) {
        $(function(){

	        $("tbody.uf_sortable").sortable({
	            update: function (event, ui) {
	                var myObject = new Object();
	                var index=0;
	                $("tr.qfield").each(function() {
	                      var $this = $(this)
	                      var q_id = $this.attr('group-id');
	                      myObject[q_id] = ++index;
	                });     
	                var url = BASE_URL + 'admin/navigation/order_group/';
	                $.post(url,myObject).done(function(data)
	                {
	               
	                });
	            }
	        });

        //x-editable
        $.fn.editable.defaults.mode = 'inline';
        $(document).ready(function() {

            $('.xeditable').editable({
                success: function(response, newValue) {
                    //msg will be shown in editable form
                    if(response.status == 'error') return response.msg; 
                }
            });


        });


        });
    })(jQuery);     

</script>