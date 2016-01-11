<?php

    require_once('system/cms/libraries/Analytics.php');

    /*
    $this->load->library('analytics', [
        'email' => $this->settings->ga_email,
        'key_file' => $this->settings->ga_json_key
    ]);
    */
    $analytics = new Analytics(['email'=>$this->settings->ga_email,'key_file'=>$this->settings->ga_p12_key]);

    if($analytics->initGapi()) {
      $token = $analytics->getToken();
    } else {
      return;
    }
    
?>


<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>


<div class="col-md-12">
    <div class="box box-solid collapsed-box">
        <div class="box-header with-border">
            Google Analytics Account Settings

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>

        </div><!-- /.box-header -->
        <div class="box-body">
            <div id="embed-api-auth-container"></div>

            <div class='col-md-12'>
                <div id="view-selector-container"></div>
            </div>

        </div>
    </div>
</div>

<div class="col-md-12">
	<div class="box box-solid">
        <div class="box-header with-border">
        	Activity by Browser
        </div><!-- /.box-header -->
        <div class="box-body">

            <div class='col-md-12'>
                <div id="chart-container"></div>
            </div>
  			
            <div class='row'>
                <div class='col-md-6'>
                    <div id="main-chart-container"></div>
                </div>
                <div class='col-md-6'>
                    <div id="breakdown-chart-container"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="col-md-12">
    <div class='col-md-6 nopadding'>

        <div class="box box-solid">
            <div class="box-header with-border">
                New and Returning Users
            </div><!-- /.box-header -->
            <div class="box-body">
                   <div id="usertypecompare-container"></div>
      		</div>
    	</div>
    </div>

    <div class='col-md-6 nopadding'>
        <div class="box box-solid">
            <div class="box-header with-border">
                User Countries
            </div><!-- /.box-header -->
            <div class="box-body">
                   <div id="chart-pie-container"></div>
            </div>
        </div>
    </div>

</div>

    
<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            Bounce and Exit Analysis
        </div><!-- /.box-header -->
        <div class="box-body">
            <div id="bouncerate-container"></div>
        </div>
    </div>
</div>




<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            Technology
        </div>
        <div class="box-body">
            <div id="technology-container"></div>
        </div>
    </div>
</div>


<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            Landing Page
        </div>
        <div class="box-body">
            <div id="landing-container"></div>
        </div>
    </div>
</div>


<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            Age comparer
        </div>
        <div class="box-body">
            <div id="agecomparer-container"></div>
        </div>
    </div>
</div>





<script>

gapi.analytics.ready(function() {

      /**
       * Authorize the user with an access token obtained server side.
       */
      gapi.analytics.auth.authorize({
        'serverAuth': {
          'access_token': '<?php echo $token;?>'
        }
      });



      /**
       * Create a new ViewSelector instance to be rendered inside of an
       * element with the id "view-selector-container".
       */
      var viewSelector = new gapi.analytics.ViewSelector({
        container: 'view-selector-container'
      });



      // Render the view selector to the page.
      viewSelector.execute();


      /**
       * Render the dataChart on the page whenever a new view is selected.
       */
      viewSelector.on('change', function(ids) {

            dataChartRight.set({query: {ids: ids}}).execute();
            newUsersDataSet.set({query: {ids: ids}}).execute();
            dataComparer.set({query: {ids: ids}}).execute();
            technologyComparer.set({query: {ids: ids}}).execute();   
            landingComparer.set({query: {ids: ids}}).execute();  
            ageDataSet.set({query: {ids: ids}}).execute();  


       

            /**
             * Update both charts whenever the selected view changes.
             */
            var options = {query: {ids: ids}};

            // Clean up any event listeners registered on the main chart before
            // rendering a new one.
            if (mainChartRowClickListener) {
              google.visualization.events.removeListener(mainChartRowClickListener);
            }

            mainChart.set(options).execute();
            breakdownChart.set(options);

            // Only render the breakdown chart if a browser filter has been set.
            if (breakdownChart.get().query.filters) breakdownChart.execute();

      });



      var ageDataSet = new gapi.analytics.googleCharts.DataChart({
        query: {
          metrics: 'ga:users',
          dimensions: 'ga:city',
          'start-date': '30daysAgo',
          'end-date': 'yesterday',
          'max-results': '50',
        },
        chart: {
          container: 'agecomparer-container',
          type: 'TABLE',
          options: {
            width: '100%',
          }
        }
      });




      var newUsersDataSet = new gapi.analytics.googleCharts.DataChart({
        query: {
          metrics: 'ga:sessions',
          dimensions: 'ga:userType',
          'start-date': '30daysAgo',
          'end-date': 'yesterday',
          'max-results': '50',
        },
        chart: {
          container: 'usertypecompare-container',
          type: 'PIE',
          options: {
            width: '100%',
            colors: ['#4444ee', '#6666ff']  
          }
        }
      });

      var landingComparer = new gapi.analytics.googleCharts.DataChart({
        query: {
          metrics: 'ga:users',
          dimensions: 'ga:country,ga:sessionDurationBucket,ga:landingPagePath',
          'start-date': '30daysAgo',
          'end-date': 'yesterday',
          'max-results': '50',
        },
        chart: {
          container: 'landing-container',
          type: 'TABLE',
          options: {
            width: '100%',
            colors: ['#4444ee', '#6666ff']  
          }
        }
      });

      var dataComparer = new gapi.analytics.googleCharts.DataChart({
        query: {
          metrics: 'ga:bounceRate,ga:bounces,ga:exits,ga:exitRate,ga:newUsers,ga:avgPageLoadTime',
          dimensions: 'ga:daysSinceLastSession',
          'start-date': '30daysAgo',
          'end-date': 'yesterday',
        },
        chart: {
          container: 'bouncerate-container',
          type: 'TABLE',
          options: {
            width: '100%',
          }
        }
      });

      var technologyComparer = new gapi.analytics.googleCharts.DataChart({
        query: {
          metrics: 'ga:users,ga:newUsers',
          dimensions: 'ga:operatingSystem,ga:country',
          'start-date': '30daysAgo',
          'end-date': 'yesterday',
        },
        chart: {
            container: 'technology-container',
            type: 'TABLE',
            options: {
            width: '100%',
            title: 'The Technology comparer',          
          }
        }
      });



      var dataChartRight = new gapi.analytics.googleCharts.DataChart({
        query: {
          metrics: 'ga:sessions',
          dimensions: 'ga:country',
          'start-date': '30daysAgo',
          'end-date': 'yesterday',
          'max-results': 6,
          sort: '-ga:sessions'
        },
        chart: {
          container: 'chart-pie-container',
          type: 'PIE',
          options: {
            width: '100%',
            is3D: true,
            /*pieHole: 1/16*/
          }
        }
      });


      /**
       * Create a table chart showing top browsers for users to interact with.
       * Clicking on a row in the table will update a second timeline chart with
       * data from the selected browser.
       */
      var mainChart = new gapi.analytics.googleCharts.DataChart({
        query: {
          'dimensions': 'ga:browser',
          'metrics': 'ga:sessions',
          'sort': '-ga:sessions',
          'max-results': '6'
        },
        chart: {
          type: 'TABLE',
          container: 'main-chart-container',
          options: {
            width: '100%'
          }
        }
      });


      /**
       * Create a timeline chart showing sessions over time for the browser the
       * user selected in the main chart.
       */
      var breakdownChart = new gapi.analytics.googleCharts.DataChart({
        query: {
          'dimensions': 'ga:date',
          'metrics': 'ga:sessions',
          'start-date': '7daysAgo',
          'end-date': 'yesterday'
        },
        chart: {
          type: 'LINE',
          container: 'breakdown-chart-container',
          options: {
            width: '100%'
          }
        }
      });


      /**
       * Store a refernce to the row click listener variable so it can be
       * removed later to prevent leaking memory when the chart instance is
       * replaced.
       */
      var mainChartRowClickListener;




      /**
       * Each time the main chart is rendered, add an event listener to it so
       * that when the user clicks on a row, the line chart is updated with
       * the data from the browser in the clicked row.
       */
      mainChart.on('success', function(response) 
      {

        var chart = response.chart;
        var dataTable = response.dataTable;

        // Store a reference to this listener so it can be cleaned up later.
        mainChartRowClickListener = google.visualization.events
            .addListener(chart, 'select', function(event) {

          // When you unselect a row, the "select" event still fires
          // but the selection is empty. Ignore that case.
          if (!chart.getSelection().length) return;

          var row =  chart.getSelection()[0].row;
          var browser =  dataTable.getValue(row, 0);
          var options = {
            query: {
              filters: 'ga:browser==' + browser
            },
            chart: {
              options: {
                title: browser,
                crosshair: { trigger: 'both' }
              }
            }
          };

          breakdownChart.set(options).execute();
        });
      });



});

</script>
