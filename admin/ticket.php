<style>
    .img{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
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
<?php

if (isset($_SESSION['userdata']['sname']) && isset($_SESSION['userdata']['id_no'])) {
    $studentIdNo = $_SESSION['userdata']['id_no'];
    $studentName = $_SESSION['userdata']['sname'];

    // Query to retrieve the fee details of the logged-in student
    $fees_query = $conn->query("SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id WHERE s.name = '$studentName' AND s.id_no = '$studentIdNo' ORDER BY s.name ASC");

    if (!$fees_query) {
        // Query failed
        echo "Error: " . mysqli_error($conn);
    } else {
        // Fetch fee details
        $row = $fees_query->fetch_assoc();
        $total_fee = $row['total_fee']; // Total fee of the student

        // Calculate daily fee
        $day_fee = $total_fee / 30;

        // Query to retrieve the total amount paid by the student for the specific enrollment fee
        $paid_query = $conn->query("SELECT SUM(amount) AS total_paid FROM payments WHERE ef_id = {$row['id']}");
        $paid_row = $paid_query->fetch_assoc();
        $paid_amount = $paid_row['total_paid']; // Total amount paid by the student for the enrollment fee

        // Check if the student has paid their fees
        $count_query = $conn->query("SELECT SUM(download_count) AS total_downloads FROM ticket_downloads WHERE student_id = '$studentIdNo'");
        $count_row = $count_query->fetch_assoc();
        $total_downloads = $count_row['total_downloads'];

        if ($paid_amount >= ($day_fee * ($total_downloads + 1))) {
            $today = date('Y-m-d');
            $download_query = $conn->query("SELECT * FROM ticket_downloads WHERE student_id = '$studentIdNo'");
            $download_row = $download_query->fetch_assoc();
            if ($download_row) {
                $last_download_date = $download_row['download_date'];
                if ($last_download_date < $today) {
                    // Proceed with ticket download process
                    // Update ticket download history
                    $conn->query("UPDATE ticket_downloads SET download_count = download_count + 1, download_date = '$today' WHERE student_id = '$studentIdNo'");
                   
                    
                    $updated_count_query = $conn->query("SELECT download_count FROM ticket_downloads WHERE student_id = '$studentIdNo'");
                    $updated_count_row = $updated_count_query->fetch_assoc();
                    $download_count = $updated_count_row['download_count'];?>
                    <div class="card card-outline card-primary"> 
                    <div class="card-header">
                        <h3 class="card-title">Ticket Information</h3><br>
                
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="" id="filter-data">
                                <div class="row align-items-end">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <div class="row justify-content-center pt-4">
                
                                    </div>
                                    </div>
                                    </div>		
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button class="btn btn-success btn-flat" type="button" id="downloadBtn"><i class="fa fa-download"></i> Download</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <div id="outprint">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Download Date</th>
                                    <td><?php echo date('Y-m-d') ?></td>
                                </tr>
                                <tr>
                                    <th>Reg. No</th>
                                    <td><?php echo ($row['ef_no']) ?></td>
                                </tr>
                                <tr>
                                    <th>Fullname</th>
                                    <td><?php echo ucwords($row['sname']) ?></td>
                                </tr>
                                <tr>
                                    <th>Remarks</th>
                                    <td><?php echo "Proceed to lesson no ".$download_count ?></td>
                                </tr>
                            </tbody>
                        </table>

                            <p style="color:blue;">Please download the ticket</p>

                        </div>
                        </div>
                    </div>
                </div> <?php
                } else {
                    // Student has already downloaded a ticket today
                
                    $updated_count_query = $conn->query("SELECT download_count FROM ticket_downloads WHERE student_id = '$studentIdNo'");
                    $updated_count_row = $updated_count_query->fetch_assoc();
                    $download_count = $updated_count_row['download_count']; ?>
                    <div class="card card-outline card-primary"> 
                    <div class="card-header">
                        <h3 class="card-title">Ticket Information</h3><br>
                
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="" id="filter-data">
                                <div class="row align-items-end">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <div class="row justify-content-center pt-4">
                
                                    </div>
                                    </div>
                                    </div>		
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button class="btn btn-success btn-flat" type="button" id="print"><i class="fa fa-download"></i> Download</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <div id="outprint">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Download Date</th>
                                    <td><?php echo date('Y-m-d') ?></td>
                                </tr>
                                <tr>
                                    <th>Reg. No</th>
                                    <td><?php echo ($row['ef_no']) ?></td>
                                </tr>
                                <tr>
                                    <th>Fullname</th>
                                    <td><?php echo ucwords($row['sname']) ?></td>
                                </tr>
                                <tr>
                                    <th>Remarks</th>
                                    <td><?php echo "Proceed to lesson no ".$download_count ?></td>
                                </tr>
                            </tbody>
                        </table>

                            <p style="color:blue;">You have already downloaded the ticket</p>
                        </div>
                        </div>
                    </div>
                </div> <?php

                }
            } else {
                // No previous downloads, insert a new record
                $conn->query("INSERT INTO ticket_downloads set student_id = '$studentIdNo', download_date='$today', download_count= 1");
                    
                    $updated_count_query = $conn->query("SELECT download_count FROM ticket_downloads WHERE student_id = '$studentIdNo'");
                    $updated_count_row = $updated_count_query->fetch_assoc();
                    $download_count = $updated_count_row['download_count']; ?>
                    <div class="card card-outline card-primary"> 
                    <div class="card-header">
                        <h3 class="card-title">Ticket Information</h3><br>
                
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="" id="filter-data">
                                <div class="row align-items-end">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <div class="row justify-content-center pt-4">
                
                                    </div>
                                    </div>
                                    </div>		
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button download class="btn btn-success btn-flat" type="button" id="print"><i class="fa fa-download"></i> Download</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <div id="outprint">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <th>Download Date</th>
                                    <td><?php echo date('Y-m-d') ?></td>
                                </tr>
                                <tr>
                                    <th>Reg. No</th>
                                    <td><?php echo ($row['ef_no']) ?></td>
                                </tr>
                                <tr>
                                    <th>Fullname</th>
                                    <td><?php echo ucwords($row['sname']) ?></td>
                                </tr>
                                <tr>
                                    <th>Remarks</th>
                                    <td><?php echo "Proceed to lesson no ".$download_count ?></td>
                                </tr>
                            </tbody>
                        </table>

                        </div>
                        </div>
                    </div>
                </div> <?php
            }
        } else {
            // Display a message indicating that the student needs to pay the remaining fees
            echo "You need to pay the remaining fees to download the ticket.";
        }
    }
} 
else {
  

 if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>
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
						<b>Download Ticket </b>

					
						
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Date</th>
									<th class="">ID No.</th>
									<th class="">ADM No.</th>
									
									<th class="">Name</th>
									

									<th class="text-center">Action</th>

								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$isAdmin = 	($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2);

								if ($isAdmin) {
                                     $fees_query = $conn->query("SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id  ORDER BY ef_no DESC");
								
									if($fees_query->num_rows > 0):
										while($row=$fees_query->fetch_assoc()):
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
									

									<td class="text-center">							
                                        <button  class="btn btn-sm btn-outline-primary view_download" type="button" data-id="<?php echo $row['id_no']; ?>" data-name="<?php echo $row['sname']; ?>">Print</button>
                                        <button class="btn btn-sm btn-outline-danger edit_download" type="button" data-id="<?php echo $row['id_no'] ?>">Edit</button>
                                    </td>
								</tr>
								<?php endwhile; ?>
									<?php endif;}  ?>

								
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 
<?php endif;}  ?>




<script>
    $('.edit_download').click(function(){
		uni_modal("Edit No of Lessons(Ticket)","manage_download.php?id_no="+$(this).attr('data-id'),"mid-large")
		
	})
	$(document).ready(function(){
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('#print').click(function(){
            var _h = $("head").clone()
            var _p = $('#outprint').clone()
            var el = $("<div>")
            $('script').each(function(){
                if(_h.find('script[src="'+$(this).attr('src')+'"]').length <= 0){
                    _h.append($(this).clone())
                }
            })
			var ao = "";
			
            _h.find('title').text("Payment Report - Print View")
            _p.prepend("<hr class='border-navy bg-navy'>")
            _p.prepend("<img src='<?= validate_image($_settings->info('logo')) ?>' id='print-logo' />")
            
            el.append(_h)
            el.append(_p)

            
               
        })
	})

	$(document).ready(function(){
		$('table').dataTable()
	})
	
	
	$('.view_download').click(function(){
    uni_modal("Ticket Details","view_download.php?id_no="+$(this).attr('data-id')+"&sname="+$(this).attr('data-name'),"mid-large")
})

	
	

</script>


