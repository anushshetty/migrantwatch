<?php
	//include("main_includes.php"); 
	include("db.php");
	include("functions.php");

?>

<div class="container top">
     <div class="left">
     	  <div class="container logo-box">
    	      <div style='float:left'>
      	       	    <a href='http://migrantwatch.in'><img style="margin-left:0" src="logo/mwlogo.png" alt="MigrantWatch" title="MigrantWatch"></a>
    	      </div>
	      <div style='float:right;margin-top:26px'>
      	      	   <form name="frm_login" action="userlogin.php" method="POST">
		   <table>
	  <? if(  $_SESSION['userid'] ) { ?>
             	   <tr>
			<td style='text-align:right;'><? echo $_SESSION['username']; ?>&nbsp;( <a href='userlogin.php?cmd=logout'>Log Out</a> )&nbsp;</td>
             	   </tr>
                  <? } else { ?>
	  	  <tr>
			<td class="small-link" style="margin:0;padding:0;font-size:10px;">
           		    <table style="margin:0;padding:0;width:390px;">
			    <tr>
           		    	   <td style="text-align:right;width:150px"><a title="register"  href="register.php">signup!</a></td>
           			   <td style="padding-left:35px">
				       <a title="forgot password ?" href="forgot_password.php">forgot?</a>
				   </td>
				   <td style="text-align:right;padding-right:33px">
                  		       <a  title="remember me" class="rememberme"  href="#">remember me</a> 
				       <a style="display:none" class="rememberme"  href="#">remembered</a>
                  		       <input type="hidden" value="0" id="remember" name="remember">
          			   </td>
	   		    </tr>
           		    </table>

         		</td>
		  </tr>
             	  <tr>
			<td style="padding:0;margin:0;">
		  	    <input class="default-value login-box" type="text" name="email" value="email id" />
		  	    <input id="password-clear" class="login-box" type="text"  value="password" autocomplete="off"/>
		  	    <input class="login-box" id="password-password" type="password" name="pwd" value="" autocomplete="off" />
                  	    <input type="hidden" name="cmd" value="login" />
		  	    <input style="width:30px;border:solid 1px #666" type="submit" value="go" onclick="javascript:return validate();">
			</td>
	    	  </tr>
	     <? } ?>
      	     	  </table>
      		  <table class="main-links"> 
         	  <tr>
			<td style=""><a href="addsightings.php">report&nbsp;sightings</a></td>
          		<td style=''>|</td>
          		<td style=""><a href="editsightings.php">edit&nbsp;sightings</a></td>
          		<td style=''>|</td>
          		<td style=""><a href="editprofile.php">my&nbsp;profile</a></td>
         	  </tr>
		  </table>
      		</form>
    	       </div>
  	  </div> <!-- END OF LOGO BOX -->
	  <div class="container main_banner">
    
	  </div>
	  <div class="container menu-links">
 	   <ul id="jsddm">
    <li><a href="#">join</a>
        <ul>
            <li><a href="#">why join</a></li>
        </ul>
    </li><li>|</li>
    <li><a href="#">what to do</a>
        <ul>
            <li><a href="#">watch migrants</a></li>
            <li><a href="#">identify migrants</a></li>
            <li><a href="#">submit data</a></li>
        </ul><li>|</li>
    </li>
	<li><a href="#">participants</a>
        <ul>
            <li><a href="participants.php">individuals</a></li>
            <li><a href="#">groups</a></li>
            <li><a href="#">map</a></li>
        </ul><li>|</li>
    </li>
 <li><a href="#">species</a>
        <ul>
            <li><a href="#">migrants we watch</a></li>
            <li><a href="#">highlighted species</a></li>
            <li><a href="#">all species</a></li>
        </ul><li>|</li>
    </li>
	<li><a href="#">campaigns</a>
        <ul>
            <li><a href="#">pied cuckoo</a></li>
            
        </ul><li>|</li>
    </li>
	<li><a href="#">data</a>
        <ul>
            <li><a href="#">view data/maps</a></li>
            <li><a href="#">latest summaries</a></li>
            <li><a href="#">terms of use</a></li>
        </ul><li>|</li>
    </li>
	<li><a href="#">resources</a>
        <ul>
            <li><a href="#">getting started with indian birds</a></li>
            <li><a href="#">bird migration and climate change</a></li>
            <li><a href="#">citizen science projects</a></li>
	         <li><a href="#">publications</a></li>
        </ul><li>|</li>
    </li>
	<li><a href="#">news</a>
        <ul>
            <li><a href="#">media</a></li>
            
        </ul><li>|</li>
    </li>
	<li><a href='#'>blog</a></li><li>|</li>
	<li><a href='#'>faq</a></li>
</ul>

 <div style="float:right">
      <form id="search_form" action="search/index.php" method="get">
      <input type="text" name="query" id="query" style="border:solid 1px #666;" value="search" autocomplete="off" delay="1500">
      <input type="hidden" name="search" value="1"> 
      <input type="submit" class="submit" value="go">
      </form>
 </div>
</div>
<script>
$(document).ready(function() {

    $(".filter").corner();
    $(".first_image").corner('bottom');
});

</script>
<style type="text/css">
#jsddm
{	margin: 0;
	padding: 0;
	font-size:14px;
}
	
	#jsddm li
	{	float: left;
		list-style: none;
          }

	#jsddm li a
	{	display: block;
		//background: #20548E;
		padding: 3px 5px;
	        margin-left:1%;
                margin-right:1%;
		text-decoration: none;
		width:100%;
		color: #fff;
		font-size:100%;
		white-space: nowrap}

	#jsddm li a:hover
	{	color: #ffcb1a}
		
		#jsddm li ul
		{	margin:0;
			margin-top: 10px;
			padding: 0;
			min-width:200px;
			position: absolute;
			visibility: hidden;
			border-top: 1px solid #ffcb1a;
			z-index:1;
		
		}
		
		#jsddm li ul li
		{	float: none;
			display: inline;
		
			
	        }
		
		#jsddm li ul li a
		{	width: auto;
		        font-size:14px;
			background: #333;border: 1px solid #ffcb1a; border-top:none; font-weight:normal; }
		
		#jsddm li ul li a:hover
		{	background: #000;color: #fff}
</style>
<script>

var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;

function jsddm_open()
{  jsddm_canceltimer();
   jsddm_close();
   ddmenuitem = $(this).find('ul').css('visibility', 'visible');}

function jsddm_close()
{  if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

function jsddm_timer()
{  closetimer = window.setTimeout(jsddm_close, timeout);}

function jsddm_canceltimer()
{  if(closetimer)
   {  window.clearTimeout(closetimer);
      closetimer = null;}}

$(document).ready(function()
{  $('#jsddm > li').bind('mouseover', jsddm_open)
   $('#jsddm > li').bind('mouseout',  jsddm_timer)});

document.onclick = jsddm_close;
</script>

<script type="text/javascript">
$('.default-value').each(function() {
    var default_value = this.value;
    $(this).css('color', '#666'); // this could be in the style sheet instead
    $(this).focus(function() {
        if(this.value == default_value) {
            this.value = '';
            $(this).css('color', '#333');
        }
    });
    $(this).blur(function() {
        if(this.value == '') {
            $(this).css('color', '#666');
            this.value = default_value;
        }
    });
});


$('#password-clear').show();
$('#password-password').hide();

$('#password-clear').focus(function() {
    $('#password-clear').hide();
    $('#password-password').show();
    $('#password-password').focus();
});
$('#password-password').blur(function() {
    if($('#password-password').val() == '') {
        $('#password-clear').show();
        $('#password-password').hide();
    }
});

 var toggle = false;
  $(".rememberme").click(function () {
     if( toggle  == false) { 
         $('#remember').val('1'); 
         toggle = true;
     } else { 
         $('#remember').val('0'); toggle = false; 
     }
     $(".rememberme").toggle();           
  });
</script>
<script src="jquery.corner.js" type="text/javascript"></script>

<script>
  $(document).ready(function(){
$('#query').emptyonclick();

$('#query').autocomplete("autocomplete.php", {
  //    width: 388,
       selectFirst: false,
           matchSubset :true,
      matchContains: false,
      formatItem: formatItem

          });

$("#query").result(function(event, data, formatted) {

				   document.location.href= "../guide.php?id="+ data[1];

});
});
function formatItem(row) {
     var completeRow;
         completeRow = new String(row);
                var scinamepos = completeRow.lastIndexOf("(");
                    var rest = completeRow.substr(0,scinamepos)
                        var sciname = completeRow.substr(scinamepos);
                            var commapos = sciname.lastIndexOf(",");
                sciname = sciname.substr(0,commapos);
                var newrow = rest + '<br><i>' + sciname + '</i>';
        	    return newrow;

  }

  </script>