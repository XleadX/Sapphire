var url;

// Fungsi Administrator
function newAdministrator(){
	$('#dlg_administrator').dialog('open').dialog('setTitle','New Administrator');
	$('#form_administrator').form('clear');
	url = '../controller/administrator_save.php';
}

function saveAdministrator(){
	$('#form_administrator').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			} else {
				$('#dlg_administrator').dialog('close');
				$('#dg_administrator').datagrid('reload');
			}
		}
	});
}

function destroyAdministrator(){
	var row = $('#dg_administrator').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Are you sure you want to delete this user?',function(r){
			if (r){
				$.post('../controller/administrator_delete.php',{TopLevelId: row.TopLevelId},function(result){
					if (result.success){
						$('#dg_administrator').datagrid('reload');
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

$('#form_administrator input').on('change', function() {
   ($('input[name="ReceiveEmail"]:checked', '#form_administrator').val()); 
});

// Fungsi Engineer
function newEngineer(){
	$('#dlg_engineer').dialog('open').dialog('setTitle','New Engineer');
	$('#form_engineer').form('clear');
	url = '../controller/engineer_save.php';
}

function saveEngineer(){
	$('#form_engineer').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			} else {
				$('#dlg_engineer').dialog('close');
				$('#dg_engineer').datagrid('reload');
			}
		}
	});
}

function destroyEngineer(){
	var row = $('#dg_engineer').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Are you sure you want to delete this user?',function(r){
			if (r){
				$.post('../controller/engineer_delete.php',{EngineerId: row.EngineerId},function(result){
					if (result.success){
						$('#dg_engineer').datagrid('reload');
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

$('#form_engineer input').on('change', function() {
   ($('input[name="ReceiveEmail"]:checked', '#form_engineer').val()); 
});

// Fungsi Sales
function newSales(){
	$('#dlg_sales').dialog('open').dialog('setTitle','New Sales');
	$('#form_sales').form('clear');
	url = '../controller/sales_person_save.php';
}

function saveSales(){
	$('#form_sales').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			} else {
				$('#dlg_sales').dialog('close');
				$('#dg_sales').datagrid('reload');
			}
		}
	});
}

function destroySales(){
	var row = $('#dg_sales').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Are you sure you want to delete this user?',function(r){
			if (r){
				$.post('../controller/sales_person_delete.php',{SalesId: row.SalesId},function(result){
					if (result.success){
						$('#dg_sales').datagrid('reload');
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

$('#form_sales input').on('change', function() {
   ($('input[name="ReceiveEmail"]:checked', '#form_sales').val()); 
});

// Fungsi Opportunity
function newOpportunity(){
	$('#dlg_opportunity').dialog('open').dialog('setTitle','New Opportunity');
	$('#form_opportunity').form('clear');
	url = '../controller/opportunity_save.php';
}

function saveOpportunity(){
	$('#form_opportunity').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			} else {
				$('#dlg_opportunity').dialog('close');
				$('#dg_opportunity').datagrid('reload');
			}
		}
	});
}

function destroyOpportunity(){
	var row = $('#dg_opportunity').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Are you sure you want to delete this data?',function(r){
			if (r){
				$.post('../controller/opportunity_delete.php',{ProbabilityId: row.ProbabilityId},function(result){
					if (result.success){
						$('#dg_opportunity').datagrid('reload');
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

// Fungsi Sales Group & Market
function newGroup(){
	$('#dlg_group').dialog('open').dialog('setTitle','New Group');
	$('#form_group').form('clear');
	url = '../controller/sales_group_save.php';
}

function newMarket(){
	$('#dlg_market').dialog('open').dialog('setTitle','New Market');
	$('#form_market').form('clear');
	url = 'sales_market_save.php';
}

function showDetail(){
	var row = $('#dg_group').datagrid('getSelected');
	if(row){
		$('#dg_market').datagrid('reload',row);
		url = 'sales_market_data.php?SalesGroupId='+row.SalesGroupId;
	}
}

function saveGroup(){
	$('#form_group').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			} else {
				$('#dlg_group').dialog('close');
				$('#dg_group').datagrid('reload');
				$('#dg_market').datagrid('reload');
			}
		}
	});
}

function saveMarket(){
	$('#form_market').form('submit',{
		url: url,
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(result){
			var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: 'Error',
					msg: result.errorMsg
				});
			} else {
				$('#dlg_market').dialog('close');
				$('#dg_market').datagrid('reload');
			}
		}
	});
}

function destroyGroup(){
	var row = $('#dg_group').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Are you sure you want to delete this user?',function(r){
			if (r){
				$.post('../controller/sales_group_delete.php',{SalesGroupId: row.SalesGroupId},function(result){
					if (result.success){
						$('#dg_group').datagrid('reload');
						$('#dg_market').datagrid('reload');
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

function destroyMarket(){
	var row = $('#dg_market').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Are you sure you want to delete this user?',function(r){
			if (r){
				$.post('../controller/sales_market_delete.php',{SalesMarketId: row.SalesMarketId},function(result){
					if (result.success){
						$('#dg_market').datagrid('reload');
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}

// Fungsi Sales Order
function newSalesOrder(){
	var row = $('#dg_sales_order').datagrid('getSelected');
	if(row){
		$('#dlg_sales_order').dialog('open');
		$('#sales_order').form('load', row);
	}
}

function showSalesOrderDetail(){
	var row = $('#dg_sales_order').datagrid('getSelected');
	if(row){
		$('#dg_sales_order_detail').datagrid('reload',row);
		url = 'pipeline_detail_data.php?PipelineNumber='+row.PipelineNumber;
	}
}

function salesOrderPO(){
	$('#dg_sales_order').datagrid('load',{
		field_order: 'PipelineStatus',
		value_order: 'PO',
	});				
}

function salesOrderSO(){
	$('#dg_sales_order').datagrid('load',{
		field_order: 'PipelineStatus',
		value_order: 'SO',
	});				
}

function salesOrderAll(){
	$('#dg_sales_order').datagrid('load',{
		field_order: 'PipelineNumber',
		value_order: '%',
	});				
}

// Fungsi Request For Quotation		
function showRFQDetail(){
	var row = $('#dg_rfq').datagrid('getSelected');
	if(row){
		$('#dg_rfq_detail').datagrid('reload',row);
		url = 'pipeline_detail_data.php?PipelineNumber='+row.PipelineNumber;
	}
}

function newFilterRFQ(){
	var year_value = $('#year').val();
	var bu_group = $('#BUGroup').val();
	$('#dg_rfq').datagrid('load',{
		field_order: 'RFQStatus',
		value_order: 'Request',
		year_value: year_value,
		bugroup: bu_group,
	});				
}

function pickFilterRFQ(){
	var year_value = $('#year').val();
	var bu_group = $('#BUGroup').val();
	$('#dg_rfq').datagrid('load',{
		field_order: 'RFQStatus',
		value_order: 'Pick',
		year_value: year_value,
		bugroup: bu_group,
	});
}

function scheduleFilterRFQ(){
	var year_value = $('#year').val();
	var bu_group = $('#BUGroup').val();
	$('#dg_rfq').datagrid('load',{
		field_order: 'RFQStatus',
		value_order: 'Schedule',
		year_value: year_value,
		bugroup: bu_group,
	});
}

function answerFilterRFQ(){
	var year_value = $('#year').val();
	var bu_group = $('#BUGroup').val();
	$('#dg_rfq').datagrid('load',{
		field_order: 'RFQStatus',
		value_order: 'Answer',
		year_value: year_value,
		bugroup: bu_group,
	});
}

function allFilterRFQ(){
	var year_value = $('#year').val();
	var bu_group = $('#BUGroup').val();
	$('#dg_rfq').datagrid('load',{
		field_order: 'RFQ',
		value_order: 'Yes%',
		year_value: year_value,
		bugroup: bu_group,
	});
}

function pickRFQ(){
	var row = $('#dg_rfq').datagrid('getSelected');
	if(row.RFQ == 'Yes' && row.Approved != 'Yes'){
		alert('This pipeline need approval !');
	} else {
		$.messager.confirm('Confirm','Are you sure you want to pick this pipeline?',function(r){
			if (r){
				$.post('../controller/request_for_quotation_pick.php',{
					PipelineNumber: row.PipelineNumber,
					ProjectName: row.ProjectName,
					Customer: row.Customer,
					CreateId: row.CreateId,
					RevisionNumber: row.RevisionNumber,
					SalesGroupId: row.SalesGroupId
				}, function(result){
					if (result.success){
						alert("Email was sent to Sales !");
						$('#dg_rfq').datagrid('reload');
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}
		
// Fungsi Drawing Approval
function showDrawDetail(){
	var row = $('#dg_draw').datagrid('getSelected');
	if(row){
		$('#dg_draw_detail').datagrid('reload',row);
		url = 'pipeline_detail_data.php?PipelineNumber='+row.PipelineNumber;
	}
}
		
function requireFilterDraw(){
	var year_value = $('#year').val();
	$('#dg_draw').datagrid('load',{
		field_order: 'DrawStatus',
		value_order: 'Require',
		year_value: year_value,
	});				
}

function answerFilterDraw(){
	var year_value = $('#year').val();
	$('#dg_draw').datagrid('load',{
		field_order: 'DrawStatus',
		value_order: 'Answer',
		year_value: year_value,
	});				
}

function approveFilterDraw(){
	var year_value = $('#year').val();
	$('#dg_draw').datagrid('load',{
		field_order: 'DrawStatus',
		value_order: 'Approve',
		year_value: year_value,
	});				
}

function allFilterDraw(){
	var year_value = $('#year').val();
	$('#dg_draw').datagrid('load',{
		field_order: 'DrawReq',
		value_order: 'Yes%',
		year_value: year_value,
	});				
}

function answerDraw(){
	var row = $('#dg_draw').datagrid('getSelected');
	if(row){
		$('#dlg_draw_answer').dialog('open');
		var number = row.PipelineNumber;
		$.ajax({
			type: "GET",
			url: "drawing_approval_answer.php",
			dataType: "html",
			data: "PipelineNumber=" + number,
			success: function(data){                    
				$("#draw_answer_show").html(data);
			}
		});
	}
}

// Fungsi Transformer Code
function showCodeDetail(){
	var row = $('#dg_code').datagrid('getSelected');
	if(row){
		$('#dg_code_detail').datagrid('reload',row);
		url = 'code_detail_data.php?PipelineNumber='+row.PipelineNumber;
	}
}

function notAnswerFilterCode(){
	var year_value = $('#year').val();
	$('#dg_code').datagrid('load',{
		field_order: 'TrfCodeAnswer',
		value_order: 'No',
		year_value: year_value,
	});				
}

function answerFilterCode(){
	var year_value = $('#year').val();
	$('#dg_code').datagrid('load',{
		field_order: 'TrfCodeAnswer',
		value_order: 'Yes',
		year_value: year_value,
	});				
}

function allFilterCode(){
	var year_value = $('#year').val();
	$('#dg_code').datagrid('load',{
		field_order: 'TrfCodeReq',
		value_order: 'Yes%',
		year_value: year_value,
	});				
}

function answerCode(){
	var row = $('#dg_code').datagrid('getSelected');
	if(row){
		$('#dlg_code_answer').dialog('open');
		var number = row.PipelineNumber;
		$.ajax({
			type: "GET",
			url: "transformer_code_answer.php",
			dataType: "html",
			data: "PipelineNumber=" + number,
			success: function(data){                    
				$("#code_answer_show").html(data);
			}
		});
	}
}

// Fungsi Pipeline Monitoring
		function newSales(){
			$('#dlg_sales').dialog('open').dialog('setTitle','New Sales');
			$('#form_sales').form('clear');
			url = 'sales_save.php';
		}
		
function showPipelineDetail(){
	var row = $('#dg_pipeline').datagrid('getSelected');
	if(row){
		$('#dg_pipeline_detail').datagrid('reload',row);
		url = 'pipeline_detail_data.php?PipelineNumber='+row.PipelineNumber;
	}
}

function filterMonitoring(){
	$('#dg_pipeline').datagrid('load',{
		field: $('#field_monitoring').val(),
		value: $('#value_monitoring').val(),
		year: $('#year_monitoring').val(),
	});				
}

function showHistory(){
	var row = $('#dg_pipeline').datagrid('getSelected');
	if(row){
		$('#filterMonitoring').hide();
		$('#historyMonitoring').hide();
		$('#reportMonitoring').hide();
		$('#backMonitoring').show();
		
		$('#dg_pipeline').datagrid('load',{
			field: 'PipelineNumber',
			value: row.PipelineNumber,
			active: '%',
		});
	}
}

function showMonitoring(){
	$('#filterMonitoring').show();
	$('#historyMonitoring').show();
	$('#reportMonitoring').show();
	$('#backMonitoring').hide();
		
	$('#dg_pipeline').datagrid('load',{
		field: 'PipelineNumber',
		value: '%',
		active: 'Yes',
	});
}

function scheduleRFQ(){
	var row = $('#dg_rfq').datagrid('getSelected');
	if(row){
		$('#dlg_rfq_schedule').dialog('open');
		var number = row.PipelineNumber;
		$.ajax({
			type: "GET",
			url: "request_for_quotation_schedule.php",
			dataType: "html",
			data: "PipelineNumber=" + number,
			success: function(data){                    
				$("#rfq_schedule_show").html(data);
			}
		});
	}
}

function answerRFQ(){
	var row = $('#dg_rfq').datagrid('getSelected');
	if(row){
		$('#dlg_rfq_answer').dialog('open');
		var number = row.PipelineNumber;
		$.ajax({
			type: "GET",
			url: "request_for_quotation_answer.php",
			dataType: "html",
			data: "PipelineNumber=" + number,
			success: function(data){                    
				$("#rfq_answer_show").html(data);
			}
		});
	}
}

		function saveSales(){
			$('#form_sales').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					if (result.errorMsg){
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					} else {
						$('#dlg_sales').dialog('close');		// close the dialog
						$('#dg_sales').datagrid('reload');	// reload the user data
					}
				}
			});
		}
		
		function destroySales(){
			var row = $('#dg_sales').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to delete this user?',function(r){
					if (r){
						$.post('sales_delete.php',{SalesId: row.SalesId},function(result){
							if (result.success){
								$('#dg_sales').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.errorMsg
								});
							}
						},'json');
					}
				});
			}
		}
		
		$('#form_sales input').on('change', function() {
		   ($('input[name="ReceiveEmail"]:checked', '#form_sales').val()); 
		});

// Fungsi Order Pipeline
function newOrder(){
	$('#dlg_new_pipeline').dialog('open');
	$.ajax({
		type: "GET",
		url: "order_pipeline_create.php",
		dataType: "html",
		data: "PipelineNumber=true",
		success: function(data){                    
			$("#pipeline_new").html(data);
		}
	});
}

function updateOrder(){
		var row = $('#dg_order').datagrid('getSelected');
		if(row){
			$('#dlg_change_pipeline').dialog('open');
			var number = $('#number').val();
			$.ajax({
				type: "GET",
				url: "order_pipeline_update.php",
				dataType: "html",
				data: "PipelineNumber=" + number,
				success: function(data){                    
					$("#pipeline_update").html(data);
				}
			});
		}
	}

function changeOpportunity(){
	var row = $('#dg_order').datagrid('getSelected');
	if(row){
		$('#dlg_change_opportunity').dialog('open');
		var number = $('#number').val();
		$.ajax({
			type: "GET",
			url: "order_pipeline_opportunity.php",
			dataType: "html",
			data: "PipelineNumber=" + number,
			success: function(data){                    
				$("#opportunity").html(data);
			}
		});
	}
}

function changeFAT(){
	var row = $('#dg_order').datagrid('getSelected');
	if(row){
		$('#dlg_change_fat').dialog('open');
		var number = $('#number').val();
		$.ajax({
			type: "GET",
			url: "order_pipeline_fat.php",
			dataType: "html",
			data: "PipelineNumber=" + number,
			success: function(data){                    
				$("#fat").html(data);
			}
		});
	}
}

function POAward(){
	var row = $('#dg_order').datagrid('getSelected');
	if(row.RFQStatus != 'Answer' && row.Approved == 'No'){
		alert('Please approve pipeline first !');
	} else if(row.RFQStatus != 'Answer' && row.Approved == 'Yes'){
		alert('Please answer pipeline first !');
	} else {
		$('#dlg_po_award').dialog('open');
		var number = row.PipelineNumber;
		$.ajax({
			type: "GET",
			url: "sales_purchase_order_award.php",
			dataType: "html",
			data: "PipelineNumber=" + number,
			success: function(data){                    
				$("#po_award").html(data);
			}
		});
	}
}

function showOrderDetail(){
	var row = $('#dg_order').datagrid('getSelected');
	if(row){
		$('#number').val(row.PipelineNumber);
		$('#dg_order_detail').datagrid('reload',row);
		url = 'pipeline_detail_data.php?PipelineNumber='+row.PipelineNumber;
	}
}

function showPurchaseOrderDetail(){
	var row = $('#dg_order').datagrid('getSelected');
	if(row){
		$('#dg_purchase_order_detail').datagrid('reload',row);
		url = 'pipeline_detail_data.php?PipelineNumber='+row.PipelineNumber;
	}
}

function cancelProject(){
	var row = $('#dg_order').datagrid('getSelected');
	if(row){
		$.messager.confirm('Confirm','Are you sure you want to cancel this pipeline?',function(r){
			if(r){
				$('#dlg_cancel_pipeline').dialog('open');
				var number = $('#number').val();
				$.ajax({
					type: "GET",
					url: "order_pipeline_cancel.php",
					dataType: "html",
					data: "PipelineNumber=" + number,
					success: function(data){                    
						$("#cancel_pipeline").html(data);
					}
				});
			}
		});
	}
}
	
function filterOrder(){
	$('#dg_order').datagrid('reload',{
		field_order: $('#field_order').val(),
		value_order: $('#value_order').val(),
		active_order: $('#active_order').val(),
		value_year: $('#value_year').val(),
	});				
}

function drawApprove(){
	var row = $('#dg_order').datagrid('getSelected');
	if(row){
		$('#dlg_draw_approve').dialog('open');
		var number = $('#number').val();
		$.ajax({
			type: "GET",
			url: "order_pipeline_draw.php",
			dataType: "html",
			data: "PipelineNumber=" + number,
			success: function(data){                    
				$("#draw_approval").html(data);
			}
		});
	}
}

// Fungsi Approval Pipeline
function approvePipeline(){
	var row = $('#dg_pipeline').datagrid('getSelected');
	if (row){
		$.messager.confirm('Confirm','Are you sure you want to approve this pipeline?',function(r){
			if (r){
				$.post('../controller/pipeline_monitoring_approve.php',{
					PipelineNumber: row.PipelineNumber,
					ProjectName: row.ProjectName,
					Customer: row.Customer,
					CreateId: row.CreateId,
					BUGroup: row.BUGroup,
					Tescom: row.Tescom,
					FAT: row.FAT,
					RevisionNumber: row.RevisionNumber
				}, function(result){
					if (result.success){
						alert("Email was sent to Sales and ENG !");
						$('#dg_pipeline').datagrid('reload');
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.errorMsg
						});
					}
				},'json');
			}
		});
	}
}