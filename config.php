<?php
$prod = false;
$aws = false;
if(isset($_SERVER['RDS_HOSTNAME'])) {
  $aws = true;
  $db_host = $_SERVER['RDS_HOSTNAME'];
  $db_port = $_SERVER['RDS_PORT'];
  $db_user = $_SERVER['RDS_USERNAME'];
  $db_pass = $_SERVER['RDS_PASSWORD'];
  $db_name = $_SERVER['RDS_DB_NAME'];
} else if($prod) {
  $db_host = "***REMOVED***";
  $db_port = 3306;
  $db_user = "***REMOVED***";
  $db_pass = "***REMOVED***";
  $db_name = "***REMOVED***";
} else {
  $db_host = "localhost";
  $db_port = 23306;
  $db_user = "sps";
  $db_pass = "sps";
  $db_name = "sps";
}


?>