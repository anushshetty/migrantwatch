<? include("checklogin.php");
   $page_title="MigrantWatch: Pied Cuckoo";
   include("main_includes.php");
?>
<body><? 
	include("header.php");	
?>
<style> .cms { font-size:13px; line-height:1.8em; padding:20px;} P { font-size:13px; } </style>
<div class="container first_image">
<? $page=mw_get_page(434); ?>
   <div id='tab-set'>   
     <ul class='tabs'>
        <li style='width:200px'><a href='#x' class='selected'><? echo strtolower($page[0]); ?></a></li>
    </ul>
   </div>
   <div class='page_layout cms'>
     <? echo $page[1]; ?>
   </div>
<? include("credits.php"); ?>
</div>
</div>
</div>
<div class="container bottom">

</div>
<?php 
   include('login_includes.php'); 
   include("footer.php");
?>
</body>
</html>
