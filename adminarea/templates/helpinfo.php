<div class="ui-state-default-3" id="helpcontent">
<div id="helpcontent_title"><?  echo $row["name"];  ?>
<img src="images/green/myitemname_popup/help_close.gif" align="right" style="cursor:pointer;" onclick="close_help_content()" />
</div>
<div id="helpcontent_cont">
<? 
//echo "<pre>"; print_r($_SERVER); echo "</pre>";
$cont = $row["cont"];
global $site;
$prega = "/src=\"/";
$cont = preg_replace(  $prega, "src=\"$site", $cont  );
echo $cont;
//************************************
//$mass =  __fjs_tree_to_assoc_array(  1, "items"  );
//$mass = __fjs_tree_to_assoc_array_from_keys(  1, "items", array(  "name", "href_name", "folder"  )  );
//echo "<pre>"; print_r(  $mass  ); echo "</pre>";
//$mass = __fjs_decode_data_array(  "CP1251", "UTF-8", $mass  );
//$json = json_encode(  $mass, true  );
//$json = iconv("UTF-8", "CP1251", $json);
//echo "<pre>"; echo $json; echo "</pre>";
?>
<?
$txt = "img.width = 100
img.height = 300
car.price = 340
car = mazda
car.mark = rx8
car.driver.detals.material = ferrum
car.driver.detals = metal";

function convert_str_to_associative_array(  $str, $val_container  ){
	$rmass = false;
	$mass = explode(  "\n", $str  );
	foreach(  $mass as $key=>$val  ){
		$smass = explode(  "=", $val  );
		$a = explode(  ".", $smass[0]  );
		print_r($a);
		for(  $i = 0; $i < count(  $a  ); $i++  ){
			$vals = "";
			for(  $j = 0; $j < count(  $a  ); $j++  ){
				$vals .= "[\"$a[j]\"]";
			}
			echo "vals = $vals<br/>\n";
			$vals .= "[\"".$val_container."\"]";
			$eval = "\$rmass$vals = $smass[1];\n";
			eval(  $eval  );
		}
	}
	return $rmass;
}
echo "<pre>"; print_r(  convert_str_to_associative_array(  $txt, "value"  )  ); echo "</pre>";
?>
<div style="float:none; clear:both;"></div>
</div></div>
