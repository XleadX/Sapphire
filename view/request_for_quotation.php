<?php
include 'menu.php';

$req_user = $_SESSION['username'];

if($req_user == 'nanda'){
	$request = '';
} else {
	$request = 'hidden';
}
?>

<div style="width:100%; padding-top:40px">
	<table id="dg_rfq" class="easyui-datagrid"
		url="../model/request_for_quotation_data.php" pageSize="15" pageList="[10,15,20,30,50]"
		toolbar="#toolbar_rfq" pagination="true" striped="true" nowrap="true"
		rownumbers="false" fitColumns="false" singleSelect="true" data-options="
			onClickRow:function(){ showRFQDetail(); },
			onSelect: function(index,row){
			if(row.RFQStatus == 'Request'){
				$('#pickRFQ').linkbutton('enable');
				$('#scheduleRFQ').linkbutton('disable');
				$('#answerRFQ').linkbutton('disable');
			} else if(row.RFQStatus == 'Pick'){
				$('#pickRFQ').linkbutton('disable');
				$('#scheduleRFQ').linkbutton('enable');
				$('#answerRFQ').linkbutton('enable');
			} else if(row.RFQStatus == 'Schedule'){
				$('#pickRFQ').linkbutton('disable');
				$('#scheduleRFQ').linkbutton('disable');
				$('#answerRFQ').linkbutton('enable');
			} else if(row.RFQStatus == 'Answer'){
				$('#pickRFQ').linkbutton('disable');
				$('#scheduleRFQ').linkbutton('disable');
				$('#answerRFQ').linkbutton('disable');
			}
		}
		">
		<thead frozen="true">
            <tr>
				<th field="RFQStatus" style="width:100px" align="center"><center><b>RFQ Status</b></center></th>
				<th field="PipelineNumber" style="width:90px" align="center"><center><b>Pipeline No.</b></center></th>
            </tr>
        </thead>
		<thead>
            <tr>
				<th field="RevisionNumber" style="width:75px" align="center"><center><b>Revision</b></center></th>
				<th field="ProjectName" style="width:400px"><center><b>Project Name</b></center></th>
				<th field="Customer" style="width:350px"><center><b>Customer</b></center></th>
				<th field="PipelineNote" style="width:400px"><center><b>Note</b></center></th>
				<th field="CreateDate" style="width:100px" align="center"><center><b>Created Date</b></center></th>
				<th field="CreateId" style="width:100px" align="center"><center><b>Created By</b></center></th>
				<th field="ApprovedDate" style="width:100px" align="center"><center><b>Approved Date</b></center></th>
				<th field="ApprovedId" style="width:100px" align="center"><center><b>Approved By</b></center></th>
                <th field="PickDate" style="width:100px" align="center"><center><b>Pick Date</b></center></th>
				<th field="PickId" style="width:100px" align="center"><center><b>Pick By</b></center></th>
				<th field="ScheduleDate" style="width:115px" align="center"><center><b>Schedule Date</b></center></th>
				<th field="ScheduleId" style="width:100px" align="center"><center><b>Schedule By</b></center></th>
				<th field="AnswerDate" style="width:100px" align="center"><center><b>Answer Date</b></center></th>
				<th field="AnswerId" style="width:100px" align="center"><center><b>Answer By</b></center></th>
            </tr>
        </thead>
	</table>
	<div id="toolbar_rfq" style="padding: 5px">
		<a href="javascript:void(0)" id="pickRFQ" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="pickRFQ()">Pick</a>
		<a href="javascript:void(0)" id="scheduleRFQ" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="scheduleRFQ()">Schedule</a>
		<a href="javascript:void(0)" id="answerRFQ" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="answerRFQ()">Answer</a>
		<a href="javascript:void(0)" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000, plain:false, menu:'#filterRFQ'">Filter</a>
		<div id="filterRFQ">
			<div onclick="newFilterRFQ()"><span>New</span></div>
			<div onclick="pickFilterRFQ()"><span>Pick</span></div>
			<div onclick="scheduleFilterRFQ()"><span>Schedule</span></div>
			<div onclick="answerFilterRFQ()"><span>Answer</span></div>
			<div onclick="allFilterRFQ()"><span>All</span></div>
		</div>
		<a href="javascript:void(0)" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000, plain:false, menu:'#reportRFQ'">Report</a>
		<div id="reportRFQ">
			<div onclick="$('#dlg_export').dialog('open').dialog('setTitle','RFQ Manager Report')"><span>RFQ Report</span></div>
			<div onclick="$('#dlg_export_answer').dialog('open').dialog('setTitle','RFQ Answer Report')"><span>RFQ Answer Summary</span></div>
			<div <?php echo $request; ?> onclick="$('#dlg_export_request').dialog('open').dialog('setTitle','RFQ Request - Pick Report')"><span>RFQ Request - Pick Summary</span></div>
		</div>
		<select id="BUGroup" name="BUGroup" style="width:100px; height:25px; border-radius:0px; padding-top:1px" <?php echo $request; ?>>
			<option value="%"></option>
			<?php
				$stmt = $conn->query("SELECT BUGroup FROM BusinessUnit");
				while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
					echo '<option value="' . $data['BUGroup'] . '">' . $data['BUGroup'] . '</option>';
				}
			?>
		</select>
		<div style="float:right;">
			<label><b>Year<b></label>
			<input id="year" type="number" name="year" style="width:60px; text-align:center" value="<?php echo date('Y') ?>" onkeypress="return filter(event)">
		</div>
	</div>
	<div style="width:1366px">
	<table id="dg_rfq_detail" class="easyui-datagrid"
		url="../model/pipeline_detail_data.php"
		pagination="false" striped="true"
		rownumbers="false" fitColumns="false" singleSelect="true">
		<thead>
			<tr>
				<th field="TrafoType" style="width:200px"><center><b>Trafo Type</b></center></th>
				<th field="KVA" style="width:80px" align="center" type="numberbox"><center><b>KVA</b></center></th>
				<th field="OtherRequest" style="width:310px"><center><b>Description</b></center></th>
				<th field="Qty" style="width:80px" align="center"><center><b>Quantity</b></center></th>
			</tr>
		</thead>
	</table>
	</div>

	<div id="dlg_export" class="easyui-dialog" modal="true" closed="true" closable="false" style="padding: 15px 20px 15px 20px; top:30%" buttons="#dlg-buttons-export">
		<form id="viewReport" method="post" action="controller/export_rfq.php" novalidate>
			<div class="fitem">
				<label style="width:125px">Pipeline Create</label>
				<select id="createdMonth" name="createdMonth" class="easyui-combobox" style="width:150px" data-options="panelHeight:'auto', editable:false" required="true">
					<option value="Jan">January</option>
					<option value="Feb">February</option>
					<option value="Mar">March</option>
					<option value="Apr">April</option>
					<option value="May">May</option>
					<option value="Jun">June</option>
					<option value="Jul">July</option>
					<option value="Aug">August</option>
					<option value="Sep">September</option>
					<option value="Okt">October</option>
					<option value="Nov">November</option>
					<option value="Dec">December</option>
				</select>
			</div>
			<div class="fitem">
				<label style="width:125px"></label>
				<select id="createdYear" name="createdYear" class="easyui-combobox" style="width:150px" data-options="panelHeight:'auto', editable:false" required="true">
					<?php
						foreach($out as $year) {
							echo '<option value="'.$year['year'].'">'.$year['year'].'</option>';
						}
					?>
				</select>
			</div>
		</form>
	</div>
	<div id="dlg-buttons-export">
		<button type="submit" form="viewReport" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif" onclick="$('#dlg_export').dialog('close')">Export</button>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_export').dialog('close');" style="width:90px">Cancel</a>
	</div>

	<div id="dlg_export_answer" class="easyui-dialog" modal="true" closed="true" closable="false" style="padding: 15px 20px 15px 20px; top:30%" buttons="#dlg-buttons-export-answer">
		<form id="answerReport" method="post" action="controller/export_rfq_answer.php" novalidate>
			<div class="fitem">
				<label>Created Year</label>	
				<select id="answerYear" name="answerYear" class="easyui-combobox" style="width:150px" data-options="panelHeight:'auto', editable:false" required="true">
					<?php
						foreach($out as $year) {
							echo '<option value="'.$year['year'].'">'.$year['year'].'</option>';
						}
					?>
				</select>
			</div>
		</form>
	</div>
	<div id="dlg-buttons-export-answer">
		<button type="submit" form="answerReport" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif" onclick="$('#dlg_export_answer').dialog('close')">Export</button>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_export_answer').dialog('close');" style="width:90px">Cancel</a>
	</div>

	<div id="dlg_rfq_schedule" class="easyui-dialog" title="Schedule Pipeline" style="width:545px; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-rfq-schedule" data-options="modal:true,closed:true,shadow:false">
		<div id="rfq_schedule_show"></div>
	</div>
	<div id="dlg-buttons-rfq-schedule">
		<button type="submit" form="rfq_schedule" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Save</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_rfq_schedule').window('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</a>
	</div>

	<div id="dlg_rfq_answer" class="easyui-dialog" title="Answer Pipeline" style="width:545px; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-rfq-answer" data-options="modal:true,closed:true,shadow:false">
		<div id="rfq_answer_show"></div>
	</div>
	<div id="dlg-buttons-rfq-answer">
		<button type="submit" onclick="$('#submitRFQ').click(); $('#submitCost').click()" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Answer</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_rfq_answer').dialog('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</button>
	</div>
</div>

<script>
var attachmentsRFQ		= $("#input_field_rfq");
var attachmentsRFQCost	= $("#input_field_rfq_cost");
	
$('#attachmentRFQ').click(function(e){
	$('#button_rfq').removeAttr('id');
	$(attachmentsRFQ).prepend('<div class="dialog"><input id="button_rfq" type="file" name="filesRFQ[]"/><a href="javascript:void(0)" id="remove_field_rfq" style="margin-top:4px; float:right; color:red">Remove</a></div>');
	$('#button_rfq').click();
});

$('#attachmentRFQCost').click(function(e){
	$('#button_cost').removeAttr('id');
	$(attachmentsRFQCost).prepend('<div class="dialog"><input id="button_cost" type="file" name="filesRFQCost[]"/><a href="javascript:void(0)" id="remove_field_rfq_cost" style="margin-top:4px; float:right; color:red">Remove</a></div>');
	$('#button_cost').click();
});

$(attachmentsRFQ).on("click","#remove_field_rfq", function(e){
	$(this).parent('div').remove();
});

$(attachmentsRFQCost).on("click","#remove_field_rfq_cost", function(e){
	$(this).parent('div').remove();
});

$('#BUGroup').change(function(){
	var bu_group = $('#BUGroup').val();
	$('#dg_rfq').datagrid('load',{
		bugroup: bu_group,
	});
});

$(function(){
	$('#dg_rfq').datagrid({
		rowStyler:function(index,row){
			if(row.Approved != 'Yes' && row.RFQ == 'Yes'){
				return 'background-color:#FFAD99';
			}
		}
	});
});

$(function(){
    var pager = $('#dg_rfq').datagrid().datagrid('getPager');
    pager.pagination({
        buttons:[{
            iconCls:'icon-tip',
			text:'= Approval Needed'
        }]
    });
})

function filter(e){
	var year = $('#year').val();
	if(e.keyCode == 13){
		$('#dg_rfq').datagrid('load',{
			year_value: year,
		});
		return false;
	}
}

var access = $('#access').val();
if(access == 'admin'){
	$('#pickRFQ').hide();
	$('#scheduleRFQ').hide();
	$('#answerRFQ').hide();
} else {
	$('#pickRFQ').show();
	$('#scheduleRFQ').show();
	$('#answerRFQ').show();
}
</script>