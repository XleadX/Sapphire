<?php
include '../setting/connection.php';
include '../setting/function.php';
$password = $_GET['Password'];
?>

<form id="change_password" action="../controller/change_password.php" method="post">
	<div class="fitem">
		<label style="width:150px">Input New Password</label>
	</div>
	<div class="fitem">
		<input name="password" class="easyui-textbox" style="width:265px" required value="<?php echo $password; ?>" autocomplete="off">
	</div>
</form>