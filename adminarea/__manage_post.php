<?
require_once("/home/micromed/public_html/__config.php");
require_once("/home/micromed/public_html/__functions_post.php");
dbgo();
if($_GET["startsender"]){
	$respoo = mysql_query("update sender set issend=1 ");
}
//************************************************************
function __mp_sendMail($to,$from_mail,$from_name,$subject,$mess,$file_name=false) {
	$bound = "frukt-studio-biz-1234";
	$message  = "";
	
	$message .= "--$bound\n";
	$message .= "Content-type: text/html; Windows-1251  Content-Transfer-Encoding: 8bit\n\n";
	$message .= "$mess<br/>\n";
	$message .= "\n--$bound\n";
	if($file_name){
		$file=fopen($file_name,"rb");
		$message .="Content-Type: application/octet-stream;";
		$message .="name=".basename($file_name)."\n";
		$message .="Content-Transfer-Encoding:base64\n";
		$message .="Content-Disposition:attachment\n\n";
		$message .=base64_encode(fread($file,filesize($file_name)))."\n";
		$message .="$bound--\n\n";
	}
	
	//****************************
	
	$headers   =  "MIME-Version: 1.0\r\n";
	$headers  .=  "From: -->micromed.ua<office@micromed.ua>\r\n";
	$headers  .=  "Content-Type: multipart/mixed; boundary=\"$bound\"\r\n";
	
	if(mail("$to", "$subject", $message, $headers) ) {
		return "true";
	} else {
		return "false";
	}
	//****************************
}
//************************************************************
function get_data_control($smtp_conn){
	$data="";
	while($str = fgets($smtp_conn,515)) 
		$data .= $str;
	return $data;
}
//************************************************************
$resp = mysql_query("select * from news order by id desc limit 0,1");
$mass=mysql_fetch_assoc($resp);
//************************************************************
$resp = mysql_query("select * from sender  where tmp=0 && issend=1  order by id asc limit 0, 100");
//$resp = mysql_query("select * from sender  where tmp=0 && issend=1  order by id asc limit 0, 1");
//$resp = mysql_query("select * from sender where email='info@frukt-studio.biz' || email='martynov@fmt.com.ua' "); 
//************************************************************
while($row = mysql_fetch_assoc($resp)){
	$poluch = "";
	if($row["name"] == "" || $row["name"]=="0"){
		$poluch = $row["email"];
	}
	else{
		if($row["name"] != "" || $row["name"]!="0"){
			$poluch .= $row["name"];
		}else{
			$poluch = $row["email"];
		}
	}
	//******************************************
	//$row["email"] = "info@frukt-studio.biz";
	$file="../nimages/$mass[link]";
	$mtt = $mass["cont"];
	$mtt .= "\n\n<br/><br/>ФАРММЕДТЕХ-<br/>\n";
	$mtt .= "0532-633-000 (многоканальный)<br/>\n";
	$mtt .= "044-360-69-70<br/>\n";
	$mtt .= "http://www.micromed.ua<br/>\n";
	$mtt .= "E-mail: info@micromed.ua<br/>\n";
	$mtt = eregi_replace("\.\.\/", "http://www.micromed.ua/", $mtt);
	$file="../nimages/$mass[link]";
	echo __fp_sendMail_v2($row["email"], "post@micromed.ua", "Фарммедтех", "-->Рассылка новостей", $mtt, $file)."->$row[email]<br/>\n";
	$respoo = mysql_query("update sender  set issend=0 where id=$row[id] ");
	//break;
}
?>

Рассылка произведена.