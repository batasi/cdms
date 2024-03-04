<?php require_once('../config.php');  ?>
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
						<b>List of Payments </b>

						<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>

						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_payment">
						<i class="fa fa-plus"></i> New 
						</a></span>

						<?php endif; ?>
						
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
								<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
									<th class="text-center">#</th>
									<?php endif; ?>
									<th class="">Date</th>
									<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
									<th class="">ID No.</th>
									<th class="">ADM No.</th>
									<?php endif; ?>
									
									<th class="">Name</th>
									<th class="">Paid Amount</th>
									

									<th class="text-center">Action</th>

								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$isAdmin = 	($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2);
								$isStudent = 	($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4);

								if ($isAdmin) {
								
									$payments = $conn->query("SELECT p.*,s.name as sname, ef.ef_no,s.id_no FROM payments p inner join student_ef_list ef on ef.id = p.ef_id inner join student s on s.id = ef.student_id order by unix_timestamp(p.date_created) desc ");
									if($payments->num_rows > 0):
										while($row=$payments->fetch_assoc()):
											$paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
											$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:''; 
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p> <b><?php echo date("M d,Y H:i A",strtotime($row['date_created'])) ?></b></p>
									</td>
									<td>
										<p> <b><?php echo $row['id_no'] ?></b></p>
									</td>
									<td>
										<p> <b><?php echo $row['ef_no'] ?></b></p>
									</td>
									<td>
										<p> <b><?php echo ucwords($row['sname']) ?></b></p>
									</td>
									<td class="text-right">
										<p> <b><?php echo number_format($row['amount'],2) ?></b></p>
									</td>
									<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>

									<td class="text-center">							
										<button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id'] ?>" data-ef_id="<?php echo $row['ef_id'] ?>">View</button>
										<?php if($_settings->userdata('type') == 1): ?>
										<button class="btn btn-sm btn-outline-primary edit_payment" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_payment" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>									
											<?php endif;?>
									</td>
									<?php endif; ?>
								</tr>
								<?php endwhile;endif; }
							 else{ ?>
								<?php if (isset($_SESSION['userdata']['sname']) && isset($_SESSION['userdata']['id_no'])) {
										$studentIdNo = $_SESSION['userdata']['id_no'];
										$studentName = $_SESSION['userdata']['sname'];
										$payments = $conn->query("SELECT p.*, s.name as sname, ef.ef_no, s.id_no FROM payments p INNER JOIN student_ef_list ef ON ef.id = p.ef_id INNER JOIN student s ON s.id = ef.student_id WHERE s.name = '$studentName' AND s.id_no = '$studentIdNo' ORDER BY UNIX_TIMESTAMP(p.date_created) DESC");
										if (!$payments) {
											// Query failed
											echo "Error: " . mysqli_error($conn);
										} else {					
											while($row=$payments->fetch_assoc()):
												$paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
												$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:''; 
								?>
								<tr>
									<td>
										<p> <b><?php echo date("M d,Y H:i A",strtotime($row['date_created'])) ?></b></p>
									</td>
									
									<td>
										<p> <b><?php echo ucwords($row['sname']) ?></b></p>
									</td>
									<td class="text-right">
										<p> <b><?php echo number_format($row['amount'],2) ?></b></p>
									</td>

									<td class="text-center">							
										<button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id'] ?>" data-ef_id="<?php echo $row['ef_id'] ?>">View</button>
										<?php if($_settings->userdata('type') == 1): ?>
										<button class="btn btn-sm btn-outline-primary edit_payment" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_payment" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>									
											<?php endif;?>
									</td>
								</tr>
								<?php endwhile; ?>
								<?php }} }?>
								
								
							</tbody>
						</table>
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
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('#new_payment').click(function(){
		uni_modal("New Payment ","manage_payment.php","mid-large")
		
	})

	$('.view_payment').click(function(){
		uni_modal("Payment Details","view_payment.php?ef_id="+$(this).attr('data-ef_id')+"&pid="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.edit_payment').click(function(){
		uni_modal("Manage Payment","manage_payment.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_payment').click(function(){
		_conf("Are you sure to delete this payment ?","delete_payment",[$(this).attr('data-id')])
	})
	
	function delete_payment($id){
		start_loader();
		$.ajax({
			url:"../classes/Master.php?f=delete_payment",
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
</script>