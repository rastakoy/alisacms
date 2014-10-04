<?

if(!$adres) $adres = $_GET["adres"];
$adres = eregi_replace("http://", "", $adres);
if(!$site) $site = $_GET["site"];


$file = "http://$adres";

$a=0;
$str = "";
for($i=0; $i<strlen($file); $i++){
	if(substr($file, $i, 1) == "/"){
		$a++;
	}
	$str .= substr($file, $i, 1);
	if($a==2)
		$site = $str;
}

$site = preg_replace("/http:\/\//", "", $site);
//echo $site;
//echo $file;

$lines = file($file);
//$site = "vseinstrumenti.ru";

$is_body = false;

foreach($lines as $key=>$val){
	if(ereg("<body", $val)) {
		$is_body=true;
		echo "\n<link href=\"styles/grabber.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
	}
	//eregi
	$src="";
	$sc = false;
	$href = "";
	$hc = false;
	for($i=0; $i<strlen($val); $i++){
		
		//echo  substr($val, $i, 5)."<br/>\n";
		if(substr($val, $i, 5) == "src=\""){
			$sc = $i+5;
			//echo "sov<br/>\n";
		}
		if($sc && substr($val, $i, 1) == "\"" && $i>$sc+7){
			$src = substr($val, $sc, $i-$sc);
			$sc=false;
			//echo "end sov<br/>\n";
		}
	}
	
	//$val = eregi_replace("www.", "", $val);
	
	for($i=0; $i<strlen($val); $i++){
		
		//echo  substr($val, $i, 6)."<br/>\n";
		if(substr($val, $i, 6) == "href=\""){
			$hc = $i+6;
			//echo "sov_href<br/>\n";
		}
		if($hc && substr($val, $i, 1) == "\"" && $i>$hc){
			$href = substr($val, $hc, $i-$hc);
			$hc=false;
			//echo "end sov_href<br/>\n";
		}
	}
	for($i=0; $i<strlen($val); $i++){
		
		//echo  substr($val, $i, 6)."<br/>\n";
		if(substr($val, $i, 6) == "href='"){
			$hc = $i+6;
			//echo "sov_href<br/>\n";
		}
		if($hc && substr($val, $i, 1) == "'" && $i>$hc){
			$href = substr($val, $hc, $i-$hc);
			$hc=false;
			//echo "end sov_href<br/>\n";
		}
	}
	//if($src!="") echo $src."<br/>\n";
	
	
	
	if($src!=""){
		//echo $src."<br/>\n";
		if(!ereg($site, $src)){
			$new_src = "http://".$site.$src;
			$val = eregi_replace($src, $new_src, $val);
			//echo "new src = ".$new_src."<br/>\n";
		}
	} 
	
	if($href!="" && $is_body){
	//echo "href=".$href."<br/>\n";
		if(!ereg($site, $href)){
			
			//$new_href="virus.php?addres=http://$site/$href&site=$site";
			//$val = eregi_replace($href, $new_href, $val);
			//echo "new_href=".$new_href."<br/>\n";
		}
		if(ereg($site, $href)){
			//echo "href=".$href."<br/>\n";
			//$new_href = eregi_replace("http://", "", $href);
			//$new_href = eregi_replace("www.", "", $new_href);
			//$new_href = "virus.php?adres=$new_href&site=$site";
			//echo "new_href=".$new_href."<br/>\n";
			//$new_href = "virus.php";
			//$val = eregi_replace($href, $new_href, $val);
			//echo $val;
			//$val = eregi_replace($href, $new_href, $val);
			//echo $new_href."<br/>\n";
		} //else {
			//$new_href = eregi_replace($href, "".$href)
		//}
		
	} 
	
	
	//$val = eregi_replace("http://$site", "virus.php", $val);
	//$val = eregi_replace
	echo iconv("UTF-8", "CP1251", $val);
	
}
require_once("__catch_pizd.php");
?>