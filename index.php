<!doctype html>
<?php $page='calendar';include 'incl/cc.php'; ?>
<head>
	<?php include 'incl/head.php'; ?>
	<title>Hello Soldier! How was your day?</title>
</head>
<body class="<?php echo $page; ?>">
	<?php //include 'incl/header.php'; ?>
<?php 
	function bisiesto($y){
		if (($y % 4 == 0) && (($y % 100 != 0) || ($y % 400 == 0))) {
			return true;
		} else { return false; }
	}

	// prueba de fecha
	// set default timezone
	date_default_timezone_set('Europe/Madrid'); // CDT
	$current_date = date('d-m-Y');
	$current_day = date('z');

	echo '<!--' . $current_date . '-->';
	echo '<!--' . $current_day . '-->';

	// constantes
	$year = '2013';
	$myyear = simplexml_load_file('year/2013.xml');
	$days = count($myyear);
	$total_days = 365;
	$iconos = array();
	$stats = array(
		'ok' => 0,
		'ko' => 0,);

	// Ajustes
	if (bisiesto($year)) { $total_days = 366; } 
	if ($days > $total_days) { $days = $total_days; }

	//echo 'td: ' . $total_days . '<br>';
	//echo 'd: ' + $days;

	for ($i=0; $i <= $total_days-1; $i++)
	{ 
		$iconos[$i] = array(
			'id' => $i+1,
			'day' => '',
			'face' => '?',
			'date' => $year,
			);
	}

	for ($i=0; $i < $days; $i++)
	{
		if ($myyear->day[$i] == 'ok') {
			$face = ':)';
			$stats['ok']++;
		} else {
			$face = ':(';
				$stats['ko']++;
		}


		$nodo = $myyear->day[$i]['id']-1;
		$iconos[$nodo]['day'] = $myyear->day[$i];
		$iconos[$nodo]['face'] = $face;
		$iconos[$nodo]['date'] = $myyear->day[$i]['date'];
	}

	echo '<!-- stats: ' . $stats['ok'] . ' - ' . $stats['ko'] . ' -->' ;
 ?>

<div id="main" role="main">
	<ul class="year clearfix">
<?php 
	for ($i=0; $i <= $total_days-1; $i++)
	{ 
		//echo 'día: ' . $iconos[$i]['id'] . ' @' . $iconos[$i]['date'] . ' / ' . $iconos[$i]['face'] . '<br>';
?>
		<li class="day day<?php echo $iconos[$i]['id']; ?>" title="<?php echo $iconos[$i]['date']; ?>">
				<i class="face <?php echo $iconos[$i]['day']; ?>"><?php echo $iconos[$i]['face']; ?></i>
				<time class="date" datetime="<?php echo $iconos[$i]['date']; ?>"><?php echo $iconos[$i]['date']; ?></time>
		</li>
<?php 
	}
 ?>
	</ul>	
	</div>

<?php 
	unset($year);
	unset($myyear);
	unset($days);
	unset($total_days);
	unset($iconos);
	unset($stats);
	unset($i);
	unset($nodo);
	unset($face);
 ?>

	<?php include 'incl/js.php'; ?>

	<?php include 'incl/analytics.php'; ?>

</body>
</html>
