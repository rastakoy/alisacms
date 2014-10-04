<div style="padding:15px;">
<?
//***************************************
//if ($_FILES["sp_link"]["name"]!="") {  
//	if(file_exists("../backup/csvtmp.csv")){
//		unlink("../tmp/csvtmp.csv");
//	}
//}
//$res_dopfile = copy($_FILES["sp_link"]["tmp_name"], "../tmp/csvtmp.csv");
//***************************************

//require_once('zip.lib.php');

$action = $_GET["action"];
if($action == "makecopy"){
	$jsont = __fjs_tree_to_json(460, false);
//$jsont = preg_replace('/\}",/', "},", $jsont);
__fp_create_file(  "backup/_____backup.json",  $_SERVER['DOCUMENT_ROOT']."/",  $jsont  );
	//__fjs_create_zip_from_folder();
	
	
	
	?><a href="/backup/<?  echo $fileName; ?>">Скачать копию</a><?
}
if($action == "readcopy"){ 

	//$dirHandle = opendir("../backup/"); 
	//while (false !== ($file = readdir($dirHandle))) { 
    //	echo "Имя файла: $file<br/>";
	//}
	
	$fp = fopen(  "../backup/_____backup.json", "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) {
		while(  !feof(  $fp  )  ) {
			$mytext .= fgets(  $fp, 4096  );
		}
	}
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	
	//$mytext = str_replace(  "{\n", "(\n", $mytext  );
	//$mytext = str_replace(  "}\n", ")\n", $mytext  );
	//$mytext = str_replace(  "},", "),", $mytext  );
	//$mytext = str_replace(  "\n", "", $mytext  );
	//echo $mytext;
	
	//echo "<div id=\"jsonConteiner\" style=\"display: ;\">$mytext</div>";
	
	$mytext = iconv(  "CP1251", "UTF-8", $mytext  );
	
	
	//$mytext  = str_replace('\"', '"', $mytext);
	//$mytext  = str_replace('"', '\"', $mytext);
	
	//$mytext = 
	
	echo "<pre>"; echo "$mytext"; echo "</pre>";
	
	$mass = json_decode(  $mytext, true  );
	//$mass = __fjs_json_stringify($mytext);
	
	echo PHP_VERSION;
	
	//switch (json_last_error()) {
    //    case JSON_ERROR_NONE:
    //        echo ' - Ошибок нет';
    //    break;
    //    case JSON_ERROR_DEPTH:
    //        echo ' - Достигнута максимальная глубина стека';
    //    break;
    //    case JSON_ERROR_STATE_MISMATCH:
    //        echo ' - Некорректные разряды или не совпадение режимов';
    //    break;
    //    case JSON_ERROR_CTRL_CHAR:
    //        echo ' - Некорректный управляющий символ';
    //    break;
    //    case JSON_ERROR_SYNTAX:
    //        echo ' - Синтаксическая ошибка, не корректный JSON';
    //    break;
    //    case JSON_ERROR_UTF8:
    //        echo ' - Некорректные символы UTF-8, возможно неверная кодировка';
    //    break;
    //    default:
    //        echo ' - Неизвестная ошибка';
    //    break;
    //}
	
	//echo "<pre>"; print_r($mass); echo "</pre>";
	$mass = __fjs_decode_data_array(  "UTF-8", "CP1251", $mass  );
	echo "<pre>"; print_r($mass); echo "</pre>";
	__fjs_recovery_data_from_array(  $mass, "1064"  );
	
	
	
	//__fjs_array_to_javascript(  $mass  );
	//foreach(  $mass as $key=>$val  ){
	//	
	//}
	
	//echo "<pre>"; print_r($mass); echo "</pre>";
	//print_r($mass);
	
	//echo $mytext;

?>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <input name="uploadfile" type="file" id="uploadfile" />
    <input type="submit" name="Submit" value="Отправить" />
</form>
  <? }
	//$jsont = iconv("CP1251", "UTF-8", $jsont );
	//$array = json_decode($jsont, true);
	//echo "<pre>"; print_r($array); echo "</pre>";
?>
</div>
<script>
//var myjson = eval(  '('  +  document.getElementById("jsonConteiner").innerHTML  +  ')'  );
//alert(myjson.length);
//for(i=0; i<myjson.length; i++){
//	alert(myjson[i]);
//}
</script>