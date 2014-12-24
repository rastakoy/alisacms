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
require_once("../core/__functions_mtm.php");
require_once("../filter/__functions_filter.php");
require_once("../core/__functions_sitemap_0.1.php");
require_once("../core/__function_saver.php");
require_once("../core/__function_post_2.0.php");
require_once("../core/__functions_zakaz.php");
require_once("../core/__functions_order.php");
require_once("../core/__functions_pages.php");

//require_once("__functions_register.php");
//require_once("__functions_rating.php");
dbgo();
//*************************
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
//*************************
$item_name       	= iconv("UTF-8", "CP1251", $_POST["item_name"]);
$item_name       	= preg_replace('/"/', "»", $item_name );
$item_name       	= preg_replace("/ »/", " «", $item_name );
$item_name       	= preg_replace("/'/", "&rsquo;", $item_name );

$item_art           	= iconv("UTF-8", "CP1251", $_POST["item_art"]);
$item_psevdoart 	= iconv("UTF-8", "CP1251", $_POST["item_psevdoart"]);
$item_code        		= iconv("UTF-8", "CP1251", $_POST["item_code"]);
$item_prior        		= $_POST["item_prior"];
$item_parent      	= $_POST["item_parent"];
$item_price        	= iconv("UTF-8", "CP1251", $_POST["item_price"]);
$item_conta       	= preg_replace("/~~~aspirand~~~/", "&", iconv("UTF-8", "CP1251", $_POST["item_conta"] ) );
$item_conta       	= preg_replace("/~~~plus~~~/", "+", $item_conta );
$coder					= preg_replace("/~~~aspirand~~~/", "&", iconv("UTF-8", "CP1251", $_POST["coder"] ) );
$coder			       	= preg_replace("/~~~plus~~~/", "+", $coder );
//$item_conta       				= preg_replace("/'/", "\\'", $item_conta );
//$item_conta       	= preg_replace("/'/", "\'", $item_conta );
$item_href_name	= iconv("UTF-8", "CP1251", $_POST["item_href_name"]);
$galtype					= iconv("UTF-8", "CP1251", $_POST["galtype"]);

$item_page_show	= $_POST["item_page_show"];
if(!$item_page_show) $item_page_show="0";

$cont     			  	= preg_replace("/~~~aspirand~~~/", "&", iconv("UTF-8", "CP1251", $_POST["cont"] ) );
//$cont     			  	= preg_replace("/{aspirand}/", "&", iconv("UTF-8", "CP1251", $_POST["cont"] ) );
$cont       				= preg_replace("/'/", "\\'", $cont );
$cont       				= preg_replace("/~~~plus~~~/", "+", $cont );
$respon     				= preg_replace("/~~~aspirand~~~/", "&", iconv("UTF-8", "CP1251", $_POST["respon"] ) );

$item_mdesc        	= iconv("UTF-8", "CP1251", $_POST["item_mdesc"]);
$item_mtitle        	= iconv("UTF-8", "CP1251", $_POST["item_mtitle"]);
$item_mh        	  	= iconv("UTF-8", "CP1251", $_POST["item_mh"]);
//*************************
$action=$_GET["action"];
$paction = $_POST["paction"];
$pid = $_POST["id"];
$folder=$_GET["folder"];
if(!$folder) $folder=$_POST["folder"];
$parent=$_GET["parent"];
if(!$parent) $parent=$_POST["parent"];
$id=$_GET["id"];
$search = $_GET["search"];
$sw = $_GET["sw"];
//*************************
$taj = $_POST["testajax"];
$taj2 = $_POST["testajax_2"];
$snipid_cont = iconv("UTF-8", "CP1251", $_POST["snipid_cont"]);
$item_cont			= preg_replace("/~~~aspirand~~~/", "&", iconv("UTF-8", "CP1251", $_POST["item_cont"] )  );
$item_cont			= preg_replace("/~~~plus~~~/", "+", $item_cont  );
$item_cont       	= preg_replace("/'/", "\\'", $item_cont );
$psevdonum = $_POST["psevdonum"];
//*************************
$itemeditdate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
//*************************
//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\"/>";
//**************
require_once("__ajax_help.php");
require_once("templates/mtm_logic.php");
//**************
if($taj) echo $taj."::".$taj2;
//**************
if($_FILES["name"]=="qqfile"){
	echo "{success:true}";
	//echo "Загружаем файл на сервер";
}
//**************
$value = $_POST["value"];
$value =  trim(iconv("UTF-8", "CP1251", $_POST["value"]));
$value = str_replace("'", "\\'", $value);
//**************
if($paction=="ao_sendSMS"){
	if($SMSSender!="on"){
		echo "У вас нет прав на отправку SMS";
		exit;
	}
	$text = $_POST["text"];
	$orderId = $_POST["orderId"];
	$resp = mysql_query("select * from orders where id=$orderId  ");
	$order = mysql_fetch_assoc($resp);
	$resp = mysql_query("select * from users where id=$order[userId]  ");
	$user = mysql_fetch_assoc($resp);
	require_once("__class.eSputnikAPI.php");
	$esp = new eSputnikAPI();
	$phone = $user["phone"];
	$phone = str_replace("(", "", $phone);
	$phone = str_replace(")", "", $phone);
	$phone = str_replace(" ", "", $phone);
	$phone = str_replace("-", "", $phone);
	$phone = trim($phone);
	//echo $phone;
	//$status = $esp->sendSMS($phone, $text);
	$resp = mysql_query("select * from smsmanager order by id desc limit 0,1");
	$row = mysql_fetch_assoc($resp);
	if($row['balance']>$smsPrice){
		$status = $esp->sendSMS_curl($phone, $text);
		$text = iconv("UTF-8", "CP1251", $text);
		$date = date('Y-m-d H:i:s');
		$resp = mysql_query("insert into smsmanager (cont, phone, text, balance, time) values ('$status', '$phone', '$text', ".($row['balance']-$smsPrice)." , '$date'  )  ");
		echo "Сообщение отправлено";
	}else{
		echo "Не хватает средств";
	}
}
if($paction=="ao_saveOrderTTN"){
	$ttn = $_POST["ttn"];
	$ttn = iconv("UTF-8", "CP1251", $ttn);
	$orderId = $_POST["orderId"];
	$resp = mysql_query(" update orders set TTN='$ttn' where id=$orderId ");
}
if($paction=="ao_cangeOrderStatus"){
	$orderStatus = $_POST["orderStatus"];
	$orderId = $_POST["orderId"];
	//*********************
	$resp = mysql_query("select * from orders where id=$orderId  ");
	$rowOrder = mysql_fetch_assoc($resp);
	$currentStatus = $rowOrder["orderStatus"];
	//*********************
	$resp = mysql_query("update orders set orderStatus='$orderStatus' where id=$orderId  ");
	$respStatusAll = mysql_query(" select * from items where folder=1 && parent=0 && href_name='ordersstatuses' ");
	$rowStatus = mysql_fetch_assoc($respStatusAll);
	$respStatus = mysql_query("select * from items where parent=$rowStatus[id] $dop_query  ");
	$resp = mysql_query("select * from sborka where orderId=$orderId  ");
	//*********************
	$a = true;
	//*********************
	while($rowStatus = mysql_fetch_assoc($respStatus) ){
		if($rowStatus['is_news']==1 && $rowStatus['href_name']==$orderStatus){
			while($row=mysql_fetch_assoc($resp)){
				$subResp = mysql_query("update items set kolvo=kolvo-$row[qtty] where id=$row[itemId]  ");
				if($currentStatus=="cancel")
					$subResp = mysql_query("update items set kolvov=kolvov-$row[qtty] where id=$row[itemId]  ");
				$a = false;
			}
		}
		//*****
		if($orderStatus == "cancel"){
			while($row=mysql_fetch_assoc($resp)){
				if($currentStatus=="ok")
					$subResp = mysql_query("update items set kolvo=kolvo+$row[qtty] where id=$row[itemId]  ");
				$subResp = mysql_query("update items set kolvov=kolvov+$row[qtty] where id=$row[itemId]  ");
			}
		}
	}
	//*********************
	if($a && $currentStatus=="ok"){
		while($row=mysql_fetch_assoc($resp)){
			$subResp = mysql_query("update items set kolvo=kolvo+$row[qtty] where id=$row[itemId]  ");
		}
	}
	//*********************
	if($currentStatus=="cancel"){
		while($row=mysql_fetch_assoc($resp)){
			if($orderStatus=="ok")
				$subResp = mysql_query("update items set kolvo=kolvo-$row[qtty] where id=$row[itemId]  ");
			$subResp = mysql_query("update items set kolvov=kolvov-$row[qtty] where id=$row[itemId]  ");
		}
	}
	//*********************
}
if($paction=="ao_postPrice"){
	$orderId = $_POST["orderId"];
	$resp = mysql_query("select * from orders where id=$orderId  ");
	$order = mysql_fetch_assoc($resp);
	$resp = mysql_query("select * from users where id=$order[userId]  ");
	$user = mysql_fetch_assoc($resp);
	$html = __fo_getOrder($orderId, true, true);
	$resp = mysql_query("select * from orders where id=$orderId");
	$order = mysql_fetch_assoc($resp);
	$header = getOrderQuery($order["userId"], $orderId);
	//echo $header;
	$file[0] = __fz_order_to_docx_admin_v2($orderId, $header." ".$html);
	//*****************************************************
	$resp = mysql_query("select * from pages where name='order_body'  ");
	$order_body = mysql_fetch_assoc($resp);
	$order_body = $order_body['cont'];
	__fp_sendMail_v2($user["email"], "robot@oksanalenta.com.ua", "Оксаналента", "Заказ с сайта", $order_body, $file);
	if(  file_exists($file[0])  ) unlink($file[0]);
}
if($paction=="ao_orderToWord"){
	$orderId = $_POST["orderId"];
	$html = __fo_getOrder($orderId, true, true);
	$resp = mysql_query("select * from orders where id=$orderId");
	$order = mysql_fetch_assoc($resp);
	$header = getOrderQuery($order["userId"], $orderId);
	//echo $header;
	echo __fz_order_to_docx_admin_v2($orderId, $header."  ".$html);
}
if($paction=="ao_getOrder"){
	$id = $_POST["id"];
	echo __fo_getOrder($id);
}
if($paction=="changeSborkaQtty"){
	$qtty = $_POST["qtty"];
	$id = $_POST["id"];
	
	$resp = mysql_query("select * from sborka where id=$id");
	$row = mysql_fetch_assoc($resp);
	$rowSborka = $row;
	$respItem = mysql_query("select * from items where id=$row[itemId] ");
	$rowItem = mysql_fetch_assoc($respItem);
	if($rowItem["discount"]=="") $rowItem["discount"] = "0";
	//print_r($rowItem);
	$resp = mysql_query("update sborka set qtty=$qtty where id=$id ");
	//*********** Расчет скидки
	$discount = "0";
	if($qtty >= $row["dinDiscountQtty"])
		$discount = $row["dinDiscount"];
	//$aDiscount = __fo_getUserDiscount($row["userId"]);
	//if($aDiscount > $discount)
	//	$discount = $aDiscount;
	if($discount==0) $discount = str_replace("%", "", $rowItem["discount"]);
	$resp = mysql_query("update sborka set discount=$discount where id=$id  ");
	$discPrice =  $row["price"] - round( $row["price"]/100*$discount, 2 );
	$sum = $discPrice*$qtty;
	$resp = mysql_query("update sborka set sum=$sum where id=$id  ");
	$all_sum = __fo_getAllSum($row["orderId"]);
	$resp = mysql_query("update orders set orderSum=$all_sum where id=$row[orderId]  ");
	//************************
	if($rowSborka["qtty"]>$qtty){
		$resp = mysql_query(" update items set kolvov=kolvov+".($rowSborka["qtty"]-$qtty)." where id=$rowItem[id] ");
	}elseif($rowSborka["qtty"]<$qtty){
		$resp = mysql_query(" update items set kolvov=kolvov-".($qtty-$rowSborka["qtty"])." where id=$rowItem[id] ");
	}
	//************************
	echo __fo_getSborkaJSON($id);
}
if($paction=="deleteItemFromOrder"){
	$id = $_POST["id"];
	//************************
	$resp = mysql_query("select * from orders where id=$orderId  ");
	$rowOrder = mysql_fetch_assoc($resp);
	$currentStatus = $rowOrder["orderStatus"];
	//************************
	$resp = mysql_query("select * from sborka where id=$id");
	$rowSborka = mysql_fetch_assoc($resp);
	//************************
	//if($currentStatus=="ok"){
	//	$resp = mysql_query("update from items set kolvov=kolvov+$rowSborka[qtty] where id=$id");
	//	$resp = mysql_query("update from items set kolvo=kolvo+$rowSborka[qtty] where id=$id");
	//}elseif($currentStatus!="cancel"){
	//	$resp = mysql_query("update from items set kolvov=kolvov+$rowSborka[qtty] where id=$id");
	//}
	$resp = mysql_query("delete from sborka where id=$id");
}
if($paction=="deleteOrder"){
	//*********************
	$orderId = $_POST["orderId"];
	//************************
	$resp = mysql_query("select * from orders where id=$orderId  ");
	$rowOrder = mysql_fetch_assoc($resp);
	$currentStatus = $rowOrder["orderStatus"];
	//************************
	$resp = mysql_query("select * from sborka where orderId=$orderId  ");
	while($row=mysql_fetch_assoc($resp)){
		if($currentStatus=="ok")
			$subResp = mysql_query("update items set kolvo=kolvo+$row[qtty] where id=$row[itemId]  ");
		if($currentStatus!="cancel")
			$subResp = mysql_query("update items set kolvov=kolvov+$row[qtty] where id=$row[itemId]  ");
	}
	//************************
	$resp = mysql_query("delete from sborka where orderId=$orderId");
	$resp = mysql_query("delete from orders where id=$orderId");
}
//**************
if($paction=="edit_user_discount"){
	$resp = mysql_query(" update users set discount=$value where id=".$_POST["pid"]);
}
if($paction=="edit_user_fio"){
	$resp = mysql_query(" update users set fio='$value' where id=".$_POST["pid"]);
}
if($paction=="edit_user_email"){
	$resp = mysql_query(" update users set email='$value' where id=".$_POST["pid"]);
	$resp = mysql_query("select * from users where id=".$_POST["pid"]);
	$row = mysql_fetch_assoc($resp);
	if($row["reg"]==1)  $resp = mysql_query(" update users set login='$value' where id=".$_POST["pid"]);
}
if($paction=="edit_user_phone"){
	$resp = mysql_query(" update users set phone='$value' where id=".$_POST["pid"]);
}
if($paction=="edit_user_pass"){
	$value = md5($value);
	$resp = mysql_query(" update users set pass='$value' where id=".$_POST["pid"]);
}
if($paction=="addUserToUsers"){
	$sc_time = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y")) + 60*60*24;
	$time = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
	$query = "insert into users (login, sc_time, user_promo, reg_time, reg, email, fio, isnews  ) 
	values ( 'email', $sc_time, '".__fz_usercode_generator()."', $time, 2, 'email' , 'Новый пользователь', 1 ) ";
	//echo $query;
	$resp = mysql_query($query);
}
if($paction=="registeringUser"){
	$query = "update users set reg=1 where id=".$_POST["pid"];
	//echo $query;
	$resp = mysql_query($query);
}
if($paction=="deletingUser"){
	$sc_time = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y")) + 60*60*24;
	$query = "update users set most_delete=1, del_time=$sc_time where id=".$_POST["pid"];
	echo $query;
	$resp = mysql_query($query);
}
if($paction=="cancelDeletingUser"){
	$query = "update users set most_delete=0 where id=".$_POST["pid"];
	$resp = mysql_query($query);
}
if($paction=="toggleUserSpam"){
	if($value==0) $value="0";
	$query = "update users set isnews=$value where id=".$_POST["pid"];
	$resp = mysql_query($query);
}
//**************
if($paction=="orders_send_order"){
	$pid = $_POST["pid"];
	$resp = mysql_query(" select * from items where id=$pid ");
	$row = mysql_fetch_assoc($resp);
	$mass = explode("<b>Промо код:</b> ", $row["cont"]);
	$promo = preg_replace("/<br.*$/", "", $mass[1]);
	//echo $promo;
	$resp = mysql_query(" select * from users where user_promo='$promo' ");
	$row_user = mysql_fetch_assoc($resp);
	//order-send-0
	//print_r($row_user);
	$mailresp = mysql_query(" select * from pages where name='rec' ");
	$rowmail = mysql_fetch_assoc($mailresp);
	$from_mail = $rowmail["cont"];
	__fp_sendMail_v2( $row_user["email"],  $from_mail,  "OksanaLenta",  "--> Заказ с сайта",  $row["cont"], $images);
	$new_cont = str_replace("order-send-0", "order-send-1", $row["cont"]);
	echo $new_cont;
	$resp = mysql_query(" update items set cont='$new_cont' where id=$pid ");
}
//**************
if($paction=="test_new_zakaz"){
	//echo "test";
	$query = "select * from zakaz where adddate>".$_POST["nztime"]." order by adddate desc limit 0,1";
	//echo "adddate=$row[adddate] ::: nztime=".$_POST["nztime"]."\n $query";
	$resp = mysql_query($query);
	$row=mysql_fetch_assoc($resp);
	if(mysql_num_rows($resp)>0){
		echo "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" 
		codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" 
		width=\"2\" height=\"2\">
          <param name=\"movie\" value=\"flash/sound.swf\">
          <param name=\"quality\" value=\"high\">
          <embed src=\"flash/sound.swf\" quality=\"high\" 
		  pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" 
		  width=\"2\" height=\"2\"></embed>
        </object>";
	}
	//echo "adddate=$row[adddate] ::: nztime=".$_POST["nztime"]."\n $query";
	exit;
}
//**************
if($paction=="load_img_from_link"){
	$pid = $_POST["id"];
	$specimg = iconv("UTF-8", "CP1251", $_POST["specimg"]);
	//-----------------Загрузка ворованного рисунка------
	for($i=strlen($specimg); $i>0; $i--){
		if(substr($specimg, $i, 1) == "/") {
			$specname = substr($specimg, $i+1, strlen($specimg)-$i);
			break;
		}
	}
	if(file_exists("../uploader/".$specname)){
		$specname = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y")).".jpg";
	}
	//-----------------  ---  ------
	$filename = "$specimg";
	$handle = fopen($filename, "r");
	$contents = '';
	while (!feof($handle)) {
		$contents .= fread($handle, 8192);
	}
	fclose($handle);
	//-----------------  ---  ------
	$handle = fopen("../loadimages/".$specname, 'a');
	fwrite($handle, $contents);
	fclose($handle);
	
	if(file_exists("../loadimages/".$specname)){
		$query = "INSERT INTO images (name, parent, link, prior) VALUES ('img', $pid, '$specname', 0)";
		$resp = mysql_query($query);
		echo "Запись произведена specname=$specname<br/>\n";
	} else {
		echo "Запись не удалась specname=$specname<br/>\n";
	}
	
}
//**************
if($paction=="deletefolder"){
	$pid = $_POST["id"];
	$query = "update items set recc=1 where id=$pid";
	//echo $query;
	$resp = mysql_query($query);
}
//**************
if($paction=="pic_in_text"){
	$pid = preg_replace("/simg_/", "", $pid);
	$query = "select * from images where id=$pid";
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$pic = $row["link"];
	$query = "update images set useintext=1 where id=$pid";
	$resp = mysql_query($query);
	$image_in=imagecreatefromjpeg("../loadimages/".$pic);
	$img_w = imagesx($image_in);  //Ширина изображения
	$img_h = imagesy($image_in); //Высота изображения
	if($resp) echo "<img src=\"/loadimages/$pic\" width=\"$img_w\" height=\"$img_h\" >";
}
//**************
if($paction=="pic_in_text_ef"){
	$pid = preg_replace("/simg_/", "", $pid);
	$query = "select * from images where id=$pid";
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$pic = $row["link"];
	$query = "update images set useintext=1 where id=$pid";
	$resp = mysql_query($query);
	$image_in=imagecreatefromjpeg("../loadimages/".$pic);
	$img_w = imagesx($image_in);  //Ширина изображения
	$img_h = imagesy($image_in); //Высота изображения
	if($resp) echo "<img class=\"fancybox-txtimg\" src=\"/loadimages/$pic\" style=\"width:240px; height:auto;\" alt=\"$row[cont]\" >";
}
//**************
if($paction=="savejsonpostdata"){
	$item_type = get_item_type($pid);
	$pid = $_POST["id"];
	//**********************
	$query = __ff_querypostdata($item_type, $_POST);
	//$resp = mysql_query($query);
}
//**************
if($paction=="set_item_type_in_multiitem_default"){
	$pid = $_POST["pid"];
	$value = $_POST["value"];
	$resp = mysql_query("select * from items where id=$pid");
	$row = mysql_fetch_assoc($resp);
	$mc = $row["multi_config"];
	//echo $mc;
	$prega = "/".$value.",?/";
	$mc = preg_replace($prega, "", $mc);
	$mc = preg_replace("/(^,|,$)/", "", $mc);
	$mc = "$value,$mc";
	$resp = mysql_query("update items set multi_config='$mc' where id=$pid  ");
	//echo "\n\n$mc";
}
//**************
if($paction=="set_item_type_in_multiitem"){
	$pid = $_POST["pid"];
	$action = $_POST["action"];
	$value = $_POST["value"];
	$resp = mysql_query("select * from items where id=$pid");
	$row = mysql_fetch_assoc($resp);
	$mc = $row["multi_config"];
	//echo $mc;
	$mc = preg_replace("/saveblock,?/", "", $mc);
	$prega = "/".$value.",?/";
	$mc = preg_replace($prega, "", $mc);
	$mc .= ",saveblock";
	$mc = preg_replace("/,,/", ",", $mc);
	$mc = preg_replace("/(^,|,$)/", "", $mc);
	if($action=="set")
		$mc .= ",".$value;
	$resp = mysql_query("update items set multi_config='$mc' where id=$pid  ");
	//echo "\n\n$mc";
}
//**************
if($paction=="stop_multiitem"){
	$pid = $_POST["pid"];
	$resp = mysql_query("update items set is_multi=0 where id=$pid ");
}
//**************
if($paction=="start_multiitem"){
	$pid = $_POST["pid"];
	$query = "select * from items where id=$pid ";
	echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$page = $row;
	$itemadddate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
	$query = "INSERT INTO items (name, prior, tmp, recc, page_show, itemadddate, folder, parent, galtype, is_multi) 
	VALUES ('$page[name]', $page[prior], 0, 0, 1, $itemadddate, 0,  $page[id], 1, 2 )";
	$resp = mysql_query($query);
	$query = "select * from items order by id desc limit 0,1";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$resp = mysql_query("update items set href_name='[mi=".$row["id"]."]' where id=$row[id] ");
	$resp = mysql_query("update items set is_multi=1 where id=$page[id] ");
	//$query = "insert into items ";
}
//**************
if($paction=="get_item_type_items"){
	$pid = $_POST["pid"];
	$item_type = get_item_type($pid);
	$query = "select * from itemstypes where id=$item_type";
	$resp = mysql_query($query);
	$row=mysql_fetch_assoc($resp);
	$masso = explode("\n", $row["pairs"]);
	$resp = mysql_query("select * from items where id=$pid");
	$row = mysql_fetch_assoc($resp);
	$mc = $row["multi_config"];
	$mc = explode(",", $mc);
	//************
	echo "<a href=\"javascript:multiitem_off($pid)\">Отключить мультизапись</a><hr size=1 />";
	//************
	foreach($masso as $key=>$val){
		$mass = explode("===", $val);
		if($mass[3]){
			$aaa = false;
			echo "<input type=\"checkbox\" onClick=\"mi_set_config('$mass[0]===$mass[1]', this, $pid)\" ";
			foreach($mc as $mkey=>$mval) {if(  $mval  ==  $mass[0]."===".$mass[1]  ){  echo "checked"; $aaa = true;}}
			echo " ><input name=\"radiobutton\" type=\"radio\" value=\"radiobutton\" onClick=\"mi_set_config_default('$mass[0]===$mass[1]', this, $pid)\" ";
			foreach($mc as $mkey=>$mval) if(  $mval  ==  $mass[0]."===".$mass[1]  && $mkey==0  )  echo "checked";
			if(!$aaa) echo " disabled ";
			echo " />$mass[3]<br/>";
		} else {
			//************
			if(  $mass[0]  ==  "pricedigit"  ){
				echo "<input type=\"checkbox\" onClick=\"mi_set_config('$mass[0]', this, $pid)\" ";
				foreach($mc as $mkey=>$mval) if(  $mval  ==  $mass[0]  )  echo "checked";
				echo " style=\"margin-right:20px;\" />Цена<br/>";
			}
			//************
			if(  $mass[0]  ==  "textarea"  ){
				echo "<input type=\"checkbox\" onClick=\"mi_set_config('$mass[0]', this, $pid)\" ";
				foreach($mc as $mkey=>$mval) if(  $mval  ==  $mass[0]  )  echo "checked";
				echo " style=\"margin-right:20px;\" />Текстовый блок<br/>";
			}
			//************
			if(  $mass[0]  ==  "artikul"  ){
				echo "<input type=\"checkbox\" onClick=\"mi_set_config('$mass[0]', this, $pid)\" ";
				foreach($mc as $mkey=>$mval) if(  $mval  ==  $mass[0]  )  echo "checked";
				echo " style=\"margin-right:20px;\" />Артикул<br/>";
			}
			//************
			//if(  $mass[0]  ==  "saveblock"  ){
			//	echo "<input type=\"checkbox\" onClick=\"mi_set_config('$mass[0]', this, $pid)\" ";
			//	foreach($mc as $key=>$val) if(  $val  ==  $mass[0]  )  echo "checked";
			//	echo " >Блок сохранения<br/>";
			//}
			//************
			if(  $mass[0]  ==  "images"  ){
				echo "<input type=\"checkbox\" onClick=\"mi_set_config('$mass[0]', this, $pid)\" ";
				foreach($mc as $mkey=>$mval) if(  $mval  ==  $mass[0]  )  echo "checked";
				echo " style=\"margin-right:20px;\" />Изображения<br/>";
			}
			//************
		}
	}
}
//**************
if($paction=="getjsonpostdata"){
	$item_type = get_item_type($pid);
	//Multiitem
	$MI = get_item_multiitem($pid, "true");
	if($MI) $MI = explode(",", $MI);
	//print_r($MI);
	if($item_type > 1)
		echo __ff_getjsonpostdata($item_type, $pid, $MI);
}
//**************
if($paction=="delete_item_form_recc"){
	$pid = $_POST["pid"];
	clear_recc_item($pid);
}
//**************
function clear_recc_item($pid){
	$query = "select * from items where id=$pid";
	//echo $query;
	$resp = mysql_query($query);
	$itemRow = mysql_fetch_assoc($resp);
	//**************
	$query = "select * from images where parent=$itemRow[id] ";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$respo = mysql_query("delete from images where id=$row[id]");
		if(file_exists("../loadimages/$row[link]")){
			unlink("../loadimages/$row[link]");
		}
	}
	//**************
	$query = "delete from items where id=$pid  ";
	$resp = mysql_query($query);
}
//**************
if($paction=="delete_item_recc"){
	$query = "select * from items where recc=1  ";
	$resp = mysql_query($resp);
	while($row=mysql_fetch_assoc($resp)){
		clear_recc_item($row["id"]);
	}
	$query = "delete from items where tmp=1  ";
	$resp = mysql_query($query);
}
//**************
if($paction=="resc_item"){
	$query = "update items set recc=0 where id=$pid";
	$resp = mysql_query($query);
	$resp = mysql_query("select * from items where id=$pid");
	$row = mysql_fetch_assoc($resp);
	echo $row["name"];
	
}
//**************
if($paction=="delete_item"){
	$query = "update items set recc=1 where id=$pid";
	echo $query;
	$resp = mysql_query($query);
	
}
//**************
if($paction=="delete_select_items"){
	$ids = explode("\n", $_POST["ids"]);
	foreach($ids as $key=>$val){
		if($val!=""){
			$query = "update items set recc=1 where id=$val";
			echo $query;
			$resp = mysql_query($query);
		}
	}
}
//**************
if($paction=="getmenu"){
	$__page_parent = $_POST["id"];
	if($__page_parent){
		$most_show=false;
		$link_mass =  __fmt_find_item_parent_id("0", $__page_parent);
		if(count($link_mass)>1)
			for($i=count($link_mass)-1; $i>0; $i--)
				$most_show[] = $link_mass[$i];
		echo __farmmed_rekursiya_show_semantik_tree("0", 0, false, $__page_parent, 0, $most_show);
	} else {
		echo __farmmed_rekursiya_show_semantik_tree("0", 0, false, false, 0); 
	}
}
//**************
if($paction=="editItemToCatalog_post"){
	$pid = $_POST["id"];
	//**********************
	$folder_name = iconv("UTF-8", "CP1251", $_POST["efolder_name"]);
	$query = "update items set name='$folder_name' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$fassoc = $_POST["efolder_assoc"];
	$query = "update items set fassoc=$fassoc where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$folder_prior = $_POST["efolder_prior"];
	$query = "update items set prior=$folder_prior where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$folder_parent = $_POST["efolder_parent"];
	$query = "update items set parent=$folder_parent where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$folder_item_type = $_POST["efolder_item_type"];
	$query = "update items set itemtype=$folder_item_type where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$folder_href_name = iconv("UTF-8", "CP1251", $_POST["efolder_href_name"]);
	$query = "update items set href_name='$folder_href_name' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$folder_cont = iconv("UTF-8", "CP1251", $_POST["efolder_cont"]);
	$folder_cont = preg_replace("/~~~aspirand~~~/", "&",  $folder_cont );
	$query = "update items set cont='$folder_cont' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set tmp=0, itemeditdate=$itemeditdate where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set psevdonum=$psevdonum where id=$pid";
	echo $query."---<br/>\n";
	$resp = mysql_query($query);
	//**********************
	$folder_title = iconv("UTF-8", "CP1251", $_POST["folder_title"]);
	$query = "update items set mtitle='$folder_title' where id=$pid";
	echo $query."---<br/>\n";
	$resp = mysql_query($query);
	//**********************
	$folder_desc = iconv("UTF-8", "CP1251", $_POST["folder_desc"]);
	$query = "update items set mdesc='$folder_desc' where id=$pid";
	echo $query."---<br/>\n";
	$resp = mysql_query($query);
	//**********************
	$folder_art = iconv("UTF-8", "CP1251", $_POST["folder_art"]);
	$query = "update items set item_art='$folder_art' where id=$pid";
	echo $query."---<br/>\n";
	$resp = mysql_query($query);
	//**********************
	$folder_code = iconv("UTF-8", "CP1251", $_POST["folder_code"]);
	$query = "update items set item_code='$folder_code' where id=$pid";
	echo $query."---<br/>\n";
	$resp = mysql_query($query);
	//**********************
	$folder_icon = iconv("UTF-8", "CP1251", $_POST["folder_icon"]);
	$query = "update items set folder_icon='$folder_icon' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$folder_filter = $_POST["folder_filter"];
	$query = "update items set mtm=$folder_filter where id=$pid";
	echo $query."---<br/>\n";
	$resp = mysql_query($query);
	//**********************
	$fpage_show = $_POST["fpage_show"];
	if(!$fpage_show) $fpage_show="0";
	$query = "update items set page_show=$fpage_show where id=$pid";
	echo $query."---<br/>\n";
	echo "psevdonum = $psevdonum---<br/>\n";
	$resp = mysql_query($query);
	if($resp) echo "Управление показом директории ($fpage_show)";
}
//**************
if($paction=="saveiteminfo"){
	$query = "update items set name='$item_name', tmp=0 where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set item_code='$item_code' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set item_art='$item_art' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set item_psevdoart='$item_psevdoart' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set href_name='$item_href_name' where id=$pid";
	$resp = mysql_query($query);
	
	//**********************
	$query = "update items set mtitle='$item_mtitle' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set mdesc='$item_mdesc' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set mh='$item_mh' where id=$pid";
	$resp = mysql_query($query);
	
	//**********************
	$query = "update items set prior=$item_prior where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set parent=$item_parent where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set item_price='$item_price' where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set galtype=$galtype where id=$pid";
	$resp = mysql_query($query);
	
	//**********************
	$query = "update items set page_show=$item_page_show where id=$pid";
	$resp = mysql_query($query);
	//**********************
	$query = "update items set psevdonum=$psevdonum where id=$pid";
	$resp = mysql_query($query);
	
	//**********************
	if($item_conta){
		//$item_conta = preg_replace("/'/", "\'", $item_conta );
		$query = "update items set cont='$item_conta' where id=$pid";
		echo "<pre>".$query."</pre><br/>\n";
		$resp = mysql_query($query);
	}
}
//**************
if($paction=="save_item_cont"){
	$query = "update items set cont='$item_cont' where id=$pid";
	$resp = mysql_query($query);
	//echo $item_cont;
	echo get_item_content($pid);
}
//**************
if($paction=="save_new_img_popup"){
	$pid = preg_replace("/simg_/", "", $pid);
	$query = "update images set cont='$snipid_cont' where id=$pid";
	$resp = mysql_query($query);
	if($resp){
		echo "Информация про изображение сохранена<br/>----<br/>\n";
	} else {
		echo "Произошла ошибка!<br/>\nИнформация про изображение не сохранена<br/>$query<br/>\n----<br/>\n";
	}
}
//**************
if($paction=="show_new_img_popup"){
	$pid = preg_replace("/simg_/", "", $pid);
	require_once("templates/imagesedittext.php");
}
//**************
if($paction=="images_delete"){
	$pid = preg_replace("/simg_/", "", $pid);
	$resp = mysql_query("select * from images where id=$pid ");
	$row = mysql_fetch_assoc($resp);
	$query = "delete from images where id=$pid";
	$resp = mysql_query($query);
	if($resp)  {
		unlink("../loadimages/$row[link]");
		echo "Произведено удаление $row[link]($row[id])<br/>\n";
		
	} else { 
		echo "Неудача: ".$query."<br/>\n";
	}
}
//**************
if($paction=="delete_filemanager_item"){
	$pid = preg_replace("/simg_/", "", $pid);
	$resp = mysql_query("select * from filemanager where id=$pid ");
	$row = mysql_fetch_assoc($resp);
	$query = "delete from filemanager where id=$pid";
	$resp = mysql_query($query);
	if($resp)  {
		unlink("../userupload/$row[link]");
		echo "Произведено удаление $row[link]($row[id])<br/>\n";
		
	} else { 
		echo "Неудача: ".$query."<br/>\n";
	}
}
//**************
if($paction=="images_get_images"){
	if($_POST["name"]=="site-img")
		echo show_images_for_items(false, true);
	else
		echo show_images_for_items($pid);
}
//**************
if($paction=="files_get_files"){
	echo show_files_fmanager($pid);
}
//**************
if($paction=="getimgprior_sort"){
	echo show_images_for_items_sort($pid);
}
//**************
if($paction=="setimgprior"){
	//echo "priors: $pid";
	$sprior = 10;
	$mass = explode(",", $pid);
	$pid = false;
	//print_r($mass);
	foreach($mass as $k=>$v){
		//echo preg_replace("/li_images_sort_/", "", $v)."<br/>\n";
		$v =  preg_replace("/li_images_sort_/", "", $v);
		if($v!="ok"){
			if($sprior==10){
				$qu = "select * from images where id=$v";
				$resp = mysql_query($qu);
				//echo $qu;
				$row = mysql_fetch_assoc($resp);
				$pid = $row["parent"];
			}
			$resp = mysql_query("update images set prior=$sprior where id=$v");
			$sprior += 10;
		}
	}
	if($pid) echo show_images_for_items($pid);
}
//**************
if($paction=="save_myitems_prior"){
	$sprior = 10;
	$mass = explode(",", $pid);
	$pid = false;
	//print_r($mass);
	foreach($mass as $k=>$v){
		//echo preg_replace("/li_images_sort_/", "", $v)."<br/>\n";
		$v =  preg_replace("/prm_/", "", $v);
		if($v!="ok"){
			if($sprior==10){
				$qu = "select * from items where id=$v";
				$resp = mysql_query($qu);
				//echo $qu;
				$row = mysql_fetch_assoc($resp);
				$pid = $row["parent"];
			}
			$resp = mysql_query("update items set prior=$sprior where id=$v");
			$aresp = mysql_query("select is_multi from items where id=$v");
			$arow = mysql_fetch_assoc($aresp);
			if($arow["is_multi"]==1){
				$resp = mysql_query("update items set prior=$sprior where parent=$v");
			}
			$sprior += 10;
		}
	}
	if($pid) echo show_images_for_items($pid);
}
//**************
if($paction=="getfolderinfo"){
	$id=$pid;
	if(!$id) $id="0";
	$item_type = get_item_type($pid, "true");
	//echo "item_type=$item_type<br/>";
	$query = "select * from items where id=$pid";
	$resp=mysql_query($query);
	$row=mysql_fetch_assoc($resp);
	if(($item_type == 0 || $item_type == 1) && $item_type!="multiitem"){
		if($item_type==1){
			require("templates/itemform.php");
		} else {
			require("templates/def_form.php");
		}
	}
	if($item_type > 1){
		require("templates/form_template.php");
	}
	//require_once("templates/itemform.php");
}
//**************
if($paction=="rootgetfolderinfo"){
	$id=$pid;
	$page=$_POST["page"];
	$prefix=$_POST["prefix"];
	if(!$page) $page = 1;
	if(!$id) $id = $_POST["pid"];
	if(!$id) $id="0";
	$limit=$_POST["limit"];
	if(!$limit) $limit = $usersOnPageLimit;
	$search_name = $_POST["search_name"];
	$search_name = iconv(  "UTF-8", "CP1251", $search_name  );
	$search_fio = $_POST["search_fio"];
	$search_fio = iconv(  "UTF-8", "CP1251", $search_fio  );
	$search_email = $_POST["search_email"];
	$search_email = iconv(  "UTF-8", "CP1251", $search_email  );
	if($search_name || $search_email) $limit = 1000;
	$folderparam = false;
	if($id!=0){
		$myresp = mysql_query("select * from items where id=$id");
		$myrow = mysql_fetch_assoc($myresp);
		 if(  __fts_is_item_useradmin(  $myrow, "items"  )  &&  !$folderparam  )
		 	$folderparam = true;
		if(  __fts_is_item_order(  $myrow, "items"  )  &&  !$folderparam  )
		 	$folderparam = true;
		if(  __fts_is_item_admin(  $myrow, "items"  )  &&  !$folderparam  )
		 	$folderparam = true;
		if(  __fts_is_item_goo(  $myrow, "items"  )  &&  !$folderparam  ){
		 	$folderparam = true;
			//echo "<!-- itemgoo -->\n";
		}
	}
	if($folderparam) {
		echo "folderparam=no\n";
		if(  __fts_is_item_goo(  $myrow, "items"  )  )   echo "<!-- itemgoo -->\n";
	}
	require("templates/folderinfo.php");
}
//*************************
if($paction=="newitem"){
	if(!$folder) $folder="0";
	if($folder){
		$itemadddate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
		$resp = mysql_query("INSERT INTO items (name, prior, tmp, itemadddate, folder, parent) VALUES ('Новая директория', 0, 1, $itemadddate, 1, $parent )");
		$resp = mysql_query("select * from items order by id desc limit 0,1 ");
		$row = mysql_fetch_assoc($resp);
		$id=$row["id"];
		//echo $row["id"];
		require("templates/folders.php");
	} else {
		$itemadddate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
		$query = "INSERT INTO items (name, prior, tmp, itemadddate, folder, parent, galtype) 
		VALUES ('Новая запись', 0, 1, $itemadddate, 0,  $parent, 1 )";
		//echo $query;
		$resp = mysql_query($query);
		$resp = mysql_query("select * from items order by id desc limit 0,1 ");
		$row = mysql_fetch_assoc($resp);
		echo $row["id"];
	}
}
//**************
if($paction=="edititem"){
	//echo "asd";
	if(!$folder) $folder="0";
	$id = $_POST["id"];
	require("templates/folders.php");
}
//**************
if ($action=="loaditems") {
	//echo "asd";
	echo __farmmed_rekursiya_show_semantik_tree($_GET["tree_index"], $_GET['parent'], $edit_mass, $edit, $_GET["count"]);
}
//**************
if ($action=="getdiritems") {
	echo __ft_getdiritems($_GET['parent']);
}
//**************
//**************  КОММЕНТАРИИ ПОЛЬЗОВАТЕЛЕЙ
//**************
if ($paction=="getusercomments") {
	$resp = mysql_query("select * from user_comments where parent=$pid order by itemadddate desc ");
	while($row=mysql_fetch_assoc($resp)){
		echo "<div class=\"div_ucw_incont\">";
		
		echo $row["name"].": <i>".strftime("%d.%m.%Y %H:%M:%S", $row["itemadddate"])."</i><br/>";
		
		echo "<br/><span  style=\"background-color: #EAEAEA;\">".$row["cont"]."</span><br/>\n";
		if($row["url"]!="" && $row["url"]!="http://")
			echo "<br/>\nСайт: <a href=\"$row[url]\" target=\"_blank\">$row[url]</a>";
		if($row["email"] != "")
			echo "<br/>\nE-mail: <a href=\"mailto:$row[email]\">$row[email]</a>";
		if($row["respon"] != "")
			echo "<br/><br/>\n<strong>Ваш ответ:</strong> $row[respon]";
		
		echo "<br/><br/><span style=\"background-color: #CCCCCC;\">
		<a href=\"javascript:uc_show_edit($row[id])\">Редактировать</a> :: 
		<a href=\"javascript:uc_delete_comment($row[id], $row[parent])\"><font color=red>Удалить</font></a>
		</span>";
		
		echo "</div>";
	}
}
//**************
if ($paction=="show_popup_user_response") {
	//$query = "select * from user_comments where parent=$pid order by itemadddate desc ";
	//$resp = mysql_query($query);
	//$row = mysql_fetch_assoc($resp);
	require("templates/edit_user_comments.php");
}
//**************
if ($paction=="save_uc") {
	$resp = mysql_query("update user_comments set cont='$cont', respon='$respon' where id=$pid  ");
	echo "\nДанные о комментарии изменены\n";
}
//**************
if ($paction=="delete_uc") {
	$resp = mysql_query("delete from user_comments where id=$pid  ");
	echo "\nДанные о комментарии $pid удалены\n";
}
//**************
if ($paction=="toogle_page_show_save") {
	$query = "select * from items where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$row["page_show"]=!$row["page_show"];
	if(!$row["page_show"]) $row["page_show"] = "0";
	$query = "update items set page_show=$row[page_show] where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
}
//**************
if ($paction=="toogle_rests_show_save") {
	$query = "select * from items where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$row["is_rests"]=!$row["is_rests"];
	if(!$row["is_rests"]) $row["is_rests"] = "0";
	$query = "update items set is_rests=$row[is_rests] where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
}
//**************
if ($paction=="toogle_spec_show_save") {
	$query = "select * from items where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$row["hot_item"]=!$row["hot_item"];
	if(!$row["hot_item"]) $row["hot_item"] = "0";
	$query = "update items set hot_item=$row[hot_item] where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
}
//**************
if ($paction=="toogle_akc_show_save") {
	$query = "select * from items where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$row["is_akc"]=!$row["is_akc"];
	if(!$row["is_akc"]) $row["is_akc"] = "0";
	$query = "update items set is_akc=$row[is_akc] where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
}
//**************
if ($paction=="toogle_new_show_save") {
	$query = "select * from items where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$row["is_new"]=!$row["is_new"];
	if(!$row["is_new"]) $row["is_new"] = "0";
	$query = "update items set is_new=$row[is_new] where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
}
//**************
if ($paction=="toogle_sale_show_save") {
	$query = "select * from items where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$row["is_sale"]=!$row["is_sale"];
	if(!$row["is_sale"]) $row["is_sale"] = "0";
	$query = "update items set is_sale=$row[is_sale] where id=$pid ";
	//echo $query."<br/>";
	$resp = mysql_query($query);
}
//**************
if ($paction=="fast_order_cont_save") {
	$cont = preg_replace("/\\\\\\.*'/", "'", $cont);
	$query = "update pages set cont='$cont' where name='order_body' ";
	echo $query."<br/>";
	$resp = mysql_query($query);
}
//**************
if ($paction=="fast_offert_cont_save") {
	$cont = preg_replace("/\\\\\\.*'/", "'", $cont);
	$query = "update pages set cont='$cont' where name='offert_cont' ";
	echo $query."<br/>";
	$resp = mysql_query($query);
}
//**************
if ($paction=="fast_cont_save") {
	$cont = preg_replace("/\\\\\\.*'/", "'", $cont);
	$query = "update items set cont='$cont' where id=$pid ";
	echo $query."<br/>";
	$resp = mysql_query($query);
}
//**************
if ($paction=="get_fast_cont") {
	$query = "select cont from items where id=$pid ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	echo $row["cont"];
}
//**************
if ($paction=="get_fast_order_cont") {
	$query = "select cont from pages where name='order_body'  ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	echo $row["cont"];
}
//**************
if ($paction=="get_fast_offert_cont") {
	$query = "select cont from pages where name='offert_cont'  ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	echo $row["cont"];
}
//**************
if ($paction=="get_fc_images") {
	$query = "select * from images where parent = $pid && img_in_text=1 ";
	$resp = mysql_query($query);
	while($row = mysql_fetch_assoc($resp)){
		//echo $row["link"]."<br/>\n";
		echo "<div class=\"div_fc_images_in_box\">";
		echo "<img onMouseDown=\"start_insert_img()\" src=\"../imgres.php?resize=100&link=$row[link]\">";
		echo "</div>";
	}
	
}
//**************
if($paction=="fast_table_get_csv"){
	//echo "fast_table_get_csv is ON";
	echo show_csv_for_items($pid);
}
//**************
if($paction=="fast_table_get_csvtable"){
	require_once("templates/table_csv.php");
}
//**************
if ($paction=="fast_table_save") {
	$cells_csv = $_POST["cells_csv"];
	//$query = "update items set cont='$cont' where id=$pid ";
	//echo $query."<br/>";
	//$resp = mysql_query($query);
	$resp = mysql_query("select * from files_csv where id=$pid");
	$row = mysql_fetch_assoc($resp);
	$csv_file = $row["link"];
	$cont = preg_replace("/\\\'/", "'", $cont);
	$values = $cont;
	require_once("templates/__csv_decode.php");
	echo $cont;
}
//**************
if ($paction=="mtm_get_filter") {
	require_once("templates/mtm_filter.php");
}
//**************
if ($paction=="set_mtm") {
	$ret = "";
	$lev1 = $_POST["lev1"];
	$lev2 = $_POST["lev2"];
	$del_lev1 = $_POST["del_lev1"];
	$del_lev2 = $_POST["del_lev2"];
	
	$resp = mysql_query("select * from items where id=$pid ");
	$row = mysql_fetch_assoc($resp);
	
	//echo $row["mtm_cont"];
	
	$mass = $row["mtm_cont"];
	$mass = explode("\n", $mass);
	foreach($mass as $key=>$val){
		$tmp = explode("->", $val);
		$tmp = $tmp[0];
		$tmp = preg_replace("/:/", "", $tmp);
		if($tmp != $lev1){
			$ret.=$val."\n";
		} else {
			if($lev2 != -1 && $del_lev1!=$lev1){
				//$ret.=":$lev1->";
				$tmp = preg_replace("/$lev1-$lev2,/", "", $val);
				if($del_lev2 != $lev2) $ret .= $tmp."$lev1-$lev2,";
				else $ret .= $tmp;
				$ret .= "\n";
			}
		}
	}
	if($del_lev1 != $lev1   &&   $lev2 == -1){
		$ret.=":$lev1->,";
	}
	
	$ret = trim($ret);
	echo $ret;
	$resp = mysql_query("update items set mtm_cont='$ret' where id=$pid  ");
}
//**************
if ($paction=="mtm_fast_mtm") {
	//require_once("templates/mtm_fast_mtm.php");
	require_once("templates/mtm_interface.php");
}
//**************
if ($paction=="reload_single_item") {
	echo __ff_reload_single_item( $pid );
}
//**************
if ($paction=="save_spfast_name") {
	$myid = $_POST["myid"];
	$field = $_POST["field"];
	$table = $_POST["table"];
	if($cont=="") $cont=" ";
	$query = "update $table set $field='$cont' where id=$myid ";
	$resp = mysql_query($query);
	//echo $query;
}
//**************
if ($paction=="generate_sitemap") {
	__fp_create_file("sitemap.xml", $_SERVER['DOCUMENT_ROOT']."/", __fsm_generate_sm_items("items", "0"));
	//****************************************************
	echo "Файл sitemap.xml сгенерирован";
}
//**************
if ($paction=="fast_pricedigit_change") {
	$pid = $_POST["pid"];
	$price = $_POST["newprice"];
	if(!$price) $price="0";
	$price = str_replace(",", ".", $price);
	$query = "update items set pricedigit=$price where id=$pid  ";
	$resp = mysql_query($query);
	echo $query;
}
//**************
if ($paction=="chui") {
	$val = $_POST["ui"];
	if(!$val) $val = "0";
	$resp = mysql_query("update manage_site set value=$val, dop_value='$_COOKIE[PHPSESSID]' where name='ui_on'   ");
}
//**************
if ($paction=="my_search_items") {
	$pid = $_POST["pid"];
	$resp = mysql_query(  "select * from items where parent=$pid && recc=0 && tmp=0 && folder=0 order by prior asc, name asc"  );
	echo "{\n";
	$count = 0;
	while(  $row=mysql_fetch_assoc(  $resp  )  ){
		echo "$count: '$row[name]'";
		$count++;
		if(  $count != mysql_num_rows(  $resp  )  ){
			echo ",";
		}
		echo "\n";
	}
	echo "}";
}
//**************
if ($paction=="my_search_users") {
	$pid = $_POST["pid"];
	$resp = mysql_query(  "select * from users order by reg desc, count_zak desc, id desc"  );
	echo "{\n";
	$count = 0;
	while(  $row=mysql_fetch_assoc(  $resp  )  ){
		if($row["fio"]=="") $row["fio"] = "Гость";
		echo "$count: '".str_replace("'", "\\'", $row["fio"])."'";
		$count++;
		if(  $count != mysql_num_rows(  $resp  )  ){
			echo ",";
		}
		echo "\n";
	}
	echo "}";
}
//**************
if ($paction=="my_search_email") {
	$pid = $_POST["pid"];
	$resp = mysql_query(  "select * from users order by reg desc, count_zak desc, id desc"  );
	echo "{\n";
	$count = 0;
	while(  $row=mysql_fetch_assoc(  $resp  )  ){
		echo "$count: '$row[email]'";
		$count++;
		if(  $count != mysql_num_rows(  $resp  )  ){
			echo ",";
		}
		echo "\n";
	}
	echo "}";
}
//**************
if (  $paction=="delete_files_filemanager"  ) {
	$links = explode(  "\n", $_POST["ids"]  );
	foreach(  $links as $key=>$val  ){
		$dlinks .= " link='$val' " ;
		if(  $key != count(  $links  ) - 1  ) $dlinks .= " || ";
	}
	$query = "delete from filemanager where $dlinks ";
	echo $query;
	$resp = mysql_query(  $query  );
	if(  $resp  ) foreach(  $links as $key=>$val  ) if(  file_exists(  "../files/$val"  )  ) unlink(  "../files/$val"  );
	
}
//**************
if ($paction=="look_basket") {
	$userid = $_POST["userid"];
	$value = $_POST["value"];
	if(!$value) $value = "0";
	$resp = mysql_query("  update users set look_basket=$value where id=$userid   ");
}
//**************
if ($paction=="setOrderStatus") {
	$pid = $_POST["pid"];
	$action = $_POST["action"];
	$resp = mysql_query(" select * from items where id=$pid ");
	$row = mysql_fetch_assoc($resp);
	$cont = $row["cont"];
	//preg_match_all("/\[.?.?.?\]$/", $aEval, $out);
	//$out[0][0] = preg_replace(  "/^\[|\]$/", "", $out[0][0]  );
	preg_match_all("/thisbasketid_[0-9]{1,6}=\"\">[0-9]{1,6}</", $cont, $out);
	if($action == "ordersstatuses/cancel/"){
		if( count($out)>0 ){
			foreach($out[0] as $key => $val){
				$id = preg_replace("/(^thisbasketid_|=.*$)/", "", $val);
				$kolvo = preg_replace("/(^thisbasketid_[0-9]{1,6}=\"\">|<$)/", "", $val);
				//echo $id."::".$kolvo."::".$action."\n";
				$aresp = mysql_query("select * from items where id=$id");
				$arow = mysql_fetch_assoc($aresp);
				$aresp = mysql_query(" update items set kolvov=".($arow["kolvov"]*1+$kolvo*1)." where id=$arow[id]     ");
			}
			$awresp = mysql_query(" update items set orderstatus='ordersstatuses/cancel' where id=$pid     ");
		}
	}
	//****************************************
	if($action == "ordersstatuses/ok/"){
		if( count($out)>0 ){
			foreach($out[0] as $key => $val){
				$id = preg_replace("/(^thisbasketid_|=.*$)/", "", $val);
				$kolvo = preg_replace("/(^thisbasketid_[0-9]{1,6}=\"\">|<$)/", "", $val);
				//echo $id."::".$kolvo."::".$action."\n";
				$aresp = mysql_query("select * from items where id=$id");
				$arow = mysql_fetch_assoc($aresp);
				$aresp = mysql_query(" update items set kolvo=".($arow["kolvo"]*1-$kolvo*1)." where id=$arow[id]     ");
			}
			$qqq = " update items set orderstatus='ordersstatuses/ok' where id=$pid     ";
			echo $qqq;
			$awresp = mysql_query($qqq);
		}
	}
	//****************************************
	if(  $action == "ordersstatuses/take/" || $action == ""  ){
		$awresp = mysql_query(" update items set orderstatus='ordersstatuses/take' where id=$pid     ");
	}
	//****************************************
	if(  $action == "ordersstatuses/working/"  ){
		$awresp = mysql_query(" update items set orderstatus='ordersstatuses/working' where id=$pid     ");
	}
	//****************************************
	if(  $action == "ordersstatuses/sended/"  ){
		$awresp = mysql_query(" update items set orderstatus='ordersstatuses/sended' where id=$pid     ");
	}
	//****************************************
	//echo "getOrderStatus";
}
//**************
if ($paction=="change_item_parent_dnd") {
	$id = $_POST["pid"];
	$parent = $_POST["parent"];
	if(!$parent) $parent="0";
	echo "$id => $parent";
	if($id)
		$resp = mysql_query(" update items set parent=$parent where id=$id  ");
	//$userid = $_POST["userid"];
	//$value = $_POST["value"];
	//if(!$value) $value = "0";
	//$resp = mysql_query("  update users set look_basket=$value where id=$userid   ");
}
//**************
if($paction=="edit_agq_post"){
	$pid = $_POST["pid"];
	$cont = str_replace("\n", "<br>", $item_conta);
	$query = "update items set cont='$cont' where id=$pid  ";
	$resp = mysql_query($query);
	//if($resp) 
	//echo "$query";
}
//**************
if($paction=="edit_agr_post"){
	$pid = $_POST["pid"];
	$cont = str_replace("\n", "<br>", $item_conta);
	$query = "update items set minicont='$cont' where id=$pid  ";
	$resp = mysql_query($query);
	//if($resp) 
	//echo "$query";
}
//**************
if($paction=="restsOnOff"){
	$rests = $_POST["rests"];
	if($rests=="on"){
		$resp = mysql_query("update pages set cont='1' where name='rests'  ");
	}else{
		$resp = mysql_query("update pages set cont='0' where name='rests'  ");
	}
}
//**************
if($paction=="offertOnOff"){
	$rests = $_POST["offert"];
	if($rests=="on"){
		$resp = mysql_query("update pages set cont='1' where name='offert'  ");
	}else{
		$resp = mysql_query("update pages set cont='0' where name='offert'  ");
	}
}
//**************
if($paction=="updateSiteSettingsPhone"){
	$phone = trim($_POST["phone"]);
	$resp = mysql_query("update pages set cont='$phone' where name='phone'  ");
}
//**************
if($paction=="updateSiteSettingsEmail"){
	$email = trim($_POST["email"]);
	$resp = mysql_query("update pages set cont='$email' where name='rec'  ");
}
//**************
if($paction=="get_messanger_data"){ ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
	<td height="40" width="300">Выберите сообщение для рассылки</td>
	<td height="40"><select style="width:300px; height:30px;" id="selectMessanger">
	<option value="">Выберите сообщение</option><?
	$query = "select * from items where folder=1 && href_name='messanger' && parent=0 ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$query = "select * from items where parent=$row[id] $dop_query order by prior asc" ;
	echo $query;
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		echo "<option value=\"$row[id]\">$row[name]</option>\n";
	}
	?></select></td>
</tr>
<tr>
	<td height="40" width="300">В режиме тестирования</td>
	<td height="40"><input type="checkbox" id="isEmailTesting" onclick="toggleEmailShow(this)" /> 
	<b id="pEmailText" style="display:none;">&nbsp;&nbsp;&nbsp;e-mail 
	<input type="text" id="emailText" style="height:30px;" /></b></td>
</tr></table>
<hr size="1" />
<? }
//**************
if($paction=='start_messanger'){
	$pid = $_POST['pid'];
	$onEmail = $_POST['onemail'];
	$resp = mysql_query(" truncate send_emails ");
	if(!$_POST['onemail']){
		$resp = mysql_query(" select * from users where isnews=1 && email!='' group by email  order by id asc ");
	}
	if(!$_POST['onemail']){
		while($row=mysql_fetch_assoc($resp)){
			$respo = mysql_query(" insert into send_emails (email, is_send_id) values ('$row[email]', $pid) ");
		}
	}else{
		$respo = mysql_query(" insert into send_emails (email, is_send_id) values ('".$_POST['onemail']."', $pid) ");
	}
	//$resp = mysql_query(" update users set is_send_email=1, is_send_id=$pid where isnews=1 ");
}
//**************

//**************







?>