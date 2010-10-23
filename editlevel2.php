<?php session_start();
	if(!isset($_SESSION['userid'])){
		echo "<div class='error1'>Looks like your session has expired. Please login back</div>";
		exit();
	}

	include('db.php');
	include('functions.php');
	include('main_includes.php');
	include('page_includes_js.php');


$sql = "SELECT s.common_name, s.alternative_english_names, s.scientific_name, l.location_name, ";
	$sql.= "l.city, st.state, l1.number, l1.accuracy, l1.entry_notes, l1.sighting_date, l1.species_id, l1.sighting_type,l1.flight_dir,";
	$sql.= "l1.location_id, l1.obs_start, l1.frequency, l1.notes, l1.user_friend, l1.entered_on, l1.obs_type ";
	$sql.= "FROM migwatch_l1 l1 INNER JOIN migwatch_species s ON l1.species_id = s.species_id ";
	$sql.= "INNER JOIN migwatch_locations l ON l1.location_id = l.location_id ";
	$sql.= "INNER JOIN migwatch_states st ON st.state_id = l.state_id ";
	$sql.= "WHERE l1.user_id = ".$_SESSION['userid']." AND l1.id=".$_GET['id']." ORDER BY sighting_date DESC";
	$sql;
	$result = mysql_query($sql);
	if($result){
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$sdt = date("d-m-Y",strtotime($row{'sighting_date'}));
			$species_name = $row{'common_name'};
			$obstart = date("d-m-Y",strtotime($row{'obs_start'}));
			$often = $row{'frequency'};
			$user_friend = $row{'user_friend'};
			$notes = $row{'notes'};
			$often = $row['frequency'];
			$loc = $row{'location_name'}." - ".$row{'city'}." - ".$row{'state'};
			$obs_type = $row['obs_type'];
			$number = $row['number'];
			$alternative_eng_names = $row['alternative_english_names'];
			$scientific_name = $row['scientific_name'];
			$number = empty($row['number']) ? '' : $row['number'];
			$accuracy = $row['accuracy'];
			$entry_notes = $row['entry_notes'];
			$sighting_type = $row['sighting_type'];
			$flight_dir = $row['flight_dir'];
		}

		if ($error == 1 && !empty($errors)) {
			$sdt = $lastData['dt'];
			$obstart = date("d-m-Y",strtotime($lastData['obstart']));
			$often = $lastData['often'];
			$user_friend = getStripped($lastData['other_name']);
			$notes = getStripped($lastData['other_notes']);
			$number = getStripped($lastData['number']);
			$accuracy = getStripped($lastData['accuracy']);
			$entry_notes = getStripped($lastData['entry_notes']);
			$sighting_type = getStripped($lastData['sighting_type']);
			$flight_dir = getStripped($lastData['flight_dir']);
		}
	}

?>
<script type="text/javascript" src="jquery.validate.js"></script>
<script type="text/javascript" src="jquery.form.js"></script>
<script type="text/javascript">


$(document).ready(function() { 

    
    // validate signup form on keyup and submit 
   $("#editsightings").validate({ 
     
        rules: { 
            species_name: { required: true },
       
				location_name: { required: true },
             
			   obstart: { required: true },
				obs_type: { required: true },
				often: { required: true },
		      dt: { required: true,
					
				},
				number: { required: true,
				// digits:true 
				},
				accuracy: { required: true },
				
        },
	
	messages: {
           species_name: "please enter a species name",
        
			
			  location_name: "Please select a location name",
			  obstart: "Please select a date",
			  obs_type: "Please select a sighting type",
			often: "please choose how often you visit this location",
			dt : { required: "please choose a date" },
		   number: {
							required: "Please enter the number of species",
							//digits: "please enter only digits"
			},
			
				
	},

	debug: true,
});
 


}); 

$().ready(function() {
    $("#editLocation").autocomplete("edit_miglocations.php", {
            width: 250,
                selectFirst: false,
                mustMatch:true,
        });

      $("#species").autocomplete("autocomplete.php", {
                        width: 200,
                        selectFirst: false,
                        matchSubset :0,
                        extraParams : {all : 1},
                        mustMatch:true,
                        //formatItem:formatItem
                });
    


    
});


</script>
</head><body>



	<!----------SIGHTING DETAIL START--------------------->
	<p>

		
		<table width=700 cellpadding=4 cellspacing=0>
			
			<tr><td><div class='message'></div><div id='updateSightingTarget'></div></td></tr>
     </table>
		<form name="frm_editlevel1" id="editsightings" method=post action="updatesighting.php">
	
				<table>
				<tr bgcolor=#ffffff><td width=180px>Species</td>
				<td><input type="text" style="width:250px" id="species" name="species_name" value="<?php  print $species_name; ?>"></td></tr>
				<tr bgcolor=#ffffff><td width=180px>Location</td><td>
					<input type="text" style="width:250px" id="editLocation" name="location_name" value="<?php print $loc; ?>">
					<input type="hidden" name="location" value="">
				</td></tr>
				<tr bgcolor=#ffffff><td>Observation <?php echo ($obs_type == 'first') ? 'Start' : 'End' ; ?> date</td>
					<td>
					<input type=text class="startDate" id="obstart" name=obstart value="<?php print $obstart; ?>" readonly="readonly"  onclick="showCalendarControl(obstart);"/> *
				</td></tr>
				<tr><td>Observation type</td><td>
        			<select name="obs_type">
                                                <option value="" >Select</option>
                                                <option value="first" <?php print($obs_type == "first" ? " selected " : "") ?>>First</option>
						<option value="general" <?php print($obs_type == "general" ? " selected " : "") ?>>General</option>
                                                <option value="last" <?php print($obs_type == "last" ? " selected " : "") ?>>Last</option>										</select>
				</td></tr>
				<tr bgcolor=#ffffff><td width=180px>Frequency of bird watching</td><td>
					<select name="often">
						<option value="" >Select</option>
						<option value="Daily" <?php print($often=="Daily" ? " selected " : "") ?>>Daily</option>
						<option value="Weekly" <?php print($often=="Weekly" ? " selected " : "") ?>>Weekly</option>
						<option value="Fortnightly" <?php print($often=="Fortnightly" ? " selected " : "") ?>>Fortnightly</option>
						<option value="Monthly" <?php print($often=="Monthly" ? " selected " : "") ?>>Monthly</option>
						<option value="Irregular" <?php print($often=="Irregular" ? " selected " : "") ?>>Irregular</option>
						<option value="First visit" <?php print($often=="First visit" ? " selected " : "") ?>>This is my first visit</option>
					</select>
				</td></tr>
				<tr bgcolor=#ffffff><td width=180px>Date of <?php echo ucfirst($obs_type); ?> sighting</td><td>
					<input type=text class="endDate" id="obdate" name=dt readonly="readonly" value="<?php print $sdt; ?>"  onclick="showCalendarControl(dt);" /> *
				</td></tr>
				<tr bgcolor=#ffffff><td width=180px>Number</td><td>
					<input type=text name="number" value="<?php print $number; ?>" style="width:150px">
				</td></tr>
				<tr bgcolor=#ffffff><td width=180px>Accuracy</td><td>
					<select name="accuracy">
						<option value="" <?php print($accuracy=="" ? " selected " : "") ?>>--SELECT--</option>
						<option value="exact" <?php print($accuracy=="exact" ? " selected " : "") ?>>Exactly</option>
						<option value="approximate" <?php print($accuracy=="approximate" ? " selected " : "") ?>>Approximately</option>
					</select>
				</td></tr>
				<tr bgcolor=#ffffff><td width=180px>Notes on this Record</td><td>
					<input type=text name="entry_notes" id="entry_notes" value="<?php print htmlentities($entry_notes); ?>" style="width:250px">
				</td></tr>
				<tr bgcolor=#ffffff><td width=180px>Reported on behalf of</td><td>
					<input type=text name="other_name" value="<?php print htmlentities($user_friend); ?>" style="width:150px">
				</td></tr>
				<tr bgcolor=#ffffff><td width=180px>General notes about this location</td><td>
					<textarea name="other_notes" class="editbox" style="width:200px; height:100px"><?php print $notes; ?></textarea>
				</td></tr>
		 <? if($species_name == 'Pied Cuckoo'){ ?>
				<tr bgcolor=#ffffff><td width=180px>Sighting Type</td><td>
					<select name="sighting_type">
						<option value="" <?php print($sighting_type =="" ? " selected " : "") ?>>--SELECT--</option>
						<option value="saw" <?php print($sighting_type =="saw" ? " selected " : "") ?>>Saw</option>
						<option value="heard" <?php print($sighting_type == "heard" ? " selected " : "") ?>>Heard</option>
						<option value="saw_heard" <?php print($sighting_type == "saw_heard" ? " selected " : "") ?>>Saw & Heard</option>
					</select> *
				</td></tr>
				<tr bgcolor=#ffffff><td width=180px>Flight Direction</td><td>
					<select name="flight_dir">
<option value="" <?php print($flight_dir =="" ? " selected " : "") ?>>--SELECT--</option>
<option value='S-N' <?php if(isset($lastData['flight_dir'][$j]) && $lastData['flight_dir'][$j] == 'S-N') echo 'selected' ?>>S-N</option>        
<option value='SE-NW' <?php if(isset($lastData['flight_dir'][$j]) && $lastData['flight_dir'][$j] == 'SE-NW') echo 'selected' ?>>SE-NW</option>   
<option value='E-W' <?php if(isset($lastData['flight_dir'][$j]) && $lastData['flight_dir'][$j] == 'E-W') echo 'selected' ?>>E-W</option>         
<option value='NE-SW' <?php if(isset($lastData['flight_dir'][$j]) && $lastData['flight_dir'][$j] == 'NE-SW') echo 'selected' ?>>NE-SW</option>   
<option value='N-S' <?php if(isset($lastData['flight_dir'][$j]) && $lastData['flight_dir'][$j] == 'N-S') echo 'selected' ?>>N-S</option>         
<option value='NW-S' <?php if(isset($lastData['flight_dir'][$j]) && $lastData['flight_dir'][$j] == 'NW-S') echo 'selected' ?>>NW-S</option>        
<option value='W-E' <?php if(isset($lastData['flight_dir'][$j]) && $lastData['flight_dir'][$j] == 'W-E') echo 'selected' ?>>W-E</option>          
<option value='SW-NE' <?php if(isset($lastData['flight_dir'][$j]) && $lastData['flight_dir'][$j] == 'SW-NE') echo 'selected' ?>>SW-NE</option> 
					</select> 
				</td></tr>
				
				   <tr bgcolor=#ffffff><td>Resident Check</td><td><input name="resident_check" value=1 type=checkbox <? if($checked == '1'){ ?> checked = "<? echo $checked; }?>"><td></tr>
				<? } ?>
				<tr bgcolor=#ffffff><td>
				<input type=submit value="Update" name="updatesighting" onclick="return validate();"/>
				</td></tr>
				</table>
			
		</form>
	<script type="text/javascript">

function validate() {
	var now = new Date;
   var obstart = $('#obstart').val();
   var sdt = $('#obdate').val();
   
   <?php
  if ($obs_type == 'last') {
	?>
		if((compareDates(sdt,"dd-MM-yyyy",formatDate(now,"dd-MM-yyyy"),"dd-MM-yyyy") == 1) || (compareDates(obstart,"dd-MM-yyyy",sdt,"dd-MM-yyyy")==1))	{
			$('.message').html("The date of first sighting is either in future or before observation start date. Please check.");
			return false;
		}
	
	<?php
            
	}else {
	?>
		if((compareDates(sdt,"dd-MM-yyyy",formatDate(now,"dd-MM-yyyy"),"dd-MM-yyyy") == 1) || (compareDates(obstart,"dd-MM-yyyy",sdt,"dd-MM-yyyy")==1))	{
		    $('.message').html("The date of first sighting is either in future or before observation start date. Please check.");
			return false;
		}
	
	<?php
		
	} 
	?> 

}

$().ready(function() {
$('#editsightings').ajaxForm({ 
        // target identifies the element(s) to update with the server response 
        target: '#updateSightingTarget',
 
        // success identifies the function to invoke when the server response 
        // has been received; here we apply a fade-in effect to the new content 
        success: function() { 
            $('#updateSightingTarget').fadeIn('slow'); 
        } 
    });
	
});
</script>
</body></html>
