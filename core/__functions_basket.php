<?
function convert_sess_to_array($str){
	$mass = false;
	$smass = explode("*", $str);
	foreach($smass as $key=>$val){
		$vmass = explode(":", $val);
		$mass[] = $vmass;
	}
	return $mass;
}
//*******************************************************
function __fbasket__test_to_show(){
	global $row_user;
	//print_r($row_user);
	$resp = mysql_query("select * from pages where name='lookbasket'  ");
	$row = mysql_fetch_assoc($resp);
	$cont = trim($row["cont"]);
	if($cont=="������"){return false;}
	if($cont=="����"){return true;}
	if($cont=="��������� �������������" && $row_user["look_basket"]==1){return true;}
	if($cont=="������������������" && $row_user["reg"]==1){return true;}
	return false;
}
//function __fbas__calc_rests()
?>