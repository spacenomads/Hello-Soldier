<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Salvador :)</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<?php
	if ( isset($_POST['today_date']) ) {

		$str = file_get_contents( 'year/2015.json' );
		$year = json_decode( $str, true );

		$year['soldier']['day'][$_POST['today_doy']-1]['id'] = $_POST['today_doy'];
		$year['soldier']['day'][$_POST['today_doy']-1]['date'] = $_POST['today_date'];
		$year['soldier']['day'][$_POST['today_doy']-1]['mood'] = $_POST['today_mood'];

?>
<form id="date_editor" class="form" action="">
	<fieldset>
		<legend>Recogida de datos</legend>
		<ul>
			<li><input type="text" name="today_date" id="today_date" value="<?php echo $_POST['today_date'] ?>" readonly /></li>
			<li><input type="text" name="today_doy" id="today_doy" value="<?php echo $_POST['today_doy'] ?>" readonly /></li>
			<li><input type="text" name="today_mood" id="today_mood" value="<?php echo $_POST['today_mood'] ?>" readonly /></li>
			<li><input type="text" name="today_phrase" id="today_phrase" value="<?php echo $_POST['today_phrase'] ?>" readonly /></li>
		</ul>
	</fieldset>
</form>
<?php
	echo '<pre>' . print_r( $year, true ) . '</pre>';
 ?>
<?php
  	//hay datos
	} else {
		//No hay na de na
?>
	<h1>No sé de dónde has salido tú</h1>
<?php
	}
 ?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-2.1.4.min.js"><\/script>')</script>
	<script src="js/vendor/moment.min.js"></script>
	<script>


	</script>

</body>
</html>