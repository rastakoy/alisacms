<?
if($id!="recc"){
	$query = "select * from items where id=$id ";
	//echo $query;
	$resppp = mysql_query($query);
	$rowpp = mysql_fetch_assoc($resppp);
	
	if($rowpp["name"]=="" || !$rowpp["name"]) 
		$rowpp["name"] = "Корневая директория";
	
	if(!$rowpp["id"]) 
		$rowpp["id"] = "0";
} 

if($id=="recc"){
	$rowpp["name"] = "Корзина";
}
//echo "<pre>"; print_r($rowpp); echo "</pre>";
?>
<div class="folders_all">
Просмотр директории
<h1 id="folders_title">Новости</h1><?
	if($id!="recc"){
		$query = "select * from items where parent=$rowpp[id] && recc!=1 && tmp!=1 && folder=0  ";
	} else {
		$query = "select * from items where recc=1 && tmp!=1  ";
	}
	//echo $query."<br/>\n";
	$resp = mysql_query($query);
?><div id="folders_count_items">Элементов: <?  echo mysql_num_rows($resp); ?></div>
<div id="all_show_items" style="margin-top:20px;"></div>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="itemstable">
  <tr>
    <th width="20">&nbsp;</th>
    <th width="30">Фото</th>
    <th width="450">Название</th>
    <th>Приоритет</th>
    <th>&nbsp;</th>
  </tr>
<!--<div id="accordion" style="width:650px;">-->
<? 
if($id!="recc"){
	$resp = mysql_query("select * from items where parent=$id && folder=0  && tmp!=1 && recc!=1 order by prior asc, name asc");
} else {
	$resp = mysql_query("select * from items where tmp!=1 && recc=1 order by prior asc, name asc");
}
while($row=mysql_fetch_assoc($resp)){
$respi = mysql_query("select * from images where parent=$row[id] order by prior asc limit 0,1");
$rowi = mysql_fetch_assoc($respi);
$img = $rowi["link"];

//echo "<div>
//		<h4 id=\"item_h4_$row[id]\" onClick=\"return false\"><a href=\"\">$row[name]</a></h4>
//		<div id=\"item_div_$row[id]\" style=\"height:300px;\">
//			<p>Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.</p>
//		</div>
//	</div>";



echo" <tr id=\"tr_item_s_$row[id]\">
    <td><input type=\"checkbox\" id=\"items_cb_$row[id]\"></td>
    <td><img src=\"../imgres.php?resize=200&link=loadimages/$rowi[link]\" width=\"28\" height=\"21\" class=\"imggal\"></td>
    <td id=\"item_name_$row[id]\">$row[name]</td>
    <td>$row[prior]</td>
    <td>";
	if($id=="recc") { 
		echo "<a href=\"javascript:resc_item($row[id])\"><img src=\"images/green/__top_resc.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";
	} else {
		echo "<a href=\"javascript:getiteminfo($row[id])\"><img src=\"images/green/__top_edit.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";
	}
	echo "<a href=\"javascript:delete_item($row[id])\"><img src=\"images/green/__top_delete.gif\" width=\"16\" height=\"16\" border=\"0\"></a></td>
  </tr><tr id=\"tr_item_$row[id]\" style=\"display:none;\"><td id=\"td_item_$row[id]\" colspan=5>test</td></tr>";
}
 ?>
<!--</div>-->
</table>
<? if($id=="recc") {  ?>
<a href="javascript:delete_item_recc()">Очистить корзину</a>
<?  } ?>
