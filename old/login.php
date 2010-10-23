<? 
   session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>MigrantWatch</title>
</head>
<body>
<?       
	//include("header.php");
?>

<style>
.login_page { width:400px; border: solid 1px #000 ;margin-top:20px;margin-left:auto;margin-right:auto;background-color:#ffcb1a; }
.login_page input { width:200px; border:solid 1px #666 }
.errorv{  color: red; }
</style>
<div class="container first_image">
<?
if ($_SESSION['username']) {
    echo "<div class='notice'>You are logged in as " . $_SESSION['username'] . "</div>";	
} else  {

?>
<form id="migwatch_login" name="frm_login" action="userlogin.php" method="POST">
<table class="login_page">
<?
 if ( $_GET['cmd'] == 'error' ) { 
?>
        <tr><td colspan="2" style="text-align:center;font-size:14px;color:#d95c15;">Invalid username/password</td></tr>
<? } ?>
	<tr><td colspan="2" style="text-align:center;font-weight:normal;font-size:14px;">Did you <a title='forgot password?' href='forgot.php'>forget</a> your password?</td></tr>
        <tr><td	colspan="2" style="text-align:center;font-weight:normal;font-size:14px;">Are you trying to <a title='register' href='register.php'>register</a>?</td>
 
	<tr><td>Email</td><td><input type="text" name="email" /></td></tr>
	<tr><td>Password</td><td><input id="password-password" type="password" name="pwd" value="" autocomplete="off" /></td></tr>
	<tr><td></td><td><input type="hidden" name="cmd" value="login" /><input style="width:70px" type="submit" value="login" onclick=""></td></tr>
</table>
</form>
<form id="pwd_reset" action=userlogin.php method=POST>
	<table class="box login_page">
		<tr><td colspan=2><h4>Forgot password ?</h4></td></tr>
		<tr><td><b>Your Email Address</b></td>
		<td><input type=text name=email style="width:200px;"></td></tr>
		<tr><td colspan="2"><input type=submit value="Issue New Password"/><input type=hidden name="cmd" value="pwdreset" /></td></tr>
	</table>
</form>
<? } ?>
</div>

</div>
</div>
<div class="container bottom">

</div>
</script>
<script language="javascript" type="text/javascript">
   $(document).ready(function() { 
	 $("#pwd_reset").validate({ 
                rules: { 
                  
                       email: { 
                              required: true, 
                              email: true
                        }
		},
		messages: {
			email: {
                              required: "<br><div class='errorv'>Please enter an email address</div>",
                              email: "<br><div class='errorv'>Please enter a valid email address</div>"
        		}
		}
	});
        $("#migwatch_login").validate({ 
                rules: { 
                  
                       email: { 
                              required: true, 
                              email: true
                        }, 
                        pwd: { 
                             required: true, 
                             minlength: 6 
                        },
		},
		messages: {
			email: {
                              required: "<br><div class='errorv'>Please enter an email address</div>",
                              email: "<br><div class='errorv'>Please enter a valid email address</div>"
        		},
                        pwd: {
                             required: "<br><div class='errorv'>Please enter a password</div>",
                             minlength: "<br><div class='errorv'>The password has to be 6 characters long</div>"
        		},

		}
	});
   });
</script>
<script type="text/javascript" src="combine_js.php?version=<?php require('combine_js.php'); ?>"></script>
<?php 

   include("login_includes.php");
?>
</body>
</html>
