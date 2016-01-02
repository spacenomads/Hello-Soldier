<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hello Soldier - Mark II</title>
</head>
<body>

<?php
	/**
	 * Check wether is a leap year or not
	 * @param  string  $y Year to be checked
	 * @return boolean    Returns 'true' if $y is a leap year and 'false' if it is not.
	 */
	function is_leap_year($y){
		if (($y % 4 == 0) && (($y % 100 != 0) || ($y % 400 == 0))) {
			return true;
		} else {
			return false;
		}
	}





	/**
	 * writes the year unordered list
	 * @return string <ul> with the complete year information
	 */
	function write_my_year(){
		global $actual_year, $year_days;
		$my_year = '<ul class="year year_' . $actual_year . '">';
		for ( $i=0; $i < $year_days; $i++ ) {
			$my_year .= write_my_day( $i );
		}

		$my_year .= '</ul>';

		echo $my_year;
	}




	/**
	 * Writes de day list item
	 * @param  number $d Day's ID
	 * @return string    <li> with the complete day information
	 */
	function write_my_day( $d ) {
		global $year, $mood, $special_days;

		if ( $year['soldier']['day'][$d] ) {


			$my_mood = $year['soldier']['day'][$d]['mood'];
			$my_date = $year['soldier']['day'][$d]['date'];

			if ( $special_days[$d] ) {

				// Special day
				$day = '<li class="day day_' . ( $d + 1 ) . ' ' . $special_days[$d]['class'] . '" data-day="' . ( $d + 1 ) . '">';
				if ( $my_mood === 'ok' ) {
					$day .= '<div class="face face_' . $my_mood . '">' . $special_days[$d]['icon'] . '</div>';
				} else {
					$day .= '<div class="face face_' . $my_mood . '">' . $mood[ $my_mood ] . '</div>';
				}

				$day .= '<time class="date" datetime="' . $my_date . '">' . $my_date . '</time>';
				if ( $my_mood === 'ok' ) {
					$day .= '<p class="summary">' . $year['soldier']['day'][$d]['summary'] . '</p>';
				}
				$day .= '</li>';

			 } else {

				// Normal calendar day
				$day = '<li class="day day_' . ( $d + 1 ) . '" data-day="' . ( $d + 1 ) . '">';
				$day .= '<div class="face face_' . $my_mood . '">' . $mood[ $my_mood ] . '</div>';
				$day .= '<time class="date" datetime="' . $my_date . '">' . $my_date . '</time>';
				if ( $my_mood === 'ok' ) {
					$day .= '<p class="summary">' . $year['soldier']['day'][$d]['summary'] . '</p>';
				}
				$day .= '</li>';

			}



		} else {
			$day = '<li class="day"><div class="face">' . '?' . '</div></li>';
		}

		return $day;
	}



	function day_of_the_year($day, $month, $year) {
		return date('z', mktime( 0,0,0,$month,$day,$year));
	}




	// SETTINGS
	$str = file_get_contents( 'year/2015.json' );
	$year = json_decode( $str, true );
	$actual_year = $year['soldier']['year'];
	$year_days = 365;
	$mood = array( 'ok' => ':)', 'ko' => ':(' );
	if ( is_leap_year( $actual_year ) ) {
		$year_days = 366;
	}

	$special_days = array(
		(day_of_the_year(26, 1, $actual_year)) => array(
			'date' => '26-01-' . $actual_year,
			'class' => 'cday',
			'icon' => ':D'
		),
		(day_of_the_year(13, 10, $actual_year)) => array(
			'date' => '13-10-' . $actual_year,
			'class' => 'bday',
			'icon' => ':D'
		)
	);
	//echo '>> ' . $special_days[26]['date'] . '<br>';
	//echo '>> ' . $special_days[286]['date'] . '<br>';

?>
	<div class="page calendar_view">
		<?php write_my_year(); ?>
	</div>
</body>
</html>
