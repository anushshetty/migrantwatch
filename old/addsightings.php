<? 
   include("auth.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>MigrantWatch : Add Sightings</title>

	<link rel="stylesheet" href="combine_css.php?version=<?php require('combine_css.php'); ?>" type="text/css">

<? 
  // include("header.php");

?>
<div class="container first_image">
 <?php
        $user_id = $_SESSION['userid'];
        $today = getdate();
        $currentSeason = ($today['mon'] > 6) ? $today['year'] : $today['year'] - 1;
        include("addsightingform.php");
        $speciesHintText = 'Type a name here';
        $dateHintText = 'Select';
        $numberHintText = 'In numerals';
        $notesHintText = 'Enter notes here';
        addSighting();
        
?>
</div>
</div>
</div>
<div class="container bottom">

</div>
<? include("page_includes_js.php");  include("addsightings_includes.php"); ?>
<script src="combine_js.php?version=<?php require('combine_js.php'); ?>" type="text/javascript"></script>
<script>mainForm();</script>
</body>
</html>
