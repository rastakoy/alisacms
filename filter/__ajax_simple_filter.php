<?php
session_start();
header("Content-type: text/plain; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_tree_semantic_user.php");
require_once("../core/__functions_pages.php");
require_once("../core/__functions_register.php");
require_once("../core/__functions_forms.php");
require_once("../core/__functions_mtm.php");
require_once("../filter/__functions_filter.php");
dbgo(); 
$paction = $_POST["paction"];
if($paction=="addToFilter") {
	$my_filter = $_POST["mfilter"];
	$sn = $_POST["sn"];
	$pid = $_POST["pid"];
	$del = $_POST["del"];
	//************************
	if($_SESSION["flevel"] != $my_filter){
		$_SESSION["flevel"] = $my_filter;
		$_SESSION["simpleFilter"] = "";
	}
	//************************
	$pidlink = __fp_create_folder_way("items", $pid, 1);
	$attr = "/$sn=$pid&/";
	//$_SESSION["simpleFilter"] = "";
	$_SESSION["simpleFilter"] = preg_replace($attr, "", $_SESSION["simpleFilter"]);
	if(!$del) $_SESSION["simpleFilter"] .= "$sn=$pid&";
	echo $_SESSION["simpleFilter"];
	//print_r($mass);
}
//*********************************************
if($paction=="pricesort") {
	$pricesort = $_POST["pricesort"];
	$_SESSION["simpleFilterSort"] = $pricesort;
}
//*********************************************
if($paction=="getPriceDiapason") {
	//echo "getPriceDiapason";
	//$_SESSION["priceDiapason"] = "min="$_POST["min"];
	//print_r($_POST);
	$sfdq =  "";
	$my_filter = get_item_type($_POST["parent"]);
	if($my_filter){
		$sfdq = __mtm_convert_session_to_simple_filter($_SESSION["simpleFilter"], $my_filter);
	}
	if($_SESSION["filterNalichie"]=="nal"){
		$isnal = " && kolvov>0 ";
		//echo "isnal=$isnal";
	}
	if($_SESSION["filterSpec"]!=""){
		$spec = __mtm_convert_filterSpec_to_simple_filter($_SESSION["filterSpec"]);
		//echo "isnal=$isnal";
	}
	if($_SESSION["mtmfilter"]!=""){
		$mtmquery = __mtm_convert_session_to_multi_filter($_SESSION);
		//echo $mtmquery;
	}
	$query = "select pricedigit from items where pricedigit>=".$_POST["min"]." && pricedigit<=".$_POST["max"]." ";
	$query .= " && parent=".$_POST["parent"]." && folder=0 $sfdq $pdia $isnal $spec $mtmquery $dop_query order by pricedigit ASC  ";
	$resp = mysql_query($query);
	$count = mysql_num_rows($resp);
	$last = substr($count, strlen($count)-1, 1 );
	$last2 = substr($count, strlen($count)-2, 2 );
	if($count==0){
		echo "Нет товаров";
	}elseif($last>4 || $last==0 || $last2==11 || $last2==12 || $last2==13 || $last2==14){
		echo "Показать $count товаров";
	}elseif($last==1){
		echo "Показать $count товар";
	}elseif($last>1 && $last<=4){
		echo "Показать $count товара";
	}
}
//*********************************************
if($paction=="setFilterNalichie") {
	//echo "setFilterNalichie";
	$_SESSION["filterNalichie"] = $_POST["type"];
}
//*********************************************
if($paction=="setPriceDiapason") {
	//echo "setPriceDiapason";
	$_SESSION["priceDiapason"] = "min=".$_POST["min"]."&max=".$_POST["max"];
}
//*********************************************
if($paction=="setFilterSpec") {
	$sess = $_SESSION["filterSpec"];
	$type = $_POST["type"];
	$value = $_POST["value"];
	if($type=="remove"){
		$sess = preg_replace("/&?".$value."/", "", $sess);
	}else{
		$sess = preg_replace("/&?".$value."/", "", $sess);
		$sess .= "&$value";
	}
	$_SESSION["filterSpec"] = preg_replace("/^&/", "", $sess);
}
//*********************************************
if($paction=="clearFilter") {
	//echo "setPriceDiapason";
	$_SESSION["priceDiapason"] = "";
	$_SESSION["simpleFilterSort"] = "";
	$_SESSION["simpleFilter"] = "";
	$_SESSION["filterNalichie"] = "";
	$_SESSION["filterSpec"] = "";
	$_SESSION["mtmfilter"] = "";
	$_SESSION["sort"] = "";
}
//*********************************************
?>