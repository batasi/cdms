<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_package(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k, array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			// Add 'level' field with NULL value if not provided
			if (!isset($_POST['level'])) {
				$data .= ", `level` = NULL"; // Assuming 'level' field allows NULL values
			}
			$sql = "INSERT INTO `courses` SET {$data}";
		} else {
			// Construct the UPDATE query properly with SET and WHERE clauses
			$sql = "UPDATE `courses` SET {$data} WHERE id = '{$id}' ";
		}
		// Rest of the code...
	
		$check = $this->conn->query("SELECT * FROM `courses` where `course`='{$course}' ".($id > 0 ? " and id != '{$id}'" : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Package Name Already Exists.";
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Package details successfully added.";
				else
					$resp['msg'] = "Package details has been updated successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	
	}
	function delete_package(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `courses` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Package has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_enrollment(){
		if(empty($_POST['id'])){
			$pref= date("Ym");
			$code = sprintf("%'.04d",1);
			while(true){
				$check = $this->conn->query("SELECT * FROM `enrollee_list` where reg_no = '{$pref}{$code}'")->num_rows;
				if($check > 0){
					$code = sprintf("%'.04d",abs($code)+1);
				}else{
					break;
				}
			}
			$_POST['reg_no'] = $pref.$code;
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k])){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `enrollee_list` set {$data} ";
		}else{
			$sql = "UPDATE `enrollee_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$aid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id)){
				$resp['reg_no'] = $reg_no;
			}
			if(empty($id))
				$resp['msg'] = "Enrollment was successfully submitted";
			else
				$resp['msg'] = "Enrollee details was updated successfully.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_enrollment(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `enrollee_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Enrollee Records has deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `enrollee_list` SET `status` = '$status' WHERE id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			// Check if the status is 'verified'
			if ($status == 1) {
				// Fetch the enrollee details
				$enrolleeResult = $this->conn->query("SELECT * FROM `enrollee_list` WHERE id = '{$id}'");
				if ($enrolleeResult->num_rows > 0) {
					$enrollee = $enrolleeResult->fetch_assoc();
					// Insert data into the student table
					$id_no = $enrollee['dob'];
					$name = $enrollee['firstname'] . ' ' . $enrollee['middlename'] . ' ' . $enrollee['lastname'];
					$contact = $enrollee['contact'];
					$address = $enrollee['address'];
					$email = $enrollee['email'];
					$date_created = date('Y-m-d H:i:s'); // You can use the current date and time
					$type = '3'; // Assuming this is the type for verified students
					
					// Insert the data into the student table
					$insertSql = "INSERT INTO student (id_no, name, contact, address, email, date_created, type) VALUES ('$id_no', '$name', '$contact', '$address', '$email', '$date_created', '$type')";
					$insertResult = $this->conn->query($insertSql);
					if ($insertResult) {
						$resp['msg'] = "Enrollment Details has been updated and added to the student table.";
					} else {
						$resp['msg'] = "Enrollment Details has been updated, but there was an error adding data to the student table.";
						$resp['error'] = $this->conn->error;
					}
				} else {
					$resp['msg'] = "Enrollment Details has been updated, but the enrollee data could not be retrieved.";
					$resp['error'] = "Enrollee with ID {$id} not found.";
				}
			} else {
				$resp['msg'] = "Enrollment Details has been updated.";
			}
			$this->settings->set_flashdata('success', $resp['msg']);
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_payment(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `payments` set {$data} ";
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				$resp['msg'] = "Payment details was added successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		else{
			$sql = "UPDATE payments set {$data} where id = $id";
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				$resp['msg'] = "Payment details was Edited successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_payment(){
		
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `payments` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Payment has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	
	function save_fees(){
		extract($_POST);
		// Check if EF number already exists
		$ef_check_query = $this->conn->query("SELECT * FROM student_ef_list WHERE ef_no = '$ef_no'");
		if ($ef_check_query->num_rows > 0 && (empty($id) || $ef_check_query->fetch_assoc()['id'] != $id)) {
			// EF number already exists, return error response
			$resp['status'] = 'failed';
			$resp['msg'] = 'Reg number already exists. Please use a different Reg number.';
			return json_encode($resp);
		}
		
	
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
				$_POST['type'] = 3;
			}
		}
		
		if(empty($id)){
			$sql = "INSERT INTO `student_ef_list` set {$data} ";
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				$resp['msg'] = "Fees details was added successfully.";
			$_POST['type'] = 3;

			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occurred.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		else{
			$sql = "UPDATE student_ef_list set {$data} where id = $id";
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				$resp['msg'] = "Fees details was edited successfully.";
			$_POST['type'] = 3;

			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occurred.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		$_POST['type'] = 3;
		return json_encode($resp);
	}
	
	function delete_fees(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `student_ef_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Fees has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_expenses(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `expenses` set {$data} ";
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				$resp['msg'] = "Expenditure details was added successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		else{
			$sql = "UPDATE expenses set {$data} where id = $id";
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				$resp['msg'] = "Expenditure details was Edited successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_expenses(){
		
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `expenses` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Expenditure has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_student(){
		extract($_POST);
		// Check if student already exists
		$ef_check_query = $this->conn->query("SELECT * FROM student where id_no ='$id_no' ".(!empty($id) ? " and id != {$id} " : ''));
		if ($ef_check_query->num_rows > 0 && (empty($id) || $ef_check_query->fetch_assoc()['id'] != $id)) {
			// EF number already exists, return error response
			$resp['status'] = 'failed';
			$resp['msg'] = 'Id number already exists. Please use a different ID number.';
			return json_encode($resp);
		}
	
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			$_POST['type'] = 3;

			}
		}
		
		if(empty($id)){
			$sql = "INSERT INTO `student` set {$data} ";
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$_POST['type'] = 3;

				$resp['status'] = 'success';
				$resp['msg'] = "Student details was added successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occurred.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		else{
			$sql = "UPDATE student set {$data} where id = $id";
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$_POST['type'] = 3;

				$resp['status'] = 'success';
				$resp['msg'] = "Student details was edited successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occurred.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		$_POST['type'] = 3;
		return json_encode($resp);
	}
	function delete_student(){
		
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `student` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Student has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_download(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$amount = isset($amount) && is_numeric($amount) ? intval($amount) : 0;
			$sql = "UPDATE ticket_downloads set download_count='{$amount}' where student_id = $id_no";
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				$resp['msg'] = "Expenditure details was Edited successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	
	
	
}


$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();

switch ($action) {
	case 'save_package':
		echo $Master->save_package();
	break;
	case 'save_fees':
		echo $Master->save_fees();
	break;
	case 'delete_fees':
		echo $Master->delete_fees();
	break;
	case 'delete_package':
		echo $Master->delete_package();
	break;
	case 'save_enrollment':
		echo $Master->save_enrollment();
	break;
	case 'delete_enrollment':
		echo $Master->delete_enrollment();
	break;
	case 'update_status':
		echo $Master->update_status();
	break;
	case 'save_payment':
		echo $Master->save_payment();
	break;
	case 'delete_payment':
		echo $Master->delete_payment();
	break;
	case 'save_expenses':
		echo $Master->save_expenses();
	break;
	case 'delete_expenses':
		echo $Master->delete_expenses();
	break;
	case 'save_student':
		echo $Master->save_student();
	break;
	case 'delete_student':
		echo $Master->delete_student();
	break;
	case 'save_download':
		echo $Master->save_download();
	break;
	default:
		// echo $sysset->index();
		break;
}