<?php
	$start_date = new DateTime();
	$start_date = $start_date->modify('-1 year');

	$end_date = new DateTime();
	$end_date = $end_date->modify('+1 year');

	$interval = new DateInterval("P1Y");
	$dates = new DatePeriod($start_date, $interval, $end_date);

	$out = array();

	if (!empty($dates)) {
		foreach($dates as $dt) {
			$out[] = array(
				'year' => $dt->format('Y')
			);
		}
	}
?>