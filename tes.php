<?php
include 'setting/connection.php';
$bugroup = '';
	
$stmt = $conn->prepare("SELECT EngineerEmail FROM Engineer WHERE EngineerGroup = 'ENG' AND (BUGroup = :bugroup OR BUGroup = '')");
$stmt->bindParam(':bugroup', $bugroup);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $key){
	echo $key;
}
?>