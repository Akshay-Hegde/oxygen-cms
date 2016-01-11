
	<div class="col-md-12">

		<div class="box box-solid">

		    <div class="box-header with-border">
		        <h3 class="box-title">Site Analytics</h3>
		        <div class="box-tools pull-right">
			        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		        </div>
		    </div>

		    <div class="box-body">
		        <div class="row">
		                    <div class="col-md-12">
		                      <p class="text-center">
		                      </p>
		                      <div class="chart">
		                        <canvas id="salesChart" height="180"></canvas>
		                      </div>
		                    </div>
		        </div>
		    </div>

		    <div class='box-footer'>
		          <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <h5 class="description-header"><?php echo $analytic_total_visits;?></h5>
                        <span class="description-text">Total Visits</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <h5 class="description-header"><?php echo $analytic_total_views;?></h5>
                        <span class="description-text">Total Views</span>
                      </div>
                    </div>
                  </div>
		    </div>

		</div>

	</div>



			


	    <script>
	    	'use strict';

		    //wait until jQ is fully loaded
		    (function($) {
		        $(function(){

				  //------------------------
				  //- Google nalytics Data -
				  //------------------------
				  //------------------------
				  //- Using Chart.js -
				  //------------------------

				  // Get context with jQuery - using jQuery's .get() method.
				  var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
				  // This will get the first returned node in the jQuery collection.
				  var salesChart = new Chart(salesChartCanvas);

				  var salesChartData = {
				   	labels: <?php echo $analytic_labels;?>,
				    datasets: [
				      {
				        label: 'Views',
				        fillColor: "rgb(210, 214, 222)",
				        strokeColor: "rgb(210, 214, 222)",
				        pointColor: "rgb(210, 214, 222)",
				        pointStrokeColor: "#c1c7d1",
				        pointHighlightFill: "#fff",
				        pointHighlightStroke: "rgb(220,220,220)",
				        data: <?php echo $analytic_views; ?>,
				      },
				      {
				        label: 'Visits',
				        fillColor: "rgba(60,141,188,0.5)",
				        strokeColor: "rgba(60,141,188,0.5)",
				        pointColor: "#3b8bba",
				        pointStrokeColor: "rgba(60,141,188,0.5)",
				        pointHighlightFill: "#fff",
				        pointHighlightStroke: "rgba(60,141,188,0.5)",
				        data: <?php echo $analytic_visits; ?>,
				      }
				    ]
				  };

				  var salesChartOptions = {
				    //Boolean - If we should show the scale at all
				    showScale: true,
				    //Boolean - Whether grid lines are shown across the chart
				    scaleShowGridLines: false,
				    //String - Colour of the grid lines
				    scaleGridLineColor: "rgba(0,0,0,.05)",
				    //Number - Width of the grid lines
				    scaleGridLineWidth: 1,
				    //Boolean - Whether to show horizontal lines (except X axis)
				    scaleShowHorizontalLines: true,
				    //Boolean - Whether to show vertical lines (except Y axis)
				    scaleShowVerticalLines: true,
				    //Boolean - Whether the line is curved between points
				    bezierCurve: true,
				    //Number - Tension of the bezier curve between points
				    bezierCurveTension: 0.3,
				    //Boolean - Whether to show a dot for each point
				    pointDot: false,
				    //Number - Radius of each point dot in pixels
				    pointDotRadius: 4,
				    //Number - Pixel width of point dot stroke
				    pointDotStrokeWidth: 1,
				    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
				    pointHitDetectionRadius: 20,
				    //Boolean - Whether to show a stroke for datasets
				    datasetStroke: true,
				    //Number - Pixel width of dataset stroke
				    datasetStrokeWidth: 2,
				    //Boolean - Whether to fill the dataset with a color
				    datasetFill: true,
				    //String - A legend template
				    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
				    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
				    maintainAspectRatio: false,
				    //Boolean - whether to make the chart responsive to window resizing
				    responsive: true
				  };

				  //Create the line chart
				  salesChart.Line(salesChartData, salesChartOptions);

				  //---------------------------
				  //- END MONTHLY SALES CHART -
				  //---------------------------

		        });
		    })(jQuery);     

		</script>