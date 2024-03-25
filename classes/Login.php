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
		$stmt = $this->conn->prepare("SELECT * from users where username = ? and `type` = 1 ");
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$data = $result->fetch_array();
			if(password_verify($password, $data['password'])){
				foreach($data as $k => $v){
					if(!is_numeric($k) && $k != 'password'){
						$this->settings->set_userdata($k,$v);
					}
				}
				$this->settings->set_userdata('login_type',1);
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = 'Incorrect Username or Password';
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Incorrect Username or Password';
		}
		return json_encode($resp);
	}
	public function logout(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
	public function clogin(){
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from users where username = ? and `type` = 2 ");
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$data = $result->fetch_array();
			if(password_verify($password, $data['password'])){
				foreach($data as $k => $v){
					if(!is_numeric($k) && $k != 'password'){
						$this->settings->set_userdata($k,$v);
					}
				}
				$this->settings->set_userdata('login_type',1);
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = 'Incorrect Username or Password';
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Incorrect Username or Password';
		}
		return json_encode($resp);
	}
	public function clogout(){
		if($this->settings->sess_des()){
			redirect('club_admin/login.php');
		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login_user':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	case 'clogin_user':
		echo $auth->clogin();
		break;
	case 'clogout':
		echo $auth->clogout();
		break;
	default:
		echo $auth->index();
		break;
}

