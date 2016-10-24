<?php
date_default_timezone_set('Asia/Jakarta');
include '../setting/connection.php';

$number			= $_REQUEST['PipelineNumber'];
$revision		= $_REQUEST['RevisionNumber'];
$opportunity	= $_REQUEST['NewOpportunityLevel'];
$date			= date('m/d/Y H:i:s A');

$result = $conn->prepare("UPDATE Pipeline SET OpportunityLevel = :opportunity, OpportunityDate = :date WHERE PipelineNumber = :number AND RevisionNumber = :revision");
$result->bindParam(':opportunity', $opportunity);
$result->bindParam(':date', $date);
$result->bindParam(':number', $number);
$result->bindParam(':revision', $revision);
$result->execute();

if($result){
	echo '<script>alert("Opportunity was change !")</script>';
	echo '<script>document.location="../view/ORDER"</script>';
} else {
	echo '<script>alert("Opportunity wasn\'t change !")</script>';
	echo '<script>document.location="../view/ORDER"</script>';
}
?>