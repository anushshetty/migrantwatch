<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$comment_time =  date('Y-m-d H:i:s');
if ($_SESSION['userid']) {
if(isset($_GET['comment']) && $_GET['user_id'] && $_GET['photo_id'])
{
	$textcontent=stripslashes($_GET['comment']);
	$user_id  = $_GET['user_id'];
	$photo_id = $_GET['photo_id'];
	include("db.php");
	$sql ="insert into migwatch_photo_comments(user_id,photo_id,comment_text,comment_time) values('$user_id','$photo_id','$textcontent','$comment_time')";
	mysql_query($sql);
	
	if( $_GET['user_id'] != $_SESSION['userid']) {
           //$to = getEmailById($user_id, $connect);
	   $subject = getUsernameById($user_id, $connect) . " commented on your photos";
           $body = $comment_text;
        }	

	$comment_id = mysql_insert_id();
	$sql = "select comment_id from migwatch_photo_comments where photo_id='$photo_id'";
	$result1 = mysql_query($sql);
	$total_comments = mysql_num_rows($result1);

}
$comment_out = $total_comments;
$comment_out .="&&&&<table class='new_comment all_comments'><tr><td id=row_". $comment_id . "><div class='photo_comments'><b>You</b>: ";
$comment_out .= $textcontent . "<br><small><a title='Click here to delete this comment' href='#x' class='del_comment_link' id='". $comment_id . "'>delete</a></div></td></tr></table>";


echo $comment_out;


 } ?>

<script type="text/javascript">
$(".del_comment_link").click(function() {
     var new_com_pid = $(this).attr("id");
     var data = 'id=' + encodeURIComponent(new_com_pid);
     jConfirm('Are you sure you want ot delete this sighting ?', '',function(r) {
         if(r==true) {
           
             $('#row_' + new_com_pid).fadeOut("slow");
             //alert(data);
	      $.ajax({
                url: "deletecomment.php",
                     type: "GET",
                     data: data,
                     cache: false,
		     success: function (html) {
		
                          $('#ncom').html(html);
			  $('#row_' + new_com_pid).fadeOut("slow");
                     }
             });


	    }
});

});       
</script>
<style>

.photo_comments { margin-top:2px; padding:5px; font-size:13px;border: solid 1px #d95c15; background-color:#fff; color:#000; }
</style>