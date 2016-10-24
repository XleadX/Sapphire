<?php include 'menu.php' ?>

<div style="width:100%; padding-top:40px">
	<table id="dg_code" class="easyui-datagrid"
		url="../model/transformer_code_data.php" pageSize="15" pageList="[10,15,20,30,50]"
		toolbar="#toolbar_code" pagination="true" striped="true" nowrap="true"
		rownumbers="false" fitColumns="false" singleSelect="true" data-options="
			onClickRow:function(){ showCodeDetail(); },
			onSelect: function(index,row){
			if(row.TrfCodeAnswer == 'No'){
				$('#codeAnswer').linkbutton('enable');
			} else if(row.TrfCodeAnswer == 'Yes'){
				$('#codeAnswer').linkbutton('disable');
			}
		}
		">
		<thead frozen="true">
            <tr>
				<th field="PipelineStatus" style="width:225px" rowspan="2"><center><b>Pipeline Status</b></center></th>
				<th field="PipelineNumber" style="width:90px" align="center" rowspan="2"><center><b>Pipeline No.</b></center></th>
			</tr>
			<tr></tr>
        </thead>
		<thead>
            <tr>
				<th field="ProjectName" style="width:400px" rowspan="2"><center><b>Project Name</b></center></th>
				<th field="Customer" style="width:350px" rowspan="2"><center><b>Customer</b></center></th>
				<th field="SalesMarketId" style="width:145px" align="center" rowspan="2"><center><b>Sales Market</b></center></th>
				<th field="CreateDate" style="width:100px" align="center" rowspan="2"><center><b>Created Date</b></center></th>
				<th field="CreateId" style="width:100px" align="center" rowspan="2"><center><b>Created By</b></center></th>
				<th colspan="2"><center><b><span style="color:green">Transformer Code Request</span></b></center></th>
				<th colspan="2"><center><b><span style="color:green">Transformer Code Answer</span></b></center></th>
			</tr>
			<tr>
				<th field="TrfCodeReqDate" style="width:100px" align="center"><center><b>Request Date</b></center></th>
				<th field="TrfCodeReqId" style="width:100px" align="center"><center><b>Request By</b></center></th>
                <th field="TrfCodeAnswerDate" style="width:100px" align="center"><center><b>Answer Date</b></center></th>
				<th field="TrfCodeAnswerId" style="width:100px" align="center"><center><b>Answer By</b></center></th>
            </tr>
        </thead>
	</table>
	<div id="toolbar_code" style="padding:5px">
		<a href="javascript:void(0)" id="codeAnswer" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="answerCode()">Answer</a>
		<a href="javascript:void(0)" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000, plain:false, menu:'#filterCode'">Filter</a>
		<div id="filterCode">
			<div onclick="notAnswerFilterCode()"><span>Request - Not Answer</span></div>
			<div onclick="answerFilterCode()"><span>Request - Answered</span></div>
			<div onclick="allFilterCode()"><span>All</span></div>
		</div>
		<span style="float:right;">
			<label><b>Year<b></label>
			<input id="year" type="number" name="year" style="width:60px; text-align:center" value="<?php echo date('Y') ?>" onkeypress="return filter(event)">
		</span>
	</div>
	<table id="dg_code_detail" class="easyui-datagrid"
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
	
	<div id="dlg_code_answer" class="easyui-dialog" title="Transformer Code Answer" style="width:545px; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-code-answer" data-options="modal:true,closed:true,shadow:false">
		<div id="code_answer_show"></div>
	</div>
	<div id="dlg-buttons-code-answer">
		<button type="submit" form="code_answer" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Save</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_code_answer').window('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</a>
	</div>
</div>

<script>
function filter(e){
	var year = $('#year').val();
	if(e.keyCode == 13){
		$('#dg_code').datagrid('load',{
			year_value: year,
		});
		return false;
	}
}

var access = $('#access').val();
if(access == 'admin'){
	$('#codeAnswer').hide();
} else {
	$('#codeAnswer').show();
}
</script>