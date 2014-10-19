<?
//*********************************************
function __fp_search_first_data($table, $id, $field){
	$image = false;
	//Есть ли изображения в текущей группе
	$query = "select * from $table where folder=0 && parent=$id $dop_query limit 0,1";
	$resp = mysql_query($query); 
	if(mysql_num_rows($resp)<1){ // Если изображений нет
		$sresp = mysql_query("select id from $table where parent=$id && folder=1"); // Есть ли группы в текущей группе
		if(mysql_num_rows($sresp)>0){ // Если группы есть
			while($srow=mysql_fetch_assoc($sresp)) { // Прогнать группы по порядку
				return __fp_search_first_data($table, $srow["id"], $field);
			}
		} else {
			return false; //Если в текущей папке папок нет ни хуя :)   ,|, - это хуй
		}
	} else {
		$row = mysql_fetch_assoc($resp);
		$sir = mysql_query("select * from images where parent=$row[id] order by prior asc limit 0,1  ");
		$srow = mysql_fetch_assoc($sir);
		
		return $srow;
	}
}
//*********************************************
function __fp_top_is_need($id, $name, $table){
	$resp = mysql_query("select * from $table where id=$id");
	$row = mysql_fetch_assoc($resp);
	if($row["parent"]!=0)
		return __fp_top_is_need($row["parent"], $name, $table);
	else
		if($row["folder"]==1 && $row["parent"]==0 && $row["href_name"]==$name)
			return true;
		else
			return false;
}
//*********************************************
function __fp_set_name($way, $file, $num){
	if($num==0){
		//echo $way.$file."\n";
		if(file_exists("$way$file")){
			//echo $way.$file." - sov \n";
			return __fp_set_name($way, $file, $num+1);
		}
		else
			return $file;
	}
	else{
		$withoun_extension = substr($file, 0 , strlen($file)-4);
		if(file_exists($way.$withoun_extension.$num.".php")){
			//echo $way.$file." - sov \n";
			return __fp_set_name($way, $file, $num+1);
		}
		else
			return $withoun_extension.$num.".php";
	}
}
//*********************************************
function __fp_rus_to_eng($txt){
	$rv = "";
	for($i=0; $i<strlen($txt); $i++){
		if(substr($txt, $i, 1) == "а" || substr($txt, $i, 1) == "А" || substr($txt, $i, 1) == "A"){
			//1
			$rv.="a";
		}
		if(substr($txt, $i, 1) == "б" || substr($txt, $i, 1) == "Б" || substr($txt, $i, 1) == "B"){
			//2
			$rv.="b";
		}
		if(substr($txt, $i, 1) == "в" || substr($txt, $i, 1) == "В" || substr($txt, $i, 1) == "V"){
			//3
			$rv.="v";
		}
		if(substr($txt, $i, 1) == "г" || substr($txt, $i, 1) == "Г" || substr($txt, $i, 1) == "G"){
			//4
			$rv.="g";
		}
		if(substr($txt, $i, 1) == "д" || substr($txt, $i, 1) == "Д" || substr($txt, $i, 1) == "D"){
			//5
			$rv.="d";
		}
		if(substr($txt, $i, 1) == "е" || substr($txt, $i, 1) == "Е" || substr($txt, $i, 1) == "E"){
			//6
			$rv.="e";
		}
		if(substr($txt, $i, 1) == "ё" || substr($txt, $i, 1) == "Ё"){
			//7
			$rv.="yo";
		}
		if(substr($txt, $i, 1) == "ж" || substr($txt, $i, 1) == "Ж"){
			//8
			$rv.="zh";
		}
		if(substr($txt, $i, 1) == "з" || substr($txt, $i, 1) == "З" || substr($txt, $i, 1) == "Z"){
			//9
			$rv.="z";
		}
		if(substr($txt, $i, 1) == "и" || substr($txt, $i, 1) == "И" || substr($txt, $i, 1) == "I"){
			//10
			$rv.="i";
		}
		if(substr($txt, $i, 1) == "й" || substr($txt, $i, 1) == "Й"){
			//11
			$rv.="y";
		}
		if(substr($txt, $i, 1) == "к" || substr($txt, $i, 1) == "К" || substr($txt, $i, 1) == "K"){
			//12
			$rv.="k";
		}
		if(substr($txt, $i, 1) == "л" || substr($txt, $i, 1) == "Л" || substr($txt, $i, 1) == "L"){
			//13
			$rv.="l";
		}
		if(substr($txt, $i, 1) == "м" || substr($txt, $i, 1) == "М" || substr($txt, $i, 1) == "M"){
			//14
			$rv.="m";
		}
		if(substr($txt, $i, 1) == "н" || substr($txt, $i, 1) == "Н" || substr($txt, $i, 1) == "N"){
			//15
			$rv.="n";
		}
		if(substr($txt, $i, 1) == "я" || substr($txt, $i, 1) == "Я"){
			//16
			$rv.="ya";
		}
		if(substr($txt, $i, 1) == "о" || substr($txt, $i, 1) == "О" || substr($txt, $i, 1) == "O"){
			//17
			$rv.="o";
		}
		if(substr($txt, $i, 1) == "п" || substr($txt, $i, 1) == "П" || substr($txt, $i, 1) == "P"){
			//18
			$rv.="p";
		}
		if(substr($txt, $i, 1) == "р" || substr($txt, $i, 1) == "Р" || substr($txt, $i, 1) == "R"){
			//19
			$rv.="r";
		}
		if(substr($txt, $i, 1) == "с" || substr($txt, $i, 1) == "С" || substr($txt, $i, 1) == "S"){
			//20
			$rv.="s";
		}
		if(substr($txt, $i, 1) == "т" || substr($txt, $i, 1) == "Т" || substr($txt, $i, 1) == "T"){
			//21
			$rv.="t";
		}
		if(substr($txt, $i, 1) == "у" || substr($txt, $i, 1) == "У" || substr($txt, $i, 1) == "U"){
			//22
			$rv.="u";
		}
		if(substr($txt, $i, 1) == "ф" || substr($txt, $i, 1) == "Ф" || substr($txt, $i, 1) == "F"){
			//23
			$rv.="f";
		}
		if(substr($txt, $i, 1) == "х" || substr($txt, $i, 1) == "Х" || substr($txt, $i, 1) == "H"){
			//24
			$rv.="h";
		}
		if(substr($txt, $i, 1) == "ц" || substr($txt, $i, 1) == "Ц" || substr($txt, $i, 1) == "C"){
			//25
			$rv.="c";
		}
		if(substr($txt, $i, 1) == "ч" || substr($txt, $i, 1) == "Ч"){
			//26
			$rv.="ch";
		}
		if(substr($txt, $i, 1) == "ш" || substr($txt, $i, 1) == "Ш"){
			//27
			$rv.="sh";
		}
		if(substr($txt, $i, 1) == "Щ" || substr($txt, $i, 1) == "Щ"){
			//28
			$rv.="sch";
		}
		if(substr($txt, $i, 1) == "ъ" || substr($txt, $i, 1) == "Ъ"){
			//29
			$rv.="_";
		}
		if(substr($txt, $i, 1) == "ы" || substr($txt, $i, 1) == "Ы"){
			//30
			$rv.="i";
		}
		if(substr($txt, $i, 1) == "ь" || substr($txt, $i, 1) == "Ь"){
			//31
			$rv.="_";
		}
		if(substr($txt, $i, 1) == "э" || substr($txt, $i, 1) == "Э"){
			//32
			$rv.="e";
		}
		if(substr($txt, $i, 1) == "ю" || substr($txt, $i, 1) == "Ю"  || substr($txt, $i, 1) == "U"){
			//33
			$rv.="u";
		}
		if(substr($txt, $i, 1) == "і" || substr($txt, $i, 1) == "І"){
			//34
			$rv.="i";
		}
		if(substr($txt, $i, 1) == "ї" || substr($txt, $i, 1) == "Ї"){
			//35
			$rv.="i";
		}
		if(substr($txt, $i, 1) == "-" || substr($txt, $i, 1) == " "){
			//36
			$rv.="_";
		}
		if(preg_match("/^[a-z0-9._]+$/", substr($txt, $i, 1))){
			//37
			$rv.=substr($txt, $i, 1);
		}
		if(substr($txt, $i, 1) == "J"){
			//22
			$rv.="j";
		}
	}
	//$rv = str_replace(".", "", $rv);
	return $rv;
}
//***************************************************
function __fp_create_file($name, $path, $cont){
	//if (!is_writeable($csv_file)){chmod($file, 0777);}
		$fp=fopen($path.$name, "w");
		fwrite($fp, $cont);
		@fclose($fp);
		//*****************
}
//***************************************************
function __fp_is_create_files($db_table, $id, $name) {
	$create=true;
	$mass = __ft_way_to_item($db_table, $id, 1);
	foreach ($mass as $key=>$val){
		if($val["href_name"]==$name){
			$create = false;
		}
	}
	return $create;
}
//***************************************************
function __fp_create_folder_way($table, $id, $show=0){
	$rv = "";
	if(!$id) return "";
	$mass = __fp_way_to_item($table, $id, $show);
	//print_r($mass);
	//echo "fas=".$mass[count($mass)-1]["fassoc"];
	//if(preg_match("/^[/", $mass[count($mass)-1]["is_multi"]==1){
	//	
	//}
	
	//if($mass[count($mass)-2]["is_multi"]==1){
	//	foreach ($mass as $key=>$val){
	//		if($key != count($mass)-1){
	//			if($val["href_name"]) $rv.=$val["href_name"];
	//			if(substr($val["href_name"], strlen($val["href_name"])-4, 4) != ".php") $rv.="/";
	//		}
	//	}
	//	return $rv."[mi=".$mass[count($mass)-1]["id"]."]";
	//	//return $rv;
	//}
	if($mass[count($mass)-1]["fassoc"]!=0){
		//echo "Переход на папку";
		return __fp_create_folder_way($table, $mass[count($mass)-1]["fassoc"], 1);
	}
	if($mass[count($mass)-1]["rtf"]!=0){
		//echo "Переход на запись";
		return __fp_create_folder_way($table, $mass[count($mass)-1]["rtf"], 1);
	}
	if($mass)
		foreach ($mass as $key=>$val){
			if($val["href_name"]) $rv.=$val["href_name"];
			if(substr($val["href_name"], strlen($val["href_name"])-4, 4) != ".php") $rv.="/";
		}
	$prega = "/http:\/\//";
	if(preg_match($prega, $rv)){
		return "$val[href_name]";
	}
	return preg_replace("/index.php/", "", $rv);
}
//***************************************************
function __fp_create_nav_way($table, $id, $show=0){
	$rv = "";
	$mass = __ft_way_to_item($table, $id, $show);
	if($mass)
		foreach ($mass as $key=>$val){
			if($key>0) {
				//if($key!=count($mass)-1) $rv.= "<a href=\"".__fp_create_folder_way("items_pages", $val["id"], 1)."\">";
				if($val["name"]) $rv.=$val["name"];
				//if($key!=count($mass)-1) $rv.= "</a>";
				if(substr($val["href_name"], strlen($val["href_name"])-4, 4) != ".php") $rv.=" / ";
			}
		}
	//$rv = eregi_replace("\/", " / ", $rv);
	return eregi_replace("index.php", "", $rv);
}
//***************************************************
function __fp_create_nav_way_02($table, $id, $show=0){
	
	$mass = __fp_way_to_item($table, $id, $show);
	if(count($mass)>1){
	$rv = "<div xmlns:v=\"http://rdf.data-vocabulary.org/#\" id=\"div_breadlinks\">";
						$rv .= "<span typeof=\"v:Breadcrumb\"><a href=\"./\"";
						$rv .= " rel=\"v:url\" property=\"v:title\">";
						$rv .= "Главная";
						$rv .= "</a> › ";
						$rv.="</span>";
	if($mass)
		foreach ($mass as $key=>$val){
			if($key>=0) {
				//if($key!=count($mass)-1) $rv.= "<a href=\"".__fp_create_folder_way("items_pages", $val["id"], 1)."\">";
				if($val["name"]) {
					if($key != count($mass)-1) {
						$rv .= "<span typeof=\"v:Breadcrumb\"><a href=\"".__fp_create_folder_way($table, $val["id"], 1)."\"";
						$rv .= " rel=\"v:url\" property=\"v:title\">";
						$rv .= $val["name"];
						$rv .= "</a> › ";
						$rv.="</span>";
					} else {
						$rv .= "<span typeof=\"v:Breadcrumb\">";
						$rv .= $val["name"];
						$rv.="</span>";
					}
				}
				//if($key!=count($mass)-1) $rv.= "</a>";
				//if(substr($val["href_name"], strlen($val["href_name"])-4, 4) != ".php") $rv.=" / ";
				//if($key != count($mass)-1) $rv.=" › ";
			}
		}
	$rv .= "</div>";
	}
	//$rv = eregi_replace("\/", " / ", $rv);
	return preg_replace("/index.php/", "", $rv);
}
//***************************************************
function __fp_get_id_from_way($way, $table="items", $parent=0, $level=0){
	$query = "select * from $table where href_name='$way[$level]' && parent=$parent && recc!=1 && page_show=1 && tmp!=1 limit 0,1";
	//echo $query."<br/>\n";
	$resp = mysql_query($query); if(!$resp) return false;
	$row = mysql_fetch_assoc($resp);
	//print_r($row); echo "<br/><br/>";
	if($level != count($way)-1)
		return __fp_get_id_from_way($way, $table, $row["id"], $level+1);
	else
		return $row["id"];
}
//*******************************************
function __fp_way_to_item($table, $id, $self=false){
	if(!$id) return "";
	$query = "select * from $table where id=$id";
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$mass = false;
	$par=$row["parent"];
	while($par!=0){
		$resppar = mysql_query("select * from $table where id=$par");
		$rowpar = mysql_fetch_assoc($resppar);
		$par = $rowpar["parent"];
		$mass[] = $rowpar;
	}
	if($mass) $mass = array_reverse ($mass, false);
	//if($self && $mass[count($mass)-1]["is_multi"]!=1) $mass[] = $row;
	if($self) $mass[] = $row;
	return $mass;
}
//*******************************************
function __fp_get_row_from_way($ways, $table, $level=0, $parent=0){
	$ret_val=false;
	$query = "select * from $table where  href_name='".$ways[$level]."' && parent=$parent && recc!=1  ";
	//echo $query."<br/>\n";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	//echo "<pre>"; print_r($row); echo "</pre>";
	//echo "level=$level";
	if($row["redirect"]) {
			$aqresp = mysql_query("select * from items where id=$row[redirect]");
			$aqrow = mysql_fetch_assoc($aqresp);
			if($aqrow) return $aqrow;
	}
	if($level != count($ways)-1 && $row){
		//if(preg_match("/.*mi=/", $ways[$level+1])) 
		//	return "";
		//else
			$ret_val = __fp_get_row_from_way($ways, $table, $level+1, $row["id"]);
	}
	if($level == count($ways)-1 && $row){
		return  $row;
	}
	return $ret_val;
}
//*******************************************
function __fp_get_row_rtf_from_folder_id($id, $argvs=false){
	$query = "select * from items where id=$id  ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$query = "select * from items where parent=$row[parent] && folder=0 && recc!=1 && tmp!=1 && page_show=1 order by prior asc limit 0,1 ";
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	if($argvs) return $row[$argvs];
	return $row;
}
//*******************************************
function __fp_test_item_for_show($id){
	if(!$id) return false;
	$query = "select * from items where id=$id  ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	if($row["page_show"]!="1") return true;
	if($row["parent"]!="0") return __fp_test_item_for_show($row["parent"]);
	return false;
}
//*******************************************
function __fp_test_childs($rowa){
	
}
//*******************************************
function __fp_get_childs($rowa){
	
}
//*******************************************
function __fp_clear_cont($ret, $count){
	$ret = strip_tags($ret);
	$ret = substr($ret, 0, $count);
	return $ret;
}
//*******************************************
function getPagination($array){
	$page = $array["page"];
	$pagesShow = $array["pagesShow"];
	$count = $array["count"];
	$countPages = round($count / $array["onPage"]);
	if($countPages < $count / $array["onPage"]) $countPages++;
	if($countPages < 2) return"";
	$link = $array["link"];
	$sizeCount = $array["sizeCount"];
	$mask = $array["mask"];
	$maskActive = $array["maskActive"];
	$oldMask = $mask;
	//*******************************
	$return = "";
	$cc = 0; $secondPoint = true;
	for($j = 1; $j <= $countPages; $j++){
		//echo "-$return";
		$mask = ($j == $page) ? $maskActive : $oldMask;
		//******************************
		if($j <= $sizeCount){
			if($array["url"]) $lnk = "http://".$_SERVER['HTTP_HOST']."/$link$j";
			else $lnk = "$link";
			$masko = str_replace("%link%", $lnk, $mask);
			$masko = str_replace("%page%", $j, $masko);
			$return .= $masko;
		}elseif($j < $page - $pagesShow/2 && $j==$sizeCount+1){
			$return .= "&nbsp;&nbsp;...&nbsp;&nbsp;";
		}elseif($j>=$page - $pagesShow/2 && $cc<$pagesShow){
			if($array["url"]) $lnk = "http://".$_SERVER['HTTP_HOST']."/$link$j";
			else $lnk = "$link";
			$masko = str_replace("%link%", $lnk, $mask);
			$masko = str_replace("%page%", $j, $masko);
			$return .= $masko;
			$cc++;
		}elseif($j>=$page + $pagesShow/2 && $j<=$countPages-$sizeCount && $secondPoint){
			$return .= "&nbsp;&nbsp;...&nbsp;&nbsp;";
			$secondPoint = false;
		}elseif($j>$countPages-$sizeCount-$pagesShow && $secondPoint){
			if($array["url"]) $lnk = "http://".$_SERVER['HTTP_HOST']."/$link$j";
			else $lnk = "$link";
			$masko = str_replace("%link%", $lnk, $mask);
			$masko = str_replace("%page%", $j, $masko);
			$return .= $masko;
		}elseif($j>$countPages-$sizeCount){
			if($array["url"]) $lnk = "http://".$_SERVER['HTTP_HOST']."/$link$j";
			else $lnk = "$link";
			$masko = str_replace("%link%", $lnk, $mask);
			$masko = str_replace("%page%", $j, $masko);
			$return .= $masko;
		}
	}
	return $return;
}

//*******************************************
?>