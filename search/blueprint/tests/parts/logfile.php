
<?
$date1=$_POST["date1"];
$date2=$_POST["date2"];

$lines = file('glusterfsd.log');
$log=array();

$date=array();


foreach($lines as $line){
  $log[] = $line;
  /* echo $log[0]."<br>"; */
 }  

/*
for($i = 0;$i<count($log);$i++){

    //echo $date[$i]."<br>"; 
   $temp[$i]=split(' ',$log[$i]);
   print_r($temp[$i]);
   print "<br>";

}*/

/*
$temp= $log[0];
$temparr = split(' ',$temp);
$data=$temparr[0];
print $data;
*/

foreach($lines as $line){
 $linearray=split(' ',$line);
 if($linearray[0]>=$date1 && $linearray[0]<=$date2)
 {  $linedata = "<b>".$linearray[0]."</b>"." ".$linearray[1]." ".$linearray[2]." ".$linearray[4]." ".$linearray[5]." ".$linearray[6];
    echo $linedata."<br>";
 }
}
?>