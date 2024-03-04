<?php require_once('../config.php'); 
$month = isset($_GET['month']) ? date('Y-m', strtotime($_GET['month'])) : date('Y-m');
?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Expenses </b>
						<div class="row justify-content-center pt-4">
							<label for="" class="mt-2">Month</label>
							<div class="col-sm-3">
								<input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control">
							</div>
						</div>
						<span class="float:right">
							<a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_expenses">
								<i class="fa fa-plus"></i> New Expense
							</a>
						</span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover" id="report-list">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Date</th>
									<th>Remarks</th>
									<th>Amount</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$isAdmin = $_settings->userdata('type') == 1;
								if ($isAdmin) {
									$expenses = $conn->query("SELECT * FROM expenses WHERE date_format(date_created,'%Y-%m') = '$month' ORDER BY unix_timestamp(date_created) ASC");
								}	
								if($expenses->num_rows > 0):
									while($row = $expenses->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-right">
										<p><b><?php echo date("M d,Y H:i A",strtotime($row['date_created'])) ?></b></p>
									</td>
									<td>
										<p><b><?php echo $row['remarks'] ?></b></p>
									</td>
									<td>
										<p><b><?php echo number_format($row['amount'],2) ?></b></p>
									</td>
									<td class="text-center">	
											<button class="btn btn-sm btn-outline-primary edit_expenses" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
											<button class="btn btn-sm btn-outline-danger delete_expenses" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>									
										</td>
								</tr>
								<?php endwhile; ?>
								<?php else: ?>
								<tr>
									<th class="text-center" colspan="7">No data.</th>
								</tr>
								<?php endif; ?>
								<?php
									$i = 1;
									$total = 0;
									$payments = $conn->query("SELECT p.*,s.name as sname, ef.ef_no,s.id_no FROM payments p INNER JOIN student_ef_list ef ON ef.id = p.ef_id INNER JOIN student s ON s.id = ef.student_id WHERE date_format(p.date_created,'%Y-%m') = '$month'");
									if($payments->num_rows > 0):
										while($row = $payments->fetch_array()):
											$total += $row['amount'];
										endwhile;
									endif;

									$amount = $conn->query("SELECT SUM(amount) AS total_amount FROM expenses WHERE date_format(date_created,'%Y-%m') = '$month'");
									if ($amount->num_rows > 0) {
										$row = $amount->fetch_assoc();
										$total_amount = $row['total_amount'];
									} else {
										$total_amount = 0; // Default value if no records found
									}
								?>
							</tbody>
							<tfoot>
								<tr>
									<th colspan="3" class="text-right">Profit</th>
									<th class="text-right"><?php echo number_format(($total - $total_amount),2) ?></th>
									<th></th>
								</tr>
							</tfoot>
							<tfoot>
								<tr>
									<th colspan="3" class="text-right">Total Fees Paid <?php echo date("F, Y",strtotime($month)) ?></th>
									<th class="text-right"><?php echo number_format($total,2) ?></th>
									<th></th>
								</tr>
							</tfoot>
							<tfoot>
								<tr>
									<th colspan="3" class="text-right">Total Expenses <?php echo date("F, Y",strtotime($month)) ?></th>
									<th class="text-right"><?php echo number_format($total_amount,2) ?></th>
									<th></th>
								</tr>
							</tfoot>
						</table>
						<hr>
               			<div class="col-md-12 mb-4">
							<center>
								<button class="btn btn-success btn-sm col-sm-3" type="button" id="print"><i class="fa fa-print"></i> Print</button>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>

<noscript>
	<style>
		table#report-list{
			width:100%;
			border-collapse:collapse
		}
		table#report-list td,table#report-list th{
			border:1px solid
		}
        p{
            margin:unset;
        }
		.text-center{
			text-align:center
		}
        .text-right{
            text-align:right
        }
	</style>
</noscript>

<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('#new_expenses').click(function(){
		uni_modal("New Expenses ","manage_expenses.php","mid-large")
	})

	$('.view_expenses').click(function(){
		uni_modal("Expenses Details","view_expenses.php?ef_id="+$(this).attr('data-ef_id')+"&pid="+$(this).attr('data-id'),"mid-large")
	})
	
	$('.edit_expenses').click(function(){
		uni_modal("Manage Expenses","manage_expenses.php?id="+$(this).attr('data-id'),"mid-large")
	})
	
	$('.delete_expenses').click(function(){
		_conf("Are you sure to delete this expenses ?","delete_expenses",[$(this).attr('data-id')])
	})
	
	function delete_expenses($id){
		start_loader();
		$.ajax({
			url:"../classes/Master.php?f=delete_expenses",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	
	$('#month').change(function(){
    	location.replace('../admin?page=expenses&month='+$(this).val())
	})
	
	$('#print').click(function(){
		var _c = $('#report-list').clone();
		var ns = $('noscript').clone();
        ns.append(_c)
		var nw = window.open('','_blank','width=900,height=600')
		nw.document.write('<p class="text-center"><b>Expenditure Report as of <?php echo date("F, Y",strtotime($month)) ?></b></p>')
		nw.document.write(ns.html())
		nw.document.close()
		nw.print()
		setTimeout(() => {
			nw.close()
		}, 500);
	})
</script>
