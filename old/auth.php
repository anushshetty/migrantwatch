<?
	session_start();
        $current_url = $_SERVER['REQUEST_URI'];
  	if(!isset($_SESSION['userid'])){
		header("Location: login.php?done=$current_url");
		die();
   	}

?>