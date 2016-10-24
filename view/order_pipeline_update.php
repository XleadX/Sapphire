<?php
include '../setting/connection.php';
include '../setting/function.php';

session_start();
$username = $_SESSION['username'];
$number = $_GET['PipelineNumber'];
$result = $conn->query("SELECT * FROM Pipeline WHERE PipelineNumber = '$number' AND PipelineActive = 'Yes'");
$data	= $result->fetch(PDO::FETCH_ASSOC);
$probability = $data['OpportunityLevel'];

$probability_query	= $conn->query("SELECT ProbabilityDesc FROM probability WHERE ProbabilityId = '$probability'");
$probability_data	= $probability_query->fetch(PDO::FETCH_ASSOC);

$type_update	= array();
$kva_update		= array();
$desc_update	= array();
$qty_update		= array();
?>

<form id="update_pipeline" method="post" action="../controller/order_pipeline_update.php" enctype="multipart/form-data">
	<div class="fitem" >
		<label>Pipeline Number</label>
		<input id="PipelineNumber" style="width:80px; text-align:center" name="PipelineNumber" readonly="true" value="<?php echo $data['PipelineNumber'] ?>">
		<input name="RevisionNumber" type="hidden" value="<?php echo $data['RevisionNumber'] ?>">
		&nbsp;&nbsp;
		<label style="width:110px">Business Unit</label>
		<select name="BUGroup" style="width:100px" required>
			<?php
				$read_bugroup = $data['BUGroup'];
				$stmt = $conn->query("SELECT BUGroup FROM BusinessUnit");
				while($bu_group = $stmt->fetch(PDO::FETCH_ASSOC)){
					if($read_bugroup == $bu_group['BUGroup']){
						echo '<option value="' . $bu_group['BUGroup'] . '" selected>' . $bu_group['BUGroup'] . '</option>';
					} else {
						echo '<option value="' . $bu_group['BUGroup'] . '">' . $bu_group['BUGroup'] . '</option>';
					}
				}
			?>
		</select>
		<input type="hidden" name="Email" value="<?php echo $email ?>">
		<input type="hidden" name="SalesGroupId" value="<?php echo $data['SalesGroupId'] ?>">
		<input type="hidden" name="CreateId" value="<?php echo $data['CreateId'] ?>">
	</div>
	<div class="fitem" >
		<label>Project Name</label>
		<input id="ProjectNameUpdate" style="width:350px" name="ProjectName" required value="<?php echo $data['ProjectName'] ?>" autocomplete="off" onkeypress="if(event.which == 13){ $('#CustomerUpdate').focus(); return false;}">
	</div>
	<div class="fitem" >
		<label>Customer</label>
		<input id="CustomerUpdate" style="width:350px" name="Customer" required value="<?php echo $data['Customer'] ?>" autocomplete="off" onkeypress="if(event.which == 13){ $('#PipelineNoteUpdate').focus(); return false;}">
	</div>
	<div class="fitem" >
		<label>Market</label>
		<select id="SalesMarketIdUpdate" name="SalesMarketId" style="width:250px" required>
			<?php
				$read_market = $data['SalesMarket'];
				$stmt = $conn->query("SELECT SalesMarket.SalesMarketId FROM SalesMarket, SalesDept, Sales WHERE (Sales.SalesGroupId = SalesMarket.SalesGroupId AND Sales.SalesId = '$username') OR (SalesDept.SalesGroupId = SalesMarket.SalesGroupId AND SalesDept.SalesId = '$username') GROUP BY SalesMarket.SalesMarketId");
				while($sales_market = $stmt->fetch(PDO::FETCH_ASSOC)){
					if($read_market == $sales_market['SalesMarketId']){
						echo '<option value="' . $sales_market['SalesMarketId'] . '" selected>' . $sales_market['SalesMarketId'] . '</option>';
					} else {
						echo '<option value="' . $sales_market['SalesMarketId'] . '">' . $sales_market['SalesMarketId'] . '</option>';
					}
				}
			?>
		</select>
	</div>
	<div class="fitem" >
		<label>Estimate Order Intake</label>
		<select id="EstimateOrderIntakeUpdate" class="easyui-combobox" name="EstimateOrderIntake" style="width:150px" onchange="$('#PipelineNote').focus()" required>
			<?php
				$date = month_year();
				
				echo '<option value="'.$data['EstimateOrderIntake'].'">'.$data['EstimateOrderIntake'].'</option>';
				echo '<option disabled>-----------------------</option>';
				echo '<option value="NA">NA</option>';
				foreach($date as $row){
					echo '<option value="'.$row['month_year'].'">'.$row['month_year'].'</option>';
				}
			?>
		</select>&nbsp;&nbsp;
		<label>Delivery Request Time</label>
		<select id="DeliveryRequestTimeUpdate" name="DeliveryRequestTime" style="width:150px" onchange="$('#PipelineNote').focus()" required>
			<?php
				$date = month_year();
				
				echo '<option value="'.$data['DeliveryRequestTime'].'">'.$data['DeliveryRequestTime'].'</option>';
				echo '<option disabled>-----------------------</option>';
				echo '<option value="NA">NA</option>';
				foreach($date as $row) {
					echo '<option value="'.$row['month_year'].'">'.$row['month_year'].'</option>';
				}
			?>
		</select>
	</div>
	<div class="fitem" >
		<label>Opportunity (%)</label>
		<input id="opportunityLevelUpdate" name="OpportunityLevel" style="width:45px" value="<?php echo $probability ?>" readonly="true">
		<input id="descriptionUpdate" name="Description" style="width:430px" value="<?php echo $probability_data['ProbabilityDesc'] ?>" readonly="true">
	</div>
	<div class="fitem" >
		<label>Notes</label>
		<input id="PipelineNoteUpdate" name="PipelineNote" style="width:490px" value="<?php echo $data['PipelineNote'] ?>" autocomplete="off" onkeypress="return event.keyCode != 13">
	</div>
	<div class="fitem" >
		<label>Deliverty Terms</label>
		<select id="DeliveryTermsUpdate" name="DeliveryTerms" style="width:150px">
			<?php
				$read_delivery = $data['DeliveryTerms'];
				$stmt = $conn->query("SELECT Term FROM DeliveryTerms");
				while($delivery = $stmt->fetch(PDO::FETCH_ASSOC)){
					if($read_delivery == $delivery['Term']){
						echo '<option value="' . $delivery['Term'] . '" selected>' . $delivery['Term'] . '</option>';
					} else {
						echo '<option value="' . $delivery['Term'] . '">' . $delivery['Term'] . '</option>';
					}	
				}
			?>
		</select>&nbsp;&nbsp;
		<label style="width:80px">Destination</label>
		<input id="DestinationUpdate" name="Destination" style="width:248px" value="<?php echo $data['Destination'] ?>" onkeypress="return event.keyCode != 13" autocomplete="off">
	</div>
	<div class="fitem" style="margin-top:10px">
		<label></label>
		<input id="TempFAT" type="hidden" name="FAT" value="<?php echo $data['FAT'] ?>">
		<input id="FATUpdate" type="checkbox" name="FATUpdate" class="input-inline" style="width:10px" value="Yes">FAT
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input id="TempTescom" type="hidden" name="Tescom" value="<?php echo $data['Tescom'] ?>">
		<input id="TescomUpdate" type="checkbox" name="TescomUpdate" class="input-inline" style="width:10px" value="Yes">Tescom
	</div>
	<div class="fitem" style="margin-top:10px">
		<label>RFQ Request</label>
		<input id="TempRFQ" type="hidden" name="RFQ" value="<?php echo $data['RFQ'] ?>">
		<input id="RFQUpdateNo" type="radio" name="RFQRequestUpdate" class="input-inline" style="width:10px" value="No">No
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input id="RFQUpdateNew" type="radio" name="RFQRequestUpdate" class="input-inline" checked style="width:10px" value="New">Renew RFQ
	</div>
	<div style="margin-top:15px">
		<div class="fitem" style="float:left">
			<label>RFQ & Supported Files</label>
		</div>
	    <div class="uploadFile" style="width:450px; float:left; height:60px; overflow:auto; border:1px solid; margin-bottom:10px; background-color:white">
			<div style="padding:2px">
				<center><p id="placeholderUpdate" style="color:grey; margin-top:18px"><i>Click + button to add file...</i></p></center>
				<div id="input_field_update"><input style="display:none" type="file" name="filesNew[]"></div>
			</div>
		</div>
		<div class="uploadFile" id="attachmentUpdate" style="float:left; border:1px solid; width:50px; height:60px; background-color:#EEEEEE">
			<span><img src="../assets/themes/icons/edit_add.png" style="margin: 22px 0px 0px 17px"></span>
		</div>
	</div>
	<table class="gridtable" width="670px">
		<thead>
			<tr>
				<th width="110px"><center>Trafo Type</center></th>
				<th width="50px"><center>KVA</center></th>
				<th width="350px"><center>Description</center></th>
				<th width="50px"><center>QTY</center></th>
				<th width="50px"><center><a href="javascript:void(0)" onclick="add_update()" style="color:blue"><b><u>ADD</u></b></button></center></th>
			</tr>
		</thead>
		<tbody id="table_detail">
		<?php
		$result = $conn->query("SELECT * FROM PipelineDetil WHERE PipelineNumber = '$number' AND RevisionNumber = (SELECT MAX(RevisionNumber) FROM PipelineDetil WHERE PipelineNumber = '$number')");

		while($data = $result->fetch(PDO::FETCH_ASSOC)){
			echo "<tr>";
			echo "<td><center><select name='type_update[]' style='width:110px; border:none; border-radius:0px; font-size:12px' onkeypress='return event.keyCode != 13'>";
			if($data['TrafoType'] == 'ICT'){
				$option1 = 'selected';
			} elseif($data['TrafoType'] == 'Non Trafo'){
				$option2 = 'selected';
			} elseif($data['TrafoType'] == 'Trafo Distribusi'){
				$option3 = 'selected';
			} elseif($data['TrafoType'] == 'Trafo Power'){
				$option4 = 'selected';
			} elseif($data['TrafoType'] == 'Trafo Standard'){
				$option5 = 'selected';
			} elseif($data['TrafoType'] == null) {
				echo "<option></option>";
			}
			echo "<option value='ICT' ".$option1.">ICT</option>
				<option value='Non Trafo' ".$option2.">Non Trafo</option>
				<option value='Trafo Distribusi' ".$option3.">Trafo Distribusi</option>
				<option value='Trafo Power' ".$option4.">Trafo Power</option>
				<option value='Trafo Standard' ".$option5.">Trafo Standard</option>";
			echo "</select></center></td>";
			echo "<td><center><input type='text' style='text-align:center; width:50px; border:none; font-size:12px' name='kva_update[]' value='".$data['KVA']."' onkeypress='return event.keyCode != 13'></center></td>";
			echo "<td><center><input type='text' style='width:350px; border:none; font-size:12px' name='desc_update[]' value='".$data['OtherRequest']."' onkeypress='return event.keyCode != 13'></center></td>";
			echo "<td><center><input type='text' style='text-align:center; width:50px; border:none; font-size:12px' name='qty_update[]' value='".$data['Qty']."' onkeypress='return add_row(event)'></center></td>";
			echo "<td><center><a href='javascript:void(0)' class='delete' style='color:red; font-size:12px'><b>DELETE</b></a></center></td>";
			echo "</tr>";
		}
		?>
		</tbody>
	</table>
</form>

<script>
var attachmentsNew = $("#input_field_update");
var delivery = $('#DeliveryTermsUpdate').val();
var fat = $('#TempFAT').val();
var tescom = $('#TempTescom').val();
var rfq = $('#TempRFQ').val();

$('#attachmentUpdate').click(function(e){
	$('#button_update').removeAttr('id');
	$(attachmentsNew).prepend('<div class="dialog"><input id="button_update" type="file" name="filesNew[]"/><a href="javascript:void(0)" id="remove_field_new" style="margin-top: 4px; float: right; color: red">Remove</a></div>');
	$('#button_update').click();
	$('#placeholderUpdate').hide();
});

$(attachmentsNew).on("click","#remove_field_new", function(e){
	$(this).parent('div').remove();
});

if(delivery == 'Ex Works'){
	$('#DestinationUpdate').prop('disabled', true);
} else {
	$('#DestinationUpdate').prop('disabled', false);
}

$('#DeliveryTermsUpdate').change(function(){
	var delivery = $('#DeliveryTermsUpdate').val();
	if(delivery == 'Ex Works'){
		$('#DestinationUpdate').prop('disabled', true);
	} else {
		$('#DestinationUpdate').prop('disabled', false);
		$('#DestinationUpdate').focus();
	}
});

if(fat == 'Yes'){
	$('#FATUpdate').prop('checked', true);
} else {
	$('#FATUpdate').prop('checked', false);
}

$('#FATUpdate').change(function(){
	if(this.checked){
		$('#TempFAT').val('Yes');
	} else {
		$('#TempFAT').val('No');
	}
});

if(tescom == 'Yes'){
	$('#TescomUpdate').prop('checked', true);
} else {
	$('#TescomUpdate').prop('checked', false);
}

$('#TescomUpdate').change(function(){
	if(this.checked){
		$('#TempTescom').val('Yes');
	} else {
		$('#TempTescom').val('No');
	}
});

if(rfq == 'Yes'){
	$('#RFQUpdateNew').prop('checked', true);
	$('.uploadFile').show();
} else {
	$('#RFQUpdateNo').prop('checked', true);
	$('.uploadFile').hide();
}

$('#RFQUpdateNew').change(function(){
	$('.uploadFile').show('slow');
});

$('#RFQUpdateNo').change(function(){
	$('.uploadFile').hide('slow');
});

function add_row(e){
	if(e.keyCode == 13){
		add_update();
		$('#update_pipeline').find('select[name*=type_update]').focus();
		return false;
	}
}
	
function numberOnly(e){
	var charCode = (e.which) ? e.which : event.keyCode
	if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
		return false;
	return true;
}

$(".delete").click(function(){
	$(this).closest('tr').remove()
});
</script>
<script>
var a = 100;
function add_update() {
    var list_update = document.getElementById('table_detail');
               
    var row_update		= document.createElement('tr');
    var type_update		= document.createElement('td');
    var kva_update		= document.createElement('td');
	var desc_update		= document.createElement('td');
	var qty_update		= document.createElement('td');
    var action_update	= document.createElement('td');

	type_update.style.textAlign = 'center';
	kva_update.style.textAlign = 'center';
	desc_update.style.textAlign = 'center';
	qty_update.style.textAlign = 'center';

    list_update.appendChild(row_update);
    row_update.appendChild(type_update);
    row_update.appendChild(kva_update);
	row_update.appendChild(desc_update);
	row_update.appendChild(qty_update);
	row_update.appendChild(action_update);
		
	var update_type = document.createElement('select');
    update_type.setAttribute('name', 'type_update[]');
	update_type.setAttribute('onkeypress', '$("input[name*=kva_update").focus()');
	update_type.setAttribute('style', 'width:110px; border:none; border-radius:0px; font-size:12px');
			
	var a_ = new Option();
	a_.value = "";
	a_.text = "";
	update_type.options.add(a_);
				
	var b_ = new Option();
	b_.value = 'ICT';
	b_.text = "ICT";
	update_type.options.add(b_);
				
	var c_ = new Option();
	c_.value = 'Non Trafo';
	c_.text = "Non Trafo";
	update_type.options.add(c_);
		
	var d_ = new Option();
	d_.value = 'Trafo Distribusi';
	d_.text = "Trafo Distribusi";
	update_type.options.add(d_);
				
	var e_ = new Option();
	e_.value = 'Trafo Power';
	e_.text = "Trafo Power";
	update_type.options.add(e_);
	
	var f_ = new Option();
	f_.value = 'Trafo Standard';
	f_.text = "Trafo Standard";
	update_type.options.add(f_);
		
    var update_kva = document.createElement('input');
    update_kva.setAttribute('name', 'kva_update[]');
	update_kva.setAttribute('onkeypress', 'return numberOnly(event)');
	update_kva.setAttribute('onkeydown', 'if(event.which == 13){ $("input[name*=desc_update").focus(); return false;}');
	update_kva.setAttribute('style', 'width:50px; text-align:center; border:none; font-size:12px');
	
    var update_desc = document.createElement('input');
    update_desc.setAttribute('name', 'desc_update[]');
	update_desc.setAttribute('onkeydown', 'if(event.which == 13){ $("input[name*=qty_update").focus(); return false;}');
	update_desc.setAttribute('style', 'width:350px; border:none; font-size:12px');
		
	var update_qty = document.createElement('input');
    update_qty.setAttribute('name', 'qty_update[]');
	update_qty.setAttribute('onkeypress', 'return numberOnly(event)');
	update_qty.setAttribute('onkeydown', 'return add_row(event)');
	update_qty.setAttribute('style', 'width:50px; text-align:center; border:none; font-size:12px');
				
	var del_update = document.createElement('span');

    type_update.appendChild(update_type);
    kva_update.appendChild(update_kva);
	desc_update.appendChild(update_desc);
	qty_update.appendChild(update_qty);
    action_update.appendChild(del_update);

    del_update.innerHTML = '<center><a href="javascript:void(0)" style="color:red"><b>DELETE<b></a></center>';
    del_update.onclick = function () {
		row_update.parentNode.removeChild(row_update);
    };
a++;
}
</script>