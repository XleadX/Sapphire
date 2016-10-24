<?php include 'menu.php' ?>

<div style="width:100%; padding-top:40px">
	<table id="dg_draw" class="easyui-datagrid"
		url="../model/drawing_approval_data.php" pageSize="15" pageList="[10,15,20,30,50]"
		toolbar="#toolbar_draw" pagination="true" striped="true" nowrap="true"
		rownumbers="false" fitColumns="false" singleSelect="true" data-options="
			onClickRow:function(){ showDrawDetail(); },
			onSelect: function(index,row){
			if(row.DrawStatus == 'Require'){
				$('#drawAnswer').linkbutton('enable');
			} else if(row.DrawStatus == 'Answer'){
				$('#drawAnswer').linkbutton('disable');
			} else if(row.DrawStatus == 'Approve'){
				$('#drawAnswer').linkbutton('disable');
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
				<th colspan="2"><center><b><span style="color:green">Drawing Request</span></b></center></th>
				<th colspan="2"><center><b><span style="color:green">Drawing Answer</span></b></center></th>
				<th colspan="2"><center><b><span style="color:green">Drawing Approval</span></b></center></th>
				<th field="RevisionNumber" hidden><center><b>Revision</b></center></th>
			</tr>
			<tr>
				<th field="DrawReqDate" style="width:100px" align="center"><center><b>Request Date</b></center></th>
				<th field="DrawReqId" style="width:100px" align="center"><center><b>Request By</b></center></th>
                <th field="DrawAnswerDate" style="width:100px" align="center"><center><b>Answer Date</b></center></th>
				<th field="DrawAnswerId" style="width:100px" align="center"><center><b>Answer By</b></center></th>
				<th field="DrawApprovalDate" style="width:115px" align="center"><center><b>Approve Date</b></center></th>
				<th field="DrawApprovalId" style="width:100px" align="center"><center><b>Approve By</b></center></th>
            </tr>
        </thead>
	</table>
	<div id="toolbar_draw" style="padding:5px">
		<a href="javascript:void(0)" id="drawAnswer" class="easyui-linkbutton" style="width:100px; height:25px" data-options="plain:false" onclick="answerDraw()">Answer</a>
		<a href="javascript:void(0)" class="easyui-menubutton" style="width:100px; height:25px" data-options="duration:60000, plain:false, menu:'#filterDraw'">Filter</a>
		<div id="filterDraw">
			<div onclick="requireFilterDraw()"><span>Require</span></div>
			<div onclick="answerFilterDraw()"><span>Answer</span></div>
			<div onclick="approveFilterDraw()"><span>Approve</span></div>
			<div onclick="allFilterDraw()"><span>All</span></div>
		</div>
		<span style="float:right;">
			<label><b>Year<b></label>
			<input id="year" type="number" name="year" style="width:60px; text-align:center" value="<?php echo date('Y') ?>" onkeypress="return filter(event)">
		</span>
	</div>
	<table id="dg_draw_detail" class="easyui-datagrid"
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
	
	<div id="dlg_draw_answer" class="easyui-dialog" title="Drawing Approval Answer" style="width:545px; padding: 5px 10px 5px 10px; top:10%" buttons="#dlg-buttons-draw-answer" data-options="modal:true,closed:true,shadow:false">
		<div id="draw_answer_show"></div>
	</div>
	<div id="dlg-buttons-draw-answer">
		<button type="submit" form="draw_answer" class="easyui-linkbutton c6" iconCls="icon-ok" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Save</button>
		<button class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg_draw_answer').window('close')" style="width:90px; font-family:Verdana,Arial,Sans-Serif">Cancel</a>
	</div>
</div>

<script>
function filter(e){
	var year = $('#year').val();
	if(e.keyCode == 13){
		$('#dg_draw').datagrid('load',{
			year_value: year,
		});
		return false;
	}
}

var access = $('#access').val();
if(access == 'admin'){
	$('#drawAnswer').hide();
} else {
	$('#drawAnswer').show();
}
</script>