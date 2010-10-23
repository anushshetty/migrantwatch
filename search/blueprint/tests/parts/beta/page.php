
<?php

include("header.php");
/* add_sidebar("sidebar.php","latest", 160);*/

?>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="fisheye/interface.js"></script>
<link type="text/css" href="fisheye/interface-fisheye.css" rel="stylesheet">

<script type="text/javascript">

$(document).ready(
function()
{
$('#fisheye').Fisheye(
{
maxWidth: 50,
items: 'a',
itemsText: 'span',
container: '.fisheyeContainter',
itemWidth: 70,
proximity: 90,
halign : 'center'
}
)

}
);

</script>


<table width=50% align=center bgcolor="#ffffff" style=" border: 1px solid #C3D9FF;"> 
<tr>
	<td align="center" colspan="2" bgcolor="#C3D9FF" >
	<h2>Control Panel</h2>
	</td>
        
</tr>
<tr height=250px>
	<td>
	<div class="txt" valign="center">
		<div id="fisheye" class="fisheye">
		     <div class="fisheyeContainter">
		     	  <a href="#" class="fisheyeItem" ><img src="volume/volume.png" width="30" /><span>Volume</span></a>
			  <a href="#" class="fisheyeItem" ><img src="performance/per.png" width="30" /><span>Performance</span></a>
			  <a href="#" class="fisheyeItem"><img src="log/log.png" width="30" /><span>Log</span></a>
			  <a href="#" class="fisheyeItem"><img src="start/start.png" width="30" /><span>Start/Stop</span></a>
	             </div>
	      
	</div> 
  	</div> 
	</td>

	<td>
		
		
	</td>
</tr>

</table> 


	
<?
/* include("footer.php"); */
?>
