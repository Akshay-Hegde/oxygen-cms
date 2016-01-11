<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title"><?php echo lang('global:plugins');?> : <?php echo lang('addons:plugins:add_on_plugins');?> </h3>
            </div>
            <div class="box-body">
				<?php echo $this->load->view('admin/plugins/_table', array('plugins' => $plugins), true) ?>
       		</div>
    	</div>
	</div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title"><?php echo lang('global:plugins');?> : <?php echo lang('addons:plugins:core_plugins');?></h3>
            </div>
            <div class="box-body">
				<?php echo $this->load->view('admin/plugins/_table', array('plugins' => $core_plugins), true) ?>	
				<?php echo $this->load->view('admin/plugins/_docs', array('plugins' => array($plugins, $core_plugins)), true) ?>
       		</div>

    	</div>
	</div>
</div>