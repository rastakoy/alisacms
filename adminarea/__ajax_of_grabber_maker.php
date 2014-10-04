<?
header("Content-type: text/plain; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_format.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_forms.php");
require_once("../core/__functions_loadconfig.php");
require_once("../core/__functions_full.php");
require_once("../core/__functions_pages.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_uploadp.php");

require_once("../filter/__functions_filter.php");


//require_once("__functions_register.php");
//require_once("__functions_rating.php");
dbgo();
//*************************
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
//*************************
$paction = $_POST["paction"];
//*************************
//*************************
if($paction=="of_mup_start_convert"){
	$grabber = $_POST["grabber"];
	//echo "grabber = $grabber\n";
	//********************************************
	$query = "select * from csvtmp order by id asc";
	//echo "query=$query\n";
	$resp = mysql_query($query);
	if(!$resp) echo "ОШИБКА запроса";
	while($row=mysql_fetch_assoc($resp)){
		$mass = explode("~~~separator~~~", $row["rowcont"]);
		if($row["rowevent"]=="ignor"){
			//$addresp = mysql_query("insert into items (recc, tmp, page_show, item_code) values (0, 0, 1, '$mass[0]')  ");
			//$addresp = mysql_query("select * from items order by id desc limit 0,1");
			//$addrow = mysql_fetch_assoc($addresp);
			//$row["rowevent"]="replace";
			//$row["outid"] = $addrow["id"];
			//$del_query = "delete from csvtmp where id=$row[id]  ";
			//$del_resp = mysql_query($del_query);
		}
		//*****************************
		//if($row["rowevent"]=="add"){
		//	$addresp = mysql_query("insert into items (recc, tmp, page_show, item_code) values (0, 0, 1, '$mass[0]')  ");
		//	$addresp = mysql_query("select * from items order by id desc limit 0,1");
		//	$addrow = mysql_fetch_assoc($addresp);
		//	$row["rowevent"]="replace";
		//	$row["outid"] = $addrow["id"];
		//	//$del_query = "delete from csvtmp where id=$row[id]  ";
		//	//$del_resp = mysql_query($del_query);
		//}
		//*****************************
		if($row["rowevent"]=="replace"){
			foreach($mass as $key=>$val){
				$noload = false;
				$qmass = __of_up_get_codes_from_index($key, $grabber);
				$fname = __of_up_get_name_from_index($key, $grabber);
				$val = preg_replace("/'/", "\'", $val);
				$val = preg_replace('/"/', '\"', $val);
				if(is_array($qmass)){
					foreach($qmass as $qkey=>$qval){
						$qval = preg_replace("/{fieldValue}/", "$val", $qval);
						$qval = preg_replace("/{id}/", $row["outid"], $qval);
						$qval = preg_replace("/{noLoad}/", "\$noload=true;", $qval);
						$qval = preg_replace("/<br\/>/", "", $qval);
						//echo $qval;
						eval ($qval);
					}
				}
				$ft = __of_up_get_field_type($fname);
				if($ft && !$noload){
					if($ft == "txt"){
						$repquery = "update items set $fname='$val' where id=$row[outid] ";
						//echo "$repquery<br/>";
						$rep_resp = mysql_query($repquery);
					} if($ft == "int" && $val) {
						$repquery = "update items set $fname=$val  where id=$row[outid]   ";
						//echo "$repquery<br/>";
						$rep_resp = mysql_query($repquery);
					}
				}
				//***************************************
			}
			$del_query = "delete from csvtmp where id=$row[id]  ";
			//echo $del_query."<br/>\n";
			$del_resp = mysql_query($del_query);
		}
	}
	//********************************************
	$del_query = "truncate csvtmp";
	$del_resp = mysql_query($del_query);
	echo "\nЗапрос обработан\n";
}
//*************************
if($paction=="of_mu_load_file"){
	//********************************************
	//Загрузка прайса CSV в базу данных
	$grabber = $_POST["grabber"];
	$fillename = $_POST["fillename"];
	//echo "FILENAME=$fillename";
	__of_up_convert_csv_to_db($fillename, $grabber);
}
//*************************
if($paction=="of_up_save_sfield"){
	$sfname = $_POST["sfname"];
	$typeid = $_POST["typeid"];
	$index = $_POST["index"];
	echo $sfname."::".$typeid."::".$index;
	//*********************************************************
	$resp = mysql_query("select * from grabber where id=$typeid ");
	$row = mysql_fetch_assoc($resp);
	$mass = explode("\n", $row["uploadp_info"]);
	$tosql = "";
	foreach($mass as $key=>$val){
		$val = trim($val);
		if($key == $index)  {
			$vmass = explode("=", $val);
			if(!preg_match("/^[0-9]+$/", $vmass[0]) && $vmass[0]!=""){
				$vmass[0]=$sfname;
				$tosql .= $vmass[0];
				foreach($vmass as $vk=>$vv)
					if($vk!=0)
						$tosql .= "=".$vv;
			} else {
				$tosql .= $sfname.$val;
			}
		} if($key != $index)  {
			$tosql .= $val;
		}
		if($key < count($mass)-1) $tosql .= "\n";
	}
	echo $tosql;
	$query = "update grabber set uploadp_info='$tosql' where id=$typeid";
	$resp = mysql_query($query);
	echo "Ok";
}
//*************************
if($paction=="of_up_delete_field"){
	$typeid = $_POST["typeid"];
	$index = $_POST["index"];
	//*********************************************************
	$resp = mysql_query("select * from grabber where id=$typeid ");
	$row = mysql_fetch_assoc($resp);
	$mass = explode("\n", $row["uploadp_info"]);
	$tosql = "";
	foreach($mass as $key=>$val){
		$val = trim($val);
		if($key == $index)  {
			__of_up_delete_codes_from_str($val);
		} if($key != $index)  {
			$tosql .= $val;
			if($key < count($mass)-1) $tosql .= "\n";
		}
	}
	if($index == count($mass)-1) $tosql = substr($tosql, 0, strlen($tosql)-1);
	//echo $tosql;
	$query = "update grabber set uploadp_info='$tosql' where id=$typeid";
	$resp = mysql_query($query);
	echo "Ok";
}
//*************************
if($paction=="of_up_add_field"){
	$typeid = $_POST["tid"];
	$resp = mysql_query("select * from grabber where id=$typeid ");
	$row = mysql_fetch_assoc($resp);
	$query = "update grabber set uploadp_info='$row[uploadp_info]\n' where id=$typeid";
	$resp = mysql_query($query);
}
//*************************
if($paction=="of_up_add_code"){
	$typeid = $_POST["typeid"];
	$index = $_POST["index"];
	$query = "INSERT INTO uploadp_codes (phpcode) VALUES ('')";
	$resp = mysql_query($query);
	$resp = mysql_query("select * from uploadp_codes order by id desc limit 0,1");
	$row = mysql_fetch_assoc($resp);
	$row_index = $row["id"];
	//*********************************************************
	$resp = mysql_query("select * from grabber where id=$typeid ");
	$row = mysql_fetch_assoc($resp);
	$mass = explode("\n", $row["uploadp_info"]);
	$tosql = "";
	foreach($mass as $key=>$val){
		$val = trim($val);
		$tosql .= $val;
		if($key == $index)  $tosql .= "=$row_index";
		if($key < count($mass)-1) $tosql .= "\n";
	}
	//echo $tosql;
	$query = "update grabber set uploadp_info='$tosql' where id=$typeid";
	$resp = mysql_query($query);
	echo "Ok";
}
//*************************
if($paction=="of_up_save_code"){
	$code = $_POST["ofupcode"];
	$code = preg_replace("/~~~aspirand~~~/", "&", iconv("UTF-8", "CP1251", $code ) );
	$code = preg_replace("/~~~plus~~~/", "+", $code );
	echo "code=$code\n\n";
	//$code = preg_replace("/'/", "\'", $code);
	//$code = preg_replace('/"/', '\"', $code);
	$id = $_POST["tid"];
	$query = "update uploadp_codes set phpcode='$code' where id=$id";
	$resp = mysql_query($query);
	echo "$query";
}
//*************************
if($paction=="of_up_get_str_to_code"){
	$id = $_POST["tid"];
	if($id){
		$query = "select * from uploadp_codes where id=$id";
		$resp = mysql_query($query);
		$row = mysql_fetch_assoc($resp);
		echo "$row[phpcode]";
	}
}
//*************************
if($paction=="of_up_get_template"){ 
	$id = $_POST["tid"];
	if($id){
		$query = "select * from grabber where id=$id";
		$resp = mysql_query($query);
		$row = mysql_fetch_assoc($resp);
		$mass = explode("\n", $row["uploadp_info"]);
		//echo "<div id=\"div_myitemname\">test test</div>";
		echo "<div class=\"ui-state-default-3\" id=\"myitems_sortable\">";
		$count = 1;
		foreach($mass as $key=>$val){
			echo "<div  class=\"ui-state-default-2\" id=\"prm_$key\">";
			echo "<div id=\"sprm_$key\" class=\"div_myitemname\" style=\"cursor:;\">";
			echo "$count ";
			echo __of_up_get_convert_str_to_code($val);
			echo "</div>";
			echo "</div>";
			$count++;
		}
		echo "</div>";
	}
	//__of_up_convert_csv_to_db("../csv/test.csv");
}
//*************************
if($paction=="save_template"){
	$tid = $_POST["tid"];
	$code = iconv("UTF-8", "CP1251", $_POST["code"]);
	$query = "update grabber set pairs='$code' where id=$tid ";
	$resp = mysql_query($query);
	echo "tid=$tid\n\n$code";
}
//*************************
if($paction=="save_newtype"){
	$nrus = iconv("UTF-8", "CP1251", $_POST["nrus"]);
	$neng = iconv("UTF-8", "CP1251", $_POST["neng"]);
	$query = "insert into grabber (name, rus_name, pairs) VALUES ('$neng',  '$nrus', 'saveblock===') ";
	//echo $query;
	$resp = mysql_query($query);
	$resp = mysql_query("select id from grabber order by id desc limit 0,1");
	$row = mysql_fetch_assoc($resp);
	echo $row["id"];
}
//*************************

?>