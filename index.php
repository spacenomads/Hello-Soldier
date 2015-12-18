<!doctype html>
<?php $page='calendar';include 'incl/cc.php'; ?>
<head>
	<?php include 'incl/head.php'; ?>
	<title>Hello Soldier! How was your day?</title>
</head>
<body class="<?php echo $page; ?>" data-default="<?php echo $page; ?>">
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
	$year = '2015';
	$bday = '13-10-' . $year;
	$bday_face = ':D';

	$cday = '26-01-' . $year;
	$cday_face = ':D';

	$dday = '04-02-' . $year;
	$dday_face = ':(';

	//$myyear = simplexml_load_file('year/2013_alt.xml');
	$myyear = simplexml_load_file('year/2015.xml');
	$days = count($myyear);
	$month = '';
	$total_days = 365;
	$iconos = array();
	$stats = array(
		'ok' => 0,
		'ko' => 0,
		);


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
			'summary' => '',
			'week_day' => '',
			'month' => '',
			'bday' => ''
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
		$iconos[$nodo]['summary'] = $myyear->day[$i]['summary'];
		$iconos[$nodo]['week_day'] = ' ' . strtolower(date('l', strtotime($iconos[$nodo]['date'])));
		$month = date("m",strtotime( $myyear->day[$i]['date'] ));
		$iconos[$nodo]['month'] = ' active m' .  $month;

		if ( $iconos[$nodo]['date'] == $bday ) {
			$iconos[$nodo]['bday'] = ' bday';
			if ($iconos[$nodo]['day'] == 'ok'){
				$iconos[$nodo]['face'] = $bday_face;
			}
		}

		if ( $iconos[$nodo]['date'] == $cday ) {
			$iconos[$nodo]['cday'] = ' cday';
			if ($iconos[$nodo]['day'] == 'ok'){
				$iconos[$nodo]['face'] = $cday_face;
			}
		}

		if ( $iconos[$nodo]['date'] == $dday ) {
			$iconos[$nodo]['dday'] = ' dday';
			if ($iconos[$nodo]['day'] == 'ko'){
				$iconos[$nodo]['face'] = $dday_face;
			}
		}

	}

	echo '<!-- stats: :) vs. :( - ' . $stats['ok'] . ' - ' . $stats['ko'] . ' -->' ;
 ?>

<div id="main" role="main">
	<ul class="year y<?php echo $year; ?> clearfix">
<?php
	for ($i=0; $i <= $total_days-1; $i++)
	{
		//echo 'día: ' . $iconos[$i]['id'] . ' @' . $iconos[$i]['date'] . ' / ' . $iconos[$i]['face'] . '<br>';
?>
		<li class="day day<?php echo $iconos[$i]['id']; ?><?php echo $iconos[$i]['bday']; ?><?php echo $iconos[$i]['cday']; ?><?php echo $iconos[$i]['dday']; ?><?php echo $iconos[$i]['week_day']; ?><?php echo $iconos[$i]['month']; ?>" title="<?php echo $iconos[$i]['date']; ?>" data-day="<?php echo $iconos[$i]['id']; ?>">
				<i class="face <?php echo $iconos[$i]['day']; ?>"><?php echo $iconos[$i]['face']; ?></i>
				<time class="date" datetime="<?php echo $iconos[$i]['date']; ?>"><?php echo $iconos[$i]['date']; ?></time>
<?php if ( ($iconos[$i]['day'] == 'ok') || ($iconos[$i]['date'] == $dday) ) { ?>				<p class="summary"><?php echo $iconos[$i]['summary'] ?></p>
<?php } ?>
		</li>
<?php
	}
 ?>
	</ul>
</div>
<div class="stats">
	<div class="good days" data-value="<?php echo $stats['ok']; ?>"></div>
	<div class="bad days" data-value="<?php echo $stats['ko']; ?>"></div>
</div>
<div class="bar_graph data" data-month="<?php echo $month; ?>" data-year="<?php echo $year; ?>"></div>
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
	unset($month);
 ?>

	<?php include 'incl/js.php'; ?>

	<?php include 'incl/analytics.php'; ?>

</body>
</html>
