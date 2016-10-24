<?php include 'menu.php' ?>

<div style="width:100%; padding-top:40px">
	<table id="dg_sales_order" class="easyui-datagrid"
		url="../model/sales_order_data.php" pageSize="15" pageList="[10,15,20,30,50]"
		toolbar="#toolbar_sales_order" pagination="true" striped="true" nowrap="true"
		rownumbers="false" fitColumns="false" singleSelect="true" data-options="
			onClickRow:function(){ showSalesOrderDetail(); },
			onSelect: function(index,row){
			if(row.SO == 'No'){
				$('#createSO').linkbutton('enable');
			} else if(row.SO == 'Yes'){
				$('#createSO').linkbutton('disable');
			}
		}">
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
				<th field="CreateId" style="width:100px" align="center" rowspan="2"><center><b>Sales</b></center></th>
				<th field="PODate" style="width:120px" align="center" rowspan="2"><center><b>Purchase Order<br>Date</b></center></th>
				<th field="SOReqDate" style="width:100px" align="center" rowspan="2"><center><b>Sales Order<br>Req. Date</b></center></th>
				<th colspan="4"><center><b><span style="color:green">Transformer Code</span></b></center></th>
				<th colspan="6"><center><b><span style="color:green">Drawing Approval</span></b></center></th>
			</tr>
            <tr>
                <th field="TrfCodeReqDate" style="width:100px" align="center"><center><b>Req. Date</b></center></th>
				<th field="TrfCodeReqId" style="width:100px" align="center"><center><b>Req. by</b></center></th>
				<th field="TrfCodeAnswerDate" style="width:100px" align="center"><center><b>Answer Date</b></center></th>
				<th field="TrfCodeAnswerId" style="width:100px" align="center"><center><b>Answer by</b></center></th>
				<th field="DrawReqDate" style="width:100px" align="center"><center><b>Req. Date</b></center></th>
				<th field="DrawReqId" style="width:100px" align="center"><center><b>Req. by</b></center></th>
				<th field="DrawAnswerDate" style="width:100px" align="center"><center><b>Answer Date</b></center></th>
				<th field="DrawAnswerId" style="width:100px" align="center"><center><b>Answer by</b></center></th>
				<th field="DrawApprovalDate" style="width:110px" align="center"><center><b>Approved Date</b></center></th>
				<th field="DrawApprovalId" style="width:110px" align="center"><center><b>Approved by</b></center></th>
            </tr>
        </thead>
	</table>
	<div id="toolbar_sales_order" style="padding:5px">
		<a href="javascript:void(0)" id="createSO" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="newSalesOrder()">Create SO</a>
		<a href="javascript:void(0)" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000, plain:false, menu:'#filterSO'">Filter</a>
		<div id="filterSO">
			<div onclick="salesOrderPO()"><span>Purchase Order</span></div>
			<div onclick="salesOrderSO()"><span>Sales Order</span></div>
			<div onclick="salesOrderAll()"><span>All</span></div>
		</div>
		<input id="search" style="border:1px solid; font-style:italic; height:25px; float:right; text-align:center" placeholder="Search pipeline no..." onkeypress="return filter(event)">
	</div>
	<table id="dg_sales_order_detail" class="easyui-datagrid"
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
	
	<div id="dlg_sales_order" class="easyui-dialog" modal="true" closed="true" style="width:300px; height:auto; padding:10px; top:100px" buttons="#dlg-buttons-sales-order">
	<form id="sales_order" action="../controller/sales_order_save.php" method="post">
		<div class="fitem">
			<label style="width:200px">Fill SO Reference Number</label>
		</div>
		<div class="fitem">
			<input name="SONumber" class="easyui-textbox" style="width:265px" required="true">
			<input name="PipelineNumber" type="hidden">
			<input name="RevisionNumber" type="hidden">
			<input name="ProjectName" type="hidden">
			<input name="Customer" type="hidden">
			<input name="CreateId" type="hidden">
			<input name="BUGroup" type="hidden">
			<input name="SalesGroupId" type="hidden">
		</div>
	</form>
	</div>
	<div id="dlg-buttons-sales-order">
		<button type="submit" form="sales_order" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Save</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_sales_order').dialog('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</button>
	</div>
</div>

<script>
function filter(e){
	var number = $('#search').val();
	if(e.keyCode == 13){
		$('#dg_sales_order').datagrid('load',{
			field_order: 'PipelineNumber',
			value_order: number,
		});
		return false;
	}
}
</script>