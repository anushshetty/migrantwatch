<html><head>
    <title>Gluster : Main Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link rel="STYLESHEET" type="text/css" href="style.css">
</head>

<body>
    <!--begin content supertable-->
     
    <table width="100%" cellpadding=0 cellspacing=0 border=0 height=5>
    

    <tr bgcolor="#ffffff" >

	<td  width="30%"  style="padding:0px 1px" colspan="1">
	<img src="gluster.png" width=50%>
	</td>

    	<!--<td  width="50%" align=left>
	<div id="menu">
	<ul>
	    <li id="list1"><a href="#">&nbsp;Menu1&nbsp;</a></li>
	    <li id="list2"><a href="#">&nbsp;Menu2&nbsp;</a></li>
	    <li id="list3"><a href="#">&nbsp;Menu3&nbsp;</a></li>
	    <li id="list4"><a href="/roster">&nbsp;Menu3&nbsp;</a></li>
	</ul>
	</div>
	</td>-->

	<td  width="100%"  style="padding:3px 3px"  colspan="1" align=right valign=top>
         
	 <a href="#">Help</a>&nbsp;&nbsp;|&nbsp;&nbsp;<?
        if ($is_login) {
            print "Welcome, <b><a href=\"/login/userinfo.php?user=$user_name\">$user_name</b>&nbsp;&nbsp;";
        } else {
            $current_url = $_SERVER['REQUEST_URI'];
            print "<a href=\"login/login.php?done=$current_url\">Login</a> &nbsp;&nbsp;";
        }

?>

	</td>
    </tr>

    <!--<tr  bgcolor="#29577f">

	<td colspan=4 align="right">
	<div id="menu">
	<?
	if ($is_login) {
	    print "Welcome, <b><a href=\"/login/userinfo.php?user=$user_name\">$user_name</b>&nbsp;&nbsp;";
	} else {
	    $current_url = $_SERVER['REQUEST_URI'];
	    print "<a href=\"/login/login.php?done=$current_url\">Login</a> &nbsp;&nbsp;";
	}

?>
	</div>
	</td>
    </tr> 
    <tr>
	<td  colspan="3" > <div id="navshad"></div> </td>
    <tr>-->
    </table>

    <br>
    <!-- End of Headers -->

    <? function add_sidebar($sidebar_file, $name="", $height = "") { 
  /*  if ($height) {?>
       <style type="text/css">
        <!-- 
            #<?= $name ?> {
	        position: absolute;
	        top: <?= $height ?>px;
       	}
        -->
        </style>
    <? } */?>
    <table width="20%" id="<?= $name ?>" class="sidebar" style="position: absolute; left: 78%;" cellspacing=0 cellpadding=0 border=0>
	<tr height=10px>
	    <td class="shadowbodytopleft" width=10px></td><td class="shadowbodytop"></td><td class="shadowbodytopright" width=10></td>
	</tr>
	<tr>
	    <td class="shadowbodyleft"></td>
	    <td class="content">
	    <? include($sidebar_file); ?>
	    </td>
	    <td class="shadowbodyright"></td>
	</tr>
	<tr height=10>
	    <td class="shadowbodybottomleft"></td><td class="shadowbodybottom"></td><td class="shadowbodybottomright"></td>
	</tr>
    </table>
    <!--- End of Sidebar -->
<? } ?>
