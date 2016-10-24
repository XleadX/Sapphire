<?php include 'menu.php' ?>

<div id="engineer" class="easyui-window" title="Engineer" style="width:735px; height:420px; padding:10px; top:100px">
	<table id="dg_engineer" class="easyui-datagrid"
		url="../model/engineer_data.php"
		toolbar="#toolbar_engineer" pagination="true" striped="true"
		rownumbers="true" fitColumns="false" singleSelect="true">
		<thead>
			<tr>
				<th field="EngineerId" style="width:317px"><center><b>Name</b></center></th>
				<th field="EngineerEmail" style="width:350px"><center><b>Email</b></center></th>
			</tr>
		</thead>
	</table>
	<div id="toolbar_engineer" style="padding:5px">
		<a class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="newEngineer()">New</a>
		<a class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="destroyEngineer()">Delete</a>
	</div>
	
	<div id="dlg_engineer" class="easyui-dialog" style="width:auto; height:auto; padding: 20px 20px 20px 20px" closed="true" buttons="#dlg-buttons-engineer">
		<form id="form_engineer" method="post" novalidate>
			<div class="fitem">
				<label>Username</label>
				<input name="EngineerId" class="easyui-textbox" required="true">
			</div>
			<div class="fitem">
				<label>Password</label>
				<input name="EngineerPassword" class="easyui-textbox" required="true">
			</div>
			<div class="fitem">
				<label>Email</label>
				<input name="EngineerEmail" class="easyui-textbox" validType="email">
			</div>
			<div class="fitem">
				<label>Group</label>
				<select name="EngineerGroup" class="easyui-combobox" style="width:75px" data-options="panelHeight: 'auto'">
					<option value="ENG">ENG</option>
					<option value="PPIC">PPIC</option>
					<option value="PC">PC</option>
					<option value="QA">QA</option>
					<option value="SVC">SVC</option>
				</select>
			</div>
			<div class="fitem">
				<label>Level</label>
				<select name="EngineerLevel" class="easyui-combobox" style="width:75px" data-options="panelHeight: 'auto'">
					<option value="Staff">Staff</option>
					<option value="Supervisor">Supervisor</option>
					<option value="Head">Head</option>
				</select>
			</div>
			<div class="fitem">
				<label>Confirm SO</label>
				<select name="ConfirmSO" class="easyui-combobox" style="width:75px" data-options="panelHeight: 'auto'">
					<option value="Yes">Yes</option>
					<option value="No">No</option>
				</select>
			</div>
			<div class="fitem">
				<label>BU Group</label>
				<select name="BUGroup" class="easyui-combobox" style="width:75px" data-options="panelHeight: 'auto'">
					<option value="PTR">PTR</option>
					<option value="DTR">DTR</option>
					<option value="ICT">ICT</option>
				</select>
			</div>
			<div class="fitem">
				<label>Receive</label>
				<input type="radio" name="ReceiveEmail" class="input-inline" style="width:10px" value="Yes">Yes
				&nbsp;&nbsp;<input type="radio" name="ReceiveEmail" class="input-inline" style="width:10px" value="No">No
			</div>
		</form>
	</div>
	<div id="dlg-buttons-engineer">
		<a class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveEngineer()" style="width:90px">Save</a>
		<a class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_engineer').dialog('close')" style="width:90px">Cancel</a>
	</div>
</div>