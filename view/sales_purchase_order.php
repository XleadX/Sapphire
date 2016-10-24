<?php include 'menu.php' ?>

<div style="width:100%; padding-top:40px">
	<table id="dg_order" class="easyui-datagrid"
		url="../model/sales_purchase_order_data.php" pageSize="15" pageList="[10,15,20,30,50]"
		toolbar="#toolbar_order" pagination="true" striped="true" nowrap="true"
		rownumbers="false" fitColumns="false" singleSelect="true" data-options="
			onClickRow:function(){ showPurchaseOrderDetail(); }">
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
				<th field="CreateId" style="width:100px" align="center" rowspan="2"><center><b>Sales</b></center></th>
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
		<a href="javascript:void(0)" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="POAward()">Create PO</a>
		<!--
		<a href="javascript:void(0)" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000, plain:false, menu:'#filter_order'">Filter</a>
		<div id="filter_order" class="menu-content" style="padding:15px; background-color:#F4F4F4">
			<b>Field :</b>
			<select id="field_order" name="field_order" style="width: 150px">
				<option value="PipelineNumber" selected>All</option>
				<option value="RFQStatus">RFQ Status</option>
				<option value="CreateId">Sales</option>
			</select>
			&nbsp;<b>Value :</b>
			<select id="value_order" name="value_order" style="width:150px">
				<option value="%">All</option>
			</select>
			<input id="active_order" type="hidden" value="Yes">
			&nbsp;<b>Year :</b>
			<input id="value_year" name="value_year" type="number" style="width:60px; text-align:center" value="2016">
			<input type="button" href="javascript:void(0)" onclick="filterOrder()" value="Filter" id="filter">
		</div>
		-->
		<input id="search" style="border:1px solid; font-style:italic; height:25px; float:right; text-align:center" placeholder="Search pipeline no..." onkeypress="return filter(event)">
	</div>
	<table id="dg_purchase_order_detail" class="easyui-datagrid" style="width:1366px"
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

	<div id="dlg_po_award" class="easyui-dialog" title="PO Award" style="width:535px; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-po-award" data-options="modal:true,closed:true,shadow:false">
		<div id="po_award"></div>
	</div>
	<div id="dlg-buttons-po-award">
		<button onclick="$('#submitRSO').click(); $('#submitTDS').click()" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Process</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_po_award').dialog('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</button>
	</div>
</div>

<script>
function filter(e){
	var number = $('#search').val();
	if(e.keyCode == 13){
		$('#dg_order').datagrid('load',{
			field_order: 'PipelineNumber',
			value_order: number,
		});
		return false;
	}
}
</script>