<?php require_once('../config.php') ?>

<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.3); /* IE */
  -moz-transform: scale(1.3); /* FF */
  -webkit-transform: scale(1.3); /* Safari and Chrome */
  -o-transform: scale(1.3); /* Opera */
  transform: scale(1.3);
  padding: 10px;
  cursor:pointer;
}
</style>
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Student fees </b>

						<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>


					<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-3 float-right" href="javascript:void(0)" id="new_fees">
					<i class="fa fa-plus"></i>Enroll New Student
					</a></span>
				<?php endif; ?>

					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
								<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>

									<th class="text-center">#</th>
									<th class="">ID No.</th>
									<th class="">ADM No.</th>
									<?php endif; ?>

									<th class="">Name</th>
									<th class="">Payable Fee</th>
									<th class="">Paid</th>
									<th class="">Balance</th>
									
									<th class="text-center">Action</th>

								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
							$isAdmin = 	($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2);
							$isStudent = 	($_settings->userdata('type') == 3 || $_settings->userdata('type') == 4);
	                        
								if ($isAdmin) {
								
								$fees = $conn->query("SELECT ef.*,s.name as sname,s.id_no FROM student_ef_list ef inner join student s on s.id = ef.student_id order by s.name asc ");
								while($row=$fees->fetch_assoc()):
									$paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
									$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';
									$balance = $row['total_fee'] - $paid;
									?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
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
										<p> <b><?php echo number_format($row['total_fee'],2) ?></b></p>
									</td>
									<td class="text-right">
										<p> <b><?php echo number_format($paid,2) ?></b></p>

									<td class="text-right">
										<p> <b><?php echo number_format($balance,2) ?></b></p>
									</td>

									<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
									<td class="text-center">									
										<button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id'] ?>">View</button>
									<?php endif; ?>
									
										<?php if($_settings->userdata('type') == 1):?>
				                        <button class="btn btn-sm btn-outline-primary edit_fees" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_fees" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>										
									</td>
									<?php endif; ?>
								</tr>
								<?php endwhile; }
							 else{ ?>
									<?php if (isset($_SESSION['userdata']['sname']) && isset($_SESSION['userdata']['id_no'])) {
										$studentIdNo = $_SESSION['userdata']['id_no'];
										$studentName = $_SESSION['userdata']['sname'];
										// Handle cases for users with invalid login_type
										$fees = $conn->query("SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id WHERE s.name = '$studentName' AND s.id_no = '$studentIdNo' ORDER BY s.name ASC");
									
											

										if (!$fees) {
											// Query failed
											echo "Error: " . mysqli_error($conn);
										} else {					
											while($row=$fees->fetch_assoc()):
												$paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
												$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';
												$balance = $row['total_fee'] - $paid;
								?>
								<tr>
									
									<td>
										<p> <b><?php echo ucwords($row['sname']) ?></b></p>
									</td>
									<td class="text-right">
										<p> <b><?php echo number_format($row['total_fee'],2) ?></b></p>
									</td>
									<td class="text-right">
										<p> <b><?php echo number_format($paid,2) ?></b></p>

									<td class="text-right">
										<p> <b><?php echo number_format($balance,2) ?></b></p>
									</td>

									<td class="text-center">									
										<button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id'] ?>">View</button>
									</td>
								</tr>
								<?php endwhile; ?>
								<?php }}}?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
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
		max-height:150px; /* Removed the colon after 'max-height' */
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('.view_payment').click(function(){
		uni_modal("Payment Details","view_payment.php?ef_id="+$(this).attr('data-id')+"&pid=0","mid-large")
		
	})
	$('#new_fees').click(function(){
		uni_modal("Enroll Student ","manage_fee.php","mid-large")
		
	})
	$('.edit_fees').click(function(){
		uni_modal("Manage Student's Enrollment Details","manage_fee.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_fees').click(function(){
		_conf("Are you sure to delete this fees ?","delete_fees",[$(this).attr('data-id')])
	})
	
	function delete_fees($id){
		start_loader();
		$.ajax({
			url:"../classes/Master.php?f=delete_fees",
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
