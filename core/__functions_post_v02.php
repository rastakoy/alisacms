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
if(!$smtp_conn) {print "���������� � �������� �� ������"; fclose($smtp_conn); $stop_send = true;}
if(!$stop_send){
$data = get_data($smtp_conn);
fputs($smtp_conn,"EHLO $soc\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "������ ���������� EHLO"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"AUTH LOGIN\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "������ �� �������� ������ �����������"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
//fputs($smtp_conn,base64_encode("$username")."\r\n");
fputs($smtp_conn,base64_encode("$username")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "������ ������� � ������ �����"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("$userpass")."\r\n");
//fputs($smtp_conn,base64_encode("1y6xQX9rhy1i")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 235) {print "�� ���������� ������"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"MAIL FROM:".$from."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "������ ������� � ������� MAIL FROM ($from)"; fclose($smtp_conn); $stop_send = true;}
}

//echo "to - ".$pos_info["cont"]."<br/\n>";
if(!$stop_send){
//echo "to=$to";
fputs($smtp_conn,"RCPT TO: ".$to."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250 AND $code != 251) {print "������ �� ������ ������� RCPT TO 2 (".$to.")"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"DATA\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 354) {print "������ �� ������ DATA"; fclose($smtp_conn); $stop_send = true; }
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

//if($nu_phone && $nu_email && $nu_fio && $nu_place){
	//$user["phone"] = $nu_phone; 
	//$user["email"] = $nu_email;
	//$user["fio"] = "$nu_fio (�� ���������������)";
	//$user["city"] = $nu_city;
	//$user["place"] = $nu_place;
	//$user["id"] = "$nu_fio (�� ���������������)";
	//$user["uszakaz"] = $nu_uszakaz;
//}

$resp = mysql_query("select * from pages where name='rec'  ");
$pos_info=mysql_fetch_assoc($resp);

$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
$header.="From: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$user[fio]")))."?= <$user[email]>\r\n"; 
$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
$header.="Reply-To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$user[fio]")))."?= <$user[email]>\r\n";
$header.="X-Priority: 3 (Normal)\r\n";
$header.="Message-ID: <172562218.".date("YmjHis")."@poklevka.net.ua\r\n";
$header.="To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("�������� �����")))."?= <$pos_info[cont]>\r\n";
$header.="Subject: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode('--> ����� � �����')))."?=\r\n";
$header.="MIME-Version: 1.0\r\n";
$header.="Content-Type: multipart/mixed; boundary=\"----------A4D921C2D10D7DB\"\r\n";

//echo "http://subdomain.localhost/__pmservice/imgres.php?type=nimages_s&resize=60&link=$mass[link]";

//$file="excel/post_price.php";
//$fp = fopen($file, "rb");
//$code_file1 = chunk_split(base64_encode(fread($fp, filesize($file))));
//fclose($fp);
//$code_file2=base64_encode("������, ��� ���� ������ ����");

$text="------------A4D921C2D10D7DB
Content-Type: text/plain; charset=windows-1251
Content-Transfer-Encoding: 8bit

��������� ��: $user[fio]
�������: $user[phone]
E-mail: $user[email]
����� ��������: $user[city]
�����������: $user[place]
������� �������: $user[uszakaz]

����� ";

$to_zakaz="user=$user[id]\n";
$re_mass = explode("*", $_SESSION["rec"]);
if(!$nu_uszakaz) $nu_uszakaz=2;
$q_resp_zakaz = "INSERT INTO zakaz (zevent, zstatus) VALUES ($nu_uszakaz, 0)";
//echo $q_resp_zakaz;
$resp_zakaz = mysql_query($q_resp_zakaz);
$resp_num = mysql_query("select * from zakaz order by id desc limit 0,1 ");
$row_num = mysql_fetch_assoc($resp_num);
//print_r($row_num);
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
			$text.= "�$num_zak\n";
			$text.= "\n+------------------------------------------------------------------------------------------------------+\n";
				$resp = mysql_query("select * from items where id=$val[0]");
				$row = mysql_fetch_assoc($resp);
				$text.= "������������: ".html_entity_decode($row["name"])."\n";
				$text.= "   �������: ".$row["item_art"]."\n";
				$text.= "   ����: ".__format_txt_price_format($row["price"])."\n";
				$text.= "   ����������: ".$val[1]."\n";
				$st = preg_replace("/,/", ".", __format_txt_price_format($row["price"]));
				$st = $st * $val[1];
				$text.= "   ���������: ".__format_txt_price_format($st)."\n";
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
			$text.="\n�����: ".__format_txt_price_format($itogo);
			if($user["discount"] > 0) {
				$to_zakaz .= "discount=$user[discount]\n";
				$itogo = $itogo - $itogo/100*$user["discount"];
			}
			$to_zakaz .= "itogo=$itogo";

$text.="";

$smtp_conn = fsockopen("mail.poklevka.net.ua", 25,$errno, $errstr, 10);
if(!$smtp_conn) {print "���������� � �������� �� ������"; fclose($smtp_conn); $stop_send = true;}
if(!$stop_send){
$data = get_data($smtp_conn);
fputs($smtp_conn,"EHLO poklevka.net.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "������ ���������� EHLO"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"AUTH LOGIN\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "������ �� �������� ������ �����������"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("robot@poklevka.net.ua")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "������ ������� � ������ �����"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("1y6xQX9rhy1i")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 235) {print "�� ���������� ������"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"MAIL FROM:robot@poklevka.net.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "������ ������� � ������� MAIL FROM"; fclose($smtp_conn); $stop_send = true;}
}

//echo "to - ".$pos_info["cont"]."<br/\n>";
if(!$stop_send){
//print_r($pos_info);
fputs($smtp_conn,"RCPT TO: $pos_info[cont]\r\n");
//fputs($smtp_conn,"RCPT TO: info@frukt-studio.biz\r\n");
//fputs($smtp_conn,"RCPT TO: robot@poklevka.net.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250 AND $code != 251) {print "������ �� ������ ������� RCPT TO 1"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"DATA\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 354) {print "������ �� ������ DATA"; fclose($smtp_conn); $stop_send = true; }
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
		//__fpost_send_mail("���� �������", $user["email"], $user["fio"], "info@poklevka.net.ua", "���� �� ������ ������", 
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
		//print_r($user);
		//echo $cont;
		__fpost_send_mail("���� ��������", 
		$user["email"], 
		$user["fio"], 
		"info@poklevka.net.ua", 
		"����� � ��������-�������� ��������", 
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
    		<td width=\"150\" height=\"30\"><strong>���������</strong></td>
    		<td>$shapka</td>
  		</tr>
		<tr>
			<td width=\"150\" height=\"30\"><strong>��� ����������</strong></td>
			<td>$row_user[fio]</td>
		</tr>
		<tr>
			<td width=\"150\" height=\"30\"><strong>�������</strong></td>
			<td>$row_user[phone]</td>
		</tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>E-mail</strong></td>
    <td>$row_user[email]</td>
  </tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>����� ����������</strong></td>
    <td>";
	if($row_user["region"] && $row_user["city"] && $row_user["place"])
		$rv .= "$row_user[region] $row_user[city] $row_user[place]";
	else
		$rv .= "$row_user[city]";
	$rv .= "</td>
  </tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>������� ��������</strong></td>
    <td>";
	if($row["zevent"]==2)
		$rv .= "���������� ������";
	if($row["zevent"]==1)
		$rv .= "����������";
	$rv .= "</td>
  </tr>
</table>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr><td>
<div align=\"center\"><strong>����� �".strftime("%d-%m-%Y", $row["adddate"])."-".$row["id"]."<br/>
  ��  ".strftime("%d.%m.%Y", $row["adddate"])."</strong>
</div></td></tr></table>
<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td width=\"40\" bgcolor=\"#CCCCCC\">�</td>
    <td width=\"400\" bgcolor=\"#CCCCCC\"><div align=\"center\">�����</div></td>
    <td bgcolor=\"#CCCCCC\">��.</td>
    <td bgcolor=\"#CCCCCC\">����������</td>
    <td bgcolor=\"#CCCCCC\">���� ��� ��� </td>
    <td bgcolor=\"#CCCCCC\">����� ��� ��� </td>
  </tr>";

$has_discount=false;
foreach($mod_mass as $key=>$val) {
$resp = mysql_query("select * from items where id=$val[1]");
$row=mysql_fetch_assoc($resp);

  if($val[0]!="discount"){
	  $rv .= "<tr>
		<td width=\"40\">".($key+1)."</td>
		<td width=\"400\">$row[name] (�������: $row[model_article])</td>
		<td>��.</td>
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
	$rv.= "  <tr><td colspan=\"5\"><div align=\"right\">������</div></td><td>$has_discount%</td></tr>";
	$mass_i[1] = $mass_i[1] - $mass_i[1] / 100 * $has_discount;
}
$rv.= "  <tr>
    <td colspan=\"5\"><div align=\"right\">�����</div></td>
    <td>$mass_i[1]</td>
  </tr>
</table>
<br>
<br>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr><td>
����� �� �����:<br>
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