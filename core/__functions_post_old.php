<?
function __fpost_send_mail($uname, $to, $toname, $from, $title, $text_post, $soc, $username, $userpass, $html=0, $postfile=false){

$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
$header.="From: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$uname")))."?= <$from>\r\n"; 
$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
$header.="Reply-To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$uname")))."?= <$from>\r\n";
$header.="X-Priority: 3 (Normal)\r\n";
$header.="Message-ID: <172562218.".date("YmjHis")."@".$soc."\r\n";
$header.="To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$toname")))."?= <".$to.">\r\n";
$header.="Subject: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($title)))."?=\r\n";
$header.="MIME-Version: 1.0\r\n";
$header.="Content-Type: multipart/mixed; boundary=\"----------A4D921C2D10D7DB\"\r\n";



//echo "http://subdomain.localhost/__pmservice/imgres.php?type=nimages_s&resize=60&link=$mass[link]";

//echo $header;

$text="------------A4D921C2D10D7DB
Content-Type: ";
if($html) $text.= "text/html; charset=\"windows-1251\" ";
else $text.= "text/plain; charset=windows-1251";
if($html) $text.= "Content-Transfer-Encoding: 8bit";
else $text.= "Content-Transfer-Encoding: quoted-printable";
$text.="

".$text_post;

if($postfile){
	$file=$postfile;
	$pfn=$postfile;
	for($i=strlen($file); $i>-1; $i--){
		if(substr($file, $i, 1) == "/"){
			$pfn = substr($file, $i+1, strlen($file)-$i);
		}
	}
	$fp = fopen($file, "rb");
	$code_file1 = chunk_split(base64_encode(fread($fp, filesize($file))));
	fclose($fp);
$text.="
------------A4D921C2D10D7DB
Content-Type: application/octet-stream; name=\"$pfn\"
Content-transfer-encoding: base64
Content-Disposition: attachment; filename=\"$pfn\"

".$code_file1."
------------A4D921C2D10D7DB--
";
}

$smtp_conn = fsockopen("mail.$soc", 25,$errno, $errstr, 10);
if(!$smtp_conn) {print "соединение с серверов не прошло"; fclose($smtp_conn); $stop_send = true;}
if(!$stop_send){
$data = get_data($smtp_conn);
fputs($smtp_conn,"EHLO $soc\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "ошибка приветсвия EHLO"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"AUTH LOGIN\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "сервер не разрешил начать авторизацию"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
//fputs($smtp_conn,base64_encode("$username")."\r\n");
fputs($smtp_conn,base64_encode("$username")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "ошибка доступа к такому юзеру"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("$userpass")."\r\n");
//fputs($smtp_conn,base64_encode("1y6xQX9rhy1i")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 235) {print "не правильный пароль"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"MAIL FROM:".$from."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "сервер отказал в команде MAIL FROM ($from)"; fclose($smtp_conn); $stop_send = true;}
}

//echo "to - ".$pos_info["cont"]."<br/\n>";
if(!$stop_send){
//echo "to=$to";
fputs($smtp_conn,"RCPT TO: ".$to."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250 AND $code != 251) {print "Сервер не принял команду RCPT TO 2 (".$to.")"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"DATA\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 354) {print "сервер не принял DATA"; fclose($smtp_conn); $stop_send = true; }
}

if(!$stop_send){
	fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
	$code = "</font>".substr(get_data($smtp_conn),0,3);
	fclose($smtp_conn); 
}
	if(!$stop_send){		
		return "post";
	} else {
		return "fail";
	}
} 
//*******************************************************************************
//*******************************************************************************
//*******************************************************************************
function __fp_post_zakaz($user, $nu_phone=false, $nu_email=false, 
$nu_fio=false, $nu_place=false, $nu_uszakaz=false, $nu_city=false){

if($nu_phone && $nu_email && $nu_fio && $nu_place){
	$user["phone"] = $nu_phone; 
	$user["email"] = $nu_email;
	$user["fio"] = "$nu_fio (Не зарегистрирован)";
	$user["city"] = $nu_city;
	$user["place"] = $nu_place;
	$user["id"] = "$nu_fio (Не зарегистрирован)";
	$user["uszakaz"] = $nu_uszakaz;
}

$resp = mysql_query("select * from pages where name='rec'  ");
$pos_info=mysql_fetch_assoc($resp);

$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
$header.="From: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$user[fio]")))."?= <$user[email]>\r\n"; 
$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
$header.="Reply-To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$user[fio]")))."?= <$user[email]>\r\n";
$header.="X-Priority: 3 (Normal)\r\n";
$header.="Message-ID: <172562218.".date("YmjHis")."@poklevka.net.ua\r\n";
$header.="To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("Владелец Сайта")))."?= <$pos_info[cont]>\r\n";
$header.="Subject: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode('--> Заказ с сайта')))."?=\r\n";
$header.="MIME-Version: 1.0\r\n";
$header.="Content-Type: multipart/mixed; boundary=\"----------A4D921C2D10D7DB\"\r\n";

//echo "http://subdomain.localhost/__pmservice/imgres.php?type=nimages_s&resize=60&link=$mass[link]";

//$file="excel/post_price.php";
//$fp = fopen($file, "rb");
//$code_file1 = chunk_split(base64_encode(fread($fp, filesize($file))));
//fclose($fp);
//$code_file2=base64_encode("привет, это типа второй файл");

$text="------------A4D921C2D10D7DB
Content-Type: text/plain; charset=windows-1251
Content-Transfer-Encoding: 8bit

Сообщение от: $user[fio]
Телефон: $user[phone]
E-mail: $user[email]
Место доставки: $user[city]
Комментарии: $user[place]
Условие платежа: $user[uszakaz]

Заказ ";

$to_zakaz="user=$user[id]\n";
$re_mass = explode("*", $_SESSION["rec"]);
$resp_zakaz = mysql_query("INSERT INTO zakaz (id,  cont) VALUES (NULL,  NULL)");
$resp_num = mysql_query("select * from zakaz order by id desc limit 0,1 ");
$row_num = mysql_fetch_assoc($resp_num);
$num_zak = $row_num["id"];
$to_zakaz .= "zakaz=$num_zak:\n";
$mass = array();
for($i=0; $i<count($re_mass)-1; $i++){
	$tm = explode(":", $re_mass[$i]);
	$mass["$tm[0]"] = $tm;
}
			$itogo=0;
			//print_r($mass);
			$not_send=true;
			foreach($mass as $key=>$val){
			$text.= "№$num_zak\n";
			$text.= "\n+------------------------------------------------------------------------------------------------------+\n";
				$resp = mysql_query("select * from items where id=$val[0]");
				$row = mysql_fetch_assoc($resp);
				$text.= "Наименование: ".html_entity_decode($row["name"])."\n";
				$text.= "   Артикул: ".$row["item_art"]."\n";
				$text.= "   Цена: ".__format_txt_price_format($row["price"])."\n";
				$text.= "   Количество: ".$val[1]."\n";
				$st = preg_replace("/,/", ".", __format_txt_price_format($row["price"]));
				$st = $st * $val[1];
				$text.= "   Стоимость: ".__format_txt_price_format($st)."\n";
				$itogo += $st;
				$to_zakaz .= "model=$row[id]=$row[price]=$val[1]=$st\n";
				$not_send = false;
			}
			if($not_send) {  
				header("Location: recycler.php"); 
				return false;
			}
			$text.= "\n+------------------------------------------------------------------------------------------------------+\n";
			//print_r($user);
			$text.="\nИтого: ".__format_txt_price_format($itogo);
			if($user["discount"] > 0) {
				$to_zakaz .= "discount=$user[discount]\n";
				$itogo = $itogo - $itogo/100*$user["discount"];
			}
			$to_zakaz .= "itogo=$itogo";

$text.="";

$smtp_conn = fsockopen("mail.poklevka.net.ua", 25,$errno, $errstr, 10);
if(!$smtp_conn) {print "соединение с серверов не прошло"; fclose($smtp_conn); $stop_send = true;}
if(!$stop_send){
$data = get_data($smtp_conn);
fputs($smtp_conn,"EHLO poklevka.net.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "ошибка приветсвия EHLO"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"AUTH LOGIN\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "сервер не разрешил начать авторизацию"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("robot@poklevka.net.ua")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "ошибка доступа к такому юзеру"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("1y6xQX9rhy1i")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 235) {print "не правильный пароль"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"MAIL FROM:robot@poklevka.net.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "сервер отказал в команде MAIL FROM"; fclose($smtp_conn); $stop_send = true;}
}

//echo "to - ".$pos_info["cont"]."<br/\n>";
if(!$stop_send){
//print_r($pos_info);
fputs($smtp_conn,"RCPT TO: $pos_info[cont]\r\n");
//fputs($smtp_conn,"RCPT TO: info@frukt-studio.biz\r\n");
//fputs($smtp_conn,"RCPT TO: robot@poklevka.net.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250 AND $code != 251) {print "Сервер не принял команду RCPT TO 1"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"DATA\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 354) {print "сервер не принял DATA"; fclose($smtp_conn); $stop_send = true; }
}

if(!$stop_send){
	fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
	$code = "</font>".substr(get_data($smtp_conn),0,3);
	fclose($smtp_conn); 
}

	if(!$stop_send) {
		$itemadddate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
		$resp_zakaz = mysql_query("UPDATE zakaz SET adddate=$itemadddate, cont='$to_zakaz' WHERE id=$num_zak");
		
		//sleep(10);
		//__fpost_send_mail("Сайт Гардена", $user["email"], $user["fio"], "info@poklevka.net.ua", "Счет на оплату заказа", 
		//$cont, "poklevka.net.ua", "robot@poklevka.net.ua", "1y6xQX9rhy1i", 1 );
		
		$cont = "<html><head></head>
		<style>
		td{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333333;
		}
		</style>
		<body>".__fpost_zakaz_html($num_zak)."</body></html>";
		print_r($user);
		echo $cont;
		__fpost_send_mail("Сайт Поклевка", 
		$user["email"], 
		$user["fio"], 
		"robot@poklevka.net.ua", 
		"Счет на оплату заказа", 
		$cont, 
		"poklevka.net.ua", 
		"robot@poklevka.net.ua", 
		"1y6xQX9rhy1i", 1);
		
		return "post";
	} else {
		$resp_zakaz = mysql_query("DELETE FROM zakaz WHERE id=$num_zak");
		return "fail";
	}
}
//******************************************************************
//******************************************************************
//******************************************************************
function __fpost_zakaz_html($cur_id, $nu_phone=false, $nu_email=false, $nu_fio=false, $nu_place=false){
	$rv = "";
	$shapka_resp = mysql_query("select * from pages where name='manage_schet'");
	$shapka_row = mysql_fetch_assoc($shapka_resp);
	$shapka = $shapka_row["cont"];
	//************
	$query = "select * from zakaz where id=$cur_id";
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$mod_mass=false;
	$mass = explode("\n", $row["cont"]);
	$mass_user = explode("=",$mass[0]);
	$user = $mass_user[1];
	
	if($nu_phone && $nu_email && $nu_fio && $nu_place){
		$row_user["phone"] = $nu_phone;
		$row_user["email"] = $nu_email;
		$row_user["fio"] = $nu_fio;
		$row_user["place"] = $nu_place;
		$row_user["id"] = "0";
	} else {
		$resp_user = mysql_query("select * from users where id=$user");
		if($resp_user) $row_user = mysql_fetch_assoc($resp_user);
	}
	
	for($i=2; $i<count($mass)-1; $i++)
		$mod_mass[]=explode("=", $mass[$i]);
		
	

	$rv .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr>
    		<td width=\"150\" height=\"30\"><strong>Поставщик</strong></td>
    		<td>$shapka</td>
  		</tr>
		<tr>
			<td width=\"150\" height=\"30\"><strong>Получатель</strong></td>
			<td>$row_user[fio]<br/>тел. $row_user[phone]</td>
		</tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>Плательщик</strong></td>
    <td>тотже</td>
  </tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>Заказ</strong></td>
    <td>без заказа </td>
  </tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>Условие продажи </strong></td>
    <td>Оплата через банк </td>
  </tr>
</table>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr><td>
<div align=\"center\"><strong>Счет №".strftime("%d-%m-%Y", $row["adddate"])."-".$row["id"]."<br/>
  от  ".strftime("%d.%m.%Y", $row["adddate"])."</strong>
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

$has_discount=false;
foreach($mod_mass as $key=>$val) {
$resp = mysql_query("select * from items where id=$val[1]");
$row=mysql_fetch_assoc($resp);

  if($val[0]!="discount"){
	  $rv .= "<tr>
		<td width=\"40\">".($key+1)."</td>
		<td width=\"400\">$row[name] (Артикул: $row[model_article])</td>
		<td>шт.</td>
		<td>$val[3]</td>
		<td>$val[2]</td>
		<td>$val[4]</td>
	  </tr>";
	} else {
		$has_discount=$val[1];
	}
}
$mass_i = explode("=",$mass[count($mass)-1]);
if($has_discount){
	$rv.= "  <tr><td colspan=\"5\"><div align=\"right\">Скидка</div></td><td>$has_discount%</td></tr>";
	$mass_i[1] = $mass_i[1] - $mass_i[1] / 100 * $has_discount;
}
$rv.= "  <tr>
    <td colspan=\"5\"><div align=\"right\">Итого</div></td>
    <td>$mass_i[1]</td>
  </tr>
</table>
<br>
<br>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr><td>
Всего на сумму:<br>
".write_price_in_words($mass_i[1])."</td></tr></table>";
//************
return $rv;
}
//************************************
function get_data($smtp_conn)
{
  $data="";
  while($str = fgets($smtp_conn,515)) 
  {
    $data .= $str;
    if(substr($str,3,1) == " ") { break; }
  }
  return $data;
}
//************************************