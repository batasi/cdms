<div class="container-fluid py-1">
<?php 
include ('../config.php');
 

    $studentIdNo =$_GET['id_no'];
    $studentName =$_GET['sname'];

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
        $day_fee = $total_fee / 21;

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
            echo "The learner needs pay the remaining fees to download the ticket.";
        }
    }

?>

</div>
<div class="modal-footer row display py-1">
		<div class="col-lg-12">
			<button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Close</button>
			<button class="btn float-right btn-success mr-2" type="button" id="print">Print</button>
		</div>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: block
	}
	.border-gradien-alert{
		border-image: linear-gradient(to right, red , yellow) !important;
	}
	.border-alert th, 
	.border-alert td {
	  animation: blink 200ms infinite alternate;
	}

	@keyframes blink {
	  from {
	    border-color: white;
	  }
	  to {
	    border-color: red;
		background: #ff00002b;
	  }
	}
</style>
<script>
$(document).ready(function(){
    $('.table td,.table th').addClass('py-1 px-2 align-middle');

    // Function to print ticket
    function printTicket() {
        var ao = ""; // Your additional data here

        // Append additional data to the HTML content
        var printContents = $('#outprint').html(); // Get the HTML content of the table
        var additionalContent = "<div class='mx-5 py-4'><h1 class='text-center'><?= $_settings->info("name") ?></h1>" +
                                "<h5 class='text-center'>Ticket Information" + ao + "</h5></div>";

        var originalContents = document.body.innerHTML; // Store the original HTML content of the page
        document.body.innerHTML = additionalContent + printContents; // Append additional content before the table

        window.print(); // Print the content

        // Hide the inner HTML after printing
        $('#outprint').hide();
    }

    // Function to attach event listeners
    function attachEventListeners() {
        $('#print').click(printTicket); // Attach event listener for printing
    }

    attachEventListeners(); // Attach event listeners initially
});

</script>

