
	  <header class="main-header">

		<!-- Logo -->
		<a target='_blank' href="<?php echo site_url();?>" class="logo">
		  <!-- mini logo for sidebar mini 50x50 pixels -->
		  <span class="logo-mini">
		  <img src='<?php echo theme_image('logow.png',null,'path'); ?>' style='width:30px;'>
		  </span>
		  <!-- logo for regular state and mobile devices -->
		  <span class="logo-lg">
		  	<b>Oxygen</b>CMS
		  </span>
		  
		</a>

		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top" role="navigation">

		   	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			 	<span style='font-family:arial'></span>
		  	</a>
		 

		  <!-- Navbar Right Menu -->
		  <div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

			<?php if(isset($mail_notifications)):?>
			  <!-- Messages: style can be found in dropdown.less-->
			  <li class="dropdown messages-menu">
				<!-- Menu toggle button -->
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  <i class="fa fa-envelope-o "></i><!--fa-envelope-o  / -->
				  <?php //if(count($mail_notifications)):?>
				  <span id='mailbox_inbox_count' class="label "><?php echo count($mail_notifications);?></span>
				   <?php //endif;?>
				</a>

				<ul class="dropdown-menu">
				  <li class="header">You have <?php echo count($mail_notifications);?> emails</li>
				  <li>
					<!-- inner menu: contains the messages -->
					<ul class="menu">
					  <?php $index =0;?>
					  <?php foreach($mail_notifications as $message):?>
					  <?php if ($index >3) continue ; else $index++ ;?>
					  <li><!-- start message -->
						<a href="admin/notifications">
						  <h5>
							<?php echo($message->name);?>
							<small><i class="fa fa-clock-o"></i> <?php echo($message->created);?></small>
						  </h5>
						  <!-- The message -->
						  <p><?php echo($message->description);?></p>
						</a>
					  </li><!-- end message -->
					  <?php endforeach; ?>
					</ul><!-- /.menu -->
				  </li>
				  <li class="footer"><a href="admin/notifications">All Emails</a></li>
				</ul>
			  </li><!-- /.messages-menu -->
			   <?php endif;?>


			<?php if(isset($global_notifications)):?>
			  <!-- Messages: style can be found in dropdown.less-->
			  <li class="dropdown messages-menu">
				<!-- Menu toggle button -->
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  <i class="fa fa-bell-o "></i><!--fa-envelope-o  / -->
				  <?php if(count($global_notifications)):?>
				  <span class="label label-default"><?php echo count($global_notifications);?></span>
				  <?php else:?>
				  	 <span class="label label-default"></span>
				   <?php endif;?>
				</a>

				<ul class="dropdown-menu">
				  <li class="header">You have <?php echo count($global_notifications);?> notification</li>
				  <li>
					<!-- inner menu: contains the messages -->
					<ul class="menu">
					  <?php $index =0;?>
					  <?php foreach($global_notifications as $message):?>
					  <?php if ($index >3) continue ; else $index++ ;?>
					  <li><!-- start message -->
						<a href="admin/notifications">
						  <h5>
							<?php echo($message->name);?>
							<small><i class="fa fa-clock-o"></i> <?php echo($message->created);?></small>
						  </h5>
						  <!-- The message -->
						  <p><?php echo($message->description);?></p>
						</a>
					  </li><!-- end message -->
					  <?php endforeach; ?>
					</ul><!-- /.menu -->
				  </li>
				  <li class="footer"><a href="admin/notifications">See All Notifications</a></li>
				</ul>
			  </li><!-- /.messages-menu -->
			   <?php endif;?>


			  <?php if(isset($todo_tasks)):?>

			  <!-- Tasks Menu -->
			  <li class="dropdown tasks-menu">
				<!-- Menu Toggle Button -->
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  <i class="fa fa-check"></i>
					<?php if(count($todo_tasks)):?>
						<span class="label dash_task_count"> <?php echo(count($todo_tasks));?></span>
					<?php else:?>
						<span class="label dash_task_count"></span>
					<?php endif;?>
				</a>
				<ul class="dropdown-menu">
				  <li class="header">You have <span class='dash_task_count'><?php echo(count($todo_tasks));?></span> tasks</li>
				  <li>
					<!-- Inner menu: contains the tasks -->
					<ul id='taskDashUL' class="menu">
					  <?php $index =0;?>
					  <?php foreach($todo_tasks as $some_task):?>
					  <?php if ($index >3) continue ; else $index++ ;?>
					  <li id='dash_task_item_<?php echo($some_task->id);?>'><!-- Task item -->
						<a href="admin/tasks/edit/<?php echo($some_task->id);?>">
						  <!-- Task title and progress text -->
						  <h3>
				   

							<?php echo($some_task->name);?>
							<small class="pull-right"><?php echo($some_task->description);?></small>
						  </h3>
						  <!-- The progress bar -->
						  <div class="progress xs">
							<!-- Change the css width attribute to simulate progress -->
							<div class="progress-bar progress-bar-aqua" style="width: <?php echo($some_task->pcent);?>%" role="progressbar" aria-valuenow="<?php echo($some_task->pcent);?>" aria-valuemin="0" aria-valuemax="100">
							  <span class="sr-only"><?php echo($some_task->pcent);?>% Complete</span>
							</div>
						  </div>
						</a>
					  </li><!-- end task item -->
					<?php endforeach; ?>
					</ul>
				  </li>
				  <li class="footer">
					  <a href="admin/tasks/">
						  Manage tasks
					  </a>
				  </li>
				</ul>
			  </li>

			  <?php endif; ?>
   
			  <!-- Start Head User-->


		<?php
		  $linkto = ($this->current_user->group == 'admin')? 'admin/users/edit/'.$this->current_user->id :  'edit-profile';
		  $profile_link =  '<a href="'.$linkto.'" class="">Edit Profile</a>';
		  ?>  


			  <!-- User Account Menu -->
			  <li class="dropdown user user-menu">
				<!-- Menu Toggle Button -->
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  <!-- The user image in the navbar-->
				  <!--img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/-->
				  <?php echo gravatar_alt($this->current_user->email,['size'=>50,'class'=>'user-image']);?>
				  <!-- hidden-xs hides the username on small devices so only the image appears. -->
				  <span class="hidden-xs"><?php echo $this->current_user->display_name;?></span>
				</a>
				<ul class="dropdown-menu">
				  <!-- The user image in the menu -->
				  <li class="user-header">
					<?php echo gravatar_alt($this->current_user->email,['size'=>150,'class'=>'img-circle']);?>
					<p>
					  <?php echo $this->current_user->display_name;?> - <?php echo($this->current_user->group_description);;?>
					  <small>Member since <?php echo(format_date($this->current_user->created_on) );?></small>
					</p>
				  </li>
				  <!-- Menu Body -->
				  <li class="user-body">
					<div class="col-xs-6 text-center">
					   <a href="admin/users/" class="">Manage Users</a>
					</div>
					<div class="col-xs-6 text-center">
					  <?php echo $profile_link;?>
					</div>
				  </li>
				  <!-- Menu Footer-->
				  <li class="user-footer">
					<div class="pull-left">
					 
					</div>
					<div class="pull-right">
					  <a href="admin/logout/" class="btn btn-default btn-flat">Sign out</a>
					</div>
				  </li>
				</ul>
			  </li>
			  <!-- End Head User-->
			  
			  <?php if(defined('DASHBOARD_VIEW')):?>
			  <li>
				<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
			  </li>  
			  <?php endif;?>            

			</ul>
			
		  </div>
		</nav>
		
	  </header>
