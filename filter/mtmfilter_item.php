<script>activate_filter=false;</script>
<?
//echo __mtm_show_select_mtm($__page_row["id"], "0", "-1")."<br/>";
//echo __mtm_show_select_mtm($__page_row["id"], "1", "0");
//$my_filter = __mtm_has_mtm($__page_row["id"]);
$my_filter = __mtm_get_mtm_filter_type($__page_row["id"]);
//echo "myfilter=$my_filter";
if($my_filter){ ?>
<div id="mtm_dsel"></div>
<script>activate_filter=<?  echo $my_filter; ?>;</script>
<script>filter_parid=<?  echo $__page_parent; ?>;</script>
<script>filter_itemid=<?  echo $__page_row["id"]; ?>;</script>
<script>filter_folder="<?  echo __fp_create_folder_way("items", $__page_parent, 1); ?>";</script><?
$mylevels = 0;
$mtmcount_allmass = explode("\n", $__page_row["mtm_cont"]);
//print_r($mtmcount_allmass);
foreach($mtmcount_allmass as $key=>$val){
	$mtmcount_mass = explode("-", $val);
	//print_r($mtmcount_mass);
	if(count($mtmcount_mass)-1 > $mylevels){
		$mylevels = count($mtmcount_mass)-1;
	}
}
?>
<script>
mtmLevels = <?  echo $mylevels;  ?>;
var  mtm_init = false;
mtm_get_select(filter_itemid, 0);
</script>
<div class="item_separator"></div>
<?  } ?>