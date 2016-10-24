<?php
$stmt = $conn->prepare("SELECT Tahun FROM Pipeline WHERE CreateId = :CreateId");
$stmt->bindParam(':CreateId', $username);
$stmt->execute();
$result = $stmt->fetch();
$tahun	= $result['Tahun'];
	
if($tahun <> NULL){
	$year = $tahun;
} else {
	$year = '2015';
}
				
$start_date = DateTime::createFromFormat('Y', $year);

$end_date = new DateTime();
$end_date = $end_date->modify('+1 year');

$interval = new DateInterval("P1Y");
$dates = new DatePeriod($start_date, $interval, $end_date);

$output = array();

if(!empty($dates)){
	foreach($dates as $dt) {
		$output[] = array(
			'year' => $dt->format('Y')
		);
	}
}
?>