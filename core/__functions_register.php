<?
function __fr_fix_errors($errors, $type){
	//if($error==4) echo "<font color=red>* ������� ���</font>";
	if($type=="useremail" && $errors["useremail"]==1) echo "<font color=red>* ������� e-mail</font>";
	if($type=="useremail2" && $errors["useremail2"]==1) echo "<font color=red>* e-mail ��� ����� ���������������</font>";

}
//************************************
function __fr_send_registration(){
	
}
//************************************
function __fr_test_login($login){
		if(!preg_match("/^[a-zA-Z0-9_]+$/", $login))
			return "���/������ ������������ ������ � ������������ �������, ����������� a-z, 0-9 � ���� �������������";
		else
			return false;
}
//************************************
function __fr_test_pass($login){
		if(!preg_match("/^[a-zA-Z0-9_]+$/", $login))
			return "������ ������������ ����� � ������������ �������, ����������� a-z, 0-9 � ���� �������������";
		else
			return "";
}
//************************************
function __fr_genpassword(){
	$mass[] = "a";
	$mass[] = "b";
	$mass[] = "c";
	$mass[] = "d";
	$mass[] = "e";
	$mass[] = "f";
	$mass[] = "g";
	$mass[] = "h";
	$mass[] = "i";
	$mass[] = "j";
	$mass[] = "k";
	$mass[] = "l";
	$mass[] = "m";
	$mass[] = "n";
	$mass[] = "o";
	$mass[] = "p";
	$mass[] = "q";
	$mass[] = "r";
	$mass[] = "s";
	$mass[] = "t";
	$mass[] = "u";
	$mass[] = "v";
	$mass[] = "w";
	$mass[] = "x";
	$mass[] = "y";
	$mass[] = "z";
	//***********
	$max = rand(10,15);
	$ret_val="";
	for($i=0; $i<$max; $i++)
		$ret_val .= $mass[rand(0,25)];
	return $ret_val;
}
//************************************
function __fr_send_password($email, $password, $to){
$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
$header.="From: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode('�������������� ������')))."?= <info@frukt-studio.biz>\r\n"; 
$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
$header.="Reply-To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode('Test')))."?= <robot@makita.in.ua>\r\n";
$header.="X-Priority: 3 (Normal)\r\n";
$header.="Message-ID: <172562218.".date("YmjHis")."@makita.in.ua\r\n";
$header.="To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode("$to")))."?= <TEST-SEND>\r\n";
$header.="Subject: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode('--> �������������� ������')))."?=\r\n";
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

������������,  $to.
---
��, ���� ���-��, ������� ��� ����� � ������
�������� ��������� ������ �� ����� 
http://www.gardena-shop.com.ua - ������� ������� Gardena

��� ����� ������: $password";
//*
$smtp_conn = fsockopen("mail.makita.in.ua", 25,$errno, $errstr, 10);
if(!$smtp_conn) {print "���������� � �������� �� ������"; fclose($smtp_conn); $stop_send = true;}
if(!$stop_send){
$data = get_data($smtp_conn);
fputs($smtp_conn,"EHLO makita.in.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "������ ���������� EHLO"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"AUTH LOGIN\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "������ �� �������� ������ �����������"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("robot@makita.in.ua")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "������ ������� � ������ �����"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,base64_encode("hwe56v3hKHed5y")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 235) {print "�� ���������� ������"; fclose($smtp_conn); $stop_send = true;}
}

if(!$stop_send){
fputs($smtp_conn,"MAIL FROM:robot@makita.in.ua\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "������ ������� � ������� MAIL FROM"; fclose($smtp_conn); $stop_send = true;}
}

//echo "to - ".$pos_info["cont"]."<br/\n>";
if(!$stop_send){
fputs($smtp_conn,"RCPT TO: $email\r\n");
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
//if($code != 250) {
		//print "������ �������� ������"; 
		fclose($smtp_conn); }
}
//************************************
?>