<? session_start();
include("db.php");
include("functions.php");
$sighting_id = $_GET['id'];


$sql = "select comment_id,comment_time, comment_text,user_id from migwatch_sighting_comments where sighting_id='$sighting_id' order by comment_id";
$result = mysql_query($sql);

$page =  "<table class='all_comments'>";
while ( $data = mysql_fetch_array($result) ) {
$c_time  = $data['comment_time'];
$c_id = $data['comment_id'];

if( $data['user_id'] == $_SESSION['userid'] ) { $del_button = "<a title='Click here to delete this comment' href='#x' class='del_comment_link' id='". $data['comment_id'] . "'>delete</a>"; } else { $del_button = ''; }
      
      if( $data['user_id'] == $_SESSION['userid'] ) { $usernam = "You"; } else { $usernam = getUserNameById($data['user_id'],$connect); }
      	  $page .= "<tr><td id='cline_" . $c_id . "'><div class='sighting_comments'><a class='usernamelink' id='userid_" . $data['user_id'] . "_" . $c_id . "' href='#'><b>" . $usernam . "</b></a>: " . $data['comment_text'] . "<br>";
	  $page .="<small><i><a class='timeago' title='" . date('F j, Y H:i:s', strtotime($c_time)) . "'>" . date('F j, Y ', strtotime($c_time)) . "</a></i>&nbsp;&nbsp;&nbsp;";
 	  $page .= $del_button . "</small></div></td></tr>";
      

}
$page .= "</table>";

echo $page;
?>
<script>
$(".del_comment_link").click(function() {
     var new_com_pid = $(this).attr("id");
     var data = 'id=' + encodeURIComponent(new_com_pid);
     jConfirm('Are you sure you want to delete this comment?', '',function(r) {
         if(r==true) {
             //alert(data);
              $.ajax({
                url: "delete_sighting_comment.php",
                     type: "GET",
                     data: data,
                     cache: false,
                     success: function (html) {

                          $('#ncom').html(html);
                          $('#cline_' + new_com_pid).fadeOut("slow");
                     }
             });


            }
});

});

$('.usernamelink').each(function() { 
	  var totid = $(this).attr("id");
	  totid=totid.split('_',3);
	  userid=totid[1];
          comment_id=totid[2];
	
          var data = 'user=' + encodeURIComponent(totid[1]);
	   $.ajax({
                url: "getuserinfo.php",
                 type: "GET",
		 data: data,
                     cache: false,
                     success: function (html) {
		    
                       $('#userid_' + totid[1] + '_' + totid[2]).attr('rel',html);
		       
                     }
            });
	    
	     });

 $('.usernamelink').tipsy({gravity: 's',title: 'rel', html: true,delayIn: 500, delayOut: 1500});

$(".timeago").timeago();
</script>
