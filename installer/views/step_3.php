<div class="box-header with-border">
	<h3 class="box-title">{header}!</h3>
	<p>{intro_text}</p>                
</div>
<div class="box-body">

  	<h3>{folder_perm}</h3>
	<table class='table'>

		<?php $count_nw_1 = 0;?>
		<?php foreach ($permissions['directories'] as $directory => $status): ?>
		<?php 
			if(!$status) {
			  $count_nw_1++;
			} else {
				continue;
			}
		?>
			<tr>
				<td width="150px;">
					<?php echo ' <span class="label label-danger">{not_writable}</span>'; ?>
				</td>				
				<td>
					<span><?php echo $directory; ?></span>
				</td>
		
			</tr>
		<?php endforeach; ?>
			<?php if(!$count_nw_1 === 0 ): ?>
				<tr>
					<td>
						<span>Status</span>
					</td>
					<td>
						All directories are OK
					</td>			
				</tr>	
			<?php endif; ?>
	</table>

	<h3>{file_perm}</h3>
	<p>{file_text}</p>

	<?php $count_nw_2 = 0;?>
	<table class='table'>
		<?php foreach($permissions['files'] as $file => $status): ?>
		<?php 
			if(!$status) {
			  $count_nw_2++;
			} else {
				continue;
			}
		?>			
		<tr>
			<td width="150px;">
				<?php echo ' <span class="label label-danger">{not_writable}</span>'; ?>
			</td>	
			<td>
				<?php echo $file;?>
			</td>
		</tr>
		<?php endforeach; ?>
			<?php if(!$count_nw_2 === 0 ): ?>
				<tr>
					<td>
						<span>Status</span>
					</td>
					<td>
						All files are OK
					</td>			
				</tr>	
			<?php endif; ?>		
	</table>
	<br/>
	<h3>Commands</h3>
	<div class='col-md-12'>
		<?php
		$cmds_d = '';
		$cmds_f ='';
		foreach($permissions['directories'] as $directory => $status) {
				$cmds_d .= $status ? '' : 'chmod 777 '.$directory.PHP_EOL;
		}
		foreach($permissions['files'] as $files => $status) {
			$cmds_f .= $status ? '' : 'chmod 666 '.$files.PHP_EOL;
		}
		?>
		<?php if ( ! empty($cmds_d) || ! empty($cmds_f)): ?>

		<textarea id="commands" style="; margin: 0 0 10px 10px; width:100%; background-color: #111; color: limegreen; padding: 0.5em;" rows="<?php echo count($permissions['directories']) + count($permissions['files']); ?>">
		<?php echo $cmds_d;?>
		<?php echo $cmds_f;?>
		</textarea>
		<?php endif; ?>

		<?php if($step_passed): ?>
			<a class="btn btn-flat bg-blue" id="next_step" href="<?php echo site_url('installer/step_4'); ?>" title="{next_step}">{step4}</a>
		<?php else: ?>
			<a class="btn btn-flat bg-blue" id="next_step" href="<?php echo site_url('installer/step_3'); ?>">{retry}</a>
		<?php endif; ?>
	</div>
</div>