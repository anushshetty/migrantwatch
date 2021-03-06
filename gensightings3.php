<?php 
	
	//include("functions.php");
	//include('db.php');

	//$user_id = $_SESSION['userid'];

	if($_POST['cmd'] != 'speciessighting') {
		$lastData = $_POST;
		$rowCount = count($lastData['obdate']);
	} else {
		unset($lastData);
	}

	if (!empty($_GET['loc_id'])) {
		$lastData['location'] = $_GET['loc_id'];
	}

	$last = 0;
	$start = 'start';
	$look = 'do you look';
	$sighting = 'General';
	$after = 'before';

	//  The current season..
	$today = getdate();
	$currentSeason = ($today['mon'] > 6) ? $today['year'] : $today['year'] - 1;

	if(isset($_GET['state']) && isset($_GET['loc'])) {
		$_SESSION['location'] = $_GET['loc'];
	}

?>

<link href="CalendarControl.css"  rel="stylesheet" type="text/css">
<script src="CalendarControl.js" language="javascript"></script>
<script src="jquery.autocomplete.js" language="javascript"></script>
<script src="jquery.bgiframe.min.js" language="javascript"></script>
<script src="jquery.autocomplete.js" language="javascript"></script>
<link href="jquery.autocomplete.css"  rel="stylesheet" type="text/css" />
<script src="date.js" language="javascript"></script>
<link href="jqmodal.css"  rel="stylesheet" type="text/css" />
<script src="jqmodal.js" language="javascript"></script>
<link href="thickbox.css"  rel="stylesheet" type="text/css" />
<script src="thickbox.js" language="javascript"></script>

     
<script language="JavaScript" type="text/javascript">
	
	// define a custom method on the string class to trim leading and training spaces
	String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ''); };

	var reWhitespace = /^\s+$/

	function isEmpty(s){
		return ((s == null) || (s.length == 0))
	}

	function isWhitespace (s) {	// Is s empty?
		return (isEmpty(s) || reWhitespace.test(s));
	}

	function displaytr(opt){
		if(opt==1)
			document.getElementById("loctr").style.display = "block";
		else
			document.getElementById("loctr").style.display = "none";
	}

	function addLocation(){
		if(isWhitespace(document.frm_level1.nlname.value)){
			alert("Please enter location name.");
			return;
		}
		if (document.frm_level1.nlstate.value == -1){
			alert("Please select a state for new location");
			return;
		}
		document.frm_level1.cmd.value = "newlocation";
		document.frm_level1.action="process_level1.php";
		document.frm_level1.submit();
	}

	function stateChanged() {
		document.frm_level1.cmd.value = "statechanged";
		document.frm_level1.action = "gensightings.php";
		document.frm_level1.submit();
	}

	function locSelected(){
		document.frm_level1.cmd.value = "locselected";
		document.frm_level1.action = "gensightings.php";
		document.frm_level1.submit();
	}

	var HintClass = 'hintTextbox';
	var hintText = 'Please enter identification details';
	var HintActiveClass = "hintTextboxActive";
	var speciesHintText = 'Type part of a species name';

	function appendNewInput()
	{
	  var tbl = $('#catTable');
	  var lastRow = $('#catTable tr').length;

	  // if there's no header row in the table, then iteration = lastRow + 1
	  var iteration = lastRow;

	  var newElement =
		"<tr>"
			
			+ "<td width='150px'>"
			+ "<input type='text' id='species_" + iteration +"' name='species[]' size='25' value='Type part of a species name' class='hintTextbox'></td>"
		 + "<td>"
                        + "<input type='text' id='obdate_" + iteration + "' name='obdate[]' value='' onclick='showCalendarControl(obdate_" + iteration + ");' style='width:75px'> "
                        + "<input type='button' id='obdate_but_" + iteration + "' value='Choose' onclick='showCalendarControl(obdate_" + iteration + ");' /></td>"
		+ "<td><input type='text' id='number_" + iteration +"' name='number[]' size='5'></td>"
		+ "<td>"
			+ "<select id= 'accuracy_" + iteration + "' name='accuracy[]'>"
			+ "<option value=''>-- SELECT --</option>"
			+ "<option value='exact'>Exactly</option>"
			+ "<option value='approximate'>Approximately</option>"
			+ "</select>"
		+ "</td>"
		+ "<td><input type='text' id='entry_notes_" + iteration + "' name='entry_notes[]' size='35' style='width:211px'></td>"
		"</tr>";

		$('#catTable').append(newElement);
	  	$("#species_" + iteration).autocomplete("autocomplete.php", {
			width: 260,
			selectFirst: false,
			matchSubset :0,
			extraParams : {all : 1},
			formatItem:formatItem
	  	});

		var hintText = 'Please enter identification details';
	  	$("#species_" + iteration).result(function(event, data, formatted) {
			if (data[1] == 1) {
				if ($("#entry_notes_" + iteration).val != '') {
					$("#entry_notes_" + iteration).val(hintText);
					$("#entry_notes_" + iteration).addClass(HintClass);
					var id = "entry_notes_" + iteration;
					$("#entry_notes_" + iteration).focus( function() { onHintTextboxFocus(id,hintText) } );
					$("#entry_notes_" + iteration).blur( function() { onHintTextboxBlur(id,hintText) } );
				}
			} else {
				if ($("#entry_notes_" + iteration).val() == hintText) {
					$("#entry_notes_" + iteration).removeClass(HintClass);
					$("#entry_notes_" + iteration).removeAttr('onFocus');
					$("#entry_notes_" + iteration).removeAttr('onBlur');
					$("#entry_notes_" + iteration).val('');
				}
			}
	  	});

		var id = "species_" + iteration;
		$("#species_" + iteration).focus( function() { onHintTextboxFocus(id,speciesHintText) } );
		$("#species_" + iteration).blur( function() { onHintTextboxBlur(id,speciesHintText) } );

	}

	 $(document).ready(function() {
		$('#species_1').autocomplete("autocomplete.php", {
			width: 260,
			selectFirst: false,
			matchSubset :0,
			extraParams : {all : 1},
                        mustMatch: true,                       
			formatItem:formatItem
		});

                $().ready(function() {
		    $('#dialog').jqm();
		 
		  });
		
		
		var iteration = 1;
		var hintText = 'Please enter identification details';
		$("#species_1").result(function(event, data, formatted) {
			if (data[1] == 1) {
				if ($("#entry_notes_" + iteration).val != '') {
					$("#entry_notes_" + iteration).val(hintText);
					$("#entry_notes_" + iteration).addClass(HintClass);
					var id = "entry_notes_" + iteration;
					$("#entry_notes_" + iteration).focus( function() { onHintTextboxFocus(id,hintText) } );
					$("#entry_notes_" + iteration).blur( function() { onHintTextboxBlur(id,hintText) } );
				}
			} else {
				if ($("#entry_notes_" + iteration).val() == hintText) {
					$("#entry_notes_" + iteration).removeClass(HintClass);
					$("#entry_notes_" + iteration).removeAttr('onFocus');
					$("#entry_notes_" + iteration).removeAttr('onBlur');
					$("#entry_notes_" + iteration).val('');
				}
			}
                      

		});


		var id = "species_" + iteration;
		$("#species_" + iteration).focus( function() { onHintTextboxFocus(id,speciesHintText) } );
		$("#species_" + iteration).blur( function() { onHintTextboxBlur(id,speciesHintText) } );
	});




function formatLocation(row) {
  var completeRow;
  completeRow = new String(row);
  splittedStr = completeRow.split(",");
  var newrow = '';
  for(var i=0; i< splittedStr.length; i++) {
    if(isNaN(splittedStr[i])) {
      newrow += splittedStr[i] +",";
    } else if(splittedStr[i] > 0 ){
      break;
    }
  }
  newrow = newrow.substr(0, newrow.lastIndexOf(","));
  return newrow;
}


	function onHintTextboxFocus(id,text) {
	  var input = document.getElementById(id);
	  if (text != undefined) {
	  	hintText = text;
	  }

	  if (input.value.trim()== hintText) {
	    input.value = "";
	    input.className = HintActiveClass;
	  }
	}

	function onHintTextboxBlur(id,text) {
	  var input = document.getElementById(id);

	  if (text != undefined) {
	  	hintText = text;
	  }

	  if (input.value.trim().length==0) {
	    input.value = hintText;
	    input.className = HintClass;
	  }
	}

	function onSpeciesChange(id,text) {

		if (text != undefined) {
			hintText = text;
		}

		if ($("#" + id).val() == hintText) {
			$("#" + id).removeClass(HintClass);
			$("#" + id).removeAttr('onFocus');
			$("#" + id).removeAttr('onBlur');
			$("#" + id).val('');
		}
	}

	function strrpos(haystack, needle, offset) {
	    // http://kevin.vanzonneveld.net
	    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // *     example 1: strrpos("Kevin van Zonneveld", "e");
	    // *     returns 1: 16

	    var i = haystack.lastIndexOf( needle, offset ); // returns -1
	    return i >= 0 ? i : false;
	}

	function substr( f_string, f_start, f_length ) {
	    // http://kevin.vanzonneveld.net
	    // +     original by: Martijn Wieringa
	    // *         example 1: substr("abcdef", 0, -1);
	    // *         returns 1: "abcde"

	    if(f_start < 0) {
	        f_start += f_string.length;
	    }

	    if(f_length == undefined) {
	        f_length = f_string.length;
	    } else if(f_length < 0){
	        f_length += f_string.length;
	    } else {
	        f_length += f_start;
	    }

	    if(f_length < f_start) {
	        f_length = f_start;
	    }

	    return f_string.slice(f_start,f_length);
	}

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

	function validate() {
		var last = <?php print($last); ?>;
		var now = new Date();
		var obstart = document.frm_level1.obstart.value;
		if(last == 1) {
			var first = 'Last';
		} else {
			var first = 'First'
		}
                
                var currentLocation = document.getElementById("addCurrentLocation");

		if( currentLocation.value == "") {
			alert("Please select a location for the Observations.");
			return false;
		}
		if (obstart == "") {
			if(last == 1) {
				alert("Please enter the date when you stopped looking for birds at this location \n(in the current migration season)");
			} else {
				alert("Please enter the date when you started looking for birds at this location \n(in the current migration season)");
			}
			return false;
		} else if(compareDates(obstart, "dd-MM-yyyy", formatDate(now, "dd-MM-yyyy"), "dd-MM-yyyy") == 1) {
			alert("The Start/end date of observation cannot be a future date");
			return false;
		}

		if (document.frm_level1.often.value == "") {
			alert("Please select How often you look for birds at this location?");
			return false;
		}

		var tbl = $('#catTable');
		var lastRow = $('#catTable tr').length - 1;
        var obSeason = season($('#obstart').val());
		for(var i = 1; i <= lastRow; i++) {

			if ($('#obdate_' + i).val() != '' || (i == 1)) {
				var obdate = $('#obdate_' + i).val();
				if ($('#species_' + i).val() == '' || $('#species_' + i).val() == speciesHintText) {
					alert('Please enter the species for the for the entry no. ' + i);
					$('#species_' + i).focus();
					return false;
				}

				if (compareDates(obdate,"dd-MM-yyyy",formatDate(now,"dd-MM-yyyy"),"dd-MM-yyyy") == 1) {
					alert("The observation date cannot be a future date.");
					return false;
				}
			}

			if (($('#species_' + i).val() != '' && $('#species_' + i).val() != speciesHintText) || (i == 1)) {
				if ($('#obdate_' + i).val() == '') {
					alert('Please enter the ' + first + ' Sighting Date for this species (entry no. ' + i +')');
					$('#obdate_' + i).focus();
					return false;
				} else {
					var obdate = $('#obdate_' + i).val();
					var ob_type = $('#ob_type_' + i).val();

					if(compareDates(obdate,"dd-MM-yyyy",formatDate(now,"dd-MM-yyyy"),"dd-MM-yyyy") == 1) {
						alert("Sighting dates cannot be future dates ");
						return false;
					} else if(last == 0) {
                        if(season(obdate) != obSeason) {
                            var alertstr = "You have entered a START date in the "+formatSeason(obSeason)+" migration season. ";
                            alertstr += "If your record is not from the "+formatSeason(obSeason)+" season,";
                            alertstr += " please enter a start date between 1 July and 30 June of the correct season.";
                            alertstr += "\nAre you sure you want to enter sighting for season "+formatSeason(obSeason)+"?";
                            if(!confirm(alertstr)) {
                                return false;
                            }
                        } else if(currentSeason() != obSeason) {
                            if(!confirm("Are you sure you want to enter sighting for season "+formatSeason(obSeason)+"?")) {
                                return false;
                            }
                        }
                        if(compareDates(obstart, "dd-MM-yyyy", obdate, "dd-MM-yyyy") == 1) {
                            alert("The " + first + " Sighting Date cannot be a date before start of observations");
                            return false;
                        }
					} else if(last == 1) {
                        /*if(season(obdate) != obSeason) {
                            var alertstr = "You have entered a Observation END date in the "+formatSeason(obSeason)+" migration season. ";
                            alertstr += "If your record is not from the "+formatSeason(obSeason)+" season,";
                            alertstr += " please enter a observation end date between 1 July and 30 June of the correct season.";
                            alertstr += "\nAre you sure you want to enter sighting for season "+formatSeason(obSeason)+"?";
                            alert(alertstr);
                            return false;
                        }*/
                        if(compareDates(obdate, "dd-MM-yyyy", obstart, "dd-MM-yyyy") == 1) {
                            alert("The " + first + " Sighting Date cannot be a date after the end of observations");
                            return false;
                        }
					}
				}
			}

			if ($('#species_' + i).val() != '' && $('#obdate_' + i).val() != '') {
				var num = $('#number_' + i).val();
				var acc = $('#accuracy_' + i).val();
				if (!isWhitespace(num) && isNaN(num)) {
					alert('Please enter only numerals under \'Number\'');
					$('#number_' + i).focus();
					return false;
				}

				if ((!isWhitespace(num) && num != '') && acc == '') {
					alert('Please select the \'Accuracy of count\' for entries where \'Number\' has been entered.');
					$('#accuracy_' + i).focus();
					return false;
				}
			}
		}
	}

	function setLocationData() {
		document.forms[0].cmd.value = 'loc_change';
		document.forms[0].action = 'gensightings.php';
		document.forms[0].submit();
	}

    function season(inputDate) {
        var seasonArray = inputDate.split("-");
        if(seasonArray[1] < 7) {
            return parseInt(seasonArray[2]) - 1;
        } else {
            return seasonArray[2];
        }
    }

    function currentSeason() {
        var currDate = new Date();
        if(currDate.getMonth() < 7) {
            return parseInt(currDate.getFullYear()) - 1;
        } else {
            return currDate.getFullYear();
        }
    }
    function formatSeason(seasonStart) {
        var seasonEnd = parseInt(seasonStart) + 1;
        var str = new String(seasonEnd);
        str = str.substring(2);
        return (seasonStart+'/'+str);
    }
</script>
<script type="text/javascript">

 $().ready(function() {
    $('#addCurrentLocation').autocomplete("auto_miglocations.php", {
      width: 300,
	  selectFirst: false,
	  matchSubset :0,
	  formatItem:formatLocation,
          
	  });
    $("#addCurrentLocation").result(function(event, data, formatted) {
        $('#location').val(data[1]);
        $('#locDetails').show();
        $('#addloc').hide();
        $('#details_loc').html(data[2]);
        $('#details_city').html(data[3]);
        $('#details_dist').html(data[4]);
        $('#details_state').html(data[5]);
        var obs_start = data[6];
        obs_start = obs_start.split('-');
        obsstart = obs_start[2] + '-' +  obs_start[1] + '-' + obs_start[0];
        $('#obstart').val(obsstart);
        document.getElementById('often').value = data[7];
        var loc_data = data[1];
       
      var table = "<a href=\"prev.php?id=" + loc_data + "\" class=\"thickbox\" title=\"Detailed information of selected issue\">View Previous</a>";

document.getElementById('prev_sightings').innerHTML = table;
tb_init('a.thickbox'); // Initialise again



        
      });

      $("#loc_info_box").hide();

      $('a#loc_ob_box').click(function() {
               $('#loc_info_box').toggle();
      });
  }); 

 
</script>
<style>

  /* jqModal base Styling courtesy of;
     Brice Burgess <bhb@iceburg.net> */

  /* The Window's CSS z-index value is respected (takes priority). If none is supplied,
  the Window's z-index value will be set to 3000 by default (in jqModal.js). You
  can change this value by either;
    a) supplying one via CSS
    b) passing the "zIndex" parameter. E.g.  (window).jqm({zIndex: 500}); */
  
.jqmWindow {
    display: none;
    
    position: fixed;
    top: 17%;
    left: 40%;
    
      /*margin-left: -300px; */
    width: 600px;
    
      background-color: #EEE;
    color: #333;
    border: 1px solid black;
    padding: 12px;
  }

.jqmOverlay { background-color: #000; }

/* Fixed posistioning emulation for IE6
     Star selector used to hide definition from browsers other than IE6
     For valid CSS, use a conditional include instead */
* html .jqmWindow {
position: absolute;
top: expression((document.documentElement.scrollTop || document.body.scrollTop) + Math.round(17 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + 'px');
}

</style>
<?php
if ($_GET['error'] == 1) {
	$error = 1;
	$lastData = $_SESSION['gensightings'];
	$rowCount = count($lastData['obdate']);
	$duplicate = (isset($lastData['duplicate']))? $lastData['duplicate'] : '';
	$errors = $lastData['errors'];
	$duplicate_species = $lastData['duplicate_species'];
} else {
	$rowCount = ($rowCount > 0) ? $rowCount : 1;
}
unset($_SESSION['gensightings']);

$errorStrings = array(
						'location' => 'Please select a location',
						'no_obStart' => 'Please enter the date when you started looking for birds at this location (in the current migration season)',
						'no_obEnd' => 'Please enter the date when you stopped looking for birds at this location (in the current migration season)',
						'obstart' => "The Observation $start date should be in (DD-MM-YYYY) format and should not be a future date",
						'no_obdate' => "Please enter $sighting Sighting Date for this species",
						'often' => 'Please select how often you look for birds',
						'obdate' => "The Sighting date should be in (DD-MM-YYYY) format and should not be a future date",
						'ob_compare' => "The $sighting Sighting Date cannot be a date $after observation start date",
						'species' => 'This species is not been tracked currently.',
						'number' => "Please enter only numerals under 'Number'",
						'accuracy' => "Please select the 'Accuracy of Count' in the entries for which the 'Number' has been entered",
						'duplicate' => $duplicate
					);

$speciesHintText = 'Type part of a species name';

if (!empty($errors)) {
	foreach ($errors as $field) {
		print("<p style='color:red'><b>". $errorStrings[$field]."</b></p>");
	}
}
?>
<div id="gen_form">
<form method='post'  name='frm_level1' action='process_level1.php'>
<input type='hidden' name='last' value='<?php echo $last; ?>' />
<table border=0 cellpadding=2 cellspacing=1 class="box" style="width:800px">
    <?php
		$locations = getAllMyLocationData($user_id,$connect);
        if(!empty($locations)) {
    ?>
	
	<tr>
		<td style="width:200px">
		If you are reporting sightings on behalf of someone else, please
		give that persons name :
		</td>
		<td><input type=text name="other_name" value="<?php print getStripped(htmlentities($lastData['other_name'],ENT_QUOTES)); ?>" style="width:150px"></tr>
	</tr>
    <?php
        }
    ?>
	
	<?php
		if (!empty($locations)) {
	?>
	<tr>
	   <td>Location</td><td><input style="width:300px" type="text" id="addCurrentLocation" name="addCurrentLocation" value=""><input type="reset" value="Clear" onclick="$('#locDetails').hide()"> </td>
	</tr><tr><td><a href="#" class="jqModal">Add a new Location</a></td>



         <div class="jqmWindow" id="dialog" style="width:800px">

<a href="#" class="jqmClose">Close</a>
<hr>
 
<iframe src="maps.php" style="width:750px; height:400px"></iframe>
		

</div>



	</tr><tr><td colspan="2">
<input type="hidden" name="location" id="location" value="" />

		<table id="locDetails" width="770px" style="border:1px solid rgb(222, 222, 222);display:none;">
    <tr width="100%">
        <td colspan="4" bgcolor="#efefef"><strong>Location Details</strong></td>
    </tr>
    <tr>
        <td width="25%">Location Name</td><td>City</td><td>District</td><td>State</td>
       
    </tr>
    <tr bgcolor="#fff">
        <td><div id="details_loc"><div></td>
        <td><div id="details_city"></div></td>
        <td><div id="details_dist"><div></td>
        <td><div id="details_state"><div></td>
        <td><div id="prev_sightings"></div></td>
    </tr>
    
  
   


</table>
</table><table><!--<tr><td><div id="prev_sightings"></div></td></tr>-->
<tr>
		<td bgcolor="dedede" colspan=2><b>Observation Details</b></td>
	</tr>
	<tr>
		<td align=right>When did you <?php print(strtoupper($start)); ?> looking for birds at this location?</td>
		<td>
			<input type=text id="obstart" name=obstart size="10" value="" onclick="showCalendarControl(obstart);"><input type=button value="Choose" onclick="showCalendarControl(obstart);" /> (dd-mm-yyyy)*
			<br>
			<!--(Date when you <?php echo ($last == 1) ? 'stopped' : 'started'; ?> observing at this location after 1st Aug 2007)-->
		</td>
	</tr>
	<tr>
		<td align=right>How often <?php print($look); ?> for birds at this location?</td>
		<td>
			<select name="often" id="often">
				<option value="" >Select</option>
				<option value="Daily" <?php print($lastData[often]=="Daily" ? " selected " : "") ?>>Daily</option>
				<option value="Weekly" <?php print($lastData[often]=="Weekly" ? " selected " : "") ?>>Weekly</option>
				<option value="Fortnightly" <?php print($lastData[often]=="Fortnightly" ? " selected " : "") ?>>Fortnightly</option>
				<option value="Monthly" <?php print($lastData[often]=="Monthly" ? " selected " : "") ?>>Monthly</option>
				<option value="Irregular" <?php print($lastData[often]=="Irregular" ? " selected " : "") ?>>Irregular</option>
				<option value="First visit" <?php print($lastData[often]=="First visit" ? " selected " : "") ?>>This is my first visit</option>
			</select> *
		</td>
	</tr>
	<tr>
                <td colspan="2"><a href="#" id="loc_ob_box">Add general notes about this location</a></td></tr><tr>
                <td id="loc_info_box" colpsan="2"><textarea name="other_notes" class="editbox" style="width:300px;height:100px"><?php print getStripped($lastData['other_notes']); ?></textarea>
                        <br>(eg, habitat, disturbance, etc.)
                </td>
        </tr>

	
	
	
</table>

<table id='catTable' class="box" style="width:500px">
	<tbody>
	<tr>
		
		<td width='150px'>Species</td>
		<td width='180px'>Date<br>(dd-mm-yyyy)</td>
		<td>Number</td>
		<td>Accuracy of count</td>
		<td>Notes on this Record</td>
	</tr>
	<?php
		if ($rowCount == 0) {
			$rowCount = 1;
		}

		for($i = 1; $i <= $rowCount; $i++) {
			$j = $i - 1;
	?>
	<tr id='cloneme'>
		<!--<td><?php print($i);?></td>-->
		<td>
			<input type='text' id='species_<?php echo $i; ?>' name='species[]' size='25'
			value='<?php
						$useDefault = 0;
						if(isset($lastData['species'][$j]) && !empty($lastData['species'][$j])) {
							$species_sel = getStripped(htmlentities($lastData['species'][$j],ENT_QUOTES));
							if ($speciesHintText == $species_sel) {
												$useDefault = 1;
							}
							echo $species_sel;
						} else {
							echo $speciesHintText;
							$useDefault = 1;
						}
					?>'"
					<?php
						// TODO : even in case of error make the functionality work.
						if ($useDefault == 1)
									echo " class=\"hintTextbox\" onFocus=\"onHintTextboxFocus('species_$i',speciesHintText)\" onBlur=\"onHintTextboxBlur('species_$i',speciesHintText)\"";
					?>></td>
		 <td>
                        <input type='text' id='obdate_<?php echo $i; ?>' name='obdate[]' value='<?php if(isset($lastData['obdate'][$j])) echo $lastData['obdate'][$j]; ?>' style='width:75px' onclick="showCalendarControl(obdate_<?php echo $i; ?>);">
            <input type='button' id='obdate_but_<?php echo $i; ?>' value="Choose" onclick="showCalendarControl(obdate_<?php echo $i; ?>);" /></td>

			<td><input type="text" id='number_<?php echo $i ?>' name='number[]' size="5" value='<?php if(isset($lastData['number'][$j])) echo $lastData['number'][$j]; ?>'></td>
		<td>
			<select id= 'accuracy_<?php echo $i ?>' name='accuracy[]'>
				<option value=''>-- SELECT --</option>
				<option value='exact' <?php if(isset($lastData['accuracy'][$j]) && $lastData['accuracy'][$j] == 'exact') echo 'selected' ?>>Exactly</option>
				<option value='approximate' <?php if (isset($lastData['accuracy'][$j]) && $lastData['accuracy'][$j] == 'approximate') echo 'selected' ?>>Approximately</option>
			</select>
		</td>
		<td><input type="text" id='entry_notes_<?php echo $i?>' name='entry_notes[]' size="35" value='<?php if(isset($lastData['entry_notes'][$j])) echo getStripped(htmlentities($lastData['entry_notes'][$j],ENT_QUOTES)); ?>' style='width:211px'
		<?php
		if($lastData['entry_notes'][$j] == 'Please enter identification details') {
			echo " onFocus=\"onHintTextboxFocus(id,hintText)\" onBlur=\"onHintTextboxBlur('entry_notes_$i','Please enter identification details')\" class='hintTextbox'";
		}
		?>
		>
		</td>
	</tr>
	<?php
			if ($i > 1) {


				?>

				<script type="text/javascript">
  				 //$(document).ready(function(){
					
				//});

				</script>
                                 <?
				echo <<<JS
				<script language='javascript'>
				  	 $("#species_" + $i).autocomplete("autocomplete.php", {
						width: 260,
						selectFirst: false,
						matchSubset :0,
						extraParams : {all : 1},
						formatItem:formatItem
				  	});
					
					
                                    

				  	$("#species_" + $i).result(function(event, data, formatted) {
						if (data[1] == 1) {
							if ($("#entry_notes_" + $i).val != '') {
								$("#entry_notes_" + $i).val(hintText);
								$("#entry_notes_" + $i).addClass(HintClass);
								var id = "entry_notes_" + $i;
								$("#entry_notes_" + $i).focus( function() { onHintTextboxFocus(id,hintText) } );
								$("#entry_notes_" + $i).blur( function() { onHintTextboxBlur(id,hintText) } );
							}
						} else {
							if ($("#entry_notes_" + $i).val() == hintText) {
								$("#entry_notes_" + $i).removeClass(HintClass);
								$("#entry_notes_" + $i).removeAttr('onFocus');
								$("#entry_notes_" + $i).removeAttr('onBlur');
								$("#entry_notes_" + $i).val('');
							}
						}
				  	});
				</script>
JS;
			}
		}
	?>
</table>
<a name='x'></a>
<input type="hidden" name="cmd" value="gensightings" id='cmd'/>
<input type="hidden" name="general" value="1"/>
<span style="margin-left:25px;"><a href='#x' onclick='appendNewInput()'> Add another species </a>
<div style="margin-top:5px;">
	&nbsp;&nbsp;<input type='submit' value= "Submit General Sighting"  class='buttonstyle' onclick="return validate();">
	&nbsp;&nbsp;<input type=button value="Go Back to Main Page" class=buttonstyle onclick="javascript:window.location.href='main.php';" />
</div>
<?php
    } else {
        print("</table>");
    }
?>
</form></div>
<br />



