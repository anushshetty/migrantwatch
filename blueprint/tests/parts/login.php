<html>
<head>
<title>Gluster : Login</title>
<meta name="Author" content="Ilkka Huotari">
<script src="rounded.js"></script>

<style>  
<? include("header_login.php"); ?>
</head>
<body style="
    
    min-height:468px;/* for good browsers*/
    min-width:552px;/* for good browsers*/
    text-align: center;
    background-color:#ffffff">
<div style="
            width:500; margin: 0px auto; background-color:#fff; /*
            font-family: Georgia; */ /*font-variant: small-caps;
            font-weight: bold; font-size: 2em; line-height: 4em;
            font-size-adjust: none; font-stretch: normal; */
            line-height:1.5;font-family:"Helvetica Neue", Helvetica,
            Arial, sans-serif; 
	    font-size:10pt; color: #333333"
            class="rounded">
  

<?

print "
<br>
<form name=\"userlogin\" id=\"userlogin\" method=\"post\" action=\"panel.php\">
	<table  bgcolor=\"#ffffff\" style=\"border: 1px solid #C3D9FF;\">
	   <tr>
                                         <td align=\"center\" colspan=\"4\" bgcolor=\"#C3D9FF\" >
                                             <b>Login</b>
                                         </td>
          </tr>
	  <tr>
				<td align='right'><div class=\"txt\" style=\"margin-top:30px\";><label for='wpUsername'>Username:</label></div></td>
				<td align='left'><div class=\"txt\" style=\"margin-top:30px\";><input tabindex='1' type='text' name=\"wpUsernaame\" id=\"wpUsername\" value=\"\" size='20' /></div>
				</td>
			
				<td align='left'>
				  <div class=\"txt\" style=\"margin-top:30px\";><input tabindex='3' type='submit' name=\"wpLoginattempt\" value=\"Log in\" /></div>
				</td>
		</tr>
		<tr>
		                <td align='right'><div class=\"txt\" style=\"margin-top:30px\";><label for='wpPassword'>Password:</label></div></td>

				<td align='left'><div class=\"txt\" style=\"margin-top:30px\";><input tabindex='2' type='password' name=\"wpPassword\" id=\"wpPassword\" value=\"\" size='20' /></div></td>
			
				<td align='left'><div class=\"txt\" style=\"margin-top:30px\";><input tabindex='4' type='checkbox' name=\"wpRemember\" value=\"1\" id=\"wpRemember\"/><label for=\"wpRemember\"><small><b>Remember my password across sessions.</b></small></label></div></td>
				
		</tr>
		<tr>
		                <td colspan='3'>&nbsp;</td>
		</tr>
		
	</table>";

		if ($_GET["done"]) { print "<input type=hidden name=done value=\"" . $_GET["done"] . "\">"; }
	print "</form> ";

?>


</div>
<script type="text/javascript">
Rounded('rounded', 6, 6);
</script>
</body>
</html>
