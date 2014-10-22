<div id="div_filter">
<form name="form_filter" id="form_filter" action="" method="post">
<?
$query_string = $_SERVER["QUERY_STRING"];

//print_r($_SESSION);
//print_r($smass);

//$query_string = eregi_replace("&&", "&", $query_string);
//echo $query_string."<br/>";
//$query_string = eregi_replace("ma\[\]=4", "", $query_string);
//echo $query_string."<br/>";
//echo "<pre>";  print_r($_SERVER); echo "</pre>";
//echo ":::marks:::"; print_r($marks);
$query_mark = "select distinct out_mark from items where parent=$__page_row[id] ";
$resp_mark = mysql_query($query_mark);
if(mysql_num_rows($resp_mark) > 0) {
$w_mass = false;
while($row_mark=mysql_fetch_assoc($resp_mark)){
	$w_mass[] = $row_mark["out_mark"];
}
/*  ?>
<div style="border: 2px solid #811201;">
<?  echo "<pre>";  print_r($w_mass); echo "</pre>"; ?>
</div>
<div style="clear:both;"></div>
<div style="height:15px;"></div>
<?  */
}  ?>
<!--  **************************************  -->

<?

function filter_ma_unset($param, $qs){
	$param1 = "&ma\[\]=$param";
	$ret_val = eregi_replace($param1, "", $qs);
	return $ret_val;
}
//*****************
function __filter_config($id, $ma){
	if(is_array($ma)){
		//print_r($ma);
		foreach($ma as $key=>$val){
			if($val == $id){
				return true;
			}
		}
	}
	return false;
}
function __filter_config_unset($param, $qs, $name){
	$param1 = "&$name\[\]=$param";
	$ret_val = eregi_replace($param1, "", $qs);
	return $ret_val;
}
//******************************************************************
if(is_array($w_mass)) {
echo "<strong>Производитель:</strong><br/>";
	foreach($w_mass as $key => $val){
		$w_resp = mysql_query("select * from marks where id = $val");
		$w_row = mysql_fetch_assoc($w_resp);
		if($w_row["id"]){
			echo "<input type=\"checkbox\" "; if(filter_ma($w_row["id"], $marks_mass["ma"])) {
				echo " checked ";
				echo " onClick=\"window.location.href='".__fp_create_folder_way("items", $__page_row["id"], 1)."[ma=-$w_row[id]]'\" "; 
			} else {
				echo " onClick=\"window.location.href='".__fp_create_folder_way("items", $__page_row["id"], 1)."[ma=$w_row[id]]'\" "; 
			} echo">";
			if(filter_ma($w_row["id"], $marks_mass["ma"]))
				echo "<a rel=\"nofollow\" href=\"".__fp_create_folder_way("items", $__page_row["id"], 1)."[ma=-$w_row[id]]\">$w_row[name]</a><br/>";
			else
				echo "<a rel=\"nofollow\" href=\"".__fp_create_folder_way("items", $__page_row["id"], 1)."[ma=$w_row[id]]\">$w_row[name]</a><br/>";
		}
	}
}
echo "<br/><br/>";

		  //print_r($parent_mass);
		  if($row["cfg_file"]!=""){
			  $cfg_mass = __lc_find_data_from_loadconfig($row["cfg_file"], "config/".$row["cfg_file"].".cfg", 1);
			  $cfg_mass = explode(",", $cfg_mass);
			  foreach($cfg_mass as $key=>$val){  if($key != count($cfg_mass)-1) {
				  //echo $val."<br/>";
				  $mass = __lc_find_data_from_loadconfig("$val", "config/".$row["cfg_file"].".cfg", 1);  
				  $mass = explode("=", $mass);
				  foreach($mass as $k=>$v) $mass[$k]=trim($v);
				  //print_r($mass);
				  echo "<strong>".$mass[0]."</strong><br/>";
				  $s_mass = explode("~", $mass[1]);
				  foreach($s_mass as $key => $val){
					  $sw_mass = explode(":", $val);
					  echo "<input type=\"checkbox\" ";
					  if(__filter_config($sw_mass[0], $_GET[$mass[6]])){
					  		echo " checked ";
							echo " onClick=\"window.location.href='?".__filter_config_unset($sw_mass[0], $query_string, $mass[6])."'\" "; 
					  } else {
							if($page>1){
								$ere = "&page=$page";
								$query_new_string = eregi_replace($ere, "&page=1", $query_string);
								echo " onClick=\"window.location.href='?$query_new_string&".$mass[6]."[]=$sw_mass[0]'\" ";
							} else {
					  			echo " onClick=\"window.location.href='?$query_string&".$mass[6]."[]=$sw_mass[0]'\" "; 
							}
					  } echo ">";
					  //echo "<pre>";  print_r($_GET["pc"]); echo "</pre>";
					  //echo "get_mass=".$sw_mass[0]."<br/>";
					  if(__filter_config($sw_mass[0], $_GET[$mass[6]])){
					  		echo "<a rel=\"nofollow\" href=\"?".__filter_config_unset($sw_mass[0], $query_string, $mass[6])."\">".$sw_mass[1]."sd</a><br/>";
						} else {
							if($page>1){
								$ere = "&page=$page";
								$query_new_string = eregi_replace($ere, "&page=1", $query_string);
								echo "<a rel=\"nofollow\" href=\"?$query_new_string&".$mass[6]."[]=$sw_mass[0]\">".$sw_mass[1]."</a><br/>";
							} else {
								echo "<a rel=\"nofollow\" href=\"?$query_string&".$mass[6]."[]=$sw_mass[0]\">".$sw_mass[1]."</a><br/>";
							}
						}
				  }
				  echo "<br/><br/>";
			  }		}



}
echo "<a href=\"".__fp_create_folder_way("items", $__page_row["id"], 1)."[fclear=1]\">Очистить фильтр</a><br/>";
?>
</form>
<script>
function location_filter(){
	
}
</script>
</div>