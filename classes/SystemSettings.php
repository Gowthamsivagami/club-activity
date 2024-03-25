<?php
if(!class_exists('DBConnection')){
	require_once('../config.php');
	require_once('DBConnection.php');
}
class SystemSettings extends DBConnection{
	public function __construct(){
		parent::__construct();
	}
	function check_connection(){
		return($this->conn);
	}
	function load_system_info(){
		// if(!isset($_SESSION['system_info'])){
			$sql = "SELECT * FROM system_info";
			$qry = $this->conn->query($sql);
				while($row = $qry->fetch_assoc()){
					$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
				}
		// }
	}
	function update_system_info(){
		$sql = "SELECT * FROM system_info";
		$qry = $this->conn->query($sql);
			while($row = $qry->fetch_assoc()){
				if(isset($_SESSION['system_info'][$row['meta_field']]))unset($_SESSION['system_info'][$row['meta_field']]);
				$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
			}
		return true;
	}
	function update_settings_info(){
		$data = "";
		foreach ($_POST as $key => $value) {
			if(!in_array($key,array("content")))
			if(isset($_SESSION['system_info'][$key])){
				$value = str_replace("'", "&apos;", $value);
				$qry = $this->conn->query("UPDATE system_info set meta_value = '{$value}' where meta_field = '{$key}' ");
			}else{
				$qry = $this->conn->query("INSERT into system_info set meta_value = '{$value}', meta_field = '{$key}' ");
			}
		}
		if(isset($_POST['content']) && is_array($_POST['content'])){
			foreach($_POST['content'] as $k => $v){
				file_put_contents(base_app."{$k}.html",$v);
			}
		}
		if($qry){
			$resp['status'] = 'success';
		}
		
		$img_err= "";
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = 'uploads/system-logo.png';
			$dir_path =base_app. $fname;
			$upload = $_FILES['img']['tmp_name'];
			$type = mime_content_type($upload);
			$allowed = array('image/png','image/jpeg');
			if(!in_array($type,$allowed)){
				$img_err.=" But Logo Image failed to upload due to invalid file type.";
			}else{
				// $new_height = 200; 
				// $new_width = 200; 
		
				list($width, $height) = getimagesize($upload);
				$t_image = imagecreatetruecolor($width, $height);
				$black = imagecolorallocate($t_image, 0, 0, 0);
				imagecolortransparent($t_image, $black);
				imagealphablending( $t_image, false );
				imagesavealpha( $t_image, true );
				$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
				imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $width, $height, $width, $height);
				if($gdImg){
						if(is_file($dir_path))
						unlink($dir_path);
						$uploaded_img = imagepng($t_image,$dir_path);
						if($uploaded_img){
							if(isset($_SESSION['system_info']['logo'])){
								$qry = $this->conn->query("UPDATE system_info set meta_value = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where meta_field = 'logo' ");
							}else{
								$qry = $this->conn->query("INSERT into system_info set meta_value =  CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)),meta_field = 'logo' ");
							}
						}
						imagedestroy($gdImg);
						imagedestroy($t_image);
				}else{
				$img_err.=" But Logo Image failed to upload due to unkown reason.";
				}
			}
		}
		if(isset($_FILES['cover']) && $_FILES['cover']['tmp_name'] != ''){
			$fname = 'uploads/system-cover.png';
			$dir_path =base_app. $fname;
			$upload = $_FILES['cover']['tmp_name'];
			$type = mime_content_type($upload);
			$allowed = array('image/png','image/jpeg');
			if(!in_array($type,$allowed)){
				$img_err.=" But Logo Image failed to upload due to invalid file type.";
			}else{
				list($width, $height) = getimagesize($upload);
				$t_image = imagecreatetruecolor($width, $height);
				$black = imagecolorallocate($t_image, 0, 0, 0);
				imagecolortransparent($t_image, $black);
				imagealphablending( $t_image, false );
				imagesavealpha( $t_image, true );
				$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
				imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $width, $height, $width, $height);
				if($gdImg){
						if(is_file($dir_path))
						unlink($dir_path);
						$uploaded_img = imagepng($t_image,$dir_path);
						if($uploaded_img){
							if(isset($_SESSION['system_info']['logo'])){
								$qry = $this->conn->query("UPDATE system_info set meta_value = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where meta_field = 'cover' ");
							}else{
								$qry = $this->conn->query("INSERT into system_info set meta_value =  CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)),meta_field = 'cover' ");
							}
						}
						imagedestroy($gdImg);
						imagedestroy($t_image);
				}else{
				$img_err.=" But Logo Image failed to upload due to unkown reason.";
				}
			}
		}
		
		$update = $this->update_system_info();
		$flash = $this->set_flashdata('success','System Info Successfully Updated. '.$img_err);
		if($update && $flash){
			// var_dump($_SESSION);
			return json_encode($resp);
		}
	}
	function set_userdata($field='',$value=''){
		if(!empty($field) && !empty($value)){
			$_SESSION['userdata'][$field]= $value;
		}
	}
	function userdata($field = ''){
		if(!empty($field)){
			if(isset($_SESSION['userdata'][$field]))
				return $_SESSION['userdata'][$field];
			else
				return null;
		}else{
			return false;
		}
	}
	function set_flashdata($flash='',$value=''){
		if(!empty($flash) && !empty($value)){
			$_SESSION['flashdata'][$flash]= $value;
		return true;
		}
	}
	function chk_flashdata($flash = ''){
		if(isset($_SESSION['flashdata'][$flash])){
			return true;
		}else{
			return false;
		}
	}
	function flashdata($flash = ''){
		if(!empty($flash)){
			$_tmp = $_SESSION['flashdata'][$flash];
			unset($_SESSION['flashdata']);
			return $_tmp;
		}else{
			return false;
		}
	}
	function sess_des(){
		if(isset($_SESSION['userdata'])){
				unset($_SESSION['userdata']);
			return true;
		}
			return true;
	}
	function info($field=''){
		if(!empty($field)){
			if(isset($_SESSION['system_info'][$field]))
				return $_SESSION['system_info'][$field];
			else
				return false;
		}else{
			return false;
		}
	}
	function set_info($field='',$value=''){
		if(!empty($field) && !empty($value)){
			$_SESSION['system_info'][$field] = $value;
		}
	}
}
$_settings = new SystemSettings();
$_settings->load_system_info();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'update_settings':
		echo $sysset->update_settings_info();
		break;
	default:
		// echo $sysset->index();
		break;
}
?>