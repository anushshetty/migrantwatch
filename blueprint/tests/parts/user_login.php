<?


$username = $_POST["wpName"];
$password = $_POST["wpPassword"];
/*$password2 = $_POST["wpRetype"];
$email = $_POST["wpEmail"];
$realname = $_POST["wpRealName"];
$create = $_POST["wpCreateaccount"]; */
$enter =  $_POST["wpLoginattempt"];
$password2="admin";

echo $username;

		if ($_POST["done"]) {
			
			header ("Location: http://localhost/fisheye/toolbar/log.php ");
		}

?>
