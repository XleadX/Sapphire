<?php
include '../setting/connection.php';

$status	= array('New','PO','SO','Loss');
$rfq	= array('Request','Schedule','Pick','Answer');
$draw	= array('Require','Answer','Approve');
$code	= array('Require','Answer');

if(isset($_POST['field_order'])){
	$choose = $_POST['field_order'];
	if($choose == 'PipelineNumber'){
		echo '<option value="%">All</option>';
	} elseif($choose == 'PipelineStatus'){
		foreach($status as $key){
			echo '<option value="'.$key.'">'.$key.'</option>';
		}
	} elseif($choose == 'RFQStatus'){
		foreach($rfq as $key){
			echo '<option value="'.$key.'">'.$key.'</option>';
		}
	} elseif($choose == 'DrawStatus'){
		foreach($draw as $key){
			echo '<option value="'.$key.'">'.$key.'</option>';
		}
	} elseif($choose == 'TrfCodeAnswer'){
		echo '<option value="No">Require</option>';
		echo '<option value="Yes">Answer</option>';
	}
}
?>