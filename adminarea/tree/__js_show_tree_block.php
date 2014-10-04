<? 
if($parent!=0){
	$most_show=false;
	$link_mass =  __fmt_find_item_parent_id("0", $parent);
	if(count($link_mass)>1)
		for($i=count($link_mass)-1; $i>0; $i--)
			$most_show[] = $link_mass[$i];
	//echo "\n\nasddsa\n\n";
	//print_r($most_show);
	echo __farmmed_rekursiya_show_items_user("0", 0, false, $parent, 0, $most_show);
}
else{
	//echo "\n\ntesttest\n\n";
	echo __farmmed_rekursiya_show_items_user("0", 0, false, false, 0);
}
?>