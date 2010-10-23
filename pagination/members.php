<? 	

   $all = mw_get_all_species();
    //for( $j=1; $j < count( $all_species['species_id'] );  $j++ ) {
?>
<script>
var members = [
<? for( $j=0; $j < count( $all['species_id'] );  $j++ ) { ?>

    ['<? echo addslashes($all["common_name"][$j]); ?>', '<? echo $all["scientific_name"][$j]; ?>', '<? echo $all["image"][$j]; ?>', '<? echo $all["image"][$j]; ?>','<? echo $all["species_id"][$j]; ?>'],
<? } ?>
];
</script>
