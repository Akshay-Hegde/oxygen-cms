jQuery(document).ready(function ($) {

	// Add that cool orange bkg to the input that has focus
	$('input, select').bind({
		focusin: function () {
			$(this)
				.closest('.input')
				.addClass('block-message ioxy');
		},
		focusout: function () {
			$(this)
				.closest('.input')
				.removeClass('block-message ioxy');
		}
	});

	$('input[name="database"]').on('keyup', function () {
		var $db = $('input[name=database]');
		// check the database name for correct alphanumerics
		if ($db.val().match(/[^A-Za-z0-9_-]+/)) {
			$db.val($db.val().replace(/[^A-Za-z0-9_-]+/, ''));
		}
	});

	$('input[name=password]').on('keyup focus', function () {

		$.post(base_url + 'index.php/ajax/confirm_database', {
				database: $('input[name=database]').val(),
				create_db: $('input[name=create_db]').is(':checked'),
				server: $('input[name=hostname]').val(),
				port: $('input[name=port]').val(),
				username: $('input[name=username]').val(),
				password: $('input[name=password]').val()
			}, function (data) {
				var $confirm_db = $('#confirm_db');
				if (data.success === true) {
					$confirm_db
						.html(data.message)
						.removeClass('block-message error')
						.addClass('block-message success');
				} else {
					$confirm_db
						.html(data.message)
						.removeClass('block-message success')
						.addClass('block-message error');
				}
			}, 'json'
		);

	});

	$('select#http_server').change(function () {
		if ($(this).val() == 'apache_w') {
			$.post(base_url + 'index.php/ajax/check_rewrite', '', function (data) {
				if (data !== 'enabled') {
					alert(data);
				}
			});
		}
	});

	// Password Complexity
	$('#user_password').complexify({}, function (valid, complexity) {
		var $progress = $('#progressbar');

		if(complexity>40) {
			if(complexity<70) {
				complexity=complexity+20;
			}
		}


		$progress.attr('aria-valuenow',complexity);

		$progress.removeClass('progress-bar-aqua');
		$progress.removeClass('progress-bar-red');
		$progress.removeClass('progress-bar-blue');
		$progress.removeClass('progress-bar-green');


		if (!valid) {
			$progress
				.css({ 'width': complexity + '%' })
				.removeClass('progressbarValid')
				.addClass('password-weak')
				.addClass('progress-bar-red');
		} else {
			$progress
				.css({ 'width': complexity + '%' })
				.removeClass('progressbarInvalid')
				.addClass('password-strong');
				

				if(complexity > 90) {
					$progress.addClass('progress-bar-green');
				}
				else {
					if(complexity > 80) {
						$progress.addClass('progress-bar-blue');
					}
					else {					
						$progress.addClass('progress-bar-aqua');
					}
				}				
		}
		$('#complexity').html(Math.round(complexity) + '%');
	});

});
