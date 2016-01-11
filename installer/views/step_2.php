  <div class="box-header with-border">
    <h3 class="box-title">{header}!</h3>
    <p>{intro_text}</p>
  </div>
  <div class="box-body">

  	<h3>{mandatory}</h3>

	<table class='table'>
		<tr>
			<td>
				<label for="server_settings">{server_settings}</label>
			</td>
			<td>
				<p class="result <?php echo ($http_server_supported === true) ? 'pass' : 'partial'; ?>">
				<?php if ($http_server_supported === true): ?>
					<?php echo $http_server_name; ?>
				<?php else: ?>{server_fail}<?php endif; ?>
				</p>
			</td>			
		</tr>

		<tr>
			<td>
				<label for="php_settings">{php_settings}</label>
			</td>
			<td>

				<p><?php echo sprintf(lang('php_required'), $php_min_version); ?></p>
				<p class="result <?php echo ($php_acceptable) ? 'pass' : 'fail'; ?>">
					{php_version} <strong><?php echo $php_running_version; ?></strong>.
					<?php if (!$php_acceptable): ?>
						<?php echo sprintf(lang('php_fail'), $php_min_version); ?>
					<?php endif; ?>
				</p>

			</td>			
		</tr>
		<tr>
			<td>
				<h5><?php echo lang('mysql_settings'); ?></h5>
				<p><?php echo lang('mysql_required'); ?></p>
			</td>
			<td>

				<!-- Server -->
				<p class="result <?php echo ($server_version_acceptable) ? 'pass' : 'fail'; ?>">
					{mysql_version1} <strong><?php echo $server_version; ?></strong>.
					<?php if ( ! $server_version_acceptable) : ?>{mysql_fail}<?php endif; ?>
				</p>
				<!-- Client -->
				<p class="result <?php echo ($client_version_acceptable) ? 'pass' : 'fail'; ?>">
					{mysql_version2} <strong><?php echo $client_version; ?></strong>.
					<?php if ( ! $client_version_acceptable): ?>{mysql_fail}<?php endif; ?>
				</p>

			</td>			
		</tr>
	</table>

	<h3>{recommended}</h3>
	<table class='table'>
		<tr>
			<td>
				<h5>{gd_settings}</h5>
				<p>{gd_required}</p>
			</td>
			<td>
				<p class="result <?php echo ($gd_acceptable) ? 'pass' : 'fail'; ?>">
					{gd_version} <strong><?php echo $gd_running_version; ?></strong>.
					<?php if (!$gd_acceptable): ?>{gd_fail}<?php endif; ?>
				</p>
			</td>			
		</tr>
		<tr>
			<td>
				<h5>{zlib}</h5>
				<p>{zlib_required}</p>
			</td>
			<td>
				<p class="result <?php echo ($zlib_enabled) ? 'pass' : 'fail'; ?>">
					<?php if ($zlib_enabled): ?>{zlib}<?php else: ?>{zlib_fail}<?php endif; ?>
				</p>
			</td>			
		</tr>
		<tr>
			<td>
				<h5>{curl}</h5>
				<p>{curl_required}</p>
			</td>
			<td>
				<p class="result <?php echo ($curl_enabled) ? 'pass' : 'fail'; ?>">
					<?php if ($curl_enabled): ?>{curl}<?php else: ?>{curl_fail}<?php endif; ?>
				</p>
			</td>			
		</tr>		
	</table>

	<h3>{summary}</h3>
	<section class="item">
		<?php if($step_passed === true): ?>
			<p class="success">{summary_success}</p>
			<a class="btn btn-flat bg-blue" id="next_step" href="<?php echo site_url('installer/step_3'); ?>" title="{next_step}">{step3}</a>
		<?php elseif($step_passed == 'partial'): ?>
			<p class="partial">{summary_partial}</p>
			<a class="btn btn-flat bg-blue" id="next_step" href="<?php echo site_url('installer/step_3'); ?>" title="{next_step}">{step3}</a>
		<?php else: ?>
			<p class="failure">{summary_failure}</p>
			<a class="btn btn-flat bg-blue" id="next_step" href="<?php echo site_url('installer/step_2'); ?>">{retry}</a>
		<?php endif; ?>
	</section>
 </div>