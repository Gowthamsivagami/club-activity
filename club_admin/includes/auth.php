<?php 
$self = $_SERVER['PHP_SELF'];
if(!strpos($self, "club_admin/login.php") && !strpos($self, "club_admin/registration.php")){
    if(!isset($_SESSION['userdata']['id'])){
        redirect('./club_admin/login.php');
    }
}
?>