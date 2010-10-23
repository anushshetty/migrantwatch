
<?
include("header.php");

$date1=$_POST["date1"];
$date2=$_POST["date2"];

$lines = file('glusterfsd.log');
$log=array();

$date=array();
$teams=array();

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
?>
 <table width=60% align=center bgcolor="#ffffff" style="border: 1px solid #C3D9FF;">
 <tr colspan="2" bgcolor="#C3D9FF">
                                         <td align="center"><b>Date</b></td>
                                         <td align="center"><b>Time</b></td>
                                         <td align="center"><b>Type</b></td>
                                </tr>

<?
foreach($lines as $line){
 $exp=explode(': ', $line);
 /* echo $exp[0].": ".$exp[1]." ".$exp[2]."<br>";*/ 
 $exp1=split(' ',$exp[0]);
 /* echo $exp1[0]." ".$exp1[3]." ".$exp[2]."<br>"; */
?>
 				<tr>	
					<td align="center"><? echo $exp1[0]; ?></td>
    	       				<td align="center"><? echo $exp1[1]; ?></td>
					 <td align="center"><? echo $exp1[2]; ?></td>
      				</tr>   
      </table>
<?
}
?>