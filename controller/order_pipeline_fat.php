<?php
date_default_timezone_set('Asia/Jakarta');
include '../setting/connection.php';

$number		= $_REQUEST['PipelineNumber'];
$fat		= $_REQUEST['newFATDate'];
$fat_date	= date('m/d/Y H:i:s A', strtotime($fat));

$result = $conn->prepare("UPDATE Pipeline SET FATDate = :fat_date, FAT = 'Yes' WHERE PipelineNumber = :number");
$result->bindParam(':fat_date', $fat_date);
$result->bindParam(':number', $number);
$result->execute();

if($result){
	echo '<script>alert("FAT date was change !")</script>';
	echo '<script>document.location="../view/ORDER"</script>';
} else {
	echo '<script>alert("FAT date wasn\'t change !")</script>';
	echo '<script>document.location="../view/ORDER"</script>';
}
?>