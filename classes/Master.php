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
	function save_club(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,['id','content'])){
				$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .= ", ";
				$data .= "`{$k}` = '{$v}'";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `club_list` set {$data}";
		}else{
			$sql = "UPDATE `club_list` set {$data} where id = '{$id}'";
		}
		$save = $this->conn->query($sql);
		if($save){
			$cid= empty($id) ? $this->conn->insert_id : $id ;
			$resp['status'] = 'success';
			$resp['cid'] = $cid;
			if(isset($content)){
				file_put_contents(base_app."/club_contents/{$cid}.html",$content);
			$err = "";
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				if(!is_dir(base_app."uploads/club-logos"))
					mkdir(base_app."uploads/club-logos");
				$fname = 'uploads/club-logos/'.$cid.'.png';
				$dir_path =base_app. $fname;
				$upload = $_FILES['img']['tmp_name'];
				$type = mime_content_type($upload);
				$allowed = array('image/png','image/jpeg');
				if(!in_array($type,$allowed)){
					$err.=" But Image failed to upload due to invalid file type.";
				}else{
					$new_height = 200; 
					$new_width = 200; 
			
					list($width, $height) = getimagesize($upload);
					$t_image = imagecreatetruecolor($new_width, $new_height);
					imagealphablending( $t_image, false );
					imagesavealpha( $t_image, true );
					$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
					imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					if($gdImg){
							if(is_file($dir_path))
							unlink($dir_path);
							$uploaded_img = imagepng($t_image,$dir_path);
							if(isset($uploaded_img)){
								$this->conn->query("UPDATE club_list set `logo_path` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$cid}' ");
							}
							imagedestroy($gdImg);
							imagedestroy($t_image);
					}else{
					$err.=" But Image failed to upload due to unknown reason.";
					}
				}
			}
			if(empty($id))
				$this->settings->set_flashdata('success',"Club has been added successfully. ".$err);
			else
				$this->settings->set_flashdata('success',"Club has been updated. ".$err);
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Saving club failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_club(){
		extract($_POST);
		$delete = $this->conn->query("UPDATE `club_list` set delete_flag = 1 where id = '{$id}' ");
		if($delete){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Club has been deleted successfully");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;

		}
		return json_encode($resp);
	}
	function dt_clubs(){
		extract($_POST);
 
		$totalCount = $this->conn->query("SELECT * FROM `club_list` where  delete_flag = 0 ")->num_rows;
		$search_where = "";
		if(!empty($search['value'])){
			$search_where .= "name LIKE '%{$search['value']}%' ";
			$search_where .= " OR description LIKE '%{$search['value']}%' ";
			$search_where .= " OR date_format(date_updated,'%M %d, %Y') LIKE '%{$search['value']}%' ";
			$search_where = " and ({$search_where}) ";
		}
		$columns_arr = array("unix_timestamp(date_updated)",
							"unix_timestamp(date_updated)",
							"name",
							"description",
							"status",
							"unix_timestamp(birthdate)");
		$query = $this->conn->query("SELECT * FROM `club_list`  where  delete_flag = 0  {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
		$recordsFilterCount = $this->conn->query("SELECT * FROM `club_list`  where  delete_flag = 0  {$search_where} ")->num_rows;
		
		$recordsTotal= $totalCount;
		$recordsFiltered= $recordsFilterCount;
		$data = array();
		$i= 1 + $start;
		while($row = $query->fetch_assoc()){
			$row['no'] = $i++;
			$row['date_updated'] = date("F d, Y H:i",strtotime($row['date_updated']));
			$data[] = $row;
		}
		echo json_encode(array('draw'=>$draw,
							'recordsTotal'=>$recordsTotal,
							'recordsFiltered'=>$recordsFiltered,
							'data'=>$data
							)
		);
	}
	function save_user(){
		if(empty($_POST['id'])){
			$_POST['password'] = password_hash(strtolower(substr($_POST['firstname'],0 ,1).$_POST['lastname']), PASSWORD_DEFAULT);
		}
		if(isset($_POST['reset_password'])){
			$get=$this->conn->query("SELECT * FROM `users` where id = '{$_POST['id']}'")->fetch_array();
			$_POST['password'] = password_hash(strtolower(substr($get['firstname'],0 ,1).$get['lastname']), PASSWORD_DEFAULT);
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,['id','reset_password']) && !is_array($_POST[$k])){
				$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .= ", ";
				$data .= "`{$k}` = '{$v}'";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `users` set {$data}";
		}else{
			$sql = "UPDATE `users` set {$data} where id = '{$id}'";
		}
		$save = $this->conn->query($sql);
		if($save){
			$uid= empty($id) ? $this->conn->insert_id : $id ;
			$resp['uid'] = $uid;
			$err = "";
			$resp['status'] = 'success';
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				if(!is_dir(base_app."uploads/users"))
					mkdir(base_app."uploads/users");
				$fname = 'uploads/users/avatar-'.$uid.'.png';
				$dir_path =base_app. $fname;
				$upload = $_FILES['img']['tmp_name'];
				$type = mime_content_type($upload);
				$allowed = array('image/png','image/jpeg');
				if(!in_array($type,$allowed)){
					$err.=" But Image failed to upload due to invalid file type.";
				}else{
					$new_height = 200; 
					$new_width = 200; 
			
					list($width, $height) = getimagesize($upload);
					$t_image = imagecreatetruecolor($new_width, $new_height);
					imagealphablending( $t_image, false );
					imagesavealpha( $t_image, true );
					$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
					imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					if($gdImg){
							if(is_file($dir_path))
							unlink($dir_path);
							$uploaded_img = imagepng($t_image,$dir_path);
							if(isset($uploaded_img)){
								$this->conn->query("UPDATE users set `avatar` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$uid}' ");
							}
							imagedestroy($gdImg);
							imagedestroy($t_image);
					}else{
					$err.=" But Image failed to upload due to unknown reason.";
					}
				}
			}
			if(empty($id))
				$this->settings->set_flashdata('success',"User has been added successfully.");
			else
				$this->settings->set_flashdata('success',"User has been updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Saving User failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_user(){
		extract($_POST);
		$get = $this->conn->query("SELECT * `users` where id = '{$id}' ")->fetch_array();
		$delete = $this->conn->query("UPDATE `users` where id = '{$id}' ");
		if($delete){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," User has been deleted successfully");
			if(isset($get['avatar'])){
				$get['avatar'] = explode("?",$get['avatar'])[0];
				if(is_file(base_app.$get['avatar']))
				unlink(base_app.$get['avatar']);
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;

		}
		return json_encode($resp);
	}
	function dt_users(){
		extract($_POST);
		$totalCount = $this->conn->query("SELECT * FROM `users` where id != '{$this->settings->userdata('id')}' ")->num_rows;
		$search_where = "";
		$columns_arr = array("unix_timestamp(date_updated)",
							"unix_timestamp(date_updated)",
							"CONCAT(lastname, ', ',firstname,' ',COALESCE(middlename,''))",
							"status",
							"unix_timestamp(birthdate)");
		if(!empty($search['value'])){
			$search_where .= "firstname LIKE '%{$search['value']}%' ";
			$search_where .= " OR lastname LIKE '%{$search['value']}%' ";
			$search_where .= " OR middlename LIKE '%{$search['value']}%' ";
			$search_where .= " OR CONCAT(lastname, ', ',firstname,' ',COALESCE(middlename,'')) LIKE '%{$search['value']}%' ";
			$search_where .= " OR CONCAT(firstname,' ',COALESCE(middlename,''), ' ', lastname) LIKE '%{$search['value']}%' ";
			$search_where .= " OR date_format(date_updated,'%M %d, %Y') LIKE '%{$search['value']}%' or club_id in (SELECT id FROM club_list where name LIKE '%{$search['value']}%' ) ";
			$search_where = " and ({$search_where}) ";
		}
		$query = $this->conn->query("SELECT *,CONCAT(lastname, ', ',firstname,' ',COALESCE(middlename,'')) as `name` FROM `users`  where id != '{$this->settings->userdata('id')}'  {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
		$query2 = $this->conn->query("SELECT * FROM `users`  where id != '{$this->settings->userdata('id')}'  {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
		$recordsFilterCount = $this->conn->query("SELECT * FROM `users`  where id != '{$this->settings->userdata('id')}'  {$search_where} ")->num_rows;
		
		$recordsTotal= $totalCount;
		$recordsFiltered= $recordsFilterCount;
		$data = array();
		$i= 1 + $start;
		$club_arr = [];
		$cids = array_column($query2->fetch_all(MYSQLI_ASSOC),'club_id');
		if(count($cids) > 0){
			$clubs = $this->conn->query("SELECT `name` as club,id FROM club_list where id in (".(implode(",",$cids)).")")->fetch_all(MYSQLI_ASSOC);
			$club_arr = array_column($clubs,'club','id');
		}
		while($row = $query->fetch_assoc()){
			$row['no'] = $i++;
			$row['club'] = isset($club_arr[$row['club_id']]) ? $club_arr[$row['club_id']] : "N/A";
			$row['date_updated'] = date("F d, Y H:i",strtotime($row['date_updated']));
			$data[] = $row;
		}
		echo json_encode(array('draw'=>$draw,
							'recordsTotal'=>$recordsTotal,
							'recordsFiltered'=>$recordsFiltered,
							'data'=>$data
							)
		);
	}
	function save_application(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k,['id','content'])){
				$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .= ", ";
				$data .= "`{$k}` = '{$v}'";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `application_list` set {$data}";
		}else{
			$sql = "UPDATE `application_list` set {$data} where id = '{$id}'";
		}
		$save = $this->conn->query($sql);
		if($save){
			$cid= empty($id) ? $this->conn->insert_id : $id ;
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"Your application has been submitted successfully. The Club's Admin/Staff will contact you using your given contact information regarding to your application. Thank you! ");
			else
				$this->settings->set_flashdata('success',"Application has been updated. ");
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Saving Application failed';
			$resp['error'] = $this->conn->error;
			$resp['sql'] = $sql;
		}
		return json_encode($resp);
	}
	function delete_application(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `application_list` where id = '{$id}' ");
		if($delete){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Application has been deleted successfully");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;

		}
		return json_encode($resp);
	}
	function dt_applications(){
		extract($_POST);
 
		$totalCount = $this->conn->query("SELECT * FROM `application_list`")->num_rows;
		$search_where = "";
		if(!empty($search['value'])){
			$search_where .= " where CONCAT(a.lastname,', ',a.firstname,' ', COALESCE(a.middlename,'')) LIKE '%{$search['value']}%' ";
			$search_where .= " OR a.year_level LIKE '%{$search['value']}%' ";
			$search_where .= " OR a.section LIKE '%{$search['value']}%' ";
			if($this->settings->userdata('type') == 1)
			$search_where .= " OR c.name LIKE '%{$search['value']}%' ";
			$search_where .= " OR a.date_format(date_updated,'%M %d, %Y') LIKE '%{$search['value']}%' ";
			// $search_where = " ({$search_where}) ";
		}
		$columns_arr = array("unix_timestamp(a.date_updated)",
							"unix_timestamp(a.date_updated)",
							"CONCAT(lastname,', ',firstname,' ', COALESCE(middlename,''))",
							"CONCAT(a.year_level, ' - ',a.section)",
							"c.name",
							"a.status");
		$query = $this->conn->query("SELECT a.*, CONCAT(a.lastname,', ',a.firstname,' ', COALESCE(a.middlename,'')) as `name`, CONCAT(a.year_level,' - ',a.section) as `class`, c.name as club FROM `application_list` a inner join club_list c on a.club_id = c.id  {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
		$recordsFilterCount = $this->conn->query("SELECT a.* FROM `application_list` a inner join club_list c on a.club_id = c.id  {$search_where} ")->num_rows;
		
		$recordsTotal= $totalCount;
		$recordsFiltered= $recordsFilterCount;
		$data = array();
		$i= 1 + $start;
		while($row = $query->fetch_assoc()){
			$row['no'] = $i++;
			$row['date_updated'] = date("F d, Y H:i",strtotime($row['date_updated']));
			$data[] = $row;
		}
		echo json_encode(array('draw'=>$draw,
							'recordsTotal'=>$recordsTotal,
							'recordsFiltered'=>$recordsFiltered,
							'data'=>$data
							)
		);
	}
	function dt_club_applications(){
		extract($_POST);
 
		$totalCount = $this->conn->query("SELECT * FROM `application_list` where club_id = '{$this->settings->userdata('club_id')}'")->num_rows;
		$search_where = "";
		if(!empty($search['value'])){
			$search_where .= "CONCAT(a.lastname,', ',a.firstname,' ', COALESCE(a.middlename,'')) LIKE '%{$search['value']}%' ";
			$search_where .= " OR a.year_level LIKE '%{$search['value']}%' ";
			$search_where .= " OR a.section LIKE '%{$search['value']}%' ";
			$search_where .= " OR a.date_format(date_updated,'%M %d, %Y') LIKE '%{$search['value']}%' ";
			$search_where = " and ({$search_where}) ";
		}
		$columns_arr = array("unix_timestamp(a.date_updated)",
							"unix_timestamp(a.date_updated)",
							"CONCAT(lastname,', ',firstname,' ', COALESCE(middlename,''))",
							"CONCAT(a.year_level, ' - ',a.section)",
							"a.status");
		$query = $this->conn->query("SELECT a.*, CONCAT(a.lastname,', ',a.firstname,' ', COALESCE(a.middlename,'')) as `name`, CONCAT(a.year_level,' - ',a.section) as `class`, c.name as club FROM `application_list` a inner join club_list c on a.club_id = c.id where a.club_id = '{$this->settings->userdata('club_id')}'  {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
		$recordsFilterCount = $this->conn->query("SELECT a.* FROM `application_list` a inner join club_list c on a.club_id = c.id where a.club_id = '{$this->settings->userdata('club_id')}'  {$search_where} ")->num_rows;
		
		$recordsTotal= $totalCount;
		$recordsFiltered= $recordsFilterCount;
		$data = array();
		$i= 1 + $start;
		while($row = $query->fetch_assoc()){
			$row['no'] = $i++;
			$row['date_updated'] = date("F d, Y H:i",strtotime($row['date_updated']));
			$data[] = $row;
		}
		echo json_encode(array('draw'=>$draw,
							'recordsTotal'=>$recordsTotal,
							'recordsFiltered'=>$recordsFiltered,
							'data'=>$data
							)
		);
	}
	
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_club':
		echo $Master->save_club();
	break;
	case 'delete_club':
		echo $Master->delete_club();
	break;
	case 'dt_clubs':
		echo $Master->dt_clubs();
	break;
	case 'save_user':
		echo $Master->save_user();
	break;
	case 'delete_user':
		echo $Master->delete_user();
	break;
	case 'dt_users':
		echo $Master->dt_users();
	break;
	case 'save_application':
		echo $Master->save_application();
	break;
	case 'delete_application':
		echo $Master->delete_application();
	break;
	case 'dt_applications':
		echo $Master->dt_applications();
	break;
	case 'dt_club_applications':
		echo $Master->dt_club_applications();
	break;
	default:
		// echo $sysset->index();
		break;
}