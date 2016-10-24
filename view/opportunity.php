<?php include 'menu.php' ?>

<div id="opportunity" class="easyui-window" title="Pipeline Opportunity" style="width:735px; height:420px; padding:10px; top:100px">
	<table id="dg_opportunity" class="easyui-datagrid"
		url="../model/opportunity_data.php"
		toolbar="#toolbar_opportunity" pagination="true" striped="true"
		rownumbers="true" fitColumns="false" singleSelect="true">
		<thead>
			<tr>
				<th field="ProbabilityId" style="width:200px" align="center"><center><b>Percentage (%)</b></center></th>
				<th field="ProbabilityDesc" style="width:467px"><center><b>Description</b></center></th>
			</tr>
		</thead>
	</table>
	<div id="toolbar_opportunity" style="padding:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="newOpportunity()">New</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" plain="false" style="width:100px; height:25px" onclick="destroyOpportunity()">Delete</a>
	</div>
	
	<div id="dlg_opportunity" class="easyui-dialog" style="width:auto; height:auto; padding: 20px 20px 20px 20px" closed="true" buttons="#dlg-buttons-opportunity">
		<form id="form_opportunity" method="post" novalidate>
			<div class="fitem" style="width:300px">
				<label style="width:125px">Percentage (%)</label>
				<input name="ProbabilityId" class="easyui-textbox" required="true">
			</div>
			<div class="fitem">
				<label style="width: 125px">Description</label>
				<input name="ProbabilityDesc" class="easyui-textbox" data-options="multiline:true" style="height:70px" required="true">
			</div>
		</form>
	</div>
	<div id="dlg-buttons-opportunity">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveOpportunity()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_opportunity').dialog('close')" style="width:90px">Cancel</a>
	</div>
</div>