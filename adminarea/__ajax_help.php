<?
$help_id = 170;
$help_resp = mysql_query(  "select * from items where id=$help_id"  );
$help_row = mysql_fetch_assoc(  $help_resp  );
$help_plink = $help_row["href_name"];
//**************
if($paction=="outerhelplnk"){
	$res = file_get_contents(  "http://alisahelp.my/adminarea/__ajax.php?paction=outerhelplnk&helplnk=".$_POST["helplnk"]  );
	echo $res;
}
//**************
if(  $_GET["paction"] == "outerhelplnk"  ){
	$lnk = $help_plink."/".$_GET["helplnk"];
	$row = __fp_get_row_from_way(  explode(  "/", $lnk  ), "items"  );
	//echo $_GET["helplnk"];
	require_once(  "templates/helpinfo.php"  );
}
//**************
if($paction=="outerhelp_json"  ){
	$res = file_get_contents(  "http://alisahelp.my/adminarea/__ajax.php?paction=outerhelp_json"  );
	echo $res;
}
//**************
if(  $_GET["paction"] == "outerhelp_json"  ){
	$mass = __fjs_tree_to_assoc_array_from_keys(  $help_id, "items", array(  "name", "href_name", "folder"  )  );
	$mass = __fjs_decode_data_array(  "CP1251", "UTF-8", $mass  );
	$json = json_encode(  $mass, true  );
	echo $json;
}
//**************
?>