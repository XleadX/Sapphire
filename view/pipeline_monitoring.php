<?php
include 'menu.php';
include '../setting/function.php';// File fungsi sales_group_level dan engineer_group

// Memanggil fungsi sales_group_level dan engineer_group
$sales	= sales_group_level($username);
$eng	= engineer_group($username);

$group		= $sales['SalesGroupId'];
$level		= $sales['SalesLevel'];
$eng_group	= $eng['EngineerGroup'];

if($level == 'Manager'){
	$approve = '<a id="approval" class="easyui-linkbutton" style="width:120px; height:25px" data-options="plain:false" onclick="approvePipeline()">Approve Pipeline</a>';
} else {
	$approve = '';
}

if($group == 'SA'){
	$option = '<option value="PipelineNumber" selected>All</option>
		<option value="PipelineStatus">Status</option>
		<option value="KVA">KVA</option>
		<option value="CreateId">Sales</option>
		<option value="SalesMarketId">Market</option>
		<option value="Customer">Customer</option>';
} elseif($group == 'MKT' OR $eng_group == 'ENG' OR $eng_group == 'PPIC' OR $eng_group == 'QA' OR $eng_group == 'PC' OR $eng_group == 'SVC'){
	$option = '<option value="PipelineNumber" selected>All</option>
		<option value="PipelineStatus">Status</option>
		<option value="KVA">KVA</option>
		<option value="CreateId">Sales</option>
		<option value="SalesMarketId">Market</option>
		<option value="BUGroup">Business Unit</option>
		<option value="CreateDate">Created Date</option>
		<option value="Customer">Customer</option>';
} else {
	$option = '<option value="PipelineNumber" selected>All</option>
		<option value="PipelineStatus">Status</option>
		<option value="Approved">Approved</option>
		<option value="KVA">KVA</option>
		<option value="OpportunityLevel">Opportunity</option>
		<option value="CreateId">Sales</option>
		<option value="SalesMarketId">Market</option>
		<option value="BUGroup">Business Unit</option>
		<option value="CreateDate">Created Date</option>
		<option value="Customer">Customer</option>';
}
?>

<style>
.fitem label{
	display: inline-block;
	width: 135px;
	font-weight: bold;
}
</style>

<div style="width:100%; padding-top:40px">
	<table id="dg_pipeline" class="easyui-datagrid"
		url="../model/pipeline_monitoring_data.php" pageSize="15" pageList="[10,15,20,30,50]"
		toolbar="#toolbar_pipeline" pagination="true" striped="true"
		rownumbers="false" fitColumns="false" singleSelect="true" data-options="
			onClickRow:function(){ showPipelineDetail(); },
			onSelect: function(index,row){
				if(row.Approved == 'Yes'){
					$('#approval').linkbutton('disable');
				} else {
					$('#approval').linkbutton('enable');
				}
			}
		">
		<thead>
			<tr>
				<th field="PipelineStatus" style="width:185px"><center><b>Status</b></center></th>
				<th field="PipelineNumber" style="width:100px" align="center"><center><b>Pipeline No.</b></center></th>
				<th field="RevisionNumber" style="width:100px" align="center"><center><b>Revision</b></center></th>
				<th field="ProjectName" style="width:400px"><center><b>Project Name</b></center></th>
				<th field="Customer" style="width:350px"><center><b>Customer</b></center></th>
				<th field="SalesGroupId" style="width:100px" align="center"><center><b>Sales Group</b></center></th>
				<th field="CreateId" style="width:100px" align="center"><center><b>Sales</b></center></th>
				<th field="CreateDate" style="width:100px" align="center"><center><b>Created Date</b></center></th>
				<th field="Approved" style="width:100px" align="center"><center><b>Approved</b></center></th>
			</tr>
		</thead>
	</table>
	<div id="toolbar_pipeline" style="padding:5px">
		<a id="filterMonitoring" href="javascript:void(0)" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000,plain:false,menu:'#filter_monitoring'">Filter</a>
		<div id="filter_monitoring" class="menu-content" style="padding:15px; background-color:#F4F4F4; font-size:12px">
			<b>Field :</b>
			<select id="field_monitoring" name="field" style="width:150px; height:22px; border-radius:0px">
				<?php echo $option; ?>
			</select>
			&nbsp;&nbsp;<b>Value :</b>
			<select id="value_monitoring" name="value" style="width:150px; height:22px; border-radius:0px">
				<option value="%">All</option>
			</select>
			<input type="button" style="width:80px; height:24px" onclick="filterMonitoring()" value="Filter" id="filter_monitoring_pipeline">
		</div>
		<div style="float:right;">
			<label><b>Year<b></label>
			<input id="year_monitoring" type="number" name="value_year" style="width:60px; text-align:center" value="<?php echo date('Y') ?>" onkeypress="return filter(event)">
		</div>
		<a id="historyMonitoring" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="showHistory()">History</a>
		<a id="reportMonitoring" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="$('#dlg_export_monitoring').dialog('open')">Report</a>
		<?php echo $approve; ?>
		<a id="revisionMonitoring" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="updateOrderMonitoring()">Revision</a>
		<a id="backMonitoring" class="easyui-linkbutton" style="width:100px; height:25px; display:none" data-options="plain:false" onclick="showMonitoring()">Back</a>
	</div>

	<div style="width:1366px">
	<table id="dg_pipeline_detail" class="easyui-datagrid"
		url="../model/pipeline_detail_data.php"
		pagination="false" striped="true"
		rownumbers="false" fitColumns="false" singleSelect="true">
		<thead>
			<tr>
				<th field="TrafoType" style="width:200px"><center><b>Trafo Type</b></center></th>
				<th field="KVA" style="width:100px" align="center"><center><b>KVA</b></center></th>
				<th field="OtherRequest" style="width:300px"><center><b>Description</b></center></th>
				<th field="Qty" style="width:80px" align="center"><center><b>Quantity</b></center></th>
			</tr>
		</thead>
	</table>
	</div>
	
	<div id="dlg_export_monitoring" title="Export Pipeline Monitoring" class="easyui-dialog" modal="true" closed="true" closable="false" style="padding: 15px 20px 15px 20px" buttons="#dlg-buttons-export-monitoring">
		<form id="monitoringReport" method="post" action="controller/export_monitoring.php" novalidate>
			<div class="fitem">
				<label>Created Date</label>	
				<select id="monitoringYear" name="monitoringYear" class="easyui-combobox" style="width:150px" data-options="panelHeight:'auto', editable:false" required="true">
				<?php
					$date = date('Y');
						
					$create_date = $conn->query("SELECT DISTINCT TOP 10 right(convert(varchar, CreateDate, 106), 8) AS CreateDate, (convert(varchar(7), CreateDate, 126)) AS Date, (convert(varchar(3), CreateDate, 107)) AS Month FROM Pipeline WHERE Tahun = '$date' ORDER BY Date DESC");
						
					while($data = $create_date->fetch(PDO::FETCH_ASSOC)){
						echo '<option value="' . $data['CreateDate'] . '">' . $data['CreateDate'] . '</option>';   
					}
				?>
				</select>
			</div>
		</form>
	</div>
	<div id="dlg-buttons-export-monitoring">
		<button type="submit" form="monitoringReport" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif" onclick="$('#dlg_export_monitoring').dialog('close')">Export</button>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_export_monitoring').dialog('close');" style="width:90px">Cancel</a>
	</div>
	
	<div id="dlg_change_pipeline" class="easyui-dialog" title="Update Pipeline" style="width:710px; height:auto; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-change-pipeline" data-options="modal:true,closed:true,shadow:false">
		<div id="pipeline_update"></div>
	</div>
	<div id="dlg-buttons-change-pipeline">
		<button type="submit" form="update_pipeline" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Update</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_change_pipeline').dialog('close');" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</button>
	</div>
</div>

<script>
$(function(){
	$('#dg_pipeline').datagrid({
		view: detailview,
		detailFormatter:function(index,row){
			return '<div id="ddv-' + index + '" style="padding:5px 0"></div>';
		},
		onExpandRow: function(index,row){
			$('#ddv-'+index).panel({
				border:false,
				cache:false,
				href:'pipeline_monitoring_expand.php?PipelineNumber='+row.PipelineNumber,
				onLoad:function(){
					$('#dg_pipeline').datagrid('fixDetailRowHeight',index);
				}
			});
			$('#dg_pipeline').datagrid('fixDetailRowHeight',index);
		}
	});
});

$(function(){
	$('#dg_pipeline').datagrid({
		rowStyler:function(index,row){
			if(row.Approved != 'Yes' && row.RFQ == 'Yes'){
				return 'background-color:#FFAD99';
			}
		}
	});
});

$(function(){
    var pager = $('#dg_pipeline').datagrid().datagrid('getPager');
    pager.pagination({
        buttons:[{
            iconCls:'icon-tip',
			text:'= Approval Needed'
        }]
    });
});

$('#field_monitoring').change(function(){
	var field = $(this).val();
	if(field == 'Customer'){
		$('#value_monitoring').replaceWith("<input id='value_monitoring' type='text' style='width:150px; border-radius:0px'>");
	} else {
		$('#value_monitoring').replaceWith("<select id='value_monitoring' name='value' style='width:150px; border-radius:0px'></select>");
	}

	$.post('../controller/pipeline_monitoring_filter.php', {field:field}, function(data){
		$('#value_monitoring').html(data);
	});
});

function filter(e){
	var year = $('#year_monitoring').val();
	if(e.keyCode == 13){
		$('#dg_pipeline').datagrid('load',{
			year: year,
		});
		return false;
	}
}
</script>