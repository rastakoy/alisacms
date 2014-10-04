<?
//*******************************
function __fz_find_all_price(  $code  ){
	$query = "select * from items where cont like('%userpromo-$code%') && orderstatus='ordersstatuses/ok'  ";
	//echo $query;
	$resp = mysql_query(  $query  );
	//echo "asd=".mysql_num_rows(  $resp  );
	$summ = 0;
	while(  $row = mysql_fetch_assoc(  $resp  )  ){
		//print_r(  $row  );
		//$prega = "/.*userpromo-$code.>.*<\/td><td>.*<\/td>/";
		$row["cont"] = str_replace("\n", "", $row["cont"] );
		$prega = "/Итого.*table/";
		//echo $prega."<br/>\n";
		$a = preg_match_all(  $prega, $row["cont"], $kv  );
		//print_r($kv);
		$price = str_replace(  " грн.</td></tr></tbody></table", "", $kv[0][0]  );
		$price = str_replace(  "Итого", "", $price  );
		$price = str_replace(  "</td><td>", "", $price  );
		//$price = str_replace(  "<td>", "", $price  );
		$price = str_replace(  ",", ".", $price  );
		$price = trim(  $price  );
		$summ += $price*1;
		//echo "pr=$price--<br/>\n";
	}
	//echo "SUMM=$summ<br/>\n";
	return $summ;
	
}
//*******************************
function __fz_test_usercode(  $code  ){
	$resp = mysql_query(  "select * from users where user_promo='$code'  "  );
	$row = mysql_fetch_assoc(  $resp  );
	print_r(  $row  );
	if(  mysql_num_rows(  $resp  ) > 0  )
		return $row["id"];
	return "false";
}
//*******************************
function __fz_usercode_generator(){
	$string=rand(0,99999999);
	$resp = mysql_query(  "select * from users where user_promo='$string'  "  );
	if(  mysql_num_rows(  $resp  ) > 0  )
		return __fz_usercode_generator();
	return $string;
}
//*******************************
function extract_data_from_zak_cont($str, $command){
	$regexp = "/$command=.*+\n/i";
	preg_match_all($regexp, $str, $m);
	return trim(str_replace("$command=", "", $m[0][0]));
}
//*******************************
function __fz_get_users(){
	$mass = false;
	$query = "select * from users where count_zak>0 ";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$mass[] = $row;
	}
	return $mass;
}
//*******************************
function __fz_get_zakaz($num, $zuser, $id){
	$rv = "";
	//*****************************
	$shapka_resp = mysql_query("select * from pages where name='manage_schet'");
	$shapka_row = mysql_fetch_assoc($shapka_resp);
	$shapka = $shapka_row["cont"];
	//*****************************
	$query = "select * from zakaz where zaknum=$num && zuser=$zuser  && id=$id  ";
	$resp = mysql_query($query);
	$row_user_info = mysql_fetch_assoc($resp);
	//*****************************
	$rv .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr>
    		<td width=\"150\" height=\"30\"><strong>Поставщик</strong></td>
    		<td>$shapka</td>
  		</tr>
		<tr>
			<td width=\"150\" height=\"30\"><strong>Имя получателя</strong></td>
			<td>$row_user_info[zname]</td>
		</tr>
		<tr>
			<td width=\"150\" height=\"30\"><strong>Телефон</strong></td>
			<td>$row_user_info[zphone]</td>
		</tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>E-mail</strong></td>
    <td>$row_user_info[zemail]</td>
  </tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>Адрес получателя</strong></td>
    <td>$row_user_info[zplace]</td>
  </tr>
</table>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr><td>
<div align=\"center\"><strong>Заказ №".strftime("%d-%m-%Y", $row_user_info["adddate"])."-".$row_user_info["id"]."<br/>
  от  ".strftime("%d.%m.%Y", $row_user_info["adddate"])."</strong>
</div></td></tr></table>
<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td width=\"40\" bgcolor=\"#CCCCCC\">№</td>
    <td width=\"400\" bgcolor=\"#CCCCCC\"><div align=\"center\">Товар</div></td>
    <td bgcolor=\"#CCCCCC\">Ед.</td>
    <td bgcolor=\"#CCCCCC\">Количество</td>
    <td bgcolor=\"#CCCCCC\">Цена без НДС </td>
    <td bgcolor=\"#CCCCCC\">Сумма без НДС </td>
  </tr>";
//*******************************
$query = "select * from zakaz where zaknum=$num && zuser=$zuser && id=$id";
$resp = mysql_query($query);
$count=1;
while($row = mysql_fetch_assoc($resp)){
	$name_query = "select * from items where id=$row_user_info[product_id]";
	//echo $name_query;
	$name_resp = mysql_query($name_query);
	$name_row = mysql_fetch_assoc($name_resp);
	//print_r($name_row);
	$qwename = $name_row["name"];
	$aprice = $row_user_info["kolvo"] * $row_user_info["zprice"];
	$rv .= "<tr>
		<td width=\"40\" bgcolor=\"#CCCCCC\">№$count</td>
		<td width=\"400\" bgcolor=\"#CCCCCC\"><div align=\"center\">$qwename</div></td>
		<td bgcolor=\"#CCCCCC\">Шт.</td>
		<td bgcolor=\"#CCCCCC\">$row_user_info[kolvo]</td>
		<td bgcolor=\"#CCCCCC\">$row_user_info[zprice]</td>
		<td bgcolor=\"#CCCCCC\">$aprice</td>
	</tr>";
	$count++;
}
//*******************************  
$rv .= "</table>";
return $rv;
}
/*******************************
function __fz_get_zakaz($num && $zuser){
	$mass = false;
	$query = "select * from zakaz where zaknum=$num && zuser=$id ";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$mass[] = $row;
	}
	return $mass;
}
//*******************************/
function __fz_create_invoice($id, $no_convert=false){
	global $katalog_table;
	//******************************
	$cfg_resp = mysql_query("select * from pages where name='discount_config'  ");
	$cfg_row = mysql_fetch_assoc($cfg_resp);
	$cfg_discount = trim($cfg_row["cont"]);
	//******************************
	$ret = "";
	$query = "select * from $katalog_table where id=$id ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	//print_r($row);
	if(  preg_match(  "/^<p>/", $row["cont"]  )  ){
		return $row["cont"];
	} 
	$row["cont"] = str_replace("\r", "", $row["cont"]);
	$mass = explode("~~~~~~~~~~~~~~~~~~~~", $row["cont"]);
	array_pop($mass);
	//echo "<pre>"; print_r($mass); echo "</pre>";
	$user_id = extract_data_from_zak_cont($mass[0], "user");
	$user_id_query = "select * from users where id=$user_id ";
	//echo $user_id_query;
	$user_resp = mysql_query(  $user_id_query  );
	$user_row = mysql_fetch_assoc($user_resp);
	//echo "<pre>"; print_r($user_row); echo "</pre>";
	$head_query = "select * from pages where name='head_invoice'  ";
	$head_resp = mysql_query($head_query);
	$head_row = mysql_fetch_assoc($head_resp);
	$head =  $head_row["cont"];
	//echo "<pre>"; print_r($head_row); echo "</pre>";
	$disc_query = "select * from pages where name='once_discount'  ";
	$disc_resp = mysql_query($disc_query);
	$disc_row = mysql_fetch_assoc($disc_resp);
	$disc_mass_a = explode("\n", $disc_row["cont"]);
	$disc_mass = array();
	foreach($disc_mass_a as $key=>$val){
		$a = explode("=", trim($val));
		$disc_mass[] = $a;
	}
	$all_disc_query = "select * from pages where name='all_discount'  ";
	$all_disc_resp = mysql_query($all_disc_query);
	$all_disc_row = mysql_fetch_assoc($all_disc_resp);
	$all_disc_mass_a = explode("\n", $all_disc_row["cont"]);
	$all_disc_mass = array();
	foreach($all_disc_mass_a as $key=>$val){
		$a = explode("=", trim($val));
		$all_disc_mass[] = $a;
	}
	//echo "<pre>"; print_r($disc_row); echo "</pre>";
	$head = str_replace("%username%", $user_row["fio"], $head);
	$head = str_replace("%userphone%", $user_row["phone"], $head);
	$head = str_replace("%usercomment%", $row["comm"], $head);
	$head = str_replace("%useremail%", $user_row["email"], $head);
	if($user_row["place"]==-100){
		$head = str_replace("%useradres%", $user_row["altplace"], $head);
	} else {
		//$padquery = "select * from items where folder=1 && parent=0 && href_name='novaposhta_states'  ";
		//$padresp = mysql_query($padquery);
		//$padrow = mysql_fetch_assoc($padresp);
		$adquery = "select * from items where id=$user_row[place]";
		$adresp = mysql_query($adquery);
		$adrow = mysql_fetch_assoc($adresp);
		$head = str_replace("%useradres%", $adrow["name"], $head);
	}
	$head = str_replace("%userpromo%", $user_row["user_promo"], $head);
	//****************************************
	$ret .= "<h2>$row[name]</h2>";
	$ret .= "<p>";
	$ret .= "$head<br/>";
	$ret .= "<table width=\"100%\" border=\"1\" id=\"order-send-0\">";
	$ret .= "<tr><td width=\"30\">№</td>";
	$ret .= "<td>Изображение</td>";
	$ret .= "<td>Название товара</td>";
	$ret .= "<td width=\"50\">Цена</td>";
	$ret .= "<td width=\"50\">Кол-во</td>";
	$ret .= "<td width=\"50\">Сумма</td></tr>";
	$allsumm = 0;
	$discount = "0%";
	$akc_allsumm = 0;
	$no_akc_allsumm = 0;
	foreach($mass as $key=>$val){
		$querya = "select * from items where id=".extract_data_from_zak_cont($val, "id");
		$respa = mysql_query($querya);
		$rowa = mysql_fetch_assoc($respa);
		$rowa["pricedigit"] = str_replace(",", ".", $rowa["pricedigit"]);
		$dd = str_replace("%", "", $rowa["dindiscount"]);
		$mdd = explode("=", $dd);
		if(   $mdd[0] <= extract_data_from_zak_cont($val, "kolvo")   )  {
			$rowa["pricedigit"] = round(   $rowa["pricedigit"] - $rowa["pricedigit"]*$mdd[1]/100,  2   );
		}
		if(  $rowa["discount"]  )  {
			$rowa["discount"] = str_replace(  "%", "", $rowa["discount"]  );
			$rowa["pricedigit"] = round( $rowa["pricedigit"] - (  $rowa["pricedigit"] / 100 * $rowa["discount"]  ),  2);
		}
		if(  ( $rowa["is_akc"]==1 || $rowa["discount"] )  &&  ( $cfg_discount!="использовать всегда" )  ){
			$akc_allsumm += round($rowa["pricedigit"]  *  extract_data_from_zak_cont($val, "kolvo"),  2);
		} else {
			$no_akc_allsumm += $rowa["pricedigit"]  *  extract_data_from_zak_cont($val, "kolvo");
		}
	}
	foreach($mass as $key=>$val){
		//$tov_id = ;
		$querya = "select * from items where id=".extract_data_from_zak_cont($val, "id");
		$respa = mysql_query($querya);
		$rowa = mysql_fetch_assoc($respa);
		$rowa["pricedigit"] = str_replace(",", ".", $rowa["pricedigit"]);
		$dd = str_replace("%", "", $rowa["dindiscount"]);
		$mdd = explode("=", $dd);
		$oldpricedigit = false;
		if(   $mdd[0] <= extract_data_from_zak_cont($val, "kolvo")  &&  $rowa["dindiscount"]   )  {
			$oldpricedigit = $rowa["pricedigit"];
			$rowa["pricedigit"] = round(   $rowa["pricedigit"] - $rowa["pricedigit"]*$mdd[1]/100,  2   );
		}
		if(  $rowa["discount"]  )  {
			$rowa["discount"] = str_replace(  "%", "", $rowa["discount"]  );
			$rowa["pricedigit"] = $rowa["pricedigit"] - (  $rowa["pricedigit"] / 100 * $rowa["discount"]  );
		}
		//$tov_resp = mysql_query("select * from items where id=$tov_id ");
		//$tov_row = mysql_fetch_assoc($tov_resp);
		//echo "<pre>"; print_r($tov_row); echo "</pre>";
		$ret .= "<tr><td><!--itemid=$rowa[id]-->".($key+1)."</td>";
		$imgr = mysql_query(" select * from images where parent=".extract_data_from_zak_cont($val, "id")." order by prior asc limit 0,1 ");
		$imgrr = mysql_fetch_assoc($imgr);
		if(count($imgrr)>0){
			$link = __fi_create_img_tumbs("loadimages", "160x120", $imgrr["link"]);
			$ret .= "<td width=\"200\" align=\"center\"><img src=\"/$link\"></td>";
		} else {
			$ret .= "<td width=\"200\" align=\"center\"><img width=\"160\" height=\"120\" src=\"/images/no_photo.jpg\"></td>";
		}
		$ret .= "<td>";
		if($rowa["item_art"] ) $ret .= "<span>Артикул: ".$rowa["item_art"]."</span><br/>";
		$ret .= extract_data_from_zak_cont($val, "name");
		//******************************************
		$presp = mysql_query("select * from items where id=$rowa[parent]");
		$page_parent = mysql_fetch_assoc($presp);
		//print_r($rowa);
		if($rowa["is_multi"]==1 || $page_parent["is_multi"]==1){
			$mtmass = $rowa["multi_config"]!=""?$rowa:$page_parent;
			$mt = $mtmass["multi_config"];
			$mt = explode("~", $mt);
			$mt = $mt[0];
			$mt = explode(",", $mt);
			$mt = $mt[0];
			$mt = explode("===", $mt);
			if($mt[1]!=""){
				$nnn = __ff_get_itemstypes_rus_name_from_index($mt, $mtmass["id"]);
				$ret .= "<br/>$nnn - ".$rowa[$mt[1]];
			}
		}
		//******************************************
		if($rowa["is_akc"]==1 || $rowa["discount"]){
			$ret .= " (Акция!  ";
			if($rowa["discount"]) $ret .= "скидка - $rowa[discount]";
			$ret .= ")";
		}
		//******************************************
		if(extract_data_from_zak_cont($val, "mtm_select") != ""){
			$ret .= "<br/>".extract_data_from_zak_cont($val, "mtm_select");
		}
		//******************************************
		$ret .= "</td>";
		if( $no_convert == false )  $resp = mysql_query(" update items set kolvov=".(  $rowa["kolvov"] - extract_data_from_zak_cont($val, "kolvo")  )." where id=$rowa[id]   ");
		if($oldpricedigit){
			$ret .= "<td><span class=\"sp_pd\" ";
			$ret .= "style=\"text-decoration: line-through;\">$oldpricedigit</span>&nbsp;<span class=\"sp_pt\" >грн.</span>";
			$ret .= "<br/>";
			$ret .= "<span class=\"sp_pd\">".__format_txt_price_format(round($rowa["pricedigit"]*1, 2))."</span></td>";
		} else {
			$ret .= "<td>".__format_txt_price_format(  round($rowa["pricedigit"]*1, 2)  )." грн.</td>";
		}
		$ret .= "<td thisbasketid_$rowa[id]=\"\">".extract_data_from_zak_cont($val, "kolvo")."</td>";
		$ret .= "<td>".__format_txt_price_format(  round(extract_data_from_zak_cont(  $val, "kolvo"  )  *  $rowa["pricedigit"],  2)   )." грн.</td>";
		$ret .= "</tr>";
		$allsumm += round(extract_data_from_zak_cont(  $val, "kolvo"  )  *  $rowa["pricedigit"], 2);
	}
	$ret .= "<tr><td colspan=\"5\">Общая сумма</td>";
	$ret .= "<td>".__format_txt_price_format(round($allsumm,2))." грн.</td></tr>";
	//******************************************
	$root_price = $allsumm;
	if(count($disc_mass > 0)){
		foreach($disc_mass as $key=>$val){
			if(  $no_akc_allsumm >= $val[0]  ){
				$discount = $val[1];
			}
		}
	}
	$promo_summ = __fz_find_all_price(  $user_row["user_promo"]  );
	if(count($all_disc_mass > 0)){
		foreach($all_disc_mass as $key=>$val){
			if(  $promo_summ >= $val[0]  ){
				$all_discount = $val[1];
			}
		}
	}
	//******************************************
	//echo "DISC MASS:<pre>"; print_r($disc_mass); echo "</pre>";
	$ret .= "<tr><td colspan=\"5\">Скидка";
	$discount = str_replace("%", "", $discount);
	$dis_price = $no_akc_allsumm - ($no_akc_allsumm/100*$discount);
	$all_discount = str_replace("%", "", $all_discount);
	$all_dis_price = $no_akc_allsumm - ($no_akc_allsumm/100*$all_discount);
	//******************************************
	$allsumm = $dis_price + $akc_allsumm;
	$dp_test = $root_price - $dis_price;
	$adp_test = $root_price - $all_dis_price;
	if(  $adp_test > $dp_test  ) {
		$allsumm = $all_dis_price;
		$discount = $all_discount;
		$ret .= "<span style=\"font-size: 10px; color: #666666;\">";
		$ret .= "<br/>Накопительная скидка больше разовой<br/>Товар будет продан с накопительной скидкой";
	} if(  $adp_test < $dp_test  ) {
		$ret .= "<span style=\"font-size: 10px; color: #666666;\">";
		$ret .= "<br/>Разовая скидка больше накопительной<br/>Товар будет продан с разовой скидкой";
	}
	if($akc_allsumm > 0){
		$ret .= "<span style=\"font-size: 10px; color: #666666;\">";
		$ret .= "<br/>* Скидка не начислеяется на акционный или с распродажи товар<br/>";
		$ret .= "Товара со скидкой выбранно на сумму ".__format_txt_price_format(round($akc_allsumm,2))." грн.<br/>";
		$ret .= "Скидка по товару без акции составляет ".__format_txt_price_format(round($no_akc_allsumm/100*$discount,  2))." грн.";
		$ret .= "</span>";
	}
	$ret .= "</td>";
	$ret .= "<td>  $discount%  </td></tr>";
	//******************************************
	//$allsumm = $allsumm - ($allsumm/100*$discount);
	$ret .= "<tr><td colspan=\"5\" id=\"userpromo-$user_row[user_promo]\">Итого</td>";
	$ret .= "<td>".__format_txt_price_format(  round($allsumm, 2)  )." грн.</td></tr>";
	//******************************************
	$ret .= "</table>";
	$ret .= "</p>";
	if( $no_convert == false ) $resp = mysql_query("update $katalog_table set cont='$ret' where id=$row[id] ");
	return $ret;
}
//*******************************/
function __fz_order_to_docx_admin($id){
	//echo "__fz_order_to_docx_admin";
	$resp = mysql_query("select * from items where id=$id");
	$row = mysql_fetch_assoc($resp);
	if(file_exists("../orders/".__fp_rus_to_eng($row["name"]).".docx")){
		unlink("../orders/".__fp_rus_to_eng($row["name"]).".docx");
	}
	//*************************************************************
	preg_match_all('"userpromo-[0-9]*"', $row["cont"], $promo);
	//print_r($promo);
	$promo = $promo[0][0];
	$promo = preg_replace('/^userpromo-/', "", $promo);
	//echo "\npromo=$promo";
	$user_resp = mysql_query("select * from users where user_promo='$promo' ");
	$user = mysql_fetch_assoc($user_resp);
	
	//print_r($user);
	
	//$img_resp = mysql_query("select * from images where parent=$row[id] order by prior asc limit 0,1");
	//$imgrow = mysql_fetch_assoc($img_resp);
	//print_r($imgrow);
	//*************************************************************
	
	require_once '../htmlToWord/PHPWord.php';

	// Create a new PHPWord Object
	$PHPWord = new PHPWord();
	
	// Every element you want to append to the word document is placed in a section. So you need a section:
	$section = $PHPWord->createSection();
	
	// After creating a section, you can append elements:
	//$section->addText('Hello world!');
	
	// You can directly style your text by giving the addText function an array:
	$name = "$row[name]";
	$name = iconv("CP1251", "UTF-8", $name);
	$section->addText($name, array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));
	
	// If you often need the same style again you can create a user defined style to the word document
	// and give the addText function the name of the style:
	//$PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
	//$section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');
	
	// You can also putthe appended element to local object an call functions like this:
	//$myTextElement = $section->addText($row["cont"]);
	//echo $row["cont"];
	$hmass = explode("<table", $row["cont"]);
	//print_r($hmass);
	$hmass[0] = str_replace("<br />", "<br/>", $hmass[0]);
	$mass = explode("<br/>", $hmass[0]);
	foreach($mass as $key=>$val){
		$val = preg_replace("/<h2>.*<\/h2>/", "", $val);
		$val = iconv("CP1251", "UTF-8", $val);
		$val = strip_tags($val);
		$val = trim($val);
		//$mm = explode(":", $val);
		//print_r($mm);
		//if($mm[0]){
			//$val = explode($mm[0], $val);
			//$val = $val[1];
			//$section->addText($mm[0], array('bold'=>true));
			$st["bold"] = "true";
			$st["size"] = "14";
			$st["color"] = "red";
			$myTextElement = $section->addText(  $val, $st  );
		//}
	}
	//print_r($mass);
	//*********************************
	$section->addTextBreak(2);
	//*********************************
	$table = explode("<table", $row["cont"]);
	$table = explode("</table>", $table[1]);
	$table = $table[0];
	//echo $table;
	//**********************
	$mass = explode("<tr>", $table);
	foreach($mass as $key=>$val){
		//$val = trim($val);
		if($key>0){
			$val = str_replace("</tr>", "", $val);
			$val = explode("<td", $val);
			foreach($val as $k=>$v){
					
					$v .= "|||";
					$colspan = 0;
					if(preg_match("/(colspan=.?[0-9].?)/", $v, $rv))
						$v .= ":".$rv[0];
					if(preg_match("/(itemid=\"?[0-9]\"?)/", $v, $rv))
						$v .= ":".$rv[0];
					if(preg_match("/(img src=\"\/loadimages\/([0-9x])+\/([0-9a-z-_])+\.jpg\"+)/", $v, $rv))
						$v .= ":".str_replace("/loadimages/160x120/", "", str_replace("img src", "imgsrc", $rv[0]));
					$v = trim($v);
					$v = preg_replace("/^>/", "", $v);
					$v = preg_replace("/^[a-z]([a-zA-Z0-9 =\"-_])+\">/", "", $v);
					$v = str_replace("</td>", "", $v);
					//$v = strip_tags($v);
					$val[$k] = $v;

			}
			$mass[$key] = $val;
		}
	}
	
	unset($mass[0]);
	foreach($mass as $key=>$val){
		unset($val[0]);
		$mass[$key] = $val; 
	}
	//print_r($mass);
	//**********************
	$table = $section->addTable();
	$maxw = 7200;
	$cols = 0;
	//**********************
	foreach($mass as $key=>$val){
		$mcols = 0;
		foreach($val as $k=>$v){
			$mcols++;
		}
		if($mcols>$cols) $cols=$mcols;
	}
	//**********************
	foreach($mass as $key=>$val){
		$table->addRow();
		//echo "\n\nadd row\n";
		foreach($val as $k=>$v){
			$imgsrc = false;
			$colspan = false;
			//echo $v."\n";
			$v = explode("|||", $v);
			$values = $v[1];
			preg_match("/(colspan=\"?([0-9])+\"?)/", $values, $rv);
			if($rv[0]) eval("$".$rv[0].";");
			preg_match("/(itemid=\"?([0-9])+\"?)/", $values, $rv);
			if($rv[0]) eval("$".$rv[0].";");
			preg_match("/imgsrc=\"([0-9a-z-_])+\.jpg\"/", $values, $rvr);
				if($rvr[0]) eval("$".$rvr[0].";");
			$v = $v[0];
			$v =  iconv("CP1251", "UTF-8", $v);
			$span=$colspan;
			//*****************************
			
			//*****************************
			if($span){
				$styleCell=array('gridSpan' => $span);
				$my_cell = $table->addCell($maxw/$cols,$styleCell);
				//$my_cell->addText($v);	
				//$my_cell->addText("b", array("strikethrough"=>"true"));
				$format = explode("</span>", $v);
				foreach($format as $key=>$val){
					$styles = array();
					$val = str_replace("&nbsp;", "", $val);
					$val = trim($val);
					$val = preg_replace("/<br \/>|<br\/>|<br>/", "", $val);
					if(preg_match("/line-through/", $val))
						$styles["strikethrough"] = "true";
					//*********					
					preg_match("/^.*(?=<)/", $val, $fv);
					if($fv[0] && $fv[0]!="\n\r") {
						$val = preg_replace("/^.*(?=<)/", "", $val);
						$fv = $fv[0]; 
					} else {
						$fv=false;
					}
					$val = preg_replace("/^\r\n<span.*>/", "\r\n", $val);
					$val = preg_replace("/^<span.*>/", "", $val);
					//*********
					if($fv) $my_cell->addText($fv);
					$my_cell->addText($val, $styles);
					//*********
					$format[$key] = $val;
				}
				$span = false;
				//echo "add cell\n";
			}else{
				if(  $imgsrc  ){
					//$img_resp = mysql_query("select * from images where parent=$itemid order by prior asc ");
					//$img = mysql_fetch_assoc($img_resp);
					//echo "../loadimages/300x225/".$imgsrc."\n\n";
					//echo "../loadimages/300x225/".$img["link"]."\n\n";
					$table->addCell($maxw/$cols)->addImage("../loadimages/160x120/".$imgsrc, array('width'=>200, 'height'=>150, 'align'=>'left'));
				} else {
					//$v = strip_tags($v);
					//$v = str_replace("&nbsp;", "", $v);
					if($k==1)   $my_cell = $table->addCell($maxw/$cols-1000);
					elseif ($k==3) $my_cell = $table->addCell($maxw/$cols+1000);
					else           $my_cell = $table->addCell($maxw/$cols);
					//$my_cell->addText($v);	
					//$my_cell->addText("b", array("strikethrough"=>"true"));
					$format = explode("</span>", $v);
					foreach($format as $key=>$val){
						$styles = array();
						$val = str_replace("&nbsp;", "", $val);
						$val = trim($val);
						$val = preg_replace("/<br \/>|<br\/>|<br>/", "", $val);
						if(preg_match("/line-through/", $val))
							$styles["strikethrough"] = "true";
						//*********					
						$val = preg_replace("/^\r\n<span.*>/", "\r\n", $val);
						$val = preg_replace("/^<span.*>/", "", $val);
						$val = strip_tags($val);
						//*********
						$my_cell->addText($val, $styles);
						//*********
						$format[$key] = $val;
					}
					//print_r($format);
					//$my_cell->addTextBreak();
					//$my_cell->addText("---");	
				}
				//$table->addCell($maxw/$cols,$styleCell)->addImage("../loadimages/".$imgrow["link"], array('width'=>210, 'height'=>210, 'align'=>'center'));
				//echo "add cell\n";
			}
		}
	}
//**********************

//$table = $section->addTable(array('borderSize'=>6, 'borderColor'=>'e3e3e3', 'cellMarginRight'=>80, 'cellMarginLeft'=>80));

//$table->addRow();
//$table->addCell(3000)->addText("test");
//$table->addCell(3000)->addText("test");
//$table->addCell(3000)->addText("test");
//$table->addCell(3000)->addText("test");

//$table->addRow();
//$table->addCell(3000, array('gridSpan' => 2))->addText("test test test"); 
//$table->addCell(3000)->addText("test");

//$table->addRow();
//$table->addCell(3000)->addText("test");
//$table->addCell(3000)->addText("test");
//$table->addCell(3000)->addText("test");
//$table->addCell(3000)->addText("test");

/*
$table->addRow();

$table->addCell(2100, array('vMerge' => 'restart'))->addText('ROWSPAN 5', array('width'=>130, 'height'=>150, 'align'=>'center'));       //rowspan count 1
$table->addCell(1500, array('bgColor'=>'f1f1f1', 'align'=>'center'))->addText('Name', array('bold'=>true, 'color'=>'666666'));
//$table->addCell(5500, array('gridSpan' => 3))->addText('My Name is Landy Kim', array('size'=>9));       //colspan


$table->addRow();
$table->addCell(2100, array('vMerge' => ''));       //rowspan count 2
$table->addCell(1500, array('bgColor'=>'f1f1f1', 'align'=>'center'))->addText('Nationality', array('bold'=>true, 'color'=>'666666'));
$table->addCell(5500, array('gridSpan' => 3))->addText('South Korea', array('size'=>9));        //colspan


$table->addRow();
$table->addCell(2100, array('vMerge' => ''));       //rowspan count 3
$table->addCell(1500, array('bgColor'=>'f1f1f1', 'align'=>'center'))->addText('Address', array('bold'=>true, 'color'=>'666666'));
$table->addCell(5500, array('gridSpan' => 3))->addText('Top Secret^^', array('size'=>9));       //colspan


$table->addRow();
$table->addCell(2100, array('vMerge' => ''));       //rowspan count 4
$table->addCell(1500, array('bgColor'=>'f1f1f1', 'align'=>'center'))->addText('Tel', array('bold'=>true, 'color'=>'666666'));
$table->addCell(2000)->addText('000-000-0000', array('size'=>9));
$table->addCell(1500, array('bgColor'=>'f1f1f1', 'align'=>'center'))->addText('Mobile', array('bold'=>true, 'color'=>'666666'));
$table->addCell(2000)->addText('000-0000-0000', array('size'=>9));
*/
/*
$table->addRow();
$table->addCell(2100, array('vMerge' => ''));       //rowspan count 5
$table->addCell(1500, array('bgColor'=>'f1f1f1', 'align'=>'center'))->addText('email', array('bold'=>true, 'color'=>'666666'));
$table->addCell(500, array('gridSpan' => 3))->addText('jun981126@hotmail.com', array('size'=>9));

*/

	//for($r = 1; $r <= 10; $r++) { // Loop through rows
	//	// Add row
	//	$table->addRow();
	//	
	//	for($c = 1; $c <= 5; $c++) { // Loop through cells
	//		// Add Cell
	//		$table->addCell(1800)->addText("Row $r, Cell $c");
	//	}
	//}
	
	
	
	
	//print_r($mass);
	
	//$section->addText('Hello World!');
	//$section->addTextBreak(2);
	
	//$section->addText('I am inline styled.', array('name'=>'Verdana', 'color'=>'006699'));
	//$section->addTextBreak(2);
	
	//$PHPWord->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>16));
	//$PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>100));
	//$section->addText('I am styled by two style definitions.', 'rStyle', 'pStyle');
	//$section->addText('I have only a paragraph style definition.', null, 'pStyle');
	
	
	
	// New portrait section
	//$section = $PHPWord->createSection(array('borderColor'=>'00FF00', 'borderSize'=>12));
	//$section->addText('I am placed on a default section.');
	
	// New landscape section
	//$section = $PHPWord->createSection(array('orientation'=>'landscape'));
	//$section->addText('I am placed on a landscape section. Every page starting from this section will be landscape style.');
	//$section->addPageBreak();
	//$section->addPageBreak();
	
	// New portrait section
	//$section = $PHPWord->createSection(array('marginLeft'=>600, 'marginRight'=>600, 'marginTop'=>600, 'marginBottom'=>600));
	//$section->addText('This section uses other margins.');





	
	//$myTextElement->setBold();
	//$myTextElement->setName('Verdana');
	//$myTextElement->setSize(22);
	
	// At least write the document to webspace:
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter->save("../orders/".__fp_rus_to_eng($row["name"]).".docx");
}
//*******************************/
function __fz_order_to_docx_admin_v2($orderId, $html){
	global $site;
	//__fo_SetOrderName($order["id"]);
	//echo "__fz_order_to_docx_admin";
	//$resp = mysql_query("select * from items where id=$id");
	//$row = mysql_fetch_assoc($resp);
	if(file_exists("../orders/".__fo_SetOrderName($orderId).".docx")){
		unlink("../orders/".__fo_SetOrderName($orderId).".docx");
	}
	//*************************************************************
	preg_match_all('"userpromo-[0-9]*"', $row["cont"], $promo);
	//print_r($promo);
	$promo = $promo[0][0];
	$promo = preg_replace('/^userpromo-/', "", $promo);
	//echo "\npromo=$promo";
	$user_resp = mysql_query("select * from users where user_promo='$promo' ");
	$user = mysql_fetch_assoc($user_resp);
	
	//print_r($user);
	
	//$img_resp = mysql_query("select * from images where parent=$row[id] order by prior asc limit 0,1");
	//$imgrow = mysql_fetch_assoc($img_resp);
	//print_r($imgrow);
	//*************************************************************
	
	require_once '../htmlToWord/PHPWord.php';

	// Create a new PHPWord Object
	$PHPWord = new PHPWord();
	
	// Every element you want to append to the word document is placed in a section. So you need a section:
	$section = $PHPWord->createSection();
	
	// After creating a section, you can append elements:
	//$section->addText('Hello world!');
	
	// You can directly style your text by giving the addText function an array:
	$name = "Заказ №".__fo_SetOrderName($orderId);
	$name = iconv("CP1251", "UTF-8", $name);
	$section->addText($name, array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));
	
	// If you often need the same style again you can create a user defined style to the word document
	// and give the addText function the name of the style:
	//$PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
	//$section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');
	
	// You can also putthe appended element to local object an call functions like this:
	//$myTextElement = $section->addText($row["cont"]);
	//echo $row["cont"];
	$hmass = explode("<table", $html);
	//print_r($hmass);
	//$hmass[0] = str_replace("<br>", "<br/>", $hmass[0]);
	//echo $hmass[0];
	$hmass[0] = str_replace("<br />", "<br/>", $hmass[0]);
	$mass = explode("<br/>", $hmass[0]);
	//print_r($mass);
	$toWord = false;
	foreach($mass as $key=>$val){
		//echo $val."\n++++++++++++\n";
		$section->addText($mm[0], array('bold'=>true));
		if(!$toWord){
			$st["bold"] = "true";
			$st["size"] = "12";
			$st["color"] = "#000000";
		}
		//**********************
		$val = preg_replace("/<h2>.*<\/h2>/", "", $val);
		$val = strip_tags($val);
		$val = trim($val);
		//echo "$val\n+++++++++++++\n";
		$val = iconv("CP1251", "UTF-8", $val);
		if(preg_match("/(color=[#0-9A-Za-z]{1,10};size=[0-9]{1,2})/", $val, $rv)){
			$a = $rv[0];
			$a = preg_replace("/(\[word\:|\])/", "", $a);
			$param = explode(";", $a);
			foreach($param as $key=>$value){
				$value = explode("=", $value);
				$st[$value[0]] = $value[1];
			}
			$val = preg_replace("/\[word:color=[#0-9A-Za-z]{1,10};size=[0-9]{1,2}\]/", "", $val);
			//echo "asd\n";
			$toWord = true;
		}
		if(preg_match("/\[\/word\]/", $val)){
			$val = preg_replace("/\[\/word\]/", "", $val);
			$toWord = false;
		}
		//**********************
		//print_r($st);
		$myTextElement = $section->addText(  $val, $st  );	//print_r($rv);
		
		
		//echo $val;
		//$mm = explode(":", $val);
		//print_r($mm);
		//if($mm[0]){
			//$val = explode($mm[0], $val);
			//$val = $val[1];
			
		//}
	}
	//print_r($mass);
	//*********************************
	$section->addTextBreak(2);
	//*********************************
	$table = explode("<table", $row["cont"]);
	$table = explode("</table>", $table[1]);
	$table = $table[0];
	$table = $html;
	$table = str_replace("<table", "", $table);
	$table = str_replace("</table>", "", $table);
	//echo $table;
	//**********************
	$mass = explode("<tr", $table);
	foreach($mass as $key=>$val){
		//$val = trim($val);
		if($key>0){
			$val = str_replace("</tr>", "", $val);
			$val = explode("<td", $val);
			foreach($val as $k=>$v){
					
					$v .= "|||";
					$colspan = 0;
					if(preg_match("/(colspan=.?[0-9].?)/", $v, $rv))
						$v .= ":".$rv[0];
					if(preg_match("/(bgcolor=.?[#0-9A-Z]{1,7}.?)/", $v, $rv))
						$v .= ":".$rv[0];
					if(preg_match("/(img src=\"\/loadimages\/([0-9x])+\/([0-9a-z-_])+\.jpg\"+)/", $v, $rv))
						$v .= ":".str_replace("/loadimages/160x120/", "", str_replace("img src", "imgsrc", $rv[0]));
					$v = trim($v);
					$v = preg_replace("/^>/", "", $v);
					$v = preg_replace("/^[a-z]([a-zA-Z0-9 =\"-_#])+\">/", "", $v);
					$v = str_replace("</td>", "", $v);
					//$v = strip_tags($v);
					$val[$k] = $v;
					//echo "$v\n";

			}
			$mass[$key] = $val;
		}
	}
	
	unset($mass[0]);
	foreach($mass as $key=>$val){
		unset($val[0]);
		$mass[$key] = $val; 
	}
	//print_r($mass);
	//**********************
	$table = $section->addTable();
	$maxw = 7200;
	$cols = 0;
	//**********************
	foreach($mass as $key=>$val){
		$mcols = 0;
		foreach($val as $k=>$v){
			$mcols++;
		}
		if($mcols>$cols) $cols=$mcols;
	}
	//**********************
	foreach($mass as $key=>$val){
		$table->addRow();
		//echo "\n\nadd row\n";
		foreach($val as $k=>$v){
			$imgsrc = false;
			$colspan = false;
			//echo $v."\n";
			$v = explode("|||", $v);
			$values = $v[1];
			preg_match("/(colspan=\"?([0-9])+\"?)/", $values, $rv);
			if($rv[0]) eval("$".$rv[0].";");
			preg_match("/(bgcolor=.?[#0-9A-Z]{1,7}.?)/", $values, $rv);
			if($rv[0]) eval("$".$rv[0].";");
			//echo "$".$rv[0].";\n";
					//$v = trim($v);
					$v = preg_replace("/^>/", "", $v);
					$v = preg_replace("/^[a-z]([a-zA-Z0-9 =\"-_#])+\"[ ]{0,7}>/", "", $v);
					$v = str_replace("</td>", "", $v);
			//preg_match("/imgsrc=\"([0-9a-z-_])+\.jpg\"/", $values, $rvr);
			//	if($rvr[0]) eval("$".$rvr[0].";");
			
			if($k==2){
				$imgsrc = str_replace("<img src=\"../", "", $v[0]);
				$imgsrc = str_replace("&amp;", "&", $imgsrc);
				$imgsrc = str_replace("imgres.php?resize=120&link=loadimages/", "", $imgsrc);
				$imgsrc = explode('"', $imgsrc);
				$imgsrc = $imgsrc[0];
				$imgsrc = __fi_create_img_tumbs("../loadimages", "120x90", $imgsrc);
				if($imgsrc=="images/no_photo.jpg") $imgsrc = false;
				//echo "\n $key \n img=$imgsrc\n";
				
			}	
				
			$v = $v[0];
			$v =  iconv("CP1251", "UTF-8", $v);
			$span=$colspan;
			//*****************************
			
			//*****************************
			if($span){
				$styleCell=array('gridSpan' => $span);
				$my_cell = $table->addCell($maxw/$cols*$span,$styleCell);
				//$my_cell->addText($v);	
				//$my_cell->addText("b", array("strikethrough"=>"true"));
				$format = explode("</span>", $v);
				foreach($format as $key=>$val){
					$styles = array();
					$val = str_replace("&nbsp;", "", $val);
					$val = trim($val);
					$val = preg_replace("/<br \/>|<br\/>|<br>/", "", $val);
					if(preg_match("/line-through/", $val))
						$styles["strikethrough"] = "true";
					//*********					
					preg_match("/^.*(?=<)/", $val, $fv);
					if($fv[0] && $fv[0]!="\n\r") {
						$val = preg_replace("/^.*(?=<)/", "", $val);
						$fv = $fv[0]; 
					} else {
						$fv=false;
					}
					$val = preg_replace("/^\r\n<span.*>/", "\r\n", $val);
					$val = preg_replace("/^<span.*>/", "", $val);
					//*********
					if($fv) $my_cell->addText($fv);
					$my_cell->addText($val, $styles);
					//*********
					$format[$key] = $val;
				}
				$span = false;
				//echo "add cell\n";
			}else{
				//echo $imgsrc."\n";
				if(  $imgsrc  ){
					//$img_resp = mysql_query("select * from images where parent=$itemid order by prior asc ");
					//$img = mysql_fetch_assoc($img_resp);
					//echo "../loadimages/300x225/".$imgsrc."\n\n";
					//echo "../loadimages/300x225/".$img["link"]."\n\n";
					//imgres.php?resize=120&link=loadimages/element_3_2.jpg
					$table->addCell($maxw/$cols)->addImage($imgsrc, array('width'=>120, 'height'=>90, 'align'=>'left'));
				} else {
					//$v = strip_tags($v);
					//$v = str_replace("&nbsp;", "", $v);
					if($k==1)   $my_cell = $table->addCell($maxw/$cols-1000);
					elseif ($k==3) $my_cell = $table->addCell($maxw/$cols+1000);
					else           $my_cell = $table->addCell($maxw/$cols);
					//$my_cell->addText($v);	
					//$my_cell->addText("b", array("strikethrough"=>"true"));
					$format = explode("</span>", $v);
					foreach($format as $key=>$val){
						$styles = array();
						$val = str_replace("&nbsp;", "", $val);
						$val = trim($val);
						$val = preg_replace("/<br \/>|<br\/>|<br>/", "", $val);
						if(preg_match("/line-through/", $val))
							$styles["strikethrough"] = "true";
						//*********					
						$val = preg_replace("/^\r\n<span.*>/", "\r\n", $val);
						$val = preg_replace("/^<span.*>/", "", $val);
						$val = strip_tags($val);
						//*********
						$my_cell->addText($val, $styles);
						//*********
						$format[$key] = $val;
					}
					//print_r($format);
					//$my_cell->addTextBreak();
					//$my_cell->addText("---");	
				}
				//$table->addCell($maxw/$cols,$styleCell)->addImage("../loadimages/".$imgrow["link"], array('width'=>210, 'height'=>210, 'align'=>'center'));
				//echo "add cell\n";
			}
		}
	}
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter->save("../orders/".__fo_SetOrderName($orderId).".docx");
	return "../orders/".__fo_SetOrderName($orderId).".docx";
}
//*******************************/
?>