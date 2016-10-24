<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Sapphire - Sales Pipeline & Physical Requirements</title>
<link href="img/icon.png" rel="icon" />
<script type="text/javascript" src="assets/js/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="assets/themes/icon.css">
<link rel="stylesheet" type="text/css" href="assets/themes/color.css">
<link rel="stylesheet" type="text/css" href="assets/css/custom.css">
<script type="text/javascript" src="assets/js/jquery.easyui.min.js"></script>
<style>
body {
	background: #CCCCCC no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
</style>
</head>

<body>
<div class="middle">
	<div class="easyui-panel" title="&nbsp;" style="width: 300px; padding: 20px 20px 20px 20px">
		<form id="login_form" action="controller/authentication.php" method="post" novalidate>
			<div>
				<input type="text" name="username" class="easyui-textbox" style="width: 260px" data-options="iconCls:'icon-man', iconAlign:'right'" required="true" prompt="Username">
			</div>
			<br>
			<div>
				<input type="password" name="password" class="easyui-textbox" style="width: 260px" data-options="iconCls:'icon-lock', iconAlign:'right'" required="true" prompt="Password">
			</div>
			<br>
			<div>
				<button id="login" type="submit" class="easyui-linkbutton c6" style="width: 262px"><b>Login</b></button>
			</div>
		</form>
	</div>
</div>
</body>