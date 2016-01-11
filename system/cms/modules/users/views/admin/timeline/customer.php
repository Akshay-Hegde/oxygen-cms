
<div class="row">

		<div class="col-md-12">

	
					<ul class="timeline">

					    <!-- timeline time label -->
					    {{timelineData}}

						    <li class="time-label">
						        <span class="bg-red">
						              {{tl_date}} 
						        </span>
						    </li>	
						    {{results}}				    
						    <!-- timeline item -->
						    <li>
						        <!-- timeline icon -->
						        <i class="{{icon}} bg-{{color}}"> </i>
						        <div class="timeline-item">
						            <span class="time"><i class="fa fa-clock-o"></i> {{time}}</span>
						            <h3 class="timeline-header">{{name}}</h3>
						            <div class="timeline-body">
						               {{description}}
						            </div>
						            <div class="timeline-footer">
						               {{actions}}
						            </div>						            
						        </div>
						    </li>
						    {{/results}}			

					    {{/timelineData}}

					    <!-- END timeline item -->
						<li>
							<i class="fa fa-clock-o bg-gray"></i>
						</li>		
					</ul>
								
				
		</div>
</div>
