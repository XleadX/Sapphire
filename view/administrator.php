<?php include 'menu.php' ?>

<div id="administrator" class="easyui-window" title="Administrator" style="width:735px; height:420px; padding:10px; top:100px">
	<table id="dg_administrator" class="easyui-datagrid"
		url="../model/administrator_data.php"
		toolbar="#toolbar_administrator" pagination="true" striped="true"
		rownumbers="true" fitColumns="false" singleSelect="true">
		<thead>
			<tr>
				<th field="TopLevelId" style="width:317px"><center><b>Name</b></center></th>
				<th field="TopLevelEmail" style="width:350px"><center><b>Email</b></center></th>
			</tr>
		</thead>
	</table>
	<div id="toolbar_administrator" style="padding:5px">
		<a class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="newAdministrator()">New</a>
		<a class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="destroyAdministrator()">Delete</a>
	</div>
	
	<div id="dlg_administrator" class="easyui-dialog" style="padding: 20px 20px 20px 20px" closed="true" buttons="#dlg-buttons-administrator">
		<form id="form_administrator" method="post" novalidate>
			<div class="fitem">
				<label>Username</label>
				<input name="TopLevelId" class="easyui-textbox" required="true">
			</div>
			<div class="fitem">
				<label>Password</label>
				<input name="TopLevelPassword" class="easyui-textbox" required="true">
			</div>
			<div class="fitem">
				<label>Email</label>
				<input name="TopLevelEmail" class="easyui-textbox" validType="email">
			</div>
			<div class="fitem">
				<label>Receive</label>
				<input type="radio" name="ReceiveEmail" class="input-inline" style="width:10px" value="Yes">Yes
				&nbsp;&nbsp;<input type="radio" name="ReceiveEmail" class="input-inline" style="width:10px" value="No">No
			</div>
		</form>
	</div>
	<div id="dlg-buttons-administrator">
		<a class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveAdministrator()" style="width:90px">Save</a>
		<a class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_administrator').dialog('close')" style="width:90px">Cancel</a>
	</div>
</div>