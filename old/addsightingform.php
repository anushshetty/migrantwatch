<? function addSighting() { 
   	$speciesHintText = 'Type a name here';
	$dateHintText = 'Select';
	$numberHintText = 'In numerals';
	$notesHintText = 'Enter notes here';
?>	<script type="text/javascript">
	var obstartHint = 'Select a date';
	var speciesHintText = '<? echo $speciesHintText; ?>';
	var dateHintText = '<? echo $dateHintText; ?>';
	var numberHintText = '<? echo $numberHintText; ?>';
	var notesHintText = '<? echo $notesHintText; ?>';
   	</script>
	<div id="sightingTarget"></div>
 	<div id="full_box">
	     	<div class='sidebar' style='border:solid 1px #333'>
       		<div style='height:120px'><h4 class='sidebar-header'>do more</h4>
		<div style="margin-top:20px;margin-right:5px;text-align:right">Learn more about First, General and Last sightings</div>
	     	<div id="other_name_box" style="">
		     	<a id="ulink" class="thickbox" href="userfriend.php?&TB_iframe=true&height=400&width=600">
				See all your sightings for <br><span id="other_name_update"></span>
			</a>
	      	</div></div>
                <table><tr>
			<td><hr></td>
		</tr></table>
   		<table id="locDetails" class="addsighting_loc">		
		<tr>
		   <td style='text-align:right'>
			see all your sightings from <br><a id='your_loc_link' href='#' title='Your earlier sightings' class='thickbox'><span class='details_loc'></span></a>
		   </td>
		</tr>
        	<tr>
		   <td style='text-align:right;padding-top:15px'>
		       	see other participant' sightings from <a id='all_loc_link' href='#' class='thickbox'><span class="details_loc"></span></a>
		    </td>
		</tr>
	 	</table>
		<table>
		<tr>
		  	<td style='text-align:right'><a class='thickbox' href='species_popout.php?height=400&width=600' title='See all MigrantWatch species'>See all MigrantWatch species</a></td>
		</tr>
  		</table>
	</div>
	<div id="form">
     	 	<form id="sighting" method='post' action='savesighting.php'>
     	    		<table border=0 cellpadding=2 cellspacing=1 class='main_panel'>
			<tr>
				<td style='vertical-align:top'>Type of sighting</td><td>
		    		<table style='width:250px'>
				<tr>
		    			<td>First&nbsp;<input style='float:right' onclick="openStartDate('First','START')" type=radio name='sighting_type' value='first'></td><td></td>
					<td>General&nbsp;<input style='float:right' onclick="openStartDate('General','START')" type=radio name='sighting_type' value='general' checked></td><td></td>
                    			<td>Last&nbsp;<input style='float:right' onclick="openStartDate('Last','STOP')" type=radio name='sighting_type'value='last'></td>
		    		</tr>
		    		</table>
		 		</td>
			</tr>
	    		<tr>
				<td style='width:180px;height:80px'>
		   			If you are reporting sightings on behalf of someone else, please enter their name:
				</td>
				<td style='width:400px;margin-left:-20px'>
		 			<input size="30" type=text id="other_name" name="other_name" value="Name" style="" onKeyUp="update_others();" onKeyDown="update_others();">
	        		</td>
	   		</tr>
	   		<tr>
                         	<td colspan='2'><hr></td>
                        </tr>
	   		<tr>
				<td style='width:155px'>Location of sighting</td>
           			<td>
					<input style="width:380px" type="text" id="addCurrentLocation" name="addCurrentLocation" value="Type a location">
					<span><input type="button" style='height:28px' value="X" onclick="$('#locDetails').hide(); document.getElementById('addCurrentLocation').value = 'Type a location'; 
					document.getElementById('location').value = '';
					document.getElementById('often').value = '';
					document.getElementById('obstart').value = '';
					 "> </span>
				</td>
	   		</tr>
	   		<tr>
				<td>
					<a href="addnewlocation.php?&height=450&width=800&TB_iframe=true" class="thickbox" title="Add a new location" style='font-size:13px;'>Add a new location</a>&nbsp;<a href='' title='How to add a new location'>(help)</a>                                              
		    			<input type="hidden" name="location" id="location" value="" />
				</td>
	  		</tr>
       	  		<tr>
				<td style='width:155px'>
					Add notes about this location<br>(eg, habitat, disturbance, etc.)
				</td>
       				<td style='width:400px'>
		    		    	<textarea id="loc_notes" name="other_notes" class="editbox" style="width:380px;height:50px;">enter notes about the location</textarea>
                		</td>
         		</tr>
			<tr id='obs_date'>
				<td style='width:155px'>
					<span id='start_stop'>When did you START looking for birds at this location?</span>
				</td>
				<td style='width:400px'>
				    <input type=text id="obstart" readonly="readonly" name=obstart size="30" style=''>&nbsp;(dd-mm-yyyy)*
				</td>
			
			</tr>
			<tr>
				<td style='width:155px'>How often do you look for birds at this location?</td>
				<td style='width:380px'>
		    		    <select name="often" id="often">
		    	    		<option value="">--Select--</option>
			    		<option value="Daily" <?php print($lastData[often]=="Daily" ? " selected " : "") ?>>Daily</option>
			    		<option value="Weekly" <?php print($lastData[often]=="Weekly" ? " selected " : "") ?>>Weekly</option>
			    		<option value="Fortnightly" <?php print($lastData[often]=="Fortnightly" ? " selected " : "") ?>>Fortnightly</option>
			    		<option value="Monthly" <?php print($lastData[often]=="Monthly" ? " selected " : "") ?>>Monthly</option>
			    		<option value="Irregular" <?php print($lastData[often]=="Irregular" ? " selected " : "") ?>>Irregular</option>
			   		<option value="First visit" <?php print($lastData[often]=="First visit" ? " selected " : "") ?>>This is my first visit</option>
		     		    </select>
				 </td>
			</tr>	
			</table>
			<table id='catTable' style="width:900px;margin-left:20px;font-size:11px" class="species_table">
                     	<tr>
				<td colspan='6'><hr></td>
			</tr>
		     	<tr>		
		     		<td>Species name</td>
				<td>Date - <input type='checkbox' id='date_checkbox'></td>
				<td>Number</td>
				<td>Accuracy of count</td>
				<td>Notes on this species</td>
 				<td>Observation type</td>
			</tr>
<?php
			if ($rowCount == 0) {
				$rowCount = 1;
			}

			for($i = 1; $i <= $rowCount; $i++) {
				$j = $i - 1; 		
?>
	 		<tr id='cloneme'>
				<td>
					<input type='text' id='species_<?php echo $i; ?>' class='species_name' name='species[]' size='20' value='<? echo $speciesHintText; ?>'>
				</td>
				<td>
					<input style='font-size:11px' class='sighting_date' type='text' id='obdate_<?php echo $i; ?>' name='obdate[]' value='<? echo $dateHintText; ?>' readonly='readonly' size='8'>
      				</td>
				<td>
					<input type="text" style='font-size:11px' id='number_<?php echo $i; ?>' name='number[]' size="8" value='<? echo $numberHintText; ?>'>
				</td>
				<td>
					<select style='width:120px' id= 'accuracy_<?php echo $i; ?>' name='accuracy[]'>
						<option value=''>-- SELECT --</option>
						<option value='exact'>Exactly</option>
						<option value='approximate'>Approximately</option>
					</select>
				</td>
				<td>
					<textarea id='entry_notes_<?php echo $i; ?>' class='entry_notes' name='entry_notes[]' style='width:180px'><? echo $notesHintText; ?></textarea>
				</td>
				<td>
					<select style='width:120px' id= 'sighting_type_<?php echo $i; ?>' name='sighting_type[]'>
						<option value=''>-- SELECT --</option>
						<option value='seen'>Seen</option>
						<option value='heard'>Heard</option>
						<option value='both'>Seen and heard</option>
					</select>
				</td>
			</tr>
<?php		
		}
?>
			</table>
			<table style='width:930px; margin-left:20px'>
			<tr>
				<td>
					<a name='x'></a><input type='hidden' class='sighting_type' name='sigtype' id='sigtype' value='general'>
				</td>
    			</tr>
    			<tr>
				<td><span><a href='#x' style='font-size:13px;padding:5px;background-color:#333;color:#fff' onclick="appendNewInput();">Add another species</a>&nbsp;
				<input type="submit" value= "Submit" name="sighting_submit"  class="buttonstyle" style='font-size:13px;padding:5px;background-color:#333;color:#fff' onclick="return validate();"></td>
			</tr>
			</table>
		</form>
	</div>
</div>

<? } ?>



