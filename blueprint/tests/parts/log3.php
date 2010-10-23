<?
include("header.php");
?>
<script type="text/javascript" src="log/js/jquery-1.2.1.min.js"></script>
<script type="text/javascript" src="log/js/date.js"></script>
<script type="text/javascript" src="log/js/jquery.datePicker.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="log/css/datePicker.css">
<link rel="stylesheet" type="text/css" media="screen" href="log/css/demo.css">

<script type="text/javascript" charset="utf-8">

   $(function()
            {
				$('.date-pick').datePicker().val(new Date().asString()).trigger('change');
            });
</script>
<script type="text/javascript" src="log/js/jquery.form.js"></script>

<script type="text/javascript" charset="utf-8">
      $(function()
		{
      	                   $('.date-pick').datePicker({startDate:'1996-01-01'});

      			   $('#date1').bind(
      			   'dpClosed',
      			   function(e, selectedDates)
      	        {
      var d = selectedDates[0];
      if (d) {
		d = new Date(d);
      		$('#date2').dpSetStartDate(d.addDays(1).asString());
      	}
      });
      
      $('#date2').bind(
	'dpClosed',
      	function(e, selectedDates)
      	{
		var d = selectedDates[0];
      		if (d) {
      		   d = new Date(d);
      		   $('#date1').dpSetEndDate(d.addDays(-1).asString());
      		}
      	});
           
  });
 </script>

<script type="text/javascript"> 
        // wait for the DOM to be loaded 
       $(document).ready(function() { 
    // bind form using ajaxForm 
    $('#chooseDateForm').ajaxForm({ 
        // target identifies the element(s) to update with the server response 
        target: '#htmlExampleTarget', 
 
        // success identifies the function to invoke when the server response 
        // has been received; here we apply a fade-in effect to the new content 
        success: function() { 
            $('#htmlExampleTarget').fadeIn('slow'); 
        } 
    }); 
})
    </script> 

<body>
        <!--<div id="container">-->
               <table align="center">     
		<form name="chooseDateForm" id="chooseDateForm" action="log/logfile.php" method=POST >
                    <table align=right width=20% bgcolor="#ffffff" style="position:absolute; right:78%; border: 1px solid #C3D9FF;">
                           <tr>
			        <td align="center" colspan="2" bgcolor="#C3D9FF" >
			        <b>Choose Date</b>
			   	</td>
		           </tr>
			   
		     <tr><td><div class="txt">From:<input name="date1" id="date1" class="date-pick" /></div></td></tr>
       	             <tr><td><div class="txt">To:<input name="date2" id="date2" class="date-pick" /></div></td></tr>
                     <tr><td><div class="txt"><input type=submit value=submit></div></td></tr>
                     </table>        
                     </form>
                   
                    <table bgcolor="#ffffff" width=40% style="position:absolute; right:30%; border: 1px solid #C3D9FF;">
                               <tr>
					 <td align="center" colspan="2" bgcolor="#C3D9FF" >
                                	     <b>Log Files</b>
                                	 </td>
                               </tr>

			       <tr><td><div style="height:300px; overflow:auto;padding:20px">
		               <div id="htmlExampleTarget"></div></div></td></tr>
		    </table><!--
                     <table width=20% align=left bgcolor="#ffffff" style="margin-left:10px; border: 1px solid #C3D9FF;">
		     	     <tr>
                                <td align="center" colspan="2" bgcolor="#C3D9FF" >
                                <b>Help: Log File</b>
                                </td>
                           </tr>

			    <tr>
				<td>Select a From and To date to view the log files in the panel.</td>
			    </tr>-->
                     </table>
		    	   			    
        </table>
        </div>
	</body>
