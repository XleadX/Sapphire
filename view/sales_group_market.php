<?php include 'menu.php' ?>

<div id="sales_group" class="easyui-window" title="Sales Group & Market" style="width:735px; height:425px; padding:10px; top:100px" data-options="closed: false, cls: 'c0'">
<div class="easyui-layout" style="width:700px; height:350px;">
	<div data-options="region:'west', split:true, title:'Sales Group', collapsible:false" style="width:275px">
		<table id="dg_group" class="easyui-datagrid" 
				url="../model/sales_group_data.php"
				toolbar="#toolbar_group" pagination="false"
				fitColumns="true" singleSelect="true" data-options="onClickRow:function(){ showDetail(); }">
			<thead>
				<tr>
					<th field="SalesGroupId" style="width:265px"><center><b>Sales Group</b></center></th>
				</tr>
			</thead>
		</table>
	<div id="toolbar_group" style="padding:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="newGroup()">New</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="destroyGroup()">Delete</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="$('#dg_group').datagrid('reload')"></a>
	</div>
	</div>
	
	<div data-options="region:'center', title:'Sales Market'">
		<table id="dg_market" class="easyui-datagrid" style="height:320px"
				url="../model/sales_market_data.php"
				toolbar="#toolbar_market" striped="true"
				fitColumns="true" singleSelect="true">
			<thead>
				<tr>
					<th field="SalesMarketId" style="width:500px"><center><b>Sales Market</b></center></th>
				</tr>
			</thead>
		</table>
	</div>
	<div id="toolbar_market" style="padding:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="newMarket()">New</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="destroyMarket()">Delete</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="$('#dg_market').datagrid('reload')"></a>
	</div>
</div>

	<div id="dlg_group" class="easyui-dialog" style="width:auto; height:auto; padding: 20px 20px 20px 20px" closed="true" buttons="#dlg-buttons-group">
		<form id="form_group" method="post" novalidate>
			<div class="fitem">
				<label style="width:150px">Input New Sales Group</label>
			</div><br>
			<div class="fitem">
				<input name="SalesGroupId" class="easyui-textbox" style="width:250px" required="true">
			</div>
		</form>
	</div>
	<div id="dlg-buttons-group">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveGroup()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_group').dialog('close')" style="width:90px">Cancel</a>
	</div>
	<div id="dlg_market" class="easyui-dialog" style="width:auto; height:auto; padding: 20px 20px 20px 20px" closed="true" buttons="#dlg-buttons-market">
		<form id="form_market" method="post" novalidate>
			<div class="fitem">
				<label style="width: 100px">Sales Group</label>
				<select name="SalesGroupId" class="easyui-combobox" style="width:75px" data-options="panelHeight: 'auto'" required="true">
					<?php
						$stmt = $conn->query("SELECT * FROM SalesGroupId");
						while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
							echo '<option value="' . $data['SalesGroupId'] . '">' . $data['SalesGroupId'] . '</option>';   
						}
					?>
				</select>
			</div>
			<div class="fitem">
				<label style="width: 100px">Sales Market</label>
				<input name="SalesMarketId" class="easyui-textbox" required="true">
			</div>
		</form>
	</div>
	<div id="dlg-buttons-market">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMarket()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_market').dialog('close')" style="width:90px">Cancel</a>
	</div>
</div>