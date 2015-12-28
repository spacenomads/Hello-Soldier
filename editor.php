<?php
session_start();
include 'incl/_config.php';
check_logged();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Editor :)</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<style>
		.page {
			opacity: 1;
			transition: opacity ease .3s;
		}
		.is_hidden {
			opacity: .1;
		}
	</style>
</head>
<body style="font-size: 3em;">
	<div class="page is_hidden">
		<form id="date_editor" class="form" method="post" action="save-the-day.php">
			<fieldset>
				<legend>Editor de fecha</legend>

				<div class="row">
					<label for="hs_date_today" class="label">Hoy</label>
					<input type="date" name="hs_date_today" id="hs_date_today" class="field_text field_date" value="<?php echo date( 'Y-m-d'); ?>" tabindex="1" />
				</div>

				<div class="row">
					<label for="hs_mood_ok" class="label mood">
						<input type="radio" name="hs_mood" id="hs_mood_ok" class="field_radio" value="ok" tabindex="2" /> :)
					</label>
					<label for="hs_mood_ko" class="label mood">
						<input type="radio" name="hs_mood" id="hs_mood_ko" class="field_radio" value="ko" checked tabindex="3" /> :(
					</label>
				</div>
				<div class="row phrase_row">
					<label for="hs_today_phrase" class="label">Frase</label>
					<input type="text" name="hs_today_phrase" id="hs_today_phrase" class="field field_text phrase" tabindex="4" />
				</div>
				<div class="row action">
					<input type="button" value="Dale!" class="hs_button" />
				</div>
			</fieldset>
			<fieldset>
				<legend>Datos finales</legend>
				<ul>
					<li><input type="text" name="today_date" id="today_date" readonly /></li>
					<li><input type="text" name="today_doy" id="today_doy" readonly /></li>
					<li><input type="text" name="today_mood" id="today_mood" readonly /></li>
					<li><input type="text" name="today_phrase" id="today_phrase" readonly /></li>
				</ul>
			</fieldset>
		</form>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-2.1.4.min.js"><\/script>')</script>
	<script src="js/vendor/moment.min.js"></script>
	<script>
		jQuery(document).ready(function($) {
			var
				$body = $( 'body' ),
				$date_form =  $body.find( '#date_editor' ),
				active_year,
				year_data;

				var year_file = $.getJSON( 'year/2015.json', function(data) {
					console.log( '>> success' );
					$body.find( '.page' ).removeClass( 'is_hidden' );
					year_data = data;
					active_year = year_data['soldier']['year'];
					check_date( $date_form.find( '#hs_date_today').val() );
				})
			  .fail(function() {
			    console.log( '>> error' );
			  });

			var check_date = function( field_date ) {
				var
					my_date = moment( field_date ).format( 'DD-MM-YYYY' ),
					my_year = moment( field_date ).format( 'YYYY' ),
					valid_date = true,
					date_exists = false;

					console.log( 'my_date: ' + my_date);

					if ( my_year === active_year ) {
						console.log( 'entra');

						$.each(year_data['soldier']['day'], function(index, el) {
							if (this['date'] === my_date ) {
								date_exists = true;
							}
						});
						console.log( '? ' + date_exists );
					} else {
						valid_date = false;
					}

				// if date exists show the button
				console.log( 'my_date: ' + my_date);
				console.log( 'my_year: ' + my_year);
				console.log( 'valid_date: ' + valid_date);
				console.log( 'date_exists: ' + date_exists);

				if ( valid_date ) {
					if ( date_exists ) {
						$date_form.find( '.hs_button' ).attr('disabled', 'disabled');
					} else {
					// if does not exists show the funny message
						$date_form.find( '.hs_button' ).removeAttr( 'disabled' );
					}
				} else {
					$date_form.find( '.hs_button' ).attr('disabled', 'disabled');
				}

			};

			var check_mood = function() {
					var mood = $date_form.find( 'input[name="hs_mood"]:checked' ).val();
					console.log( mood );
					if ( mood === 'ok' ) {
						$date_form.find( '.phrase_row' ).show();
					} else {
						$date_form.find( '.phrase_row' ).hide();
					}
				};

			var send_today_data = function() {
				var today_date = moment( $date_form.find( '#hs_date_today').val() ).format( 'DD-MM-YYYY' );
				var today_number = moment( $date_form.find( '#hs_date_today').val() ).format( 'DDD' );
				var today_mood = $date_form.find( 'input[name="hs_mood"]:checked').val();
				var today_phrase = $date_form.find( '#hs_today_phrase').val();

				if ( today_mood === 'ko' ) {
					today_phrase = '';
				}


				$date_form.find( '#today_date' ).val( today_date );
				$date_form.find( '#today_doy' ).val( today_number );
				$date_form.find( '#today_mood' ).val( today_mood );
				$date_form.find( '#today_phrase' ).val( today_phrase );
				$date_form.submit();
			};

			$date_form.find( '#hs_date_today' ).on('change', function(event) {
				event.preventDefault();
				/* Act on the event */
				check_date( $(this).val() );
			});

				check_mood();

				$date_form.find( 'input[name="hs_mood"]' ).on('change', function(event) {
					check_mood();
				});

				$date_form.find( '.hs_button' ).on('click', function(event) {
					event.preventDefault();
					/* Act on the event */
					send_today_data();
				});

				$('input[readonly]').on('touchstart', function(ev) {
    			event.preventDefault();
  			});

		});

	</script>

</body>
</html>
