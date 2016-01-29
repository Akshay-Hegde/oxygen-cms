<!--
Only used when sublayout isnt found
-->
{{ layout:partial name="title" }}
	<h1>
		<small></small>
	</h1>
{{ /layout:partial }}
		
<div class="box box-primary">

	<div class="box-header with-border">
		<h3 class="box-title">{{ page:title }}</h3>
	</div>

	<div class="box-body">

		<h3>
			Welcome to OxygenCMS... 
		</h3>

		{{ user:has_cp_permissions}}
			<p>
			    It looks like this page hasnt been configured properly.<br>
			    If you are the site owner  go to  <a href="{{url:site}}admin/pages/types">Page Types</a> and assign a sublayout to this page.
			</p>
		{{ /user:has_cp_permissions }}

	</div>

</div>    