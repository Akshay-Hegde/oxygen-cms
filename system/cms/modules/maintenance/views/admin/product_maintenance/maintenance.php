
<div class="row">

    <div class="col-xs-12">

        <h3>Product Maintenance</h3>


        <div class="box">

                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('maintenance:importer') ?></h3>
                </div><!-- /.box-header -->

                <div class="box-body">

				<table class='table'>
					<tr>
						<td>
							<p>
								<i>CLEAR :: EAV (e_attributes)</i>
							</p>
							<p>
								<small>
									Clear EAV Table of Deleted Variances attributes.
								</small>
							</p>								
						</td>						
						<td class='input'>
								<a class='btn btn-flat bg-orange confirm' href='admin/store_sysadmin/maintenance/clean_eav_products'>Clean</a>
						</td>
					</tr>	
										
					<tr>
						<td>
							<p>
								<i>CLEAR :: Variances (Deleted and NOT Sold)</i>
							</p>
							<p>
								<small>
									This will clear any variation record that has been deleted and NOT sold.
								</small>
							</p>								
						</td>							
						<td class='input'>
							<a class='btn btn-flat bg-orange confirm' href='admin/store_sysadmin/maintenance/clean_variations'>Clean</a>
						</td>
					</tr>

					<tr>
						<td>
							<p>
								<i>View All Un-zoned Variations</i>
							</p>
							<p>
								<small>
									Note that Un-zoned will still be shippable to countries in the MCL list (Master Countries List)
								</small>
							</p>
						</td>
						<td class='input'>
								<a class='btn btn-flat bg-orange confirm' href='admin/store_sysadmin/maintenance/check_zones'>View All</a>
						</td>
					</tr>
				</table>

			</div>



	</div>

</div>

</div>
