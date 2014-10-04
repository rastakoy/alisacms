<?
//************************************************************
function __fp_sendMail_v2($to,$from_mail,$from_name,$subject,$mess,$file_names=false) {
	$bound = "frukt-studio-biz-oksanalenta-1234";
	$message  = "";
	
	$message .= "--$bound\n";
	$message .= "Content-type: text/html; charset=\"windows-1251\"  Content-Transfer-Encoding: 8bit\n\n";
	$message .= "$mess<br/>\n";
	
	//if($file_name){
	//	$message .= "\n--$bound\n";
	//	$file=fopen($file_name,"rb");
	//	$message .="Content-Type: application/octet-stream;";
	//	$message .="name=".basename($file_name)."\n";
	//	$message .="Content-Transfer-Encoding:base64\n";
	//	$message .="Content-Disposition:attachment\n\n";
	//	$message .=base64_encode(fread($file,filesize($file_name)))."\n";
	//	$message .="$bound--\n\n";
	//}
	
	if(is_array($file_names)){
		foreach($file_names as $key=>$file_name){
			$message .= "\n--$bound\n";
			$file=fopen($file_name,"rb");
			$message .="Content-Type: application/octet-stream;";
			$message .="name=".basename($file_name)."\n";
			$message .="Content-Transfer-Encoding:base64\n";
			$message .="Content-Disposition:attachment\n\n";
			$message .=base64_encode(fread($file,filesize($file_name)))."\n";
			$message .="$bound--\n\n";
		}
	}
	
	//****************************
	
	$headers   =  "MIME-Version: 1.0\n";
	//$headers  .=  "From: -->$from_name<$from_mail>\n";
	$headers  .=  "From: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$from_name")))."?= <$from_mail>\n"; 
	$headers  .=  "X-Mailer: Frukt-studio-post \n"; 
	$headers  .=  "Subject: =?windows-1251?Q?-->$subject?=\n";
	$headers  .=  "Content-Type: multipart/mixed; boundary=\"$bound\"\n";
	
	if(mail("$to", "$subject", $message, $headers) ) {
		return true;
	} else {
		return false;
	}
	//****************************
	//mail("info@frukt-studio.biz", "$subject", $message, $headers);
}
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
			<td width=\"150\" height=\"30\"><strong>Имя получателя</strong></td>
			<td>$row_user[fio]</td>
		</tr>
		<tr>
			<td width=\"150\" height=\"30\"><strong>Телефон</strong></td>
			<td>$row_user[phone]</td>
		</tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>E-mail</strong></td>
    <td>$row_user[email]</td>
  </tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>Адрес получателя</strong></td>
    <td>";
	if($row_user["region"] && $row_user["city"] && $row_user["place"])
		$rv .= "$row_user[region] $row_user[city] $row_user[place]";
	else
		$rv .= "$row_user[city]";
	$rv .= "</td>
  </tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>Условие доставки</strong></td>
    <td>";
	if($row["zevent"]==2)
		$rv .= "Наложенный платеж";
	if($row["zevent"]==1)
		$rv .= "Предоплата";
	$rv .= "</td>
  </tr>
</table>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr><td>
<div align=\"center\"><strong>Заказ №".strftime("%d-%m-%Y", $row["adddate"])."-".$row["id"]."<br/>
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
".write_price_in_words($mass_i[1])."</td></tr></table>
<br/>Комментарий:<br/>$row_user[comment]";
//************
return $rv;
}
//******************************************************************

//******************************************************************
?>