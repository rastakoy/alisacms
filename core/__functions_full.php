<?
function __ffull_test_for_nothing($table, $id){
	$resp = mysql_query("select * from $table where id=$id ");
	$row = mysql_fetch_assoc($resp);
	$test =  __ffull_get_item_info("items", $row["parent"], "../config/");
	$parent_resp = mysql_query("select * from $table where id=$row[parent]");
	$parent_row = mysql_fetch_assoc($parent_resp);
	//echo "<pre>"; print_r($test); echo "</pre>";
	//**********************
	$errors = false;
	foreach($test as $key => $val){
		//echo "$rv=".$row[$val]."<br/>";
		if($row[$val]=="" || $row[$val]==0){
			if($val!="out_mark"){
				$val_mass = __lc_find_data_from_loadconfig($val, "../config/".$parent_row["cfg_file"].".cfg", 1);
				$val_mass = explode("=", $val_mass);
				//echo "$val_mass[0]<br/>\n";
				$val = $val_mass[0];
			}
			$errors[] = "$val";
		}
	}
	//echo "<pre>errors:\n"; print_r($errors); echo "</pre>";
	return $errors;
}
//*********************************
function __ffull_get_item_info($table, $id, $way){
	$resp = mysql_query("select * from $table where id=$id");
	$row = mysql_fetch_assoc($resp);
	$cfg_mass = false;
	//**********************
	if($row["cfg_file"]!="")
		$cfg_mass = __lc_find_data_from_loadconfig($row["cfg_file"], $way.$row["cfg_file"].".cfg", 1);
	//**********************
	//echo $cfg_mass;
	$cfg_mass = explode(",", $cfg_mass);
	$cfg_mass[count($cfg_mass)-1] = "out_mark";
	$cfg_mass[] = "model_price";
	return $cfg_mass;
}
?>