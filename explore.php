<? session_start(); 
  $user_id = $_SESSION['userid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>MigrantWatch</title>

<? 
include("header.php");
include("page_includes_js.php");
include("google_maps_api.php");
?>
</head>
<body onload="load()">

<?
$where_clause = "";
$sql = "";
$sql = "SELECT s.common_name,l.location_name,l.city,st.state,u.user_name,l1.sighting_date,l1.obs_type,l1.frequency,l1.obs_start,l1.user_friend,";
$sql .= "l.latitude,l.longitude";
$sql .= " FROM migwatch_l1 l1 INNER JOIN migwatch_users u ON l1.user_id=u.user_id ";
$sql .= " INNER JOIN migwatch_locations l ON l.location_id=l1.location_id ";
$sql .= " INNER JOIN migwatch_species s ON s.species_id=l1.species_id ";
$sql .= " INNER JOIN migwatch_states st ON st.state_id = l.state_id ";
                                
   
if( ( $_GET['species'] != "All" ) || $_GET['species'] != "" ) {
   $species = $_GET['species'];
} else {
   $species = "All";
}
if( $species && is_numeric($species) ) {                                  
   $where_clause = " WHERE l1.species_id=". $species;
   $tempsql = "select common_name from migwatch_species where species_id=".$species;
   $result = mysql_query($tempsql);
   if($result) {
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $strSpecies = $row{'common_name'};
     }
   }
}
             
if( ($_GET['location'] != 'All') || ($_GET['location'] != '') || ($_GET['location'] != $locationHintText )) {
   $location = $_GET['location'];
} else {	          
   $location = 'All';
}

if( $location && is_numeric($location) ) {   
   $where_clause .= " AND l1.location_id=". $location;
   $tempsql = "select location_name, city,district from migwatch_locations where location_id='$location'";
   $result = mysql_query($tempsql);
   if($result) {
   while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
   $strLocation = $row{'location_name'};
   
   if( $row['city'] != "" ) { 
    $strLocation .= ", ". $row['city'];
   }
   if( $row['district'] != "" ) { 
    $strLocation .= ", " . $row['district'];
   }   
   
  }						   
 }
}
   
if( $_GET['season'] != '') {
  if ( $_GET['season'] != 'All' ) {
   $season = $_GET['season'];
} 
}else {
   $season = getCurrentSeason();		
}
         
   $seasonArr = explode('-',$season);
   $seasonStart = $seasonArr[0];
   $seasonEnd = $seasonArr[1];
		
   if ($where_clause == "") {
     $where_clause = " WHERE l1.obs_start BETWEEN '$seasonStart-07-01' AND '$seasonEnd-06-30' AND l1.obs_start <> '1999-11-30' AND l1.obs_start <> '0000-00-00' ";
   } else {
     $where_clause .= " AND l1.obs_start BETWEEN '$seasonStart-07-01' AND '$seasonEnd-06-30' AND l1.obs_start <> '1999-11-30' AND l1.obs_start <> '0000-00-00' ";
   }
			
if( ($_GET['user'] != 'All') || ($_GET['user'] != '')) {
   $user = $_GET['user'];
} else {
   $user = 'All';
}

if ($user){
   if($user != 'All') {
            $where_clause .= " AND l1.user_id = ".$user;

   $tempsql = "Select user_name from migwatch_users where user_id=".$_GET['user'];
   $result = mysql_query($tempsql);
   $strUserName = "";
   if($result){
     while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
       $strUserName = $row{'user_name'};
   }
}
}
if( is_numeric($_GET['state']) )  {
   $state = $_GET['state'];
} else {
   $state = 'All';
}

if( is_numeric($state)) {
   $where_clause .= " AND st.state_id = ".$_GET['state'];
}

				if ($_GET['obsfrq'] != "1"){
					if($where_clause == ""){
						switch($_GET['obsfrq']){
							case 2:
								$where_clause = " WHERE l1.frequency = 'Daily' ";
								$strFrequency = "Daily only";
								break;
							case 3:
								$where_clause = " WHERE l1.frequency in ('Weekly','Daily','Twice a week') ";
								$strFrequency = "Weekly or more frequent";
								break;
							case 4:
								$where_clause = " WHERE l1.frequency in ('Fortnightly','Weekly','Daily','Twice a week') ";
								$strFrequency = "Fortnightly or more frequent";
								break;
							case 5:
								$where_clause = " WHERE l1.frequency in ('Monthly','Fortnightly','Weekly','Daily','Twice a week') ";
								$strFrequency = "Monthly or more frequent";
								break;
							default:
								$where_clause = "";
								break;
						}
					} else {
						switch($_GET['obsfrq']){
							case 2:
								$where_clause .= " AND l1.frequency = 'Daily' ";
								$strFrequency = "Daily only";
								break;
							case 3:
								$where_clause .= " AND l1.frequency in ('Weekly','Daily','Twice a week') ";
								$strFrequency = "Weekly or more frequent";
								break;
							case 4:
								$where_clause .= " AND l1.frequency in ('Fortnightly','Weekly','Daily','Twice a week') ";
								$strFrequency = "Fortnightly or more frequent";
								break;
							case 5:
								$where_clause .= " AND l1.frequency in ('Monthly','Fortnightly','Weekly','Daily','Twice a week') ";
								$strFrequency = "Monthly or more frequent";
								break;
							default:
								$where_clause .= "";
								break;
						}
					}

				}
				else
					$strFrequency = "Any";
				
if($_GET['type'] != 'All' || $_GET['type'] != '') {
   $type =  $_GET['type'];    
} else {
   $type = 'All';	
}

if($type) {
   if($type != 'All') {
   if ($where_clause == "")
        $where_clause = " WHERE l1.valid = 1 AND deleted = '0' AND l1.obs_type = '$type'";
   else
	$where_clause .= " AND l1.valid = 1 AND deleted = '0' AND l1.obs_type = '$type'";
   } 
} /*else {
   if ($where_clause == "")
      $where_clause = "  WHERE l1.valid = 1 AND deleted = '0'";
   else
      $where_clause .= " AND l1.valid = 1 AND deleted = '0'";
}*/


				if ($_SESSION['dev_entries'] == 1) {
					// Show all entries : including the ones from developer
				} else {
					$where_clause .= " AND u.user_name != 'Developer'";
				}

				$where_clause .= " AND s.Active = '1'";

				$sql .= $where_clause;
				//echo $sql;

				


	?>

<script type="text/javascript">

    //<![CDATA[
	// SQ - all this is preliminary stuff needed by Google Maps
	function createMarker(point, user, friend, location, city, state, species, sDate, obsFreq, start, icon) {
  		var marker = new GMarker(point,icon);
  		GEvent.addListener(marker, "click", function() {
    			marker.openInfoWindowHtml("<font face='Arial' size='1'><b>" + species + "</b><br>Reported by <b>" + user + "</b><br>On behalf of <b>" + friend + "</b><br>At " + location + ", " + city + ", " + state + "<br>On " + sDate + "<br>Observation frequency: " + obsFreq + "<br>Start date: " + start + "</font>");
  		});
  		return marker;
	}


    function load() {
      if (GBrowserIsCompatible()) {

	var icon1 = new GIcon();
	icon1.shadow = "" ;
	icon1.image = "mark1.png";
	icon1.iconSize = new GSize(8, 8);
	icon1.shadowSize = new GSize(0, 0);
	icon1.iconAnchor = new GPoint(6, 1);
	icon1.infoWindowAnchor = new GPoint(5, 1);

	var icon2 = new GIcon();
	icon2.shadow = "" ;
	icon2.image = "mark2.png";
	icon2.iconSize = new GSize(8, 8);
	icon2.shadowSize = new GSize(0, 0);
	icon2.iconAnchor = new GPoint(6, 1);
	icon2.infoWindowAnchor = new GPoint(5, 1);

	var icon3 = new GIcon();
	icon3.shadow = "" ;
	icon3.image = "mark3.png";
	icon3.iconSize = new GSize(8, 8);
	icon3.shadowSize = new GSize(0, 0);
	icon3.iconAnchor = new GPoint(6, 1);
	icon3.infoWindowAnchor = new GPoint(5, 1);

	var icon4 = new GIcon();
	icon4.shadow = "" ;
	icon4.image = "mark4.png";
	icon4.iconSize = new GSize(8, 8);
	icon4.shadowSize = new GSize(0, 0);
	icon4.iconAnchor = new GPoint(6, 1);
	icon4.infoWindowAnchor = new GPoint(5, 1);

	var icon5 = new GIcon();
	icon5.shadow = "" ;
	icon5.image = "mark5.png";
	icon5.iconSize = new GSize(8, 8);
	icon5.shadowSize = new GSize(0, 0);
	icon5.iconAnchor = new GPoint(6, 1);
	icon5.infoWindowAnchor = new GPoint(5, 1);

	var icon6 = new GIcon();
	icon6.shadow = "" ;
	icon6.image = "mark6.png";
	icon6.iconSize = new GSize(8, 8);
	icon6.shadowSize = new GSize(0, 0);
	icon6.iconAnchor = new GPoint(6, 1);
	icon6.infoWindowAnchor = new GPoint(5, 1);

	var icon7 = new GIcon();
	icon7.shadow = "" ;
	icon7.image = "mark7.png";
	icon7.iconSize = new GSize(8, 8);
	icon7.shadowSize = new GSize(0, 0);
	icon7.iconAnchor = new GPoint(6, 1);
	icon7.infoWindowAnchor = new GPoint(5, 1);

	var icon8 = new GIcon();
	icon8.shadow = "" ;
	icon8.image = "mark8.png";
	icon8.iconSize = new GSize(8, 8);
	icon8.shadowSize = new GSize(0, 0);
	icon8.iconAnchor = new GPoint(6, 1);
	icon8.infoWindowAnchor = new GPoint(5, 1);

	var icon9 = new GIcon();
	icon9.shadow = "" ;
	icon9.image = "mark9.png";
	icon9.iconSize = new GSize(8, 8);
	icon9.shadowSize = new GSize(0, 0);
	icon9.iconAnchor = new GPoint(6, 1);
	icon9.infoWindowAnchor = new GPoint(5, 1);

	var icon10 = new GIcon();
	icon10.shadow = "" ;
	icon10.image = "mark10.png";
	icon10.iconSize = new GSize(8, 8);
	icon10.shadowSize = new GSize(0, 0);
	icon10.iconAnchor = new GPoint(6, 1);
	icon10.infoWindowAnchor = new GPoint(5, 1);

        var map = new GMap2(document.getElementById("map"));
	map.addControl(new GLargeMapControl());
  	map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(20.21,77.86), 4);
	//map.setMapType(G_SATELLITE_MAP);
<?	

	
        $table_sql = $sql;
	$result = mysql_query($table_sql);
	$i = 1;
	list($startSeason,$endSeason) =  explode('-',$season);
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$line['count'] = $i;
		print "var point = new GLatLng(" . $line['latitude'] . "+(Math.random()*0.2)-0.1," . $line['longitude'] . "+(Math.random()*0.2)-0.1);\n";
		if (strtotime($line['sighting_date']) >= strtotime("$startSeason-07-01") && strtotime($line['sighting_date']) <= strtotime("$startSeason-07-31"))
			print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon10));\n\n";
		elseif (strtotime($line['sighting_date']) > strtotime("$startSeason-08-01") && strtotime($line['sighting_date']) <= strtotime("$startSeason-08-15"))
			print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon9));\n\n";
		elseif (strtotime($line['sighting_date']) > strtotime("$startSeason-08-15") && strtotime($line['sighting_date']) <= strtotime("$startSeason-08-31"))
			print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon8));\n\n";
		elseif (strtotime($line['sighting_date']) > strtotime("$startSeason-08-31") && strtotime($line['sighting_date']) <= strtotime("$startSeason-09-15"))
			print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon7));\n\n";
		elseif (strtotime($line['sighting_date']) > strtotime("$startSeason-09-15") && strtotime($line['sighting_date']) <= strtotime("$startSeason-09-30"))			//
			print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon6));\n\n";
		elseif (strtotime($line['sighting_date']) > strtotime("$startSeason-09-30") && strtotime($line['sighting_date']) <= strtotime("$startSeason-10-15"))
			print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon5));\n\n";
		elseif (strtotime($line['sighting_date']) > strtotime("$startSeason-10-15") && strtotime($line['sighting_date']) <= strtotime("$startSeason-10-31"))
			print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon4));\n\n";
		elseif (strtotime($line['sighting_date']) > strtotime("$startSeason-10-31") && strtotime($line['sighting_date']) <= strtotime("$startSeason-11-15"))
			print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon3));\n\n";
		elseif (strtotime($line['sighting_date']) > strtotime("$startSeason-11-15") && strtotime($line['sighting_date']) <= strtotime("$startSeason-11-30"))
		print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon2));\n\n"; 
		elseif (strtotime($line['sighting_date']) > strtotime("$startSeason-11-30"))
			print "map.addOverlay(createMarker(point,\"" . addslashes($line['user_name']) . "\", \"" . addslashes($line['user_friend']) . "\", \"" . addslashes($line['location_name']) . "\", \"" . addslashes($line['city']) . "\", \"" . addslashes($line['state']) . "\", \"" . addslashes($line['common_name']) . "\", \"" . addslashes($line['sighting_date']) . "\", \"" . addslashes($line['frequency']) . "\", \"" . addslashes($line['obs_start']) . "\",icon1));\n\n";
			} 
	?>

	}
   }

    //]]>
    </script>






    <script language="javascript">

        function formatItem(row) {
            var completeRow;
            completeRow = new String(row);
            var scinamepos = completeRow.lastIndexOf("(");
            var rest = substr(completeRow,0,scinamepos);
            var sciname = substr(completeRow,scinamepos);
            var commapos = sciname.lastIndexOf(",");
            sciname = substr(sciname,0,commapos);
            var newrow = rest + ' <i>' + sciname + '</i>';
            return newrow;
        }

    </script>


<div class="container first_image" style="padding-bottom:15px">
<!--<div class="container" style="width:950px;padding-bottom:20px">-->


<FORM name="reports" action="data.php" method="GET">
<table class="filter" style="width:930px;margin-left:auto;margin-right:auto;">           
         
<tr>
         <td style=''>Season</td>
         <td>Sighting type</td>
	 <td>Species</td>
         <td>Participant</td>
         <td></td>
       </tr>
       <tr>
         <td style="width:160px;">
                    <select style="width:85%;font-size:12px;" name='season'>
                    <?php
                    /**
                     * Use the current month and year to find out the last season to be
                     * displayed in the drop down. (Season : 1st July - 31st Aug)
                     */
                    $currentMonth = date('m');
                    $currentYear  = date('Y');

                    /**
                     * If the current month is greater than June i.e July and onwords only then display
                     * the current year in the season
                     */
                    if ($currentMonth > 6) {
                        $endSeason = $currentYear;
                    } else {
                        $endSeason = $currentYear - 1;
                    }

                    // The sighting started in 2007-2008 so start from this season
                    for ($i = 2007;$i <= $endSeason; $i++) {
                        $fromTo = "$i-".($i+1);
                        echo '<option value="' . $fromTo  . '"';
                        if (empty($_GET)) {
                            echo ' selected>';
                        } else {
                            echo ($_GET['season'] == $fromTo) ? ' selected>' : '>';
                        }
                        echo $fromTo;
                        echo '</option>';
                    }
                    ?>
           
                    </select>&nbsp;&nbsp;
		    <? $current_season = getCurrentSeason();
                   
                       if( $_GET['season'] != '' && $_GET['season']  != $current_season  ) {		       
		    ?>
                     <a title="remove season" href="#" onClick="get_remove('season');">X</a>
                    
                       <? } ?>

                   </td> <td  style="width:160px;">
                    

                    <select name="type" style="width:85%">
                            <option value="All">All</option>
                            <option value="first"<?php if($type == 'first') print("selected"); ?>>First Sighting</option>
                            <option value="general"<?php if($type == 'general') print("selected"); ?>>General Sighting</option>
                            <option value="last"<?php if($type == 'last') print("selected"); ?>>Last Sighting</option>
                     </select>&nbsp;&nbsp;
                      <? if( $_GET['type'] != "All" && $_GET['type'] != '') {  ?>
                           <a title="remove sighting type" href="#" onclick="get_remove('type');">X</a>
                      <? } ?>
		</td>
	  
                <td style="width:400px;">
                    
                  
                    <input type='text' id='species' size="25" style="width:85%;border:solid 1px #666" value="<? echo $strSpecies; ?>">
		               <input type='hidden' id='species_hidden' name='species' value="<? echo $species; ?>">
                              &nbsp;
                             <? if( is_numeric($_GET['species'] )) {  ?>
                                  <a title="remove species" href="#" onclick="get_remove('species');">X</a>
                             <? } ?>
		</td>



		<td style="width:300px;">
           
                    <select name=user style="width:91%">
                    <option value='All'>-- Select --</option>
                    <?php

                    //  The current season..
                    $today = getdate();
                    $currentSeason = ($today['mon'] > 6) ? $today['year'] : $today['year'] - 1;
                    $season = (isset($_POST['season'])) ? substr($_POST['season'], 0, 4) : $currentSeason;
                    $seasonEnd = (int)$season + 1;

                    $sql = "SELECT DISTINCT u.user_name, u.user_id from migwatch_users u INNER JOIN migwatch_l1 l1 ON ";
                    $sql .= "l1.user_id=u.user_id WHERE l1.valid=1 ";
                    //$sql .= "AND l1.obs_start BETWEEN '$season-07-01' AND '$seasonEnd-06-30'  ";
                    $sql .= "ORDER BY u.user_name";
                    $result = mysql_query($sql);
                    if(mysql_num_rows($result) <= 0) {
                        $sql = "SELECT DISTINCT u.user_name, u.user_id from migwatch_users u INNER JOIN migwatch_l1 l1 ON ";
                        $sql .= "l1.user_id=u.user_id WHERE l1.valid=1 ORDER BY u.user_name";
                        $result = mysql_query($sql);
                    }
                    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                        print "<option value=".$row{'user_id'};
                        if (($_GET['user'] != "") && ($_GET['user'] == $row{'user_id'}))
                            print " selected ";
                        print ">".$row{'user_name'}."</option>";
                    }
                    ?>
                    </select>
                </div>&nbsp;
                <? if( is_numeric( $_GET['user'] )) {  ?>
                     <a href="#" onclick="get_remove('user');">X</a>
                <? } ?>
		</td><td></td>
		</tr>
                <tr><td colspan='4' style='height:15px'></tr>
		<tr>
        <td colspan="2">State</td>
         <td colspan="2">Location</td>
	 
	 <td>
	 <? if( count($_GET) > 0 ) { ?>
	   <a href="data.php">Remove&nbsp;All</a>
	 <? } ?>
	 </td>
       </tr>
        <tr>
          
          <td colspan="2" style="">
             <select style="width:93%;"  id="state" name=state >

                        <option value="all">All the States</option>
                    <?php

                            $result = mysql_query("SELECT state_id, state FROM migwatch_states order by state");
                            if($result){
						while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                                    if($row['state'] != 'Not In India') {
                                        print "<option value=".$row{'state_id'};
                                        if (($_GET['state'] != "") && ($_GET['state'] == $row{'state_id'}))
                                            print " selected ";
                                        print ">".$row{'state'}."</option>";
					                          } else {
                                        $other_id = $row['state_id'];
                                        $other = $row['state'];
                                    }
                                }
                                print("<option value=".$other_id);
							if($other_id == $state_id)
                                    print " selected ";
				    	                  print ">".$other."</option>\n";
                            }

                    ?></select>&nbsp;&nbsp;
                   <? if( is_numeric($_GET['state'] )) {  ?>
                     <a title="remove state" href="#" onclick="get_remove('state');">X</a>
                   <? } ?>

          </td>

			<td colspan="2" style="width:500px;">
               
               <input type='text' id='location'  size='25' value="<? echo $strLocation; ?>" style="width:95%;border:solid 1px #666">
               <input type='hidden' id='location_hidden' name='location' value="<? echo $location; ?>">
               <? if( is_numeric($_GET['location'] )) {  ?>
                  &nbsp;<a title="remove location" href="#" onclick="get_remove('location');">X</a>
               <? } ?>
              
         </td>
        
         <td style='width:110px'><input type='submit' style='padding:2px' value='go'></td>
        </form>
        </tr>
	</table>

<!--</div>-->
<?
s
$result = mysql_query($table_sql);
if (mysql_num_rows($result) != 0) {
?>

<div class='container' style="width:930px;margin-left:auto;margin-right:auto;border-top:solid 1px #d95c15" id='tab-set'>
   <ul class='tabs'>
   
           <li><a href='#text1' class='selected'>map</a></li>
           <li><a href='#text2'>tabular</a></li>
 
   </ul>
   <div id='text1'>
              <div id="map" style="width:930px;height:500px"></div>
  </div>

  <div id='text2'>
     <table id="table1" class="tablesorter" style="width:930px;margin-left:auto;margin-right:auto" cellpadding="3">
                <thead>
                        <tr>
                                <th>&nbsp;No</th>
                                <th>Common Name</th>           
                                <th>Location</th>
                                <th style='width:30px'>Date</th>                        
				<th>Sighting type</th>
                                <th>Count</th>
                                <th>Reported by</th>
                                <th>On behalf of</th>
                        </tr>
                </thead>
                <tbody>

     <?
	$i=1;
         
         //$result = mysql_query($table_sql);
         
	list($startSeason,$endSeason) =  explode('-',$_GET['season']);
	//if (mysql_num_rows($result) > 0) {
	   while ($row = mysql_fetch_array($result)) {
	             print "<tr>";
                        print "<td>$i</td>";
	            print "<td>".$row{'common_name'}."</td>";
                        print "<td>".$row{'location_name'}.", ".$row{'city'}.", ".$row{'state'}."</td>";
                        print "<td style='width:10px'>".date("d-m-Y",strtotime($row{'sighting_date'}))."</td>";
		        print "<td>" . $row{'obs_type'} . "</td>";
                        ($row['number'] > 0 ) ? print "<td>".$row{'number'}."</td>" : print "<td> -- </td>";
                        print "<td>".$row{'user_name'}."</td>";
                        print "<td style='border-right:0.5px solid #ffcb1a'>".$row{'user_friend'}."</td>";
                        print "</tr>";
                        $i++;


           }

?>
      </tbody>
     </table>
       <div id="pager" class="column span-7" style="" >
                        <form name="" action="" method="post">
                                <table >
                                <tr>
                                        <td><img src='pager/icons/first.png' class='first'/></td>
                                        <td><img src='pager/icons/prev.png' class='prev'/></td>
                                        <td><input type='text' size='8' class='pagedisplay'/></td>
                                        <td><img src='pager/icons/next.png' class='next'/></td>
                                        <td><img src='pager/icons/last.png' class='last'/></td>
                                        <td>
                                                <select class='pagesize'>
                                                        <option selected='selected'  value='10'>10</option>
                                                        <option value='20'>20</option>
                                                        <option value='30'>30</option>
                                                        <option  value='40'>40</option>
                                                </select>
                                        </td>
                                </tr>
                                </table>
                        </form>
                </div>

       </div>

</div>
<? } else { ?>

<div class='container notice' style="width:900px;margin-left:auto;margin-right:auto;">no results</div>
<? } ?>
</div>
</div>
</div>
<div class="container bottom">

</div>-->
<script type='text/javascript'>

			$().ready(function() {

            $("#species").autocomplete("autocomplete_reports.php", {
                width: 250,
                selectFirst: false,
                matchSubset :0,
                mustMatch: true,
                            
           });

         $("#species").result(function(event , data, formatted) {
                if (data)
						
                  document.getElementById('species_hidden').value = data[1];
                  
						
          });


         $('#location').autocomplete("auto_miglocations.php", {
                width: 495,
                selectFirst: false,
                matchSubset :0,
                mustMatch: true,
                  //formatItem:formatItem
                 
          });

         $("#location").result(function(event , data, formatted) {
                if (data)
                  document.getElementById('location_hidden').value = data[1];
                  
                          
         });
});

</script>

<? include("tab_include.php"); ?>


</body>
</html>

<script type="text/javascript">
function get_remove(parameter) {

<? if($_GET['type']){
   $remove_type = $_GET['type'];
   }
  
   if($_GET['species']){
      $remove_species = $_GET['species'];
   }

   if($_GET['user']){
   $remove_user = $_GET['user'];
   }
   
   if($_GET['state']){
      $remove_state = $_GET['state'];
   }

   if($_GET['location']){
   $remove_location = $_GET['location'];
    }

    if($_GET['season']){
   $remove_season = $_GET['season'];
    }

?>
var remove_season = '<? echo $remove_season; ?>';
var remove_type = '<? echo $remove_type; ?>';
var remove_species = '<? echo $remove_species; ?>';
var remove_user = '<? echo $remove_user; ?>';
var remove_state = '<? echo $remove_state; ?>';
var remove_location = '<? echo $remove_location; ?>';

  if ( parameter == 'season') {
    
     remove_season = '<? echo getCurrentSeason(); ?>';
     alert(remove_season);
   }


   if ( parameter == 'type') {
      remove_type = 'All';
     }

    if (parameter == 'species') {
       remove_species = 'All'; 
     }

     if (parameter == 'user') {
     remove_user = 'All'; 
       
     
     }

 

    if (parameter == 'location') {
      remove_location = 'All';
       }

   if ( parameter == 'state') {
    remove_state = 'All'; 



  } 

  var url = "data.php?season=" + remove_season + "&type=" + remove_type + "&species=" + remove_species + "&user=" + remove_user + "&state=" + remove_state + "&location=" + remove_location;
 
  
  window.location = url;
}



</script>

