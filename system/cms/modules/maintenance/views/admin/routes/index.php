<style>
.table-responsive
{
    overflow-x: auto;
}

</style>
<div class="row">
    <div class="col-xs-12">

        <div class="box box-solid">
                <div class="box-header">			   
			            <h4 class="box-title">
			              	Routes
			            </h4>

						<div class="pull-right"></div>
                </div>

                <div class="box-body">

					<div class="table-responsive">

	                	<table id='route_table' class="table table_sortable">
	                		<thead>
								<tr>
									<th>
										ID
									</th>
									<th>
										Name
									</th>	
									<th>
										Module
									</th>	
									<th>
										Uri
									</th>	
									<th>
										Dest
									</th>	
									<th>
										Active
									</th>																																								
								</tr>
							</thead>
							<caption>Routes</caption>
							<tbody id='' >	
							<?php foreach($routes as $route): ?>

								<?php if($route->can_change) { continue; } ?>
								
								<tr class='qfield' route-id="<?php echo $route->id;?>">
									<td>
										<?php echo $route->id;?>
									</td>
									<td>

										<?php echo $route->name;?>
		
									</td>	
									<td>
										<?php echo ucfirst($route->module);?>
									</td>	
									<td>
										<?php echo $route->uri;?>
									</td>	
									<td>
										<code><?php echo $route->dest;?></code>
									</td>	
									<td>
	
											<?php echo ucfirst($route->active);?>

									</td>								
									<td>

										
									</td>																																								
								</tr>						
							<?php endforeach; ?>
							</tbody>						
							<tbody id='#sortable' class='uf_sortable'>	
							<?php foreach($routes as $route): ?>

								<?php if(!$route->can_change) { continue; } ?>
								
								<tr class='qfield' route-id="<?php echo $route->id;?>">
									<td>
										<?php echo $route->id;?>
									</td>
									<td>

										<?php echo $route->name;?>
		
									</td>	
									<td>
										<?php echo ucfirst($route->module);?>
									</td>	
									<td>
										<?php if($route->can_change==='1'):?>
											<a 
												class='xeditable' 
												data-type="text" 
												data-pk="<?php echo $route->id;?>" 
												data-name="uri" 
												data-value="<?php echo $route->uri;?>" 
												data-url="admin/maintenance/routes/xeditroute/" 
												data-title="Uri"  
												href='#'>
													<?php echo $route->uri;?>
											</a>
										<?php else: ?>	
											<?php echo $route->uri;?>
										<?php endif; ?>
									</td>	
									<td>
										<code><?php echo $route->dest;?></code>
									</td>	
									<td>
										<?php if($route->can_change==='1'):?>
											<a 
												class='xeditable_status' 
												data-type="select" 
												data-pk="<?php echo $route->id;?>" 
												data-name="active" 
												data-value="<?php echo $route->active;?>" 
												data-url="admin/maintenance/routes/xeditroute/" 
												data-title="Active"  
												href='#'>
													<?php echo ucfirst($route->active);?>
											</a>
										<?php else: ?>	
											<?php echo ucfirst($route->active);?>
										<?php endif; ?>
									</td>								
									<td>
										<?php if($route->can_change==='1'):?>
											<a href='<?php echo site_url('admin/maintenance/routes/reset_route/'.$route->id);?>' class='btn btn-xs btn-flat bg-green'>Reset Default</a>
										<?php else: ?>	
											
										<?php endif; ?>

										
									</td>																																								
								</tr>						
							<?php endforeach; ?>
							</tbody>

						</table>

					</div>

					
				</div>
                <div class="box-footer">			   
			            <a href='admin/maintenance/routes/build_routes' class='confirm btn btn-md btn-flat bg-blue'>Build Routes</a>
                </div>

		</div>
	</div>
</div>


<script>

    //sort the order of sections
    (function($) {
        $(function(){


        //x-editable
        $.fn.editable.defaults.mode = 'inline';
        $(document).ready(function() {

            $('.xeditable').editable({
                success: function(response, newValue) {
                    //msg will be shown in editable form
                    if(response.status == 'error') return response.msg; 
                }
            });

		    $('.xeditable_status').editable({  
		        source: [
		              {value: 'active', text: 'Active'},
		              {value: 'blocked', text: 'Blocked'},
		           ]
		    });



        });




        $("tbody.uf_sortable").sortable({
            update: function (event, ui) {
                var myObject = new Object();
                var index=0;
                $("tr.qfield").each(function() {
                      var $this = $(this)
                      var q_id = $this.attr('route-id');
                      myObject[q_id] = ++index;
                });     
                var url = BASE_URL + 'admin/maintenance/routes/order_routes/';
                $.post(url,myObject).done(function(data)
                {
               
                });
            }
        });



        });
    })(jQuery);     

</script>