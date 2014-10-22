<?
if($_SESSION["oldlevel"]!=$__page_row["id"]){
	$_SESSION["simpleFilter"] = "";
	$_SESSION["oldlevel"] = $__page_row["id"];
	$_SESSION["mtmfilter"] = "";
	$_SESSION["simpleFilterSort"] = "";
}
//***********************************************
if($gets) {
	$gv = explode("=", $gets);
	if($gv[0]=="fclear" && $gv[1]=="1"){
		$_SESSION["gets"] = "";
	} else{
		if(substr($gv[1], 0, 1) == "-"){
			$gets = "/".preg_replace("/-/", "", $gets)."\\*/";
			$sv = $_SESSION["gets"];
			$sv = preg_replace($gets, "", $sv);
			$_SESSION["gets"] = $sv;
		} else {
			$sv = $_SESSION["gets"];
			$sv.="$gets*";
			$_SESSION["gets"] = $sv;
		}
	}
}
//***********************************************
$marks_mass = false;
$ssmass = $_SESSION["gets"];
$ssmass = explode("*", $ssmass);
foreach($ssmass as $key=>$val){
	$tmp = explode("=", $val);
	if($tmp[0]){
		$marks_mass[$tmp[0]][]=$tmp[1];
	}
}
//print_r($marks_mass);
//if($marks_mass[0][0]==""){
//	$marks_mass=false;
//}

//*************************************************
function filter_ma($id, $ma){
	if(is_array($ma)){
		//print_r($ma);
		foreach($ma as $key=>$val){
			if($val == $id){
				return true;
			}
		}
	}
	return false;
}
//*************************************************

//*************************************************
?>