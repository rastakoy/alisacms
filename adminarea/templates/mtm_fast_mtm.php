<table width="100%">
<?
$resp = mysql_query("select * from items where id=$pid");
$row=mysql_fetch_assoc($resp);
$my_filter = __mtm_has_mtm($row["id"]);
if($my_filter){
	echo "\n<tr><td align=\"left\" style=\"height:60px; line-height:28px;\">";
	//**************************************************
	$query_filter = "select * from items where id=$my_filter   ";
	//echo $query_filter;
	$resp_filt = mysql_query($query_filter);
	$row_filt = mysql_fetch_assoc($resp_filt);
	//print_r($row_filt);
	
	$fresp_nn = mysql_query("select * from mtm_filter where id=$row_filt[mtm] ");
	$frow_nn = mysql_fetch_assoc($fresp_nn);
	
	$fresp = mysql_query("select * from mtm_filter where parent=$row_filt[mtm] order by prior asc limit 0,1  ");
	$frow = mysql_fetch_assoc($fresp);
	$mass = explode("\n", $frow["cont"]);
	
	//$mtm_mass = $row["mtm_cont"];
	$mtm_temp = explode("\n", $row["mtm_cont"]);
	foreach($mtm_temp as $key=>$val){
		$tmp = explode("->", $val);
		$tmp[0] = preg_replace(  "/:/", "", trim($tmp[0])  );
		$tmp[1] = explode(",", $tmp[1]);
		foreach($tmp[1] as $k=>$v){
			//echo "v=$v<br/>";
			$v = explode("-", $v);
			$tmp[1][$k] = $v[1];
		}
		//print_r($tmp);
		$mtm_mass[$tmp[0]] = $tmp[1];
	}
	
	//echo $row["mtm_cont"];
	//print_r($mtm_mass);
	
	echo "<b>Настройка фильтра «$frow_nn[name]»:</b><br/>";
	foreach($mass as $key=>$val){
		//echo "::$val--".$mtm_mass[$val]."::";
		echo "<div id=\"dmtm_0_$key\" class=\"dmtm_div_1\"><span id=\"mtm_0_$key\" class=\"mtm_span_1\">
		<input id=\"fcb_0_$key\" type=\"checkbox\" style=\"float:;\" onClick=\"set_mtm($key, -1, $row[id], this)\" ";
		if(count($mtm_mass[$key]) > 0)  echo " checked ";
		echo "  /> $val </span>
			<div  id=\"dmtm_1_$key\" class=\"dmtm_div_2\" style=\"display:none;\">";
			//********************
			$fresp = mysql_query("select * from mtm_filter where parent=$row_filt[mtm] order by prior asc limit 1,1  ");
			$frow = mysql_fetch_assoc($fresp);
			$mass2 = explode("\n", $frow["cont"]);
			//print_r($mass2);
			foreach($mass2 as $key2=>$val2){
				//$val2 = explode("-", $val2);
				//$val2 = $val2[1];
				echo "<span class=\"span_mtm_sub\">
				<input type=\"checkbox\" style=\"float:;\"   onClick=\"set_mtm($key, $key2, $row[id], this)\"  ";
				if(count($mtm_mass[$key]) > 0) {
					foreach($mtm_mass[$key] as $k=>$v)  
						if($v==$key2 && $v!="") echo " checked ";
				}
				echo "  /> $val2</span>";
			}
			//********************
		echo"</div>
		</div>";
	}
	//print_r($frow);
	
	
	//$resp = mysql_query("select * from  ");
	echo "";
	echo "";
	//**************************************************
	echo "</td></tr>\n";
}			

?>
<!------------------------------------------------------------>
  </table>
  
<? if($my_filter) { ?>
<script>
//********
init_mtm();
</script>
<?  } ?>