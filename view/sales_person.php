<?php include 'menu.php' ?>

<div id="sales" class="easyui-window" title="Sales" style="width:735px; height:420px; padding:10px; top:100px">
	<table id="dg_sales" class="easyui-datagrid"
		url="../model/sales_person_data.php"
		toolbar="#toolbar_sales" pagination="true" striped="true"
		rownumbers="true" fitColumns="false" singleSelect="true">
		<thead>
			<tr>
				<th field="SalesId" style="width:317px"><center><b>Name</b></center></th>
				<th field="SalesEmail" style="width:350px"><center><b>Email</b></center></th>
			</tr>
		</thead>
	</table>
	<div id="toolbar_sales" style="padding:5px">
		<a class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="newSales()">New</a>
		<a class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="destroySales()">Delete</a>
	</div>
	
	<div id="dlg_sales" class="easyui-dialog" style="width:auto; height:auto; padding: 20px 20px 20px 20px" closed="true" buttons="#dlg-buttons-sales">
		<form id="form_sales" method="post" novalidate>
			<div class="fitem">
				<label>Username</label>
				<input name="SalesId" class="easyui-textbox" required="true">
			</div>
			<div class="fitem">
				<label>Password</label>
				<input name="SalesPassword" class="easyui-textbox" required="true">
			</div>
			<div class="fitem">
				<label>Email</label>
				<input name="SalesEmail" class="easyui-textbox" validType="email">
			</div>
			<div class="fitem">
				<label>Level</label>
				<select name="SalesLevel" class="easyui-combobox" style="width:75px" data-options="panelHeight: 'auto'">
					<option value="Staff">Staff</option>
					<option value="Manager">Manager</option>
				</select>
			</div>
			<div class="fitem">
				<label>Group</label>
				<select name="SalesGroupId" class="easyui-combobox" style="width:75px" data-options="panelHeight: 'auto'">
					<?php
						$stmt = $conn->query("SELECT SalesGroupId FROM SalesGroup");
						while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
							echo '<option value="' . $data['SalesGroupId'] . '">' . $data['SalesGroupId'] . '</option>';
						}
					?>
				</select>
			</div>
			<div class="fitem">
				<label>Receive</label>
				<input type="radio" name="ReceiveEmail" class="input-inline" style="width:10px" value="Yes">Yes
				&nbsp;&nbsp;<input type="radio" name="ReceiveEmail" class="input-inline" style="width:10px" value="No">No
			</div>
		</form>
	</div>
	<div id="dlg-buttons-sales">
		<a class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveSales()" style="width:90px">Save</a>
		<a class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_sales').dialog('close')" style="width:90px">Cancel</a>
	</div>
</div>