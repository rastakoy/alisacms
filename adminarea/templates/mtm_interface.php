<table width="100%">
  <tr><td width="420" valign="top" background="images/green/test_background.gif"><div style="overflow:hidden; width:380px; margin:10px; background-color:#CCCCCC; padding: 10px;">
<div id="mtm_v2_all"><?
require_once("../core/__functions_mtm.php");
$resp = mysql_query("select * from items where id=$pid");
$row=mysql_fetch_assoc($resp);
$my_filter = __mtm_has_mtm($row["id"]);
if($my_filter){
	//**************************************************
	$query_filter = "select * from items where id=$my_filter   ";
	$resp_filt = mysql_query($query_filter);
	$row_filt = mysql_fetch_assoc($resp_filt);
	//**************************************************
	$fresp_nn = mysql_query("select * from mtm_filter where id=$row_filt[mtm] ");
	$frow_nn = mysql_fetch_assoc($fresp_nn);
	//**************************************************
	$mtm_resp = mysql_query("select * from mtm_filter where parent=$row_filt[mtm] order by prior asc ");
	echo "<script>\$(\"#mtm_v2_all\").css(\"width\", \"".(mysql_num_rows($mtm_resp)*400+50)."\")</script>";
	$level = "0";
	$level_way = "";
	while($row_level = mysql_fetch_assoc($mtm_resp)){
		echo "<div id=\"mtm_level_$level\" style=\"background-color: $row_level[fbg];\" ";
		echo "class=\"mtm_v2_level\" >";
		echo "<b id=\"mtm_ftitle_$row_level[id]\">$row_level[name]</b>";
		if($level>0) {
			$rv .= "&nbsp;&nbsp;&nbsp;<a href=\"javascript:mtm_hide_level";
			$rv .= "(0, ".($level-1).", $row[id], this, '$smlevel_way')\">Назад</a>";
		}
		echo "<br/><br/>";
		$mtm_temp = explode("\n", $row_level["cont"]);
		foreach($mtm_temp as $key=>$val){
			$val = trim($val);
			echo "<span class=\"span_mtm\" style=\"$row_level[fstyle]\"  id=\"smw-$smlevel_way$key:$level-\"  ";
			echo "onClick=\"load_mtm($key, ".($level+1).", $row[id], this, this.id.replace(/smw-/gi , ''))\" >";  
			$a = __mtm_test_item_in_row("$smlevel_way$key:$level-", $row["mtm_cont"], $level);
			echo "<input type=\"checkbox\" style=\"float:;\" ";
			if($a)  echo "  checked  ";
			echo "onClick=\"set_mtm($key, $level, $row[id], this, '$smlevel_way$key:$level-')\"  ";
			echo "id=\"smlw-$smlevel_way$key:$level-\"  ";
			echo "/> $val</span>";
		}
		echo "</div>\n\n";
		if($level==0){
			$fname = $row_level["name"];
			$fstyle = $row_level["fstyle"];
			$fbgs = $row_level["fbg"];
			$mtm_cont = $row_level["cont"];
			$rlid = $row_level["id"];
		}
		$level++;
	}
}
?></div></div></td>
<td valign="top" background="images/green/test_background.gif" style="padding:10px;">
<strong>Выберите фильтр&nbsp;&nbsp;&nbsp;Создать фильтр&nbsp;&nbsp;&nbsp;Удалить фильтр</strong>
<br/><br/><strong>
<a href="javascript:mtm_add_level()" id="mtm_add_level_a">Добавить подуровень</a>&nbsp;&nbsp;&nbsp;
<a href="javascript:mtm_del_level()" id="mtm_del_level_a">Удалить подуровень</a></strong>
<br/>
<br/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top"><strong><strong>Название группы</strong><br/>
        <input name="mtm_fname" type="text" id="mtm_fname" value="<?  echo $fname; ?>" />
        <a href="javascript:save_mtm_name()"><strong>Ок</strong></a> <br />
        <br />
        Ширина столбца</strong><br/>
      <input name="mtm_fstyle" type="text" id="mtm_fstyle"  value="<?  echo $fstyle; ?>" />
      <a href="javascript:save_mtm_style()"><strong>Ок</strong></a>
	   <br /><br />
        <strong>Цвет фона</strong></strong><br/>
      <input name="mtm_fbg" type="text" id="mtm_fbg"  value="<?  echo $fbgs; ?>"  />
      <a href="javascript:save_mtm_bg()"><strong>Ок</strong></a></td>
    <td valign="top"><strong><strong>Содержимое</strong></strong><br />
      <textarea name="mtm_cont" id="mtm_cont"cols="20" rows="20" style="float:left;"><?  echo $mtm_cont; ?></textarea>
	  <div style="float:left; width: 200px; height:300px; background-color:#FFCC99;"></div><br/>
	  <a href="javascript:save_mtm_cont()"><strong>Ок</strong></a></td>
  </tr>
</table>
<br/><br/></td>
</tr></table>
<script>
var all_mtm_level_id = <?  echo $rlid; ?>;
//alert(all_mtm_level_id);
</script>