<html>
<head>
<title>Gluster : Login</title>
<meta name="Author" content="Ilkka Huotari">
<script src="rounded.js"></script>

<style  

</head>
<body style=" margin: 50px 0px;
    
    min-height:468px;/* for good browsers*/
    min-width:552px;/* for good browsers*/
    text-align: center;
    background-color:#333333">
<div style="
            width:500;
            margin: 0px auto;
            background-color:#fff; 
            /* font-family: Georgia; */
            /*font-variant: small-caps; font-weight: bold; font-size: 2em; line-height: 4em; font-size-adjust: none; font-stretch: normal; */
            line-height:1.5;font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;
	    font-size:10pt;
	    color: #333333" class="rounded">
  

  <h3>Logo</h3>

<?

print "
<br>
<form name=\"userlogin\" id=\"userlogin\" method=\"post\" action=\"fisheye/facebox\">
	<table border='0'>
		<tr>
				<td align='right'><label for='wpUsername'>Username:</label></td>
				<td align='left'><input tabindex='1' type='text' name=\"wpUsernaame\" id=\"wpUsername\" value=\"\" size='20' />
				</td>
			
				<td align='left'>
				  <input tabindex='3' type='submit' name=\"wpLoginattempt\" value=\"Log in\" />
				</td>
		</tr>
		<tr>
		                <td align='right'><label for='wpPassword'>password:</label></td>

				<td align='left'><input tabindex='2' type='password' name=\"wpPassword\" id=\"wpPassword\" value=\"\" size='20' /></td>
			
				<td align='left'><input tabindex='4' type='checkbox' name=\"wpRemember\" value=\"1\" id=\"wpRemember\"/><label for=\"wpRemember\"><small><b>Remember my password across sessions.</b></small></label></td>
				
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
