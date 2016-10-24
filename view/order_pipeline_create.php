<?php
include '../setting/connection.php';
include '../setting/function.php';

session_start();
$username = $_SESSION['username'];
$number = $_GET['PipelineNumber'];
$type	= array();
$kva	= array();
$desc	= array();
$qty	= array();
?>

<form id="create_pipeline" method="post" action="../controller/order_pipeline_create.php" enctype="multipart/form-data">
	<div class="fitem">
		<label>Business Unit</label>
		<select id="BUGroup" name="BUGroup" style="width:100px" required onchange="$('#ProjectName').focus()">
			<option></option>
			<?php
				$stmt = $conn->query("SELECT BUGroup FROM BusinessUnit");
				while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
					echo '<option value="' . $data['BUGroup'] . '">' . $data['BUGroup'] . '</option>';
				}
			?>
		</select>
	</div>
	<div class="fitem">
		<label>Project Name</label>
		<input id="ProjectName" style="width:350px" name="ProjectName" autocomplete="off" required onkeypress="if(event.which == 13){ $('#Customer').focus(); return false;}">
	</div>
	<div class="fitem">
		<label>Customer</label>
		<input id="Customer" style="width:350px" name="Customer" autocomplete="off" required onkeypress="if(event.which == 13){ $('#PipelineNote').focus(); return false;}">
	</div>
	<div class="fitem">
		<label>Market</label>
		<select id="SalesMarketId" name="SalesMarketId" style="width:250px">
			<?php
				$stmt = $conn->query("SELECT SalesMarket.SalesMarketId FROM SalesMarket, SalesDept, Sales WHERE (Sales.SalesGroupId = SalesMarket.SalesGroupId AND Sales.SalesId = '$username') OR (SalesDept.SalesGroupId = SalesMarket.SalesGroupId AND SalesDept.SalesId = '$username') GROUP BY SalesMarket.SalesMarketId");
				while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
					echo '<option value="' . $data['SalesMarketId'] . '">' . $data['SalesMarketId'] . '</option>';
				}
			?>
		</select>
	</div>
	<div class="fitem">
		<label>Estimate Order Intake</label>
		<select id="EstimateOrderIntake" name="EstimateOrderIntake" style="width:150px" onchange="$('#PipelineNote').focus()">
			<option value="NA">NA</option>
			<?php
			$date = month_year();
			
			if(!empty($date)){
				foreach($date as $row){
					echo '<option value="'.$row['month_year'].'">'.$row['month_year'].'</option>';
				}
			}
			?>
		</select>&nbsp;&nbsp;
		<label>Delivery Request Time</label>
		<select id="DeliveryRequestTime" name="DeliveryRequestTime" style="width:150px" onchange="$('#PipelineNote').focus()">
			<option value="NA">NA</option>
			<?php
			$date = month_year();
			
			if(!empty($date)){
				foreach($date as $row){
					echo '<option value="'.$row['month_year'].'">'.$row['month_year'].'</option>';
				}
			}
			?>
		</select>
	</div>
	<div class="fitem">
		<label>Opportunity (%)</label>
		<select id="OpportunityLevel" name="OpportunityLevel" style="width:45px" required>
			<?php
				echo '<option value="10" selected>10 - Project Detected</option>';
				$stmt = $conn->query("SELECT * FROM probability WHERE ProbabilityId <> 10");
				while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
					echo '<option value="' . $data['ProbabilityId'] . '">' . $data['ProbabilityId'] . ' - ' . $data['ProbabilityDesc'] .'</option>';
				}
			?>
		</select>
		<input id="Description" name="Description" style="width:430px" value="Project Detected" readonly="true">
	</div>
	<div class="fitem">
		<label>Notes</label>
		<input id="PipelineNote" name="PipelineNote" style="width:490px" autocomplete="off" onkeypress="return event.keyCode != 13">
	</div>
	<div class="fitem">
		<label>Deliverty Terms</label>
		<select id="DeliveryTerms" name="DeliveryTerms" style="width:150px">
			<?php
				$stmt = $conn->query("SELECT Term FROM DeliveryTerms");
				while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
					echo '<option value="' . $data['Term'] . '">' . $data['Term'] . '</option>';
				}
			?>
		</select>&nbsp;&nbsp;
		<label style="width: 80px">Destination</label>
		<input id="Destination" name="Destination" style="width:248px" autocomplete="off" onkeypress="return event.keyCode != 13" disabled>
	</div>
	<div class="fitem" style="margin-top:10px">
		<label></label>
		<input id="FAT" type="checkbox" name="FAT" class="input-inline" style="width:10px" value="Yes">FAT
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input id="Tescom" type="checkbox" name="Tescom" class="input-inline" style="width:10px" value="Yes">Tescom
	</div>
	<div class="fitem" style="margin-top:10px">
		<label>RFQ Request</label>
		<input id="RFQYes" type="radio" name="RFQRequest" class="input-inline" style="width:10px" value="Yes">Yes
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input id="RFQNo" type="radio" name="RFQRequest" checked="checked" class="input-inline" style="width:10px" value="No">No
	</div>
	<div style="margin-top:15px">
		<div class="fitem" style="float:left">
			<label>RFQ & Supported Files</label>
		</div>
	    <div class="uploadFile" style="width:450px; float:left; height:60px; overflow:auto; border:1px solid; margin-bottom:10px; background-color:white">
			<div style="padding:2px">
				<center><p id="placeholderNew" style="color:grey; margin-top:18px"><i>Click + button to add file...</i></p></center>
				<div id="input_field"><input style="display:none" type="file" name="files[]"></div>
			</div>
		</div>
		<div class="uploadFile" id="attachmentNew" style="float:left; border:1px solid; width:50px; height:60px; background-color:#EEEEEE">
			<span><img src="../assets/themes/icons/edit_add.png" style="margin: 22px 0px 0px 17px"></span>
		</div>
	</div>
	<table class="gridtable" width="670px" style="margin-top:45px">
		<thead>
			<tr>
				<th width="110px"><center>Trafo Type</center></th>
				<th width="50px"><center>KVA</center></th>
				<th width="350px"><center>Description</center></th>
				<th width="50px"><center>QTY</center></th>
				<th width="50px"><center><a href="javascript:void(0)" onclick="add()" style="color:blue"><b><u>ADD</u></b></button></center></th>
			</tr>
		</thead>
		<tbody id="list">
		</tbody>
	</table>
</form>

<script>
var attachments = $("#input_field");
$('.uploadFile').hide();

$('#attachmentNew').click(function(e){
	$('#button').removeAttr('id');
	$(attachments).prepend('<div class="dialog"><input id="button" type="file" name="files[]"/><a href="javascript:void(0)" id="remove_field" style="margin-top: 4px; float: right; color: red">Remove</a></div>');
	$('#button').click();
	$('#placeholderNew').hide();
});

$(attachments).on("click","#remove_field", function(e){
	$(this).parent('div').remove();
});

$('#DeliveryTerms').change(function(){
	var delivery = $('#DeliveryTerms').val();
	if(delivery == 'Ex Works'){
		$('#Destination').prop('disabled', true);
	} else {
		$('#Destination').prop('disabled', false);
	}
	
	$('#Destination').focus();
});

$('#OpportunityLevel').change(function(){
	var text = $('#OpportunityLevel').val();
	if(text == 10){
		$('#Description').val('Project Detected');
	} else if(text == 20){
		$('#Description').val('Understand Customer Bussiness & Good Relation With DMU');
	} else if(text == 30){
		$('#Description').val('Uncover Opportunity');
	} else if(text == 40){
		$('#Description').val('Able To Demonstrate Bussiness Value');
	} else if(text == 50){
		$('#Description').val('Influence Specification');
	} else if(text == 60){
		$('#Description').val('Prequalification');
	} else if(text == 70){
		$('#Description').val('Bidding');
	} else if(text == 80){
		$('#Description').val('Bid Evaluation');
	} else if(text == 90){
		$('#Description').val('Negotiation');
	}
	
	$('#PipelineNote').focus();
});

$('#RFQYes').change(function(){
	$('.uploadFile').show('slow');
});

$('#RFQNo').change(function(){
	$('.uploadFile').hide('slow');
});

function add_row(e){
	if(e.keyCode == 13){
		add();
		$('#create_pipeline').find('select[name*=type]').focus();
		return false;
	}
}

function numberOnly(e){
	var charCode = (e.which) ? e.which : event.keyCode
	if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
		return false;
	return true;
}
</script>
<script>
var a1 = 0;
function add() {
    var list = document.getElementById('list');

    var row		= document.createElement('tr');
    var type	= document.createElement('td');
    var kva		= document.createElement('td');
	var desc	= document.createElement('td');
	var qty		= document.createElement('td');
    var action	= document.createElement('td');

	type.style.textAlign = 'center';
	kva.style.textAlign = 'center';
	desc.style.textAlign = 'center';
	qty.style.textAlign = 'center';

    list.appendChild(row);
    row.appendChild(type);
    row.appendChild(kva);
	row.appendChild(desc);
	row.appendChild(qty);
	row.appendChild(action);

	var input_type = document.createElement('select');
    input_type.setAttribute('name', 'type[' + a1 + ']');
	input_type.setAttribute('onkeypress', 'if(event.which == 13){ $("input[name*=kva").focus(); return false;}');
	input_type.setAttribute('style', 'width:110px; border:none; border-radius:0px');

	var a = new Option();
	a.value = "";
	a.text = "";
	input_type.options.add(a);

	var b = new Option();
	b.value = 'ICT';
	b.text = "ICT";
	input_type.options.add(b);

	var c = new Option();
	c.value = 'Non Trafo';
	c.text = "Non Trafo";
	input_type.options.add(c);

	var d = new Option();
	d.value = 'Trafo Distribusi';
	d.text = "Trafo Distribusi";
	input_type.options.add(d);

	var e = new Option();
	e.value = 'Trafo Power';
	e.text = "Trafo Power";
	input_type.options.add(e);

	var f = new Option();
	f.value = 'Trafo Standard';
	f.text = "Trafo Standard";
	input_type.options.add(f);

    var input_kva = document.createElement('input');
    input_kva.setAttribute('name', 'kva[' + a1 + ']');
	input_kva.setAttribute('onkeypress', 'return numberOnly(event)');
	input_kva.setAttribute('onkeydown', 'if(event.which == 13){ $("input[name*=desc").focus(); return false;}');
	input_kva.setAttribute('style', 'width:50px; text-align:center; border:none');

    var input_desc = document.createElement('input');
    input_desc.setAttribute('name', 'desc[' + a1 + ']');
	input_desc.setAttribute('onkeypress', 'if(event.which == 13){ $("input[name*=qty").focus(); return false;}');
	input_desc.setAttribute('style', 'width:350px; border:none');

	var input_qty = document.createElement('input');
    input_qty.setAttribute('name', 'qty[' + a1 + ']');
	input_qty.setAttribute('onkeypress', 'return numberOnly(event)');
	input_qty.setAttribute('onkeydown', 'return add_row(event)');
	input_qty.setAttribute('style', 'width:50px; text-align:center; border:none');

    var del = document.createElement('span');

    type.appendChild(input_type);
    kva.appendChild(input_kva);
	desc.appendChild(input_desc);
	qty.appendChild(input_qty);
    action.appendChild(del);

    del.innerHTML = '<center><a href="javascript:void(0)" style="color: red"><b>DELETE<b></a></center>';
    del.onclick = function () {
        row.parentNode.removeChild(row);
    };
a1++;
}
</script>