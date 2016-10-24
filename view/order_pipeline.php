<?php
	include 'menu.php';
	
	$type	= array();
	$kva	= array();
	$desc	= array();
	$qty	= array();
	
	$type_update	= array();
	$kva_update		= array();
	$desc_update	= array();
	$qty_update		= array();
?>
<style>
.fitem label{
	display: inline-block;
	width: 135px;
	font-weight: bold;
}
</style>

<div style="width:100%; padding-top:40px">
	<table id="dg_order" class="easyui-datagrid"
		url="../model/order_pipeline_data.php" pageSize="15" pageList="[10,15,20,30,50]"
		toolbar="#toolbar_order" pagination="true" striped="true" nowrap="true"
		rownumbers="false" fitColumns="false" singleSelect="true" data-options="
			onClickRow:function(){ showOrderDetail(); },
			onSelect: function(index,row){
				if((row.PO == 'No' && row.SO == 'No') && (row.DrawAnswer == 'Yes' && row.DrawApproval == 'No')){
					var item1 = $('#revision').menu('findItem','FAT Date');
					var item2 = $('#status').menu('findItem','PO Award');
					var item3 = $('#revision').menu('findItem','Pipeline');
					$('#menuRevision').menubutton('enable');
					$('#menuStatus').menubutton('enable');
					$('#revision').menu('disableItem', item1.target);
					$('#drawApproval').linkbutton('enable');
					$('#status').menu('enableItem', item2.target);
					$('#revision').menu('enableItem', item3.target);
				} else if((row.PO == 'Yes' && row.SO == 'No') && (row.DrawAnswer == 'Yes' && row.DrawApproval == 'No')){
					var item1 = $('#revision').menu('findItem','FAT Date');
					var item2 = $('#status').menu('findItem','PO Award');
					var item3 = $('#revision').menu('findItem','Pipeline');
					$('#menuRevision').menubutton('enable');
					$('#menuStatus').menubutton('enable');
					$('#revision').menu('enableItem', item1.target);
					$('#drawApproval').linkbutton('enable');
					$('#status').menu('disableItem', item2.target);
					$('#revision').menu('disableItem', item3.target);
				} else if((row.PO == 'Yes' && row.SO == 'No') && (row.DrawAnswer == 'Yes' && row.DrawApproval == 'Yes')){
					var item1 = $('#revision').menu('findItem','FAT Date');
					var item2 = $('#status').menu('findItem','PO Award');
					var item3 = $('#revision').menu('findItem','Pipeline');
					$('#menuRevision').menubutton('enable');
					$('#menuStatus').menubutton('enable');
					$('#revision').menu('enableItem', item1.target);
					$('#drawApproval').linkbutton('disable');
					$('#status').menu('disableItem', item2.target);
					$('#revision').menu('disableItem', item3.target);
				} else if((row.PO == 'No' && row.SO == 'No') && (row.DrawAnswer == 'No' && row.DrawApproval == 'No')){
					var item1 = $('#revision').menu('findItem','FAT Date');
					var item2 = $('#status').menu('findItem','PO Award');
					var item3 = $('#revision').menu('findItem','Pipeline');
					$('#menuRevision').menubutton('enable');
					$('#menuStatus').menubutton('enable');
					$('#revision').menu('disableItem', item1.target);
					$('#drawApproval').linkbutton('disable');
					$('#status').menu('enableItem', item2.target);
					$('#revision').menu('enableItem', item3.target);
				} else if((row.PO == 'Yes' && row.SO == 'No') && (row.DrawAnswer == 'No' && row.DrawApproval == 'No')){
					var item1 = $('#revision').menu('findItem','FAT Date');
					var item2 = $('#status').menu('findItem','PO Award');
					var item3 = $('#revision').menu('findItem','Pipeline');
					$('#menuRevision').menubutton('enable');
					$('#menuStatus').menubutton('enable');
					$('#revision').menu('enableItem', item1.target);
					$('#drawApproval').linkbutton('disable');
					$('#status').menu('disableItem', item2.target);
					$('#revision').menu('disableItem', item3.target);
				} else if((row.PO == 'Yes' && row.SO == 'Yes') && (row.DrawAnswer == 'No' && row.DrawApproval == 'No')){
					var item3 = $('#revision').menu('findItem','Pipeline');
					$('#menuRevision').menubutton('disable');
					$('#drawApproval').linkbutton('disable');
					$('#menuStatus').menubutton('disable');
					$('#revision').menu('disableItem', item3.target);
				} else if((row.PO == 'Yes' && row.SO == 'Yes') && (row.DrawAnswer == 'Yes' && row.DrawApproval == 'No')){
					var item3 = $('#revision').menu('findItem','Pipeline');
					$('#menuRevision').menubutton('disable');
					$('#drawApproval').linkbutton('enable');
					$('#menuStatus').menubutton('disable');
					$('#revision').menu('disableItem', item3.target);
				} else if((row.PO == 'Yes' && row.SO == 'Yes') && (row.DrawAnswer == 'Yes' && row.DrawApproval == 'Yes')){
					var item3 = $('#revision').menu('findItem','Pipeline');
					$('#menuRevision').menubutton('disable');
					$('#drawApproval').linkbutton('disable');
					$('#menuStatus').menubutton('disable');
					$('#revision').menu('disableItem', item3.target);
				}
			}
		">
		<thead frozen="true">
            <tr>
				<th field="PipelineStatus" style="width:200px" rowspan="2"><center><b>Status</b></center></th>
				<th field="PipelineNumber" style="width:90px" rowspan="2" align="center"><center><b>Pipeline No.</b></center></th>
			</tr>
            <tr></tr>
        </thead>
		<thead>
            <tr>
				<th field="RevisionNumber" style="width:75px" rowspan="2" align="center"><center><b>Revision</b></center></th>
				<th field="ProjectName" style="width:400px" rowspan="2"><center><b>Project Name</b></center></th>
				<th field="Customer" style="width:350px" rowspan="2"><center><b>Customer</b></center></th>
				<th field="SalesMarketId" style="width:145px" align="center" rowspan="2"><center><b>Sales Market</b></center></th>
				<th field="CreateDate" style="width:100px" align="center" rowspan="2"><center><b>Created Date</b></center></th>
				<th field="EstimateOrderIntake" style="width:100px" align="center" rowspan="2"><center><b>Estimate<br>Order Intake</b></center></th>
				<th field="DeliveryRequestTime" style="width:100px" align="center" rowspan="2"><center><b>Delivery<br>Request Time</b></center></th>
				<th field="OpportunityLevel" style="width:100px" align="center" rowspan="2"><center><b>Opportunity<br>Level (%)</b></center></th>
				<th colspan="8"><center><b><span style="color:green">Request For Quotation (RFQ)</span></b></center></th>
				<th colspan="6"><center><b><span style="color:green">Drawing Approval</span></b></center></th>
				<th colspan="2"><center><b><span style="color:green">Additional Test</span></b></center></th>
			</tr>
            <tr>
                <th field="RFQStatus" style="width:100px" align="center"><center><b>RFQ Status</b></center></th>
				<th field="RFQDate" style="width:100px" align="center"><center><b>Request Date</b></center></th>
				<th field="PickDate" style="width:100px" align="center"><center><b>Pick Date</b></center></th>
				<th field="PickId" style="width:100px" align="center"><center><b>Pick by</b></center></th>
				<th field="ScheduleDate" style="width:110px" align="center"><center><b>Schedule Date</b></center></th>
				<th field="ScheduleId" style="width:100px" align="center"><center><b>Schedule by</b></center></th>
				<th field="AnswerDate" style="width:100px" align="center"><center><b>Answer Date</b></center></th>
				<th field="AnswerId" style="width:100px" align="center"><center><b>Answer by</b></center></th>
				<th field="DrawStatus" style="width:100px" align="center"><center><b>Draw Status</b></center></th>
				<th field="DrawReqDate" style="width:100px" align="center"><center><b>Request Date</b></center></th>
				<th field="DrawAnswerDate" style="width:100px" align="center"><center><b>Answer Date</b></center></th>
				<th field="DrawAnswerId" style="width:100px" align="center"><center><b>Answer by</b></center></th>
				<th field="DrawApprovalDate" style="width:110px" align="center"><center><b>Approved Date</b></center></th>
				<th field="DrawApprovalId" style="width:110px" align="center"><center><b>Approved by</b></center></th>
				<th field="TestStatus" style="width:100px" align="center"><center><b>Status</b></center></th>
				<th field="TestDate" style="width:100px" align="center"><center><b>Date</b></center></th>
            </tr>
        </thead>
	</table>
	<div id="toolbar_order" style="padding:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="newOrder()">New</a>
		<a href="javascript:void(0)" id="menuRevision" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000, plain:false, menu:'#revision'">Revision</a>
		<div id="revision">
			<div onclick="updateOrder()"><span>Pipeline</span></div>
			<div onclick="changeOpportunity()"><span>Opportunity</span></div>
			<div onclick="changeFAT()"><span>FAT Date</span></div>
		</div>
		<a href="javascript:void(0)" id="menuStatus" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000, plain:false, menu:'#status'">Status</a>
		<div id="status">
			<div onclick="POAward()"><span>PO Award</span></div>
			<div onclick="cancelProject()"><span>Lost Project</span></div>
		</div>
		<a href="javascript:void(0)" id="drawApproval" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="drawApprove()">Draw Approve</a>
		<a href="javascript:void(0)" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000, plain:false, menu:'#filter_order'">Filter</a>
		<div id="filter_order" class="menu-content" style="padding:15px; background-color:#F4F4F4; font-size:12px">
			<b>Field :</b>
			<select id="field_order" name="field_order" style="width:150px; height:22px; border-radius:0px">
				<option value="PipelineNumber" selected>All</option>
				<option value="PipelineStatus">Status</option>
				<option value="RFQStatus">RFQ</option>
				<option value="DrawStatus">Draw</option>
				<option value="TrfCodeAnswer">Transformer Code</option>
			</select>
			&nbsp;<b>Value :</b>
			<select id="value_order" name="value_order" style="width:150px; height:22px; border-radius:0px">
				<option value="%">All</option>
			</select>
			<input id="active_order" type="hidden" value="Yes">
			<input type="button" style="width:80px; height:24px" onclick="filterOrder()" value="Filter" id="filter">
		</div>
		<div style="float:right;">
			<label><b>Year<b></label>
			<input id="value_year" type="number" name="value_year" style="width:60px; text-align:center" value="<?php echo date('Y') ?>" onkeypress="return filter(event)">
		</div>
		<input id="number" type="hidden">
	</div>
	<table id="dg_order_detail" class="easyui-datagrid" style="width:1366px"
		url="../model/pipeline_detail_data.php"
		pagination="false" striped="true"
		rownumbers="false" fitColumns="false" singleSelect="true">
		<thead>
			<tr>
				<th field="TrafoType" style="width:200px"><center><b>Trafo Type</b></center></th>
				<th field="KVA" style="width:100px" align="center"><center><b>KVA</b></center></th>
				<th field="OtherRequest" style="width:350px"><center><b>Description</b></center></th>
				<th field="Qty" style="width:80px" align="center"><center><b>Quantity</b></center></th>
			</tr>
		</thead>
	</table>
	
	<div id="dlg_new_pipeline" class="easyui-dialog" title="Update Pipeline" style="width:710px; height:auto; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-new-pipeline" data-options="modal:true,closed:true,shadow:false">
		<div id="pipeline_new"></div>
	</div>
	<div id="dlg-buttons-new-pipeline">
		<button type="submit" form="create_pipeline" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Save</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_new_pipeline').window('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</a>
	</div>

	<div id="dlg_change_pipeline" class="easyui-dialog" title="Update Pipeline" style="width:710px; height:auto; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-change-pipeline" data-options="modal:true,closed:true,shadow:false">
		<div id="pipeline_update"></div>
	</div>
	<div id="dlg-buttons-change-pipeline">
		<button type="submit" form="update_pipeline" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Update</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_change_pipeline').dialog('close');" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</button>
	</div>
	
	<div id="dlg_change_opportunity" class="easyui-dialog" title="Update Opportunity" style="width:640px; padding: 5px 10px 5px 10px; top:15%" buttons="#dlg-buttons-change-opportunity" data-options="modal:true,closed:true,shadow:false">
		<div id="opportunity"></div>
	</div>
	<div id="dlg-buttons-change-opportunity">
		<button type="submit" form="change_opportunity" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Update</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_change_opportunity').dialog('close');" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</a>
	</div>
	
	<div id="dlg_change_fat" class="easyui-dialog" title="Update FAT" style="width:325px; height:auto; padding: 5px 10px 5px 10px; top:15%" buttons="#dlg-buttons-change-fat" data-options="modal:true,closed:true,shadow:false">
		<div id="fat"></div>
	</div>
	<div id="dlg-buttons-change-fat">
		<button type="submit" form="change_fat" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Update</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_change_fat').dialog('close');" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</a>
	</div>
	
	<div id="dlg_po_award" class="easyui-dialog" title="PO Award" style="width:535px; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-po-award" data-options="modal:true,closed:true,shadow:false">
		<div id="po_award"></div>
	</div>
	<div id="dlg-buttons-po-award">
		<button onclick="$('#submitRSO').click(); $('#submitTDS').click()" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Process</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_po_award').dialog('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</button>
	</div>
	
	<div id="dlg_draw_approve" class="easyui-dialog" title="Draw Approval" style="width:515px; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-draw-approve" data-options="modal:true,closed:true,shadow:false">
		<div id="draw_approval"></div>
	</div>
	<div id="dlg-buttons-draw-approve">
		<button type="submit" form="draw_approve" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Approve</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_draw_approve').dialog('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</button>
	</div>
	
	<div id="dlg_cancel_pipeline" class="easyui-dialog" title="Cancel Pipeline" style="width:350px; padding: 1px 0px 0px 10px; top:10%" buttons="#dlg-buttons-cancel-pipeline" data-options="modal:true,closed:true,shadow:false">
		<div id="cancel_pipeline"></div>
	</div>
	<div id="dlg-buttons-cancel-pipeline">
		<button type="submit" form="cancel_project" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Submit</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_cancel_pipeline').dialog('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</button>
	</div>
</div>

<script>
$('#field_order').change(function(){
	var field_order = $(this).val();
	$.post('../controller/order_pipeline_filter.php', {field_order: field_order}, function(data){
		$('#value_order').html(data);
	});
});

$('#value_order').change(function(){
	var value = $(this).val();
	if(value == 'Loss'){
		$('#active_order').val('%');
	} else {
		$('#active_order').val('Yes');
	}
});

function filter(e){
	var year = $('#value_year').val();
	if(e.keyCode == 13){
		$('#dg_order').datagrid('load',{
			value_year: year,
		});
		return false;
	}
}
</script>