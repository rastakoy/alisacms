<?
require_once("../__config.php");
require_once("../core/__functions.php");
//wright_log("HTTP_X_REQUESTED_WITH=".$_SERVER['HTTP_X_REQUESTED_WITH']);
if($_GET["ajaxactionsdsd"]){
	header("'Content-Type': 'application/json', 'charset':'UTF-8'");
	//wright_log("post=".$_POST["ajaxaction"]);
} else {
	header("Content-type: text/plain; charset=windows-1251");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
}

require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_format.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_forms.php");
require_once("../core/__functions_loadconfig.php");
require_once("../core/__functions_full.php");
require_once("../core/__functions_pages.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_uploadp.php");
require_once("../core/__functions_auto.php");

require_once("../core/__function_saver.php");
require_once("../filter/__functions_filter.php");
require_once("../core/__functions_constructor.php");

//wright_log("request=".json_encode($_REQUEST));

//require_once("__functions_register.php");
//require_once("__functions_rating.php");
dbgo();
//*************************
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
//*************************
$paction = $_POST["paction"];
//*************************
if($_GET["ajaxaction"] == "aui_load_multiblock_data"){
	$ways = $_GET["ways"];
	$start = $_GET["start"];
	$stop = $_GET["stop"];
	$id = $_GET["id"];
	/********************************/
	$rv = "{\n";
	$rv .= "   \"header\":{\n";
	$rv .= "      \"id\":\"$id\"\n";
	$rv .= "   },\n";
	$rv .= "   \"body\":{\n";
	$parpage = $a = __fp_get_row_from_way(explode("/", $ways), "items");
	$it = get_item_type($a["id"]);
	$it_mass = __ff_get_itemstypes_to_mass_by_id($it);
	//print_r($it_mass);
	$query = "select * from items where parent=$parpage[id] $dop_query order by prior asc limit $start,$stop";
	$resp = mysql_query($query);
	$count="0";
	while($row=mysql_fetch_assoc($resp)){
		$rv .= "      \"$count\": {\n";
		foreach($it_mass as $key=>$val){
			$val = explode("===", $val);
			if($val[3])  $rv .=  "         \"$val[3]\":\"".$row[$val[1]]."\",\n";
			if($val[0]=="images")  {
				$str = false;
				$iquery = "select * from images where parent=$row[id] order by prior asc limit 0,1";
				//echo $iquery."\n";
				$iresp = mysql_query($iquery);
				$irow=mysql_fetch_assoc($iresp);  
				$rv .=  "         \"Изображение\":\"$irow[link]\",\n";
			}
		}
		$rv = preg_replace("/,\\n?$/", "\n", $rv);
		$rv .= "      },\n";
		$count++;
	}
	$rv = preg_replace("/,\\n?$/", "\n", $rv);
	$rv .= "   }\n";
	$rv .= "}";
	//$rv = iconv(  "CP1251", "UTF-8", $rv  );
	echo $rv;
	//echo "{\"ways\":\"$it_mass[0]\"}";
}
//*************************
function redo_config($index=false){
	$count = 100;
	if(!$index) $index = get_file("../alisaui_css/backup/__index.txt");
	if(strlen($index)==1) $index = "0".$index;
	$cfg = get_file("../alisaui_css/backup/backup_$index.txt");
	//echo $index;
	$index++;
	if($index == $count) $index="00";
	if(strlen($index)==1) $index = "0".$index;
	if(  !file_exists("../alisaui_css/backup/backup_$index.txt")  ) {
		return "end: history file not exists";
	}
	$test = get_file("../alisaui_css/backup/backup_$index.txt");
	file_put_contents("../alisaui_css/backup/__index.txt", $index);
	file_put_contents("../__atemplate.js", $cfg);
	if(trim($test)=="") {
		//$index--;
		return "end: history file '../alisaui_css/backup/backup_$index.txt' is empty";
	}
	return "ok";
}
if($_GET["ajaxaction"] == "redoConfigCopy"){
	//echo "{\"asd\":\"".save_config()."\"}";
	echo "{\"result\":\"".redo_config()."\"}";
}
//*************************
function undo_config($index=false){
	$count = 100;
	
	if(!$index) $index = get_file("../alisaui_css/backup/__index.txt");
	if(strlen($index)==1) $index = "0".$index;
	//echo $index;
	$index--;
	if($index == -1) $index=$count-1;
	if(strlen($index)==1) $index = "0".$index;
	if(  !file_exists("../alisaui_css/backup/backup_$index.txt")  ) return "end";
	$cfg = get_file("../alisaui_css/backup/backup_$index.txt");
	if(trim($cfg)=="") return "end";
	$index+=2;
	if($index >= $count) $index="00";
	if(strlen($index)==1) $index = "0".$index;
	$test = get_file("../alisaui_css/backup/backup_$index.txt");
	if($test=="") save_config();
	file_put_contents("../alisaui_css/backup/__index.txt", $index-2);
	file_put_contents("../__atemplate.js", $cfg);
	return "ok";
}
if($_GET["ajaxaction"] == "undoConfigCopy"){
	//echo "{\"asd\":\"".save_config()."\"}";
	echo "{\"result\":\"".undo_config()."\"}";
}
//*************************
//function get_file($filename){
//	$mytext = "";
//	$fp = fopen(  $filename  , "r"  ); // Открываем файл в режиме чтения
//	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
//	else echo "Ошибка при открытии файла";
//	fclose(  $fp  );
//	return $mytext;
//}
//*************************
function save_config($index=false){   
	$count = 100;
	if(!$index) $index = get_file("../alisaui_css/backup/__index.txt");
	if(strlen($index)==1) $index = "0".$index;
	//echo $index;
	$cfg = get_file("../__atemplate.js");
	file_put_contents("../alisaui_css/backup/backup_$index.txt", $cfg);
	$index++;
	if($index == $count) $index="00";
	if(strlen($index)==1) $index = "0".$index;
	file_put_contents("../alisaui_css/backup/backup_$index.txt", "");
	file_put_contents("../alisaui_css/backup/__index.txt", $index);
	//exit;
}
if($_GET["ajaxaction"] == "saveConfigCopy"){
	echo "{\"asd\":\"".save_config()."\"}";
	//echo "{\"test\":\"ok\"}";
}
//*************************
if($_GET["ajaxaction"] == "aui_replaceBlocks__content"){
	save_config();
	$blockKeys = $_GET["blockKeys"];
	$blockKeys = preg_replace("/~$/", "", $blockKeys);
	wright_log("blockKeys=".$blockKeys);
	$blockKeys = str_replace('"', '', $blockKeys);
	$blockKeys = explode("~", $blockKeys);
	$btmp = false;  foreach($blockKeys as $key=>$val)   $btmp[$key] = explode(",", $val); $blockKeys = $btmp; $btmp = false;
	foreach($blockKeys as $key=>$val){  foreach($val as $k=>$v){  $t = explode(":", $v);  $btmp[$key][$t[0]] = $t[1];  }  } $blockKeys = $btmp;
	//echo __fjs_json_stringify($blockKeys);
	//-----------------------------------------
	$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	$mass = json_decode(  $mytext, true  );
	$jsmass = $mass["site-template"];
	//echo __fjs_json_stringify($jsmass);
	//exit;
	//-----------------------------------------
	$aEval = auiGetBlockFromKeys($blockKeys, $jsmass);
	$aEval = trim($aEval."[\"content\"]");
	$mt = $_GET["content"];
	$mt = iconv(  "UTF-8", "CP1251", $mt  );
	eval("\$cmass = \$jsmass".$aEval.";");
	$cmass = $mt;
	eval("\$jsmass".$aEval." = \$cmass;");
	//echo "{\"res\":\"".str_replace('"', "", $cmass)."\"}";
	//-----------------------------------------
	$mass["site-template"] = $jsmass;
	$mass = __fjs_decode_data_array(  "UTF-8", "CP1251", $mass  );
	//wright_log("jsmass=".__fjs_json_stringify($jsmass));
	file_put_contents(  "../__atemplate.js", __fjs_json_stringify($mass)  );
	//echo  __fjs_json_stringify(  $mass["site-template"]  );]
	echo "{\"res\":\"ok\"}";
}
//*************************
if($_GET["ajaxaction"] == "tabs__connector_select"){
	$aconn = explode("/", preg_replace("/\/$/", "", $_GET["aconn"]));
	//print_r($aconn);
	$rowq = __fp_get_row_from_way($aconn, "items");
	//print_r($rowq);
	$query = "select * from itemstypes where id=".get_item_type($rowq["id"]);
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	//print_r($row);
	//-----------------------------------------
	$mass = explode("\n", $row["pairs"]);
	$rmass = array();
	foreach($mass as $key=>$val){
		if($val!=""){
			$tmass = explode("===", $val);
			if($tmass[0]=="textarea") $rmass["cont"] = "Текстовое поле";
			//elseif($tmass[0]=="textarea") $rmass["cont"] = "Текстовое поле";
			else $rmass[$tmass[1]] = $tmass[3];
		}
	}
	//-----------------------------------------
	echo __fjs_json_stringify($rmass);
	//echo "{\"query\":\"$query\"}";
}
//*************************
if($_GET["ajaxaction"] == "saveBlockProperties"){
	save_config();
	//-----------------------------------------
	$blockKeys = $_GET["blockKeys"];
	$blockKeys = preg_replace("/~$/", "", $blockKeys);
	wright_log("blockKeys=".$blockKeys);
	$blockKeys = str_replace('"', '', $blockKeys);
	$blockKeys = explode("~", $blockKeys);
	$btmp = false;  foreach($blockKeys as $key=>$val)   $btmp[$key] = explode(",", $val); $blockKeys = $btmp; $btmp = false;
	foreach($blockKeys as $key=>$val){  foreach($val as $k=>$v){  $t = explode(":", $v);  $btmp[$key][$t[0]] = $t[1];  }  } $blockKeys = $btmp;
	//echo __fjs_json_stringify($blockKeys);
	//-----------------------------------------
	$ct_test =  get_file("../__atemplate_tmp.js");
	//if(file_exists("../__atemplate_tmp.js")){
	if($ct_test!="") {
		$fp = fopen(  "../__atemplate_tmp.js", "r"  ); // Открываем файл в режиме чтения
	} else {
		$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	}
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	$mass = json_decode(  $mytext, true  );
	$jsmass = $mass["site-template"];
	//chmod("../__atemplate_tmp.js", 0644);
	//echo "fileperms=".fileperms("../__atemplate_tmp.js");
	file_put_contents(  "../__atemplate.js", __fjs_json_stringify($mass)  );
	if($ct_test!="") file_put_contents(  "../__atemplate_tmp.js", ""  );
	//if(file_exists("../__atemplate_tmp.js")) unlink("../__atemplate_tmp.js");
	//echo __fjs_json_stringify($jsmass);
	//exit;
	//-----------------------------------------
	$aEval = auiGetBlockFromKeys($blockKeys, $jsmass);
	$aEval = trim($aEval);
	$mt = $_GET["multiType"];
	$mt = iconv(  "UTF-8", "CP1251", $mt  );
	$mt = preg_replace("/Не указан/", "", $mt);
	$cf = $_GET["connectionField"];
	//$cf = iconv(  "UTF-8", "CP1251", $cf  );
	$cf = preg_replace("/^ | $/", "", $cf);
	//wright_log("cf=$cf");
	eval("\$cmass = \$jsmass".$aEval.";");
	$cmass["id"] 												= $_GET["id"];
	$cmass["className"] 									= $_GET["className"];
	$cmass["content"] 										= $_GET["content"];
	$cmass["multiType"] 									= $mt;
	$cmass["connectionField"] 							= $cf;
	$cmass["pageRequire"]								= $_GET["pageRequire"];
	$cmass["pagePost"]									= $_GET["pagePost"];
	$cmass["inputProperties_type"]					= $_GET["inputProperties_type"];
	$cmass["inputProperties_check"]					= $_GET["inputProperties_check"];
	$cmass["inputProperties_match"]					= $_GET["inputProperties_match"];
	eval("\$jsmass".$aEval." = \$cmass;");
	//-----------------------------------------
	//$aEval = preg_replace("/\[\"childs\"\]$/", "", $aEval);
	//__fjs_decode_data_array(  "CP1251", "UTF-8", $mass  );
	//wright_log("\$cmass = \$jsmass".$aEval);
	//echo __fjs_json_stringify( $cmass );
	//-----------------------------------------
	$mass["site-template"] = $jsmass;
	//echo "count before: ".count($mass)."<br/>\n";
	$mass = __fjs_decode_data_array(  "UTF-8", "CP1251", $mass  );
	//echo "count after: ".count($mass)."<br/>\n";
	//echo  __fjs_json_stringify(  $mass["site-template"]  );
	
	//wright_log("jsmass=".__fjs_json_stringify($jsmass));
	file_put_contents(  "../__atemplate.js", __fjs_json_stringify($mass)  );
	echo  __fjs_json_stringify(  $mass["site-template"]  );
	//echo "{\"res\":\"ok\"}";
}
//*************************
if($_GET["ajaxaction"] == "saveCSSToBlock"){
	$start_saver = $_GET["startSaver"];
	//save_config();
	//-----------------------------------------
	$rowq = __fp_get_row_from_way(array("constructor","styles"), "items");
	$resp = mysql_query("select * from items where parent=$rowq[id] $dop_query order by prior asc  ");
	$mass = array();
	while($row=mysql_fetch_assoc($resp))
		if($_GET[$row["name"]])  $mass[$row["name"]] = $_GET[$row["name"]];
	//$style_json = json_encode(  $mass, true  );
	$style_json = $mass;
	//print_r($style_json);
	//echo "$style_json";
	//exit;
	//-----------------------------------------
	$blockKeys = $_GET["blockKeys"];
	$blockKeys = preg_replace("/~$/", "", $blockKeys);
	$blockKeys = preg_replace("/\\\\/", "", $blockKeys);
	//echo "blockKeys=$blockKeys<br/\n>";
	//wright_log("blockKeys=".$blockKeys);
	$blockKeys = str_replace('"', '', $blockKeys);
	$blockKeys = explode("~", $blockKeys);
	$btmp = false;  foreach($blockKeys as $key=>$val)   $btmp[$key] = explode(",", $val); $blockKeys = $btmp; $btmp = false;
	foreach($blockKeys as $key=>$val){  foreach($val as $k=>$v){  $t = explode(":", $v);  $btmp[$key][$t[0]] = $t[1];  }  } $blockKeys = $btmp;
	//wright_log("blockKeys=".__fjs_json_stringify($blockKeys));
	//echo __fjs_json_stringify($blockKeys);
	//exit;
	//-----------------------------------------
	$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	$mass = json_decode(  $mytext, true  );
	$jsmass = $mass["site-template"];
	//echo __fjs_json_stringify($jsmass);
	//exit;
	//-----------------------------------------
	//print_r($blockKeys);
	//print_r($jsmass);
	$aEval = auiGetBlockFromKeys($blockKeys, $jsmass);
	$aEval = preg_replace("/\[\"childs\"\]$/", "", $aEval);
	$aEval .= "[\"css\"]";
	//$aEval .= "[\"css\"]";
	//wright_log("aEval=".$aEval);
	//echo "\$jsmass$aEval = \$style_json;";
	eval("\$jsmass$aEval = \$style_json;");
	//echo "print_r(\$jsmass$aEval);";
	//eval("echo __fjs_json_stringify(\$jsmass$aEval);");
	//print_r($jsmass);
	//wright_log("jsmass=".__fjs_json_stringify($jsmass));
	//echo __fjs_json_stringify($jsmass);
	//exit;
	//-----------------------------------------
	$mass["site-template"] = $jsmass;
	$mass = __fjs_decode_data_array(  "UTF-8", "CP1251", $mass  );
	//wright_log("jsmass=".__fjs_json_stringify($jsmass));
	if(startSaver){
		file_put_contents(  "../__atemplate_tmp.js", __fjs_json_stringify($mass)  );
	} else {
		file_put_contents(  "../__atemplate.js", __fjs_json_stringify($mass)  );
	}
	echo  __fjs_json_stringify(  $mass["site-template"]  );
	//wright_log("mass=".__fjs_json_stringify(  $mass["site-template"]  ));
	//echo "{\"res\":\"ok\"}";
}
//*************************
if($_REQUEST["ajaxaction"]=="aui_replaceBlocks"){
	save_config();
	//-----------------------------------------
	$from = $_GET["from"];
	$to = $_GET["to"];
	//-----------------------------------------
	$blockKeys = $_GET["blockKeys"];
	$blockKeys = preg_replace("/~$/", "", $blockKeys);
	wright_log("blockKeys=".$blockKeys);
	$blockKeys = str_replace('"', '', $blockKeys);
	$blockKeys = explode("~", $blockKeys);
	$btmp = false;  foreach($blockKeys as $key=>$val)   $btmp[$key] = explode(",", $val); $blockKeys = $btmp; $btmp = false;
	foreach($blockKeys as $key=>$val){  foreach($val as $k=>$v){  $t = explode(":", $v);  $btmp[$key][$t[0]] = $t[1];  }  } $blockKeys = $btmp;
	//wright_log("blockKeys=".__fjs_json_stringify($blockKeys));
	//echo __fjs_json_stringify($blockKeys);
	//exit;
	//-----------------------------------------
	$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	$mass = json_decode(  $mytext, true  );
	$jsmass = $mass["site-template"];
	//echo __fjs_json_stringify($jsmass);
	//exit;
	//-----------------------------------------
	$aEval = auiGetBlockFromKeys($blockKeys, $jsmass)."[\"childs\"]";
	$aEval_a = $aEval."[$from]";
	$aEval_b = $aEval."[$to]";
	//echo "\$aEval_tmp_a = \$jsmass".$aEval_a.";";
	//echo "\$aEval_tmp_b = \$jsmass".$aEval_b.";";
	eval("\$aEval_tmp_a = \$jsmass".$aEval_a.";");
	eval("\$aEval_tmp_b = \$jsmass".$aEval_b.";");
	eval("\$jsmass".$aEval_a."=\$aEval_tmp_b;");
	eval("\$jsmass".$aEval_b."=\$aEval_tmp_a;");
	//-----------------------------------------
	$mass["site-template"] = $jsmass;
	$mass = __fjs_decode_data_array(  "UTF-8", "CP1251", $mass  );
	//wright_log("jsmass=".__fjs_json_stringify($jsmass));
	file_put_contents(  "../__atemplate.js", __fjs_json_stringify($mass)  );
	//echo  __fjs_json_stringify(  $mass["site-template"]  );
	//echo __fjs_json_stringify(array("result"=>preg_replace('/"/', "", $prega)));
	echo "{\"result\":\"replaceBlockAjaxFunction\"}";
}
//*************************
if($_REQUEST["ajaxaction"]=="deletePageBlock"){
	save_config();
	//-----------------------------------------
	$blockKeys = $_GET["blockKeys"];
	$blockKeys = preg_replace("/~$/", "", $blockKeys);
	wright_log("blockKeys=".$blockKeys);
	$blockKeys = str_replace('"', '', $blockKeys);
	$blockKeys = explode("~", $blockKeys);
	$btmp = false;  foreach($blockKeys as $key=>$val)   $btmp[$key] = explode(",", $val); $blockKeys = $btmp; $btmp = false;
	foreach($blockKeys as $key=>$val){  foreach($val as $k=>$v){  $t = explode(":", $v);  $btmp[$key][$t[0]] = $t[1];  }  } $blockKeys = $btmp;
	//wright_log("blockKeys=".__fjs_json_stringify($blockKeys));
	//echo __fjs_json_stringify($blockKeys);
	//exit;
	//-----------------------------------------
	$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	$mass = json_decode(  $mytext, true  );
	$jsmass = $mass["site-template"];
	//echo __fjs_json_stringify($jsmass);
	//exit;
	//-----------------------------------------
	$aEval = auiGetBlockFromKeys($blockKeys, $jsmass);
	preg_match_all("/\[.?.?.?\]$/", $aEval, $out);
	$out[0][0] = preg_replace(  "/^\[|\]$/", "", $out[0][0]  );
	$prega = "/\[".$out[0][0]."\]/";
	$prep_eval = preg_replace($prega, "", $aEval);
	eval("\$len=count(\$jsmass".$prep_eval.");");
	if($len == 1) eval("\$jsmass".$prep_eval."=false;");
	else eval("array_splice(\$jsmass".$prep_eval.", ".$out[0][0].", 1);");
	//-----------------------------------------
	$mass["site-template"] = $jsmass;
	$mass = __fjs_decode_data_array(  "UTF-8", "CP1251", $mass  );
	//wright_log("jsmass=".__fjs_json_stringify($jsmass));
	file_put_contents(  "../__atemplate.js", __fjs_json_stringify($mass)  );
	echo  __fjs_json_stringify(  $mass["site-template"]  );
	//echo __fjs_json_stringify(array("result"=>preg_replace('/"/', "", $prega)));
	//echo "{\"result\":\"deteteAjaxFunction\"}";
}
//*************************
if($_REQUEST["ajaxaction"]=="addPageBlock" || $_GET["ajaxaction"]=="addPageBlock"){
	save_config();
	//-----------------------------------------
	$block = $_REQUEST["block"];
	//$block = $_GET["block"];
	$blockKeys = $_REQUEST["blockKeys"];
	//$blockKeys = $_GET["blockKeys"];
	$block = preg_replace("/\/$/", "", $block);
	$blockKeys = str_replace('"', '', $blockKeys);
	//$block = preg_replace('/\/$/', "", $block);
	//wright_log("block=".$block);
	//wright_log("blockKeys=".$blockKeys);
	$blockKeys = explode("~", $blockKeys);
	$btmp = false;
	foreach($blockKeys as $key=>$val)
		$btmp[$key] = explode(",", $val);
	$blockKeys = $btmp;
	$btmp = false;
	foreach($blockKeys as $key=>$val){
		foreach($val as $k=>$v){
			$t = explode(":", $v);
			$btmp[$key][$t[0]] = $t[1];
		}
	}
	$blockKeys = $btmp;
	print_r($blockKeys);
	//wright_log(__fjs_json_stringify($blockKeys));
	//-----------------------------------------
	$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	$mass = json_decode(  $mytext, true  );
	$jsmass = $mass["site-template"];
	//$ json_encode(  $jsmass, true  );
	
	$row = __fp_get_row_from_way(explode("/", $block), "items");
	$row["coder"] = iconv(  "CP1251", "UTF-8", $row["coder"]  );
	$data = json_decode($row["coder"], true);
	//$data = __fjs_decode_data_array(  "UTF-8", "CP1251", $data  );
	//wright_log("data=".__fjs_json_stringify($data));
	$aEval = auiGetBlockFromKeys($blockKeys, $jsmass);
	$aEval .= "[\"childs\"]";
	//wright_log("aEval=".$aEval);
	$allInterfaceTemplate = $jsmass;
	$aVal = "allInterfaceTemplate".$aEval;
	//echo $aVal."\n";
	eval("\$a=\$"."$aVal;");
	//print_r($a);
	//echo "count=".count( $a )."\n";
	if(count($a)  > 0){
		//echo "dop\n";
		//echo "\$allInterfaceTemplate$aEval"."[".count($a)."] = \$data;";
		eval("\$allInterfaceTemplate$aEval"."[".count($a)."] = \$data;");
		//print_r($allInterfaceTemplate);
		$mass["site-template"] = $allInterfaceTemplate;
		$mass = __fjs_decode_data_array(  "UTF-8", "CP1251", $mass  );
		//echo(__fjs_json_stringify($mass));
		file_put_contents(  "../__atemplate.js", __fjs_json_stringify($mass)  );
	} else {
		eval("\$allInterfaceTemplate$aEval = array(\$data);");
		$mass["site-template"] = $allInterfaceTemplate;
		$mass = __fjs_decode_data_array(  "UTF-8", "CP1251", $mass  );
		//file_put_contents(  "../__atemplate.js", __fjs_json_stringify($mass)  );
	}
	$allInterfaceTemplate = __fjs_decode_data_array(  "UTF-8", "CP1251", $allInterfaceTemplate  );
	//echo __fjs_json_stringify($allInterfaceTemplate);
	//wright_log("allInterfaceTemplate=".__fjs_json_stringify($allInterfaceTemplate));
}
function auiGetBlockFromKeys($blockKeys, $tmpl){
	//alert("auiGetBlockFromKeys()");
	$count=0;
	$rv = "";
	//wright_log("bk=".__fjs_json_stringify($blockKeys));
	$cc=0;
	//$tmp=false;
	//foreach(  $tmpl as $key=$val  )
	//	$tmp
	
	foreach( $tmpl as $j=>$val){
		if(  strtolower($blockKeys[0][1]) == strtolower($tmpl[$j]["tagname"])  &&  $blockKeys[0][0] == $cc  ){
			$rv .= "[".$j."]"; 
			if($blockKeys[1]){
				array_splice($blockKeys, 0, 1);
				//wright_log("rbk=".__fjs_json_stringify($blockKeys));
				$rv .= "[\"childs\"]".auiGetBlockFromKeys($blockKeys, $tmpl[$j]["childs"]);
			}
			return $rv;
		}
		if(  strtolower($blockKeys[0][1]) == strtolower($tmpl[$j]["tagname"])  )	
			$count++;
		$cc++;
	}
	return "";
}
//*************************
if($_REQUEST["ajaxaction"]=="getStylesCSS"){
	$rv = "{";
	$rowq = __fp_get_row_from_way(array("constructor","styles"), "items");
	$resp = mysql_query("select * from items where parent=$rowq[id] $dop_query order by prior asc  ");
	$count="0";
	while($row=mysql_fetch_assoc($resp)){
		$rv .= "\"$count\": {";
			$rv .= "\"name\":\"$row[name]\",";
			$rv .= "\"psname1\":\"$row[name]\",";
			$rv .= "\"psname2\":\"$row[name]\",";
			$rv .= "\"rusname\":\"$row[name]\",";
			if($row["coder"])  $rv .= "\"data\":$row[coder],";
			$rv .= "\"comment\":\"$row[cont]\"";
		$rv .= "},";
		$count++;
		//wright_log($rv."::".$count);
	}
	$rv = preg_replace("/\,$/", "", $rv);
	$rv .= "}";
	echo $rv;
	//wright_log($rv);
}
//*************************

//*************************
if($_REQUEST["ajaxaction"]=="saveSitePages"){
	save_config();
	//-----------------------------------------
	$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo '{"result":"closeFile error"}';
	fclose(  $fp  );
	$data = $_REQUEST["data"];
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	$mass = json_decode(  $mytext, true  );
	$mass["site-pages"] = $data;
	$mass = __fjs_decode_data_array(  "UTF-8", "CP1251", $mass  );
	file_put_contents(  "../__atemplate.js", __fjs_json_stringify($mass)  );
	//wright_log(  __fjs_json_stringify(   $data )  );
	echo '{"result":"ok"}';
}
//*************************
if($paction=="getTemplateJSON"){
	$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	//echo $mytext;
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	//$mytext  = str_replace('\"', '"', $mytext);
	//$mytext  = str_replace('"', '\"', $mytext);
	//echo "<pre>"; echo "$mytext"; echo "</pre>";
	$mass = json_decode(  $mytext, true  );
	//echo "mass";
	//print_r($mass);
	$jsmass = $mass["site-template"];
	echo json_encode(  $jsmass  );
}
//*************************
if($paction=="auiGetSiteProperties"){
	$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	$mass = json_decode(  $mytext, true  );
	$jsmass = $mass["site-properties"];
	echo json_encode(  $jsmass  );
}
//*************************
if($paction=="auiGetSitePages"){
	//wright_log("auiGetSitePages");
	$fp = fopen(  "../__atemplate.js", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	$mass = json_decode(  $mytext, true  );
	$jsmass = $mass["site-pages"];
	echo json_encode(  $jsmass  );
}
//*************************
function __aui_SelectAllPages($parent, $need=false){
	global $dop_query;
	if(!$parent) $parent = "0";
	$mass = array();
	$query = "select * from items where parent=$parent $dop_query order by folder desc, prior asc ";
	$resp = mysql_query($query);
	$count = 0;
	//wright_log("__aui_SelectAllPages()=".$need[0]."::".$need[1]."::".$need[2]."::".$need[3]."::".$need[4]."::".$need[5]);
	while($row=mysql_fetch_assoc($resp)){
		$mass[$count]["id"] = $row["id"];
		$mass[$count]["name"] = $row["name"];
		$mass[$count]["href_name"] = $row["href_name"];
		$mass[$count]["href"] =  __fp_create_folder_way("items", $row["id"], 1);
		$mass[$count]["folder"] = $row["folder"];
		if(  $row["href_name"] == $need[0] &&  $need[0]!="" )
			$mass[$count]["class"] = "active";
		if(  $row["href_name"] == $need[0]  ){
			array_shift($need);
			wright_log("unset()=".$need[0]."::".$need[1]."::".$need[2]."::".$need[3]."::".$need[4]."::".$need[5]);
			$mass[$count]["children_data"] = __aui_SelectAllPages($row["id"], $need);
		}
		$respo = mysql_query("select * from items where parent=$row[id] $dop_query");
		if(mysql_num_rows($respo)>0){
			$mass[$count]["children"] = "1";
		}
		$count++;
	}
	return $mass;
}
//*************************
if($paction=="auiSelectPageFromAllPages"){
	$parent = $_POST["sparent"];
	//wright_log("parent=$parent");
	if(!is_numeric($parent)) $parent = __fp_get_id_from_way(explode("/", $parent), "items");
	//wright_log("parent=$parent");
	$need = $_POST["needLink"];
	$need = explode("/", $need);
	if($need[count($need)-1] == "") { 
		array_pop($need); 
		$need[count($need)-1]  = $need[count($need)-1] ."/";
	}
	//echo "auiSelectPageFromAllPages";
	$mass = __aui_SelectAllPages($parent, $need);
	//wright_log("-----------------------------");
	$mass = __fjs_decode_data_array(  "CP1251", "UTF-8", $mass  );
	//print_r($mass);
	$json = json_encode(  $mass  );
	echo $json;
	//print_r();
}
//*************************
if($paction=="getelementproperties_bg"){
	$elname = $_POST["elname"];
	$mystylefile = $_POST["mystylefile"];
	$file = "../styles/tmpl-1/$mystylefile"; 
	$rmass = __fa_css_to_array($file, $elname);
	//**************
	$mass = __fa_get_bg_styles($rmass);
	require_once("templates/__user_interface_properties_bg.php");
}
//*************************
if($paction=="getelementproperties_box"){
	$elname = $_POST["elname"];
	$mystylefile = $_POST["mystylefile"];
	$file = "../styles/tmpl-1/$mystylefile"; 
	$rmass = __fa_css_to_array($file, $elname);
	//**************
	$mass = __fa_get_box_styles($rmass);
	require_once("templates/__user_interface_properties_box.php");
}
//*************************
if($paction=="getelementproperties_pos"){
	$elname = $_POST["elname"];
	$mystylefile = $_POST["mystylefile"];
	$file = "../styles/tmpl-1/$mystylefile"; 
	$rmass = __fa_css_to_array($file, $elname);
	//**************
	$mass = __fa_get_pos_styles($rmass);
	require_once("templates/__user_interface_properties_pos.php");
}
//*************************
if($paction=="getelementproperties_txt"){
	$elname = $_POST["elname"];
	$mystylefile = $_POST["mystylefile"];
	$file = "../styles/tmpl-1/$mystylefile"; 
	$rmass = __fa_css_to_array($file, $elname);
	//**************
	$mass = __fa_get_txt_styles($rmass);
	require_once("templates/__user_interface_properties_txt.php");
}
//*************************
if($paction=="getelementproperties_bor"){
	$elname = $_POST["elname"];
	$mystylefile = $_POST["mystylefile"];
	$file = "../styles/tmpl-1/$mystylefile"; 
	$rmass = __fa_css_to_array($file, $elname);
	//**************
	$mass = __fa_get_bor_styles($rmass);
	require_once("templates/__user_interface_properties_bor.php");
}
//*************************
if($paction=="saveelementproperties"){
	$elname = "/".trim($_POST["elname"])."{/";
	$elname_no = "/ ".trim($_POST["elname"])."{/";
	//echo "elname = $elname\n";
	$mystylefile = $_POST["mystylefile"];
	$file = "../styles/tmpl-1/$mystylefile"; 
	$fh = fopen($file, 'r+'); 
	$cont = fread($fh, filesize($file)); 
	fclose($fh); 
	//**************
	$mass = explode("\n", $cont);
	foreach($mass as $key=>$val)
		$mass[$key] = trim($val);
	//**************
	$pmass = explode(";", $_POST["styles"]);
	foreach($pmass as $key=>$val){
		$pmass[$key] = explode(":", trim($val));
	}
	//**************
	$a_start = false;
	$index_start = false;
	$index_stop = false;
	foreach($mass as $key=>$val){
		//echo "Строка: $val\n";
		if(preg_match($elname, $val) && !preg_match($elname_no, $val)){
			$a_start = true;
			$index_start = $key+1;
			$key++;
			//echo "В строке $val найдено совпадение с условием $elname\n";
		}
		if($a_start && preg_match("/}/", $val)) {
			$a_start = false;
			$index_stop = $key;
			$dopstr =  __fa_test_to_add_style_to_css($mass, $pmass, $index_start+1, $index_stop);
			$mass[$key-1] .= $dopstr;
			//echo "В строке $val найдено закрытие группы\n";
		}
		if($a_start) {
			$amass = explode(":", $val);
			$act = false;
			foreach($pmass as $k=>$v){
				if($v[0]==$amass[0]) {
					$v[1] = trim($v[1]);
					if($v[1]=="false") $v[1]="";
					$act = "	$v[0]: $v[1];";
					break;
				}
			}
			if($act) $mass[$key] = $act;
		}
	}
	//**************
	$ret_str = "";
	//print_r($mass);
	foreach($mass as $key => $val){
		if(!preg_match("/: ;/", $val))
			$ret_str .= "$val\n";
	}
	//**************
	$ret_str = preg_replace("/^: ;\n/", "", $ret_str);
	//echo $ret_str;
	$f = fopen($file,'wb'); 
	fwrite($f,$ret_str,strlen($ret_str)); 
	fclose($f); 
}
//*************************
function Escape_win ($path) { 
$path = strtoupper ($path); 
return strtr($path, array("\U0430"=>"а", "\U0431"=>"б", "\U0432"=>"в", 
"\U0433"=>"г", "\U0434"=>"д", "\U0435"=>"е", "\U0451"=>"ё", "\U0436"=>"ж", "\U0437"=>"з", "\U0438"=>"и", 
"\U0439"=>"й", "\U043A"=>"к", "\U043B"=>"л", "\U043C"=>"м", "\U043D"=>"н", "\U043E"=>"о", "\U043F"=>"п", 
"\U0440"=>"р", "\U0441"=>"с", "\U0442"=>"т", "\U0443"=>"у", "\U0444"=>"ф", "\U0445"=>"х", "\U0446"=>"ц", 
"\U0447"=>"ч", "\U0448"=>"ш", "\U0449"=>"щ", "\U044A"=>"ъ", "\U044B"=>"ы", "\U044C"=>"ь", "\U044D"=>"э", 
"\U044E"=>"ю", "\U044F"=>"я", "\U0410"=>"А", "\U0411"=>"Б", "\U0412"=>"В", "\U0413"=>"Г", "\U0414"=>"Д",
"\U0415"=>"Е", "\U0401"=>"Ё", "\U0416"=>"Ж", "\U0417"=>"З", "\U0418"=>"И", "\U0419"=>"Й", "\U041A"=>"К",
"\U041B"=>"Л", "\U041C"=>"М", "\U041D"=>"Н", "\U041E"=>"О", "\U041F"=>"П", "\U0420"=>"Р", "\U0421"=>"С", 
"\U0422"=>"Т", "\U0423"=>"У", "\U0424"=>"Ф", "\U0425"=>"Х", "\U0426"=>"Ц", "\U0427"=>"Ч", "\U0428"=>"Ш", 
"\U0429"=>"Щ", "\U042A"=>"Ъ", "\U042B"=>"Ы", "\U042C"=>"Ь", "\U042D"=>"Э", "\U042E"=>"Ю", "\U042F"=>"Я")); 
} 
//*************************

?>