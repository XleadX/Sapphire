<?php
	include '../validation.php';
	include '../controller/year.php';
	include '../controller/year_filter.php';
	
	$inactive = 360000; 
	ini_set('session.gc_maxlifetime', $inactive); // set the session max lifetime to 2 hours

	if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > $inactive)){
		session_unset();
		session_destroy();
	}
	$_SESSION['time'] = time();
?>

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sapphire - Sales Pipeline & Physical Requirements</title>
<link href="../assets/img/icon.png" rel="icon"/>
<link rel="stylesheet" type="text/css" href="../assets/themes/sunny/easyui.css">
<link rel="stylesheet" type="text/css" href="../assets/themes/icon.css">
<link rel="stylesheet" type="text/css" href="../assets/themes/color.css">
<link rel="stylesheet" type="text/css" href="../assets/css/custom.css">
<link rel="stylesheet" type="text/css" href="../assets/css/loadingbar.css">
<link rel="stylesheet" type="text/css" href="../assets/css/jquery.datetimepicker.css">
<script type="text/javascript" src="../assets/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../assets/js/datagrid-detailview.js"></script>
<script type="text/javascript" src="../assets/js/function.js"></script>
<script type="text/javascript" src="../assets/js/jquery.loadingbar.js"></script>
<script type="text/javascript" src="../assets/js/jquery.datetimepicker.full.min.js"></script>
<script>
setTimeout(function(){
	alert('Session Time Out');
	window.location.href = "../index.php";
}, 36000000);		// Session 15 menit
</script>
</head>

<body>     
<div class="easyui-panel" style="padding:5px; background-color: #A29A89; width:100%; position: fixed">
    <a href="#" class="easyui-menubutton" data-options="menu:'#menu1',duration:60000"><b>File</b></a>
    <a href="#" class="easyui-menubutton" data-options="menu:'#menu2',duration:60000"><b>Activities</b></a>
	<a href="../assets/img/Sapphire.pdf" target="_blank" class="easyui-linkbutton" plain="true"><b>Help</b></a>
	<a class="easyui-linkbutton" plain="true" style="float:right; margin-right:10px; color:black"><b>User ID : <span style="color:white"><?php echo $username; ?></span></b></a>
	<input id="password" type="hidden" value="<?php echo $change_password ?>">
	<input id="access" type="hidden" value="<?php echo $access ?>">
</div>
<div id="menu1">
    <div><span>Data</span>
		<div>
			<div id="administratorMenu" href="ADMINISTRATOR">Administrator</div>
			<div id="engineerMenu" href="ENGINEER">Engineer</div>
			<div id="salesMenu"><span>Sales</span>
				<div>
					<div id="salesGroupMenu" href="SALES_GROUP">Sales Group & Market</div>
					<div id="salesPersonMenu" href="SALES">Sales Person</div>
				</div>
			</div>
			<div class="menu-sep"></div>
			<div id="opportunityMenu" href="OPPORTUNITY">Opportunity</div>
		</div>
	</div>
	<div onclick="changePassword()">Change Password
	</div>
    <div class="menu-sep"></div>
	<div href="../controller/logout.php" data-options="iconCls:'icon-back'">Exit</div>
</div>

<div id="menu2">
	<div id="salesManageMenu"><span>Sales</span>
		<div>
			<div id="orderMenu" class="loading" href="ORDER">Order Pipeline Manager</div>
			<div id="purchaseMenu" class="loading" href="PURCHASE_ORDER">Purchase Order Manager</div>
			<div id="salesOrderMenu" class="loading" href="SALES_ORDER">Sales Order Manager</div>
		</div>
	</div>
	<div id="engineerManageMenu"><span>Engineering</span>
		<div>
			<div id="rfqMenu" class="loading" href="RFQ">Request For Quotation Manager</div>
			<div id="drawMenu" class="loading" href="DRAW">Drawing Approval Manager</div>
			<div id="codeMenu" class="loading" href="CODE">Transformer Code Manager</div>
		</div>
	</div>
    <div class="menu-sep"></div>
	<div id="monitoringMenu" class="loading" href="PIPELINE">Order Pipeline Monitoring</div>
</div>

<div id="dlg_change_password" class="easyui-dialog" title="Change Password" style="width:300px; padding: 5px 10px 5px 10px; top:30%" buttons="#dlg-buttons-change-password" data-options="modal:true,closed:true,shadow:false">
	<div id="change_password_show"></div>
</div>
<div id="dlg-buttons-change-password">
	<button type="submit" form="change_password" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Change</button>
	<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_change_password').window('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</a>
</div>

<script type="text/javascript">
var access = $('#access').val();
if(access == 'sales'){
	$('#administratorMenu').attr('disabled', 'disabled');
	$('#engineerMenu').attr('disabled', 'disabled');
	$('#salesMenu').attr('disabled', 'disabled');
	$('#engineerManageMenu').attr('disabled', 'disabled');
	$('#salesOrderMenu').attr('disabled', 'disabled');
	$('#purchaseMenu').attr('disabled', 'disabled');
} else if(access == 'sales_admin'){
	$('#administratorMenu').attr('disabled', 'disabled');
	$('#engineerMenu').attr('disabled', 'disabled');
	$('#engineerManageMenu').attr('disabled', 'disabled');
	$('#orderMenu').attr('disabled', 'disabled');
} else if(access == 'eng'){
	$('#administratorMenu').attr('disabled', 'disabled');
	$('#engineerMenu').attr('disabled', 'disabled');
	$('#salesMenu').attr('disabled', 'disabled');
	$('#salesManageMenu').attr('disabled', 'disabled');
	$('#purchaseMenu').attr('disabled', 'disabled');
} else if(access == 'eng_head'){
	$('#administratorMenu').attr('disabled', 'disabled');
	$('#salesMenu').attr('disabled', 'disabled');
	$('#salesManageMenu').attr('disabled', 'disabled');
	$('#engineerManageMenu').attr('disabled', 'disabled');
	$('#purchaseMenu').attr('disabled', 'disabled');
} else if(access == 'admin'){
	$('#salesManageMenu').attr('disabled', 'disabled');
	$('#engineerManageMenu').attr('disabled', 'disabled');
}

$(".loading").loadingbar({
	done: function(data){}
});

function changePassword(){
	var change_password = $('#password').val();
	$('#dlg_change_password').dialog('open');
	$.ajax({
		type: "GET",
		url: "change_password.php",
		dataType: "html",
		data: "Password=" + change_password,
		success: function(data){                    
			$("#change_password_show").html(data);
		}
	});
}
</script>
</body>