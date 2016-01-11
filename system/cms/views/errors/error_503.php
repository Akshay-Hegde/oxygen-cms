<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo lang('error_503_title'); ?></title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body {
            background-color: white;
        }

        #loginbox {
            margin-top: 60px;
        }

        #loginbox > div:first-child {
            padding-bottom: 10px;
        }

        #form > div {
            margin-bottom: 25px;
        }

        #form > div:last-child {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .panel {
            background-color: transparent;
        }

        .panel-body {
            padding-top: 30px;
            background-color: rgba(2555, 255, 255, .3);
        }

        .alert {
            margin: 15px;
        }


    </style>
</head>
<body>
<div class="container">
    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title text-center"><?php echo lang('error_503_title'); ?></div>
            </div>
            <div class="panel-body">
	            <div class='text-center'>
	            	<?php echo sprintf(lang('error_503_message'), site_url('')); ?>
	            </div>
	            <div class='text-center'>
	            	<br>
	            	<br>

                    <a class='btn btn-primary' href='http://google.com'>
                    	<i class="glyphicon glyphicon-log-in"></i>&nbsp;
                        	Exit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script src="js/bootstrap.min.js"></script>
</body>
</html>
