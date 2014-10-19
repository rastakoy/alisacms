<?
//*********************************
function __fo_SetOrderName($id){
	$razn = 6-strlen($id);
	for($j=0; $j<$razn; $j++)
		$id = "0".$id;
	return $id;
}
//*********************************
function __fo_getOrderList($orderId){
	$resp = mysql_query("select from orders where orderId=$orderId ");
}
//*********************************
function __fo_getOrder($val, $iAmUser=false, $toWord=false){
	$resp = mysql_query("select * from orders where id=$val ");
	$order = mysql_fetch_assoc($resp);
	//$ret .= "<table cellspacing=\"1\" cellpadding=\"1\" border=\"0\" width=\"100%\" ><tr>";
	//	$ret .= "<td height=\"20\" bgcolor=\"#FFFFFF\" >Заказ №".__fo_SetOrderName($order["id"])." ";
	//	$ret .= "Получатель</td>";
	//	$ret .= "</tr>";
	//$ret .= "</table>";
	if(!$iAmUser){
		$ret .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" bgcolor=\"#CCCCCC\" ><tr>";
			$ret .= "<td  width=\"100\" id=\"otCont\"  height=\"30\" align=\"center\" class=\"orderTab oActive\" >";
			$ret .= "<a href=\"javascript:showOrderContent()\">Заказ</a></td>";
			$ret .= "<td  width=\"100\" id=\"otInfo\" align=\"center\" class=\"orderTab\" >";
			$ret .= "<a href=\"javascript:showOrderInfo()\">Сведения</a></td>";
			$ret .= "<td bgcolor=\"#FFFFFF\" style=\"padding-left:20px;\">Заказ №".__fo_SetOrderName($order["id"])."</td>";
		$ret .= "</tr></table>";
		$ret .= "<table cellspacing=\"1\" cellpadding=\"1\" border=\"0\" ";
		$ret .= " width=\"100%\" bgcolor=\"#CCCCCC\" ><tr>";
		$ret .= "<td height=\"30\">";
		$ret .= "<a href=\"javascript:__ao_getWord($order[id])\">";
		$ret .= "<img src=\"images/green/myitemname_popup/word.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\"></a>";
		$ret .= "<a href=\"javascript:__ao_postPrice($order[id])\">";
		$ret .= "<img src=\"images/green/icons/send_email.gif\" width=\"16\" height=\"16\" border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\"></a>";
		$ret .= "</td><td>";
		$ret .= "ТТН: <input type=\"text\" id=\"orderTTN\" value=\"$order[TTN]\" />&nbsp; &nbsp;<a href=\"javascript:__ao_saveOrderTTN($order[id])\">ok</a>";
		$ret .= "</td></tr></table>";
	}
	$ret .= "<table cellspacing=\"1\" cellpadding=\"1\" border=\"0\" id=\"orderContent\" ";
	$ret .= " width=\"100%\" bgcolor=\"#CCCCCC\" >";
	$ret .= "<tr>";
		$ret .= "<td width=\"35\" bgcolor=\"#FFFFFF\" align=\"center\" height=\"30\">№</td>";
			$ret .= "<td width=\"130\" bgcolor=\"#FFFFFF\" align=\"center\">&nbsp;</td>";
			$ret .= "<td width=\"320\" bgcolor=\"#FFFFFF\">Название</td>";
			$ret .= "<td width=\"70\" align=\"center\" bgcolor=\"#FFFFFF\">Цена</td>";
			$ret .= "<td width=\"80\" align=\"center\" bgcolor=\"#FFFFFF\">Кол-во</td>";
			$ret .= "<td width=\"70\" align=\"center\" bgcolor=\"#FFFFFF\">Скидка</td>";
			$ret .= "<td width=\"70\" align=\"center\" bgcolor=\"#FFFFFF\">Цена со скидкой</td>";
			$ret .= "<td width=\"100\" align=\"center\" bgcolor=\"#FFFFFF\">Сумма</td>";
			if(!$toWord) $ret .= "<td  width=\"20\" bgcolor=\"#FFFFFF\">&nbsp;</td>";
			if(!$toWord) $ret .= "<td bgcolor=\"#FFFFFF\">&nbsp;</td>";
	$ret .= "</tr>";
	$resp = mysql_query("select * from sborka where orderId=$order[id] order by id asc ");
	$count=1;
	while( $row = mysql_fetch_assoc($resp) ){
		$good_resp = mysql_query("select * from items where id=$row[itemId]");
		$good = mysql_fetch_assoc($good_resp);
		$item = $good;
		if(strlen($count)==1) $count = "0".$count;
		$ret .= "<tr id=\"orderTR_$row[id]\">";
			$ret .= "<td width=\"35\" bgcolor=\"#FFFFFF\" align=\"center\" height=\"100\">$count</td>";
			$ret .= "<td width=\"130\" bgcolor=\"#FFFFFF\" align=\"center\">";
			$ret .= "<img src=\"../imgres.php?resize=120&amp;link=loadimages/";
			$ret .= __images_get_img_from_parent_id($good["id"])."\" ";
			$ret .= "width=\"120\" height=\"90\" border=\"0\" ></td>";
			$ret .= "<td width=\"320\" bgcolor=\"#FFFFFF\">$good[name]";
			//****************  Имя мультизаписи
			$presp = mysql_query("select * from items where id=$good[parent]");
			$page_parent = mysql_fetch_assoc($presp);
			//print_r($rowa);
			if($good["is_multi"]==1 || $page_parent["is_multi"]==1){
				$mtmass = $good["multi_config"]!=""?$good:$page_parent;
				$mt = $mtmass["multi_config"];
				$mt = explode("~", $mt);
				$mt = $mt[0];
				$mt = explode(",", $mt);
				$mt = $mt[0];
				$mt = explode("===", $mt);
				if($mt[1]!=""){
					$nnn = __ff_get_itemstypes_rus_name_from_index($mt, $mtmass["id"]);
					$ret .= "<br/>$nnn - ".$good[$mt[1]];
				}
			}
			//******************************************
			$ret .= "</td>";
			$ret .= "<td width=\"70\" align=\"center\" bgcolor=\"#FFFFFF\" id=\"price_$row[id]\">$row[price]</td>";
			$ret .= "<td width=\"80\" align=\"center\" bgcolor=\"#FFFFFF\">";
			if(!$toWord){
				$ret .= "<input type=\"number\" style=\"width:70px;height:30px;\" ";
				if($order["orderStatus"]=="0")
					$ret .= " min=\".05\" step=\".05\" max=\"$item[kolvov]\"  ";
				else
					$ret .= " min=\".05\" step=\".05\" max=\"".($item["kolvov"]+$row["qtty"])."\"  ";
				$ret .= " id=\"qtty_$row[id]\" value=\"$row[qtty]\" onChange=\"__ao_changeQtty(this)\" ></td>";
			} else {
				$ret .= "$row[qtty]</td>";
			}
			//*********** Расчет скидки 
			if($row["discount"]){
				$ret .= "<td width=\"70\" align=\"center\" bgcolor=\"#FFFFFF\" id=\"discount_$row[id]\">$row[discount]%</td>";
				$discPrice =  $row["price"] - round( $row["price"]/100*$row["discount"], 2);
				$ret .= "<td width=\"70\" align=\"center\" bgcolor=\"#FFFFFF\" id=\"discPrice_$row[id]\">$discPrice</td>";
			}else{
				$ret .= "<td width=\"70\" align=\"center\" bgcolor=\"#FFFFFF\" id=\"discount_$row[id]\">&nbsp;</td>";
				$ret .= "<td width=\"70\" align=\"center\" bgcolor=\"#FFFFFF\" id=\"discPrice_$row[id]\">&nbsp;</td>";
			}
			$ret .= "<td width=\"70\" align=\"center\" bgcolor=\"#FFFFFF\" id=\"sum_$row[id]\">$row[sum] грн.</td>";
			if(!$toWord){
				$ret .= "<td bgcolor=\"#FFFFFF\" align=\"center\">";
				$ret .= "<a href=\"javascript:deleteItemFromOrder($row[id])\">";
				if($iAmUser)
					$ret .= "<img src=\"images/delete_item.gif\" width=\"16\" height=\"16\" border=\"0\">";
				else
					$ret .= "<img src=\"images/green/myitemname_popup/delete_item.gif\" width=\"16\" border=\"0\">";
				$ret .= "</a></td>";
			}
			if(!$toWord) $ret .= "<td bgcolor=\"#FFFFFF\">&nbsp;</td>";
		$ret .= "</tr>";
		$count++;
	}
	$ret .= "<tr>";
		$ret .= "<td width=\"795\" colspan=7 bgcolor=\"#FFFFFF\" style=\"padding-left:40px;\"  ";
		$ret .= " align=\"left\" height=\"30\">Общая сумма</td>";
		$ret .= "<td bgcolor=\"#FFFFFF\" id=\"allOrderSum\" align=\"center\">".__fo_getAllSum($val)." грн.</td>";
		if(!$toWord) $ret .= "<td bgcolor=\"#FFFFFF\" colspan=2 >&nbsp;</td>";
		elseif(!$iAmUser)
			$ret .= "<td colspan=1 bgcolor=\"#FFFFFF\" >&nbsp;</td>";
	$ret .= "</tr>";
	$discount = __fo_getUserDiscount($order["userId"]);
	//echo "disc=$discount";
	$ret .= "<tr>";
		$discount = __fo_getUserDiscount($order["userId"], $order["id"]);
		if($iAmUser && $order["orderDiscount"]>0 && $order["orderStatus"]=="ok") 
			$discount = $order["orderDiscount"];
		$ret .= "<td width=\"795\" colspan=7 bgcolor=\"#FFFFFF\" style=\"padding-left:40px;\"  ";
		$ret .= " align=\"left\" height=\"30\">Общая скидка</td>";
		$ret .= "<td bgcolor=\"#FFFFFF\" id=\"allOrderDiscount\" align=\"center\">$discount%</td>";
		if(!$toWord) $ret .= "<td bgcolor=\"#FFFFFF\" colspan=2 >&nbsp;</td>";
		elseif(!$iAmUser) $ret .= "<td colspan=1 bgcolor=\"#FFFFFF\" >&nbsp;</td>";
	$ret .= "</tr>";
	$ret .= "<tr>";
		$allSum = __fo_getAllSum($val);
		$itogo =  round( $allSum - ( $allSum / 100 * $discount ), 2);
		$ret .= "<td width=\"795\" colspan=7 bgcolor=\"#FFFFFF\" style=\"padding-left:40px;\"  ";
		$ret .= " align=\"left\" height=\"30\">$row[userId]  Всего</td>";
		$ret .= "<td bgcolor=\"#FFFFFF\" id=\"orderItogo\" align=\"center\">$itogo грн.</td>";
		if(!$toWord) $ret .= "<td colspan=2 bgcolor=\"#FFFFFF\" >&nbsp;</td>";
		elseif(!$iAmUser) $ret .= "<td colspan=1 bgcolor=\"#FFFFFF\" >&nbsp;</td>";
		
	$ret .= "</tr>";
	if($toWord) $ret .= "<tr><td colspan=8 bgcolor=\"#FFFFFF\" >&nbsp;</td></tr>";
	$ret .= "</table>";
	//**********************
	if(!$toWord){
		$orderQu = getOrderQuery($order["userId"], $order["id"]);
		$orderQu = preg_replace("/\[word:color=[#0-9A-Za-z]{1,10};size=[0-9]{1,2}\]/", "", $orderQu);
		$orderQu = preg_replace("/\[\/word\]/", "", $orderQu);
		$ret .= "<table cellspacing=\"1\" cellpadding=\"1\" border=\"0\" style=\"display:none;\" ";
		$ret .= " width=\"100%\" bgcolor=\"#CCCCCC\" id=\"orderInfo\" ><tr>";
		$ret .= "<td height=\"30\" style=\"line-height:22px;\" bgcolor=\"#E8E8E8\" >".$orderQu."</td>";
		$ret .= "</tr></table>";
	}
		//$resp = mysql_query("update orders set  ");
	return $ret;
}
//*********************************
function __fo_getSborkaJSON($id){
	$resp = mysql_query("select * from sborka where id=$id");
	$row = mysql_fetch_assoc($resp);
	$respItem = mysql_query("select * from items where id=$row[itemId]");
	$rowItem = mysql_fetch_assoc($respItem);
	//print_r($rowItem);
	//************
	$ret = "{\n";
	$ret .= "	\"id\":\"$id\",\n";
	$ret .= "	\"price\":\"$row[price]\",\n";
	$ret .= "	\"qtty\":\"$row[qtty]\",\n";
	
	//print_r($row);
	if($row["discount"]>0)
		$ret .= "	\"discount\":\"$row[discount]%\",\n";
	else
		$ret .= "	\"discount\":\"\",\n";
	
	$discPrice =  $row["price"] - round( $row["price"]/100*$row["discount"], 2);
	if($discPrice < $row["price"])
		$ret .= "	\"discPrice\":\"$discPrice\",\n";
	else 
		$ret .= "	\"discPrice\":\"\",\n";
	
	$ret .= "	\"sum\":\"$row[sum] грн.\",\n";
	$resp = mysql_query("select * from items where id=$row[itemId]  ");
	$item = mysql_fetch_assoc($resp);
	$ret .= "	\"qttyMax\":\"".round($item["kolvov"], 2)."\",\n";
	$allSum = __fo_getAllSum($row["orderId"]);
	$ret .= "	\"allOrderSum\":\"$allSum грн.\",\n";
	$discount = __fo_getUserDiscount($row["userId"], $row["orderId"]);
	$ret .= "	\"allOrderDiscount\":\"$discount%\",\n";
	$itogo =  round( $allSum - ( $allSum / 100 * __fo_getUserDiscount($row["userId"], $row["orderId"]) ), 2);
	$ret .= "	\"orderItogo\":\"$itogo грн.\",\n";
	$ret .= "	\"itemId\":\"$row[itemId]\",\n";
	//************
	$queryOrder = " select * from orders where id=$row[orderId] ";
	$respOrder = mysql_query($queryOrder);
	$rowOrder = mysql_fetch_assoc($respOrder);
	//************
	//echo 
	if($rowOrder["orderStatus"]=="0")
		$ret .= "	\"onStore\":\"".(round($rowItem["kolvov"], 2)-$row["qtty"])."\",\n";
	else
		$ret .= "	\"onStore\":\"".(round($rowItem["kolvov"], 2)+$row["qtty"])."\",\n";
	//************
	$resp = mysql_query(" update orders set orderSum=$itogo, orderDiscount=$discount where id=$row[orderId] ");
	//************
	$step = "";
	$type = get_item_type($rowItem["parent"]);
	$step = __ff_findValuesFromKey($rowItem["parent"], "kolvo", "step");
	$ret .= "	\"step\":\"$step\",\n";
	$ret .= "	\"min\":\"$step\",\n";
	
	//************
	$ret = preg_replace("/,$/", "", $ret);
	$ret .= "}";
	//************
	return $ret;
}
//*********************************
function __fo_getUserAllSum($userId){
	$sum = 0;
	$resp = mysql_query("select * from orders where userId=$userId && orderStatus='ok' order by id asc ");
	while($order=mysql_fetch_assoc($resp)){
		$sum += $order["orderSum"];
	}
	$resp = mysql_query("select otherSum from users where id=$userId ");
	$row = mysql_fetch_assoc($resp);
	if($row["otherSum"])  $sum += $row["otherSum"];
	return $sum;
}
//*********************************
function __fo_getItemDiscount($itemId){
	
}
//*********************************
function __fo_getUserDiscount($userId, $orderId=false){
	$sum = __fo_getUserAllSum($userId);
	$discount = 0;
	$aDiscount = 0;
	//**********
	$all_disc_query = "select * from pages where name='all_discount'  ";
	$all_disc_resp = mysql_query($all_disc_query);
	$all_disc_row = mysql_fetch_assoc($all_disc_resp);
	$all_disc_mass_a = explode("\n", $all_disc_row["cont"]);
	$all_disc_mass = array();
	foreach($all_disc_mass_a as $key=>$val){
		$a = explode("=", trim($val));
		$all_disc_mass[] = $a;
	}
	//**********
	if(count($all_disc_mass > 0)){
		foreach($all_disc_mass as $key=>$val){
			if(  $sum >= $val[0]  ){
				$discount = $val[1];
			}
		}
	}
	$discount =  preg_replace("/%$/", "", $discount);
	//**********
	if($orderId){
		$sum = __fo_getAllSum($orderId);
		//echo "<$sum>";
		$all_disc_query = "select * from pages where name='once_discount'  ";
		$all_disc_resp = mysql_query($all_disc_query);
		$all_disc_row = mysql_fetch_assoc($all_disc_resp);
		$all_disc_mass_a = explode("\n", $all_disc_row["cont"]);
		$all_disc_mass = array();
		foreach($all_disc_mass_a as $key=>$val){
			$a = explode("=", trim($val));
			$all_disc_mass[] = $a;
		}
		//**********
		if(count($all_disc_mass > 0)){
			foreach($all_disc_mass as $key=>$val){
				//echo "$sum::$val[0]---";
				if(  $sum >= $val[0]  ){
					$aDiscount = $val[1];
				}
			}
		}
	}
	$aDiscount = preg_replace("/%$/", "", $aDiscount);
	if($aDiscount>$discount)  $discount=$aDiscount;
	$respUser = mysql_query("select * from users where id=$userId");
	$user = mysql_fetch_assoc($respUser);
	$aDiscount = $user["discount"];
	if($aDiscount>$discount)  $discount=$aDiscount;
	//**********
	return $discount;
}
//*********************************
function __fo_getAllSum($orderId){
	$resp = mysql_query("select * from sborka where orderId=$orderId   ");
	$sum = 0;
	while($item = mysql_fetch_assoc($resp)){
		$sum += $item["sum"];
	}
	return $sum;
}
//*********************************
function getOrderQuery($userId, $orderId=false){
	$head_query = "select * from pages where name='head_invoice'  ";
	$head_resp = mysql_query($head_query);
	$head_row = mysql_fetch_assoc($head_resp);
	$head =  $head_row["cont"];
	//*********
	$queryOrder = " select * from orders where id=$orderId ";
	$respOrder = mysql_query($queryOrder);
	$rowOrder = mysql_fetch_assoc($respOrder);
	//*********
	$user_id_query = "select * from users where id=$userId ";
	$user_resp = mysql_query(  $user_id_query  );
	$user_row = mysql_fetch_assoc($user_resp);
	//*********
	$head = str_replace("%username%", $user_row["fio"], $head);
	$head = str_replace("%userphone%", $user_row["phone"], $head);
	$head = str_replace("%usercomment%", $rowOrder["cont"], $head);
	$head = str_replace("%useremail%", $user_row["email"], $head);
	if($user_row["place"]==-100){
		$head = str_replace("%useradres%", $user_row["altplace"], $head);
	} else {
		$adquery = "select * from items where id=$user_row[place]";
		$adresp = mysql_query($adquery);
		$adrow = mysql_fetch_assoc($adresp);
		$head = str_replace("%useradres%", $adrow["name"], $head);
	}
	$head = str_replace("%userpromo%", $user_row["user_promo"], $head);
	return $head;
}
//*********************************
//*********************************
?>