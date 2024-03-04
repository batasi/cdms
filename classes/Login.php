<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}

	public function login(){
		extract($_POST);

		$qry_admin = $this->conn->query("SELECT * from users where username = '$username' and password = md5('$password')");
		if($qry_admin->num_rows > 0){
			$res = $qry_admin->fetch_array();
			if($res['status'] != 1){
				return json_encode(array('status'=>'notverified'));
			}
			foreach($res as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);

				}
			}
			$this->settings->set_userdata('login_type',1);
		return json_encode(array('status'=>'success'));
		}
		else{
		$qry_student = $this->conn->query("SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id WHERE ef_no = '$username' AND s.id_no = '$password'");
		if($qry_student->num_rows > 0){
			$res = $qry_student->fetch_array();
			
			foreach($res as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}
			}
			$this->settings->set_userdata('login_type',1);
		return json_encode(array('status'=>'success'));
		}
		
		}
		
			return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id WHERE ef_no = '$username' AND s.id_no = '$password'"));
		
	}
	public function clogin(){
		extract($_POST);
		$qry_student = $this->conn->query("SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id WHERE ef_no = '$username' AND s.id_no = '$password'");
		if($qry_student->num_rows > 0){
			$res = $qry_student->fetch_array();
			
			foreach($res as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}
			}
			$this->settings->set_userdata('login_type',1);
		return json_encode(array('status'=>'success'));
		}
		else{
			return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id WHERE ef_no = '$username' AND s.id_no = '$password'"));
		}
	}
	public function logout(){
		if($this->settings->sess_des()){
			header("location: ..//..//../admin/login.php");
		}
	}
	
	public function clogout(){
		if($this->settings->sess_des()){
			header("location: ..//..//../admin/login.php");

		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
    case 'login':
		echo $auth->login();
		break;
	case 'clogin':
		echo $auth->clogin();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	case 'clogout':
		echo $auth->clogout();
		break;
	default:
		echo $auth->index();
		break;
}

