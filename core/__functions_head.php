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
//fputs($smtp_conn,base64_encode("njr48KJeU&Y89lkg")."\r\n");
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
fputs($smtp_conn,"RCPT TO: ".$to."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250 AND $code != 251) {print "������ �� ������ ������� RCPT TO (".$to.")"; fclose($smtp_conn); $stop_send = true;}
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
function __fp_post_zakaz($user){
$resp = mysql_query("select * from pages where name='rec'  ");
$pos_info=mysql_fetch_assoc($resp);

$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
$header.="From: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$user[fio]")))."?= <$user[email]>\r\n"; 
$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
$header.="Reply-To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$user[fio]")))."?= <$user[email]>\r\n";
$header.="X-Priority: 3 (Normal)\r\n";
$header.="Message-ID: <172562218.".date("YmjHis")."@gardena-shop.com.ua\r\n";
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
����� ��������: $user[place]

����� ";

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
			$text.= "�$num_zak\n";
			$text.= "\n+------------------------------------------------------------------------------------------------------+\n";
				$resp = mysql_query("select * from items where id=$val[0]");
				$row = mysql_fetch_assoc($resp);
				$text.= "������������: ".html_entity_decode($row["name"])."\n";
				$text.= "   �������: ".$row["model_article"]."\n";
				$text.= "   ����: ".__format_txt_price_format($row["model_price"])."\n";
				$text.= "   ����������: ".$val[1]."\n";
				$st = eregi_replace(",", ".", __format_txt_price_format($row["model_price"]));
				$st = $st * $val[1];
				$text.= "   ���������: ".__format_txt_price_format($st)."\n";
				$itogo += $st;
				$to_zakaz .= "model=$row[id]=$row[model_price]=$val[1]=$st\n";
				$not_send = false;
			}
			if($not_send) {  
				header("Location: recycler.php"); 
				return false;
			}
			$text.= "\n+------------------------------------------------------------------------------------------------------+\n";
			$text.="\n�����: ".__format_txt_price_format($itogo);
			$to_zakaz .= "itogo=$itogo";

$text.="";

$smtp_conn = fsockopen("mail.gardena-shop.com.ua", 25,$errno, $errstr, 10);
if(!$smtp_conn) {print "���������� � �������� �� ������"; fclose($smtp_conn); $stop_send = true;}
if(!$stop_send){
$data = get_data($smtp_conn);
fputs($smtp_conn,"EHLO gardena-shop.com.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "������ ���������� EHLO"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"AUTH LOGIN\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "������ �� �������� ������ �����������"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("robot@gardena-shop.com.ua")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "������ ������� � ������ �����"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("njr48KJeU&Y89lkg")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 235) {print "�� ���������� ������"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"MAIL FROM:robot@gardena-shop.com.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "������ ������� � ������� MAIL FROM"; fclose($smtp_conn); $stop_send = true;}
}

//echo "to - ".$pos_info["cont"]."<br/\n>";
if(!$stop_send){
fputs($smtp_conn,"RCPT TO: $pos_info[cont]\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250 AND $code != 251) {print "������ �� ������ ������� RCPT TO"; fclose($smtp_conn); $stop_send = true;}
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
		//__fpost_send_mail("���� �������", $user["email"], $user["fio"], "info@gardena-shop.com.ua", "���� �� ������ ������", 
		//$cont, "gardena-shop.com.ua", "robot@gardena-shop.com.ua", "njr48KJeU&Y89lkg", 1 );
		
		$cont = "<html><head></head>
		<style>
		td{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333333;
		}
		</style>
		<body>".__fpost_zakaz_html($num_zak)."</body></html>";
		__fpost_send_mail("���� �������", $user["email"], $user["fio"], "robot@gardena-shop.com.ua", "���� �� ������ ������", 		$cont, "gardena-shop.com.ua", "robot@gardena-shop.com.ua", "njr48KJeU&Y89lkg", 1);
		
		return "post";
	} else {
		$resp_zakaz = mysql_query("DELETE FROM zakaz WHERE id=$num_zak");
		return "fail";
	}
}
//******************************************************************
//******************************************************************
//******************************************************************
function __fpost_zakaz_html($cur_id){
	$rv = "";
	$shapka_resp = mysql_query("select * from pages where name='manage_schet'");
	$shapka_row = mysql_fetch_assoc($shapka_resp);
	$shapka = $shapka_row["cont"];
	//************
	$resp = mysql_query("select * from zakaz where id=$cur_id");
	$row = mysql_fetch_assoc($resp);
	$mod_mass=false;
	$mass = explode("\n", $row["cont"]);
	$mass_user = explode("=",$mass[0]);
	$user = $mass_user[1];
	$resp_user = mysql_query("select * from users where id=$user");
	$row_user = mysql_fetch_assoc($resp_user);
	for($i=2; $i<count($mass)-1; $i++)
		$mod_mass[]=explode("=", $mass[$i]);

	$rv .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr>
    		<td width=\"150\" height=\"30\"><strong>���������</strong></td>
    		<td>$shapka</td>
  		</tr>
		<tr>
			<td width=\"150\" height=\"30\"><strong>����������</strong></td>
			<td>$row_user[fio]<br/>���. $row_user[phone]</td>
		</tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>����������</strong></td>
    <td>�����</td>
  </tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>�����</strong></td>
    <td>��� ������ </td>
  </tr>
  <tr>
    <td width=\"150\" height=\"30\"><strong>������� ������� </strong></td>
    <td>������ ����� ���� </td>
  </tr>
  <tr>
    <td colspan=2><font color=red><b>����� ������� ���� �������� ������� ������ � ��������</b></font></td>
  </tr>
</table>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  		<tr><td>
<div align=\"center\"><strong>���� �".strftime("%d-%m-%Y", $row["adddate"])."-".$row["id"]."<br/>
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

foreach($mod_mass as $key=>$val) {
$resp = mysql_query("select * from items where id=$val[1]");
$row=mysql_fetch_assoc($resp);

  $rv .= "<tr>
    <td width=\"40\">".($key+1)."</td>
    <td width=\"400\">$row[name] (�������: $row[model_article])</td>
    <td>��.</td>
    <td>$val[3]</td>
    <td>$val[2]</td>
    <td>$val[4]</td>
  </tr>";
}
$mass_i = explode("=",$mass[count($mass)-1]);
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