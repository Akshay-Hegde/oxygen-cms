<?php  defined('BASEPATH') OR exit('No direct script access allowed');

$config['bootstrap-ml-child'] = "

		<li class='{{ class }}'>
			<a href='{{ url }}'>
				<i class='{{ icon }}''></i>
				<span>
					{{ title }}
				</span>
			</a>
		</li>
";

$config['bootstrap-ml-parent'] = "
             
	<li class='treeview {{ current_class }}'>
		<a href='{{ url }}'>
			<i class='{{ icon }}'></i>
			<span>{{ title }}</span> 
			<i class='fa fa-angle-left pull-right'></i>
		</a>
		
		<ul class='treeview-menu'>
			{{ list_children }}
		</ul>

	</li>
";

$config['parent-only-child'] = "

		<li class='{{ class }}'>
			<a href='{{ url }}'>
				<span>
					{{ title }}
				</span>
			</a>
		</li>
";

$config['parent-only-parent'] = "

		<li class='{{ class }}'>
			<a href='{{ url }}'>
				<span>
					{{ title }}
				</span>
			</a>
		</li>
";

