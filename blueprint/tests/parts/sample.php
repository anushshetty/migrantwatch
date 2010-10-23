<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>NCF : Maps</title>
	 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAz2GdKU-VPA5WYpd4RF7AQxSpscTU5kaOYAZKMitMiyLtVLIV4BSJDW6E4CGqThSlS7viWhuh3kOzAQ"
      type="text/javascript"></script>

</head>

<?

$link = mysql_connect("localhost", "ncf", "ncfproject") or die("Could not connect: " . mysql_error());
mysql_select_db("anush_ncf") or die ("Can\'t use dbmapserver : " . mysql_error());

?>
  <!-- Framework CSS -->
	<link rel="stylesheet" href="blueprint/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="blueprint/print.css" type="text/css" media="print">
  <!--[if IE]><link rel="stylesheet" href="../../blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
	
	<!-- Import fancy-type plugin for the sample page. -->
	<link rel="stylesheet" href="blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection">
</head>

<body>

	<div class="container">  
		<h1>NCF Maps</h1>
		<h3 class="alt">Distribution of Mammals in South India</h3>
		<div class="span-4 last"><div class="box">
			<form action="view.php" method=GET>
			<table>
			<tr>
				<td><select name="aos">
	     					<option value="">Select Area of Survey</option>
						<?
							$query="select distinct area_of_survey from locations order by 1";
							$result = mysql_query($query);
							while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
						?>	  					       
							
							<option value="<? echo $line['area_of_survey']; ?>">
							 
                			 	 <? echo $line["area_of_survey"];
                					echo "\n";
      						  }

						?>
				</select></td>
				<td><select name="species">
	     					<option value="">Select Species</option>
						<?
							$query="select distinct species_id from sightings";
							$result = mysql_query($query);
							while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
								$species_id=$line['species_id'];
								$query2="select common_name from mammals where mammal_id='$species_id'";
								$result2=mysql_query($query2);
								while ($line2 = mysql_fetch_assoc($result2))
								{
									$species=$line2['common_name'];
								
								}
								?>	  					       
							
									<option value="<? echo $species; ?>">
							 
                			 				 <? echo $species;
                					echo "\n";
      						  }

						?>
				</select></td>
				<td><input type="submit" value="search"></form>
				</tr></table>
				
		</div></div>
		<div class="span-9 column-1" id="map" style="width: 800px; height: 600px; border:solid 1 px #333"></div>      
		

		
	</div>
</body>

<script type="text/javascript">
//<![CDATA[


var map = new GMap(document.getElementById("map"));
map.addControl(new GLargeMapControl());
map.addControl(new GMapTypeControl());
map.addControl(new GScaleControl());
map.setCenter(new GLatLng(20.21,78.86), 5, G_NORMAL_MAP);

// Creates a marker whose info window displays the given number
function createMarker(point, number)
{
  var marker = new GMarker(point);
  // Show this markers index in the info window when it is clicked
  var html =  number;
  GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
  return marker;
};

<?php /*
$link = mysql_connect("localhost", "ncf", "ncfproject") or die("Could not connect: " . mysql_error());
mysql_selectdb("anush_ncf",$link) or die ("Can\'t use dbmapserver : " . mysql_error());

$result = mysql_query(" select mammal_id,species_id,common_name,location,latitude,longitude from mammals,sightings,locations where sightings.species_id = mammals.mammal_id AND sightings.location_id=locations.location_id",$link);
if (!$result)
{
echo "no results ";
}
while($row = mysql_fetch_array($result))
{
$details = $row['common_name'].",".$row['location'];
echo "var point = new GLatLng(" . $row['latitude'] . "," . $row['longitude'] . ");\n";
echo "var marker = createMarker(point, '" . addslashes($details) . "');\n";
echo "map.addOverlay(marker);\n";
echo "\n";
}

mysql_close($link);*/
?>
//]]>

    </script>
</html>
