<?php
	 require_once('../config.php'); 


	// Fetch student_ef_list data
	$fees = $conn->query("SELECT ef.*, s.name as sname, s.id_no, concat(c.course, ' - ', c.level) as `class` FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id INNER JOIN courses c ON c.id = ef.course_id WHERE ef.id = {$_GET['ef_id']}");

	if ($row = $fees->fetch_assoc()) {
		foreach ($row as $k => $v) {
			$$k = $v;
		}
	}

	// Fetch payments data using prepared statement
	$ef_id = $_GET['ef_id'];
	$paymentsStmt = $conn->prepare("SELECT * FROM payments WHERE ef_id = ?");
	$paymentsStmt->bind_param("i", $ef_id);
	$paymentsStmt->execute();
	$paymentsResult = $paymentsStmt->get_result();

	$pay_arr = array();
	while ($row = $paymentsResult->fetch_assoc()) {
		$pay_arr[$row['id']] = $row;
	}

	// Function to fetch ef_no
	function fetchEfNo($ef_id) {
		global $conn;
		$efNoStmt = $conn->prepare("SELECT ef_no FROM student_ef_list WHERE id = ?");
		$efNoStmt->bind_param("i", $ef_id);
		$efNoStmt->execute();
		$efNoResult = $efNoStmt->get_result();
		$efNoData = $efNoResult->fetch_assoc();
		return isset($efNoData['ef_no']) ? $efNoData['ef_no'] : '';
	}

	// Function to fetch sname
	function fetchSname($ef_id) {
		global $conn;
		$snameStmt = $conn->prepare("SELECT s.name FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id WHERE ef.id = ?");
		$snameStmt->bind_param("i", $ef_id);
		$snameStmt->execute();
		$snameResult = $snameStmt->get_result();
		$snameData = $snameResult->fetch_assoc();
		return isset($snameData['name']) ? $snameData['name'] : '';
	}

	// Function to fetch class
	function fetchClass($ef_id) {
		global $conn;
		$classStmt = $conn->prepare("SELECT concat(c.course, ' - ', c.level) as class FROM student_ef_list ef INNER JOIN courses c ON c.id = ef.course_id WHERE ef.id = ?");
		$classStmt->bind_param("i", $ef_id);
		$classStmt->execute();
		$classResult = $classStmt->get_result();
		$classData = $classResult->fetch_assoc();
		return isset($classData['class']) ? $classData['class'] : '';
	}
?>

	<div class="container-fluid">
		<div style="text-align: center;">
			<img src="<?= validate_image($_settings->info('logo')) ?>" alt="" style="margin-right: 10px; border-radius: 50%;" >
			<p class="text-center" style="font-size:24px;"><b><?= $_settings->info('short_name') ?> </b></p>
			<p class="text-center" Style="color:red;"><b>CONTACT: <?= $_settings->info('contact') ?></b></p>
			<p class="text-center" Style="color:red;"><b>EMAIL: <?= $_settings->info('email') ?></b></p>
			<p class="text-center" Style="color:red;"><b>www.pacedrivingschool.ac.ke</b></p>
			<p class="text-center" Style="color:red;"><b>OFFICIAL RECEIPT</b></p>
		<hr>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md">
						<p>EF./ADM. No: <b><?php echo isset($ef_no) ? $ef_no : fetchEfNo($ef_id); ?></b></p>
						<p>Student: <b><?php echo isset($sname) ? ucwords($sname) : fetchSname($ef_id); ?></b></p>
						<p>Course/Level: <b><?php echo isset($class) ? $class : fetchClass($ef_id); ?></b></p>
						<?php if ($_GET['pid'] > 0): ?>
						<p>Payment Date: <b><?php echo isset($pay_arr[$_GET['pid']]) ? date("M d, Y", strtotime($pay_arr[$_GET['pid']]['date_created'])) : ''; ?></b></p>
						<p>Paid Amount: <b><?php echo isset($pay_arr[$_GET['pid']]) ? number_format($pay_arr[$_GET['pid']]['amount'], 2) : ''; ?></b></p>
						<p>Remarks: <b><?php echo isset($pay_arr[$_GET['pid']]) ? $pay_arr[$_GET['pid']]['remarks'] : ''; ?></b></p>
					</div>
				<?php endif; ?>			
			</div>
		</div>
		<hr>
		<div class="col-md-6">					
			<?php
				$efNoStmt = $conn->prepare("SELECT ef_no, course_id FROM student_ef_list WHERE id = ?");
				$efNoStmt->bind_param("i", $ef_id);
				$efNoStmt->execute();
				$efNoResult = $efNoStmt->get_result();
				
				if ($efNoData = $efNoResult->fetch_assoc()) {
					$ef_no = $efNoData['ef_no'];
					$course_id = $efNoData['course_id'];
				
					// Now you can use $ef_no and $course_id in your main query
					$feesStmt = $conn->prepare("SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id WHERE ef.course_id = ?");
					$feesStmt->bind_param("i", $course_id); // Assuming course_id is an integer, adjust accordingly
					$feesStmt->execute();
					$feesResult = $feesStmt->get_result();
				
					while ($row = $feesResult->fetch_assoc()) {
					
					// $paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id'].(isset($id) ? " and id!=$id " : ''));
					// $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';
					$ftotal = $row['total_fee'] ;}}
					

					$cfees = $conn->query("SELECT * FROM fees where course_id = ''");
					while ($row = $cfees->fetch_assoc()) {
					$ftotal += $row['amount'];			
				}
			?>					
			<p><b>Payment Details</b></p>
						<table >
							<tr>
								<td width="50%"><b>Date</b></td>
								<td width="50%" class='text-right'><b>Amount</b></td>
							</tr>
							<?php 
								$ptotal = 0;
								foreach ($pay_arr as $row) {
									if($row["id"] <= $_GET['pid'] || $_GET['pid'] == 0){
									$ptotal += $row['amount'];
							?>
							<tr>
								<td><?php echo date("Y-m-d",strtotime($row['date_created'])) ?> </td>
								<td class='text-right'><b> <?php echo number_format($row['amount']) ?></b></td>
								
								<?php
								}
								}
								
							?>
							</tr>
							
							<tr>
							<td><b>Total Paid</b></td>
							<td class='text-right'><b><?php echo number_format($ptotal) ?></b></td>
							</tr>
						</table>
						<hr>
						<table >
							<tr>
								<td><b>Total Payable Fee</b></td>
								<td class='text-right'><b><?php echo number_format($ftotal) ?></b></td>
							</tr>
							<tr>
								<td><b>Total Paid</b></td>
								<td class='text-right'><b><?php echo number_format($ptotal) ?></b></td>
							</tr>
							<tr>
								<td><b>Balance</b></td>
								<td class='text-right'><b><?php echo number_format($ftotal-$ptotal) ?></b></td>
							</tr>
						</table>
					</td>			
				</tr>
			</table>
		</div>
    </div>

