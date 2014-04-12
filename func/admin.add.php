<?
session_start();
include_once("config.func.php");
if(isset($_SESSION['isadmin'])){
	if(isset($_POST['submit']) && strlen($_POST['firstname'])>0 && strlen($_POST['lastname'])>0 && strlen($_POST['house'])>0 && strlen($_POST['topic'])>0 && strlen($_POST['date'])>0 && strlen($_POST['block'])>0 && strlen($_POST['location'])>0){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$house = $_POST['house'];
		$topic = $_POST['topic'];
		$date = str_replace("-","",$_POST['date']);
		$block = intval($_POST['block']);
		$location = $_POST['location'];
		$mysqli = new mysqli($db_host, $db_user, $db_pass);
		$mysqli -> select_db($db_name);
		if(mysqli_connect_errno()) {
			echo "Connection Failed: " . mysqli_connect_errno();
			exit();
		}
		if($stmt = $mysqli -> prepare("INSERT INTO presentations (uuid, 
firstname,lastname,house,topic,date,block,location) VALUES (?,?,?,?,?,?,?,?)")){
			$stmt -> bind_param("ssssssis", md5($firstname.$lastname.$topic), $firstname, $lastname, $house, $topic, $date, $block, $location);
			$stmt -> execute();
			$stmt -> close();
		} else {
			echo $mysqli->error;
		}
		$q = "
		CREATE TABLE `dalehunz_sps`.`pres_".md5($firstname.$lastname.$topic)."` (
			`uuid` VARCHAR(64) NOT NULL,
			`timestamp` TEXT NULL,
			PRIMARY KEY (`uuid`)
		);";
		if($stmt = $mysqli ->prepare($q)){
			//
			$stmt -> execute();
			$stmt ->close();
		}
		$mysqli -> close();
	}
} else {	
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>