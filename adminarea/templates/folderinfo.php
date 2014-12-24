<?
$inlimit = " limit ".($page*$limit-$limit).",$limit";
//****************************************
if($id!="recc" && $id!="users" && $id!="orders"){
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
if($id=="users"){
	$rowpp["name"] = "Список пользователей";
}
if($id=="orders"){
	$rowpp["name"] = "Список заказов";
}
//echo "<pre>"; print_r($rowpp); echo "</pre>";
?>
<div class="folders_all">
Просмотр группы
<h1 id="folders_title"><?  echo $rowpp["name"]; ?></h1><?
	if($id!="recc" && $id!="users" && $id!="orders"){
		$query = "select * from items where parent=$rowpp[id] && recc!=1 && tmp!=1 && folder=0  ";
	} elseif($id=="users") {
		if($search_fio){
			$query = "select * from users WHERE `fio` like('%$search_fio%') ";
		}elseif($search_email){
			$query = "select * from users WHERE `email` like('%$search_email%') ";
		}else{
			$query = "select id from users  ";
		}
	} elseif($id=="orders") {
		if($prefix) {
			$str = " && orderStatus='$prefix'  ";
		}
		$query = "select id from orders where orderStatus!='0'  $str  ";
		//echo $query."------------------------------------------";
	} else {
		$query = "select * from items where recc=1 && tmp!=1  ";
	}
	//echo "query=".$query."<br/>\n";
	$resp = mysql_query($query);
	$itemsCount = mysql_num_rows($resp);
?><div id="folders_count_items">Элементов: <?  echo mysql_num_rows($resp); ?></div>
<div id="all_show_items" style="margin-top:20px;"></div>
</div>
<?  /*
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="itemstable">
  <tr><?  $eltype = get_item_type($rowpp["id"]); 
												$respeltype = mysql_query("select * from itemstypes where id=$eltype");
												$roweltype = mysql_fetch_assoc($respeltype);?>
												
    <th width="20">&nbsp;</th>
    <?  if($roweltype["name"] == "items"){ ?><th width="30">Код</th>
	<th width="30">Артикул</th>
	<th width="30">P/N</th><?  } ?>
	<th width="30">Фото</th>
    <th width="450"  id="myitemname">Название</th>
    <th>Приоритет</th>
    <th>&nbsp;</th>
  </tr>
  */ ?>
<!--<div id="accordion" style="width:650px;">-->
<? 
$eltype = get_item_type($rowpp["id"]); 
$respeltype = mysql_query("select * from itemstypes where id=$eltype");
$roweltype = mysql_fetch_assoc($respeltype);
//************************************
//echo "ID=$id";
if($id!="recc" && $id!="users" && $id!="orders"){
	if($roweltype["name"] == "orders" || $roweltype["name"] == "alisagoo"){
		$resp = mysql_query("select * from items where parent=$id && folder=0  && tmp!=1 && recc!=1 order by id desc");
	} else {
		if($search_name){
			$tmpsearch = " && name like('%$search_name%') ";
		}
		$query1 = "select * from items where parent=$id && folder=0  && tmp!=1 && recc!=1 $tmpsearch order by prior asc, name asc";
		$resp = mysql_query(  $query1  );
	}
} elseif($id=="users") {
	if($search_fio){
		$resp = mysql_query("select * from users WHERE `fio` like('%$search_fio%')  order by reg desc, count_zak desc, id desc $inlimit ");
	}elseif($search_email){
		$resp = mysql_query("select * from users WHERE `email` like('%$search_email%')  order by reg desc, count_zak desc, id desc $inlimit ");
	}else{
		$resp = mysql_query("select * from users order by reg desc, count_zak desc, id desc $inlimit ");
	}
} elseif($id=="orders") {
	if($prefix!="") {
		$str = " && orderStatus='$prefix'  ";
	}
	$query = "select * from orders where orderStatus!='0' $str order by addDate DESC $inlimit ";
	//echo $query;
	$resp = mysql_query($query);
} else {
	$resp = mysql_query("select * from items where tmp!=1 && recc=1 order by prior asc, name asc");
}
//echo "<div id=\"div_myitemname\">test test</div>";
if($roweltype["name"] != "orders" && $id!="orders" && $id!="users"){
	echo "<div class=\"ui-widget\">";
	echo "<input id=\"fast_search_items\" disabled=\"disabled\" ";
	if(  $search_name  )  echo "  value=\"$search_name\" ";
	echo " style=\"background-color: #CCCCCC;\"  />";
	echo "<a href=\"javascript:init_search_after_ajax_button()\" 
	style=\"font-size:12px;color: #000000;background-color: #FFFFFF;text-decoration: none;\"><b>Найти</b></a>";
	echo "</div>";
}
if($id=="users"){
	echo "<div class=\"ui-widget\" style=\"float:left;width:150px;padding-top:20px;\" >";
	echo "<button style=\"margin-top:2px;\" onClick=\"start_users_search()\" />";
	echo "<strong>Включить поиск</strong></button>";
	echo "</div>";
	echo "<div class=\"ui-widget\" style=\"float:left;width:300px;\" >";
	echo "<strong>Пользователь</strong><br>";
	echo "<input id=\"fast_search_users\" disabled=\"disabled\" ";
	if(  $search_fio  )  echo "  value=\"$search_fio\" ";
	echo " style=\"background-color: #CCCCCC;width:200px;margin-top:3px;\"  />";
	echo "<a href=\"javascript:init_search_users_after_ajax_button()\" 
	style=\"font-size:12px;color: #000000;background-color: #FFFFFF;text-decoration: none;\"><b>Найти</b></a>";
	echo "</div>";
	echo "<div class=\"ui-widget\" style=\"float:left;width:300px;\" >";
	echo "<strong>E-mail</strong><br>";
	echo "<input id=\"fast_search_email\" disabled=\"disabled\" ";
	if(  $search_email  )  echo "  value=\"$search_email\" ";
	echo " style=\"background-color: #CCCCCC;width:200px;margin-top:3px;\" />";
	echo "<a href=\"javascript:init_search_email_after_ajax_button()\" 
	style=\"font-size:12px;color: #000000;background-color: #FFFFFF;text-decoration: none;\"><b>Найти</b></a>";
	echo "</div>";
	echo "<div style=\"float:none;clear:both;\">";
}
echo "<div class=\"ui-state-default-3\" id=\"myitems_sortable\">";

if($id=="users"){
		$ret .= "<div id=\"div_myitemname_$row[id]\" class=\"div_myitemname\" >";
			$ret .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">";
				$ret .= "<tr>";
					//**************************************
					//$ret .= "<td width=\"22\">";
					//	$ret .= "&nbsp;";
					//$ret .= "</td>";
					//**************************************
					//$ret .= "<td width=\"22\">";
					//	$ret .= "&nbsp;";
					//$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						$ret .= "&nbsp;";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td  height=\"35\" width=\"250\">";
						$ret .= "Имя пользователя";
						$ret .= "";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"70\" align=\"center\" >";
						$ret .= "Пароль";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"130\" align=\"center\" >";
						$ret .= "На сайте от";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"70\" align=\"center\" >";
						$ret .= "Заказы";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"70\" align=\"center\" >";
						$ret .= "Сумма";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"70\" align=\"center\" >";
						$ret .= "Скидка";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"\">";
						$ret .= "&nbsp;";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						$ret .= "";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						$ret .= "";
					$ret .= "</td>";
					//**************************************
				$ret .= "</tr>";
			$ret .= "</table>";
		$ret .= "</div>";
	echo $ret;
	//*********************************************************************************************
	while($row=mysql_fetch_assoc($resp)){
		echo "<div  class=\"ui-state-default-2 connectedSortable\" id=\"prm_$row[id]\">";
		echo __ff_reload_single_user( $row["id"] );
		echo "</div>";
	}
	echo "<div id=\"pagination\" style=\"background-color:#FFFFFF;height:30px;\" >";
	echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" height=\"30\"><tr>";
	echo "<td style=\"padding-left: 32px;\" >";
	//********** PAGINATION
	$limit = $limit;
	$pagesShow = 6;
	$link = "javascript:show_ritems('users', %page%)";
	$paginationArray = array(
		"count" => $itemsCount,
		"onPage" => $limit,
		"page" => $page,
		"pagesShow" => "6",
		"link" => $link,
		"sizeCount" => 3,
		"url" => false,
		"maskActive" => "<span style=\"color: red;\"><b>[%page%]</b></span>&nbsp;&nbsp;",
		"mask" => "<b><a href=\"%link%\" style=\"text-decoration:none;\">[%page%]</a></b>&nbsp;&nbsp;"
	);
	//print_r($paginationArray);
	$pagination = getPagination($paginationArray);
	echo $pagination;
	//*********************
	echo "</td></tr></table></div>";
}

if($id=="orders"){
		//$ret .= "<div class=\"ui-state-default-3\" id=\"myitems_sortable\" style=\"margin-bottom\">";
		$ret .= "<div class=\"div_myitemname\" >";
			$ret .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" height=\"30\">";
			$ret .= "<tr>";
			$respOrderHeader = mysql_query("select * from items where parent=0 && href_name='ordersstatuses'   ");
			$rowOrderHeader=mysql_fetch_assoc($respOrderHeader);
			$respOrderHeader = mysql_query("select * from items where parent=$rowOrderHeader[id]  $dop_query order by prior asc  ");
			while($rowOrderHeader=mysql_fetch_assoc($respOrderHeader)){
				$ret .= "<td width=\"150\" align=\"center\" "; 
				if($rowOrderHeader["href_name"]==$prefix)
					$ret .= " class=\"orderStatusTabActive\" ";
				else
					$ret .= " class=\"orderStatusTab\" ";
				$ret .= " onClick=\"show_ritems('orders', 1, '$rowOrderHeader[href_name]')\" >$rowOrderHeader[name]</td>";
				$ret .= "<td width=\"2\"><img src=\"images/green/items_tabs_vr.gif\" /></td>";
			}
			$ret .= "<td width=\"100\" align=\"center\"><a href=\"javascript:show_ritems('orders', '$page', '')\">Все</a></td>";
			$ret .= "<td width=\"2\"><img src=\"images/green/items_tabs_vr.gif\" /></td>";
			$ret .= "<td>&nbsp;</td>";
			$ret .= "</tr></table>";
		$ret .= "</div>";
		$ret .= "</div><div class=\"ui-state-default-3\" id=\"myitems_sortable\" style=\"margin-top: 10px;\">";
		//****************************************
		$ret .= "<div id=\"div_myitemname_$row[id]\" class=\"div_myitemname\" >";
			$ret .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">";
				$ret .= "<tr>";
					//**************************************
					//$ret .= "<td width=\"22\">";
					//	$ret .= "&nbsp;";
					//$ret .= "</td>";
					//**************************************
					//$ret .= "<td width=\"22\">";
					//	$ret .= "&nbsp;";
					//$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						$ret .= "&nbsp;";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"100\"  height=\"35\">";
						$ret .= "Номер заказа";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"100\">";
						$ret .= "&nbsp;";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"250\" align=\"center\" >";
						$ret .= "Состояние";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"230\">";
						$ret .= "Пользователь";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"130\" align=\"center\">";
						$ret .= "Дата";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"100\" align=\"center\" >";
						$ret .= "Сумма";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"70\" align=\"center\" >";
						$ret .= "Скидка";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td>";
						$ret .= "&nbsp;";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						$ret .= "";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						$ret .= "";
					$ret .= "</td>";
					//**************************************
				$ret .= "</tr>";
			$ret .= "</table>";
		$ret .= "</div>";
	echo $ret;
	//*********************************************************************************************
	while($row=mysql_fetch_assoc($resp)){
		echo "<div  class=\"ui-state-default-2 connectedSortable\" id=\"prm_$row[id]\">";
		echo __ff_reload_single_order( $row["id"], $page, $prefix );
		echo "</div>";
	}
	//********** PAGINATION
	echo "<div id=\"pagination\" style=\"background-color:#FFFFFF;height:30px;\" >";
	echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" height=\"30\"><tr>";
	echo "<td style=\"padding-left: 32px;\" >";
	$limit = $limit;
	$pagesShow = 6;
	$link = "javascript:show_ritems( 'orders', '%page%', '$prefix' )";
	$paginationArray = array(
		"count" => $itemsCount,
		"onPage" => $limit,
		"page" => $page,
		"pagesShow" => "6",
		"link" => $link,
		"sizeCount" => 3,
		"url" => false,
		"maskActive" => "<span style=\"color: red;\"><b>[%page%]</b></span>&nbsp;&nbsp;",
		"mask" => "<b><a href=\"%link%\" style=\"text-decoration:none;\">[%page%]</a></b>&nbsp;&nbsp;"
	);
	//print_r($paginationArray);
	$pagination = getPagination($paginationArray);
	echo $pagination;
	echo "</td></tr></table></div>";
	//*********************
	echo "<div id=\"show_myitemblock_bg\" style=\"display:none\"></div>";
	echo "<div id=\"show_myitemblock_cont\" style=\"display:none\">Загрузка...</div>";
	echo "<div id=\"show_myitemblock_close\" style=\"display:none\"></div>";
	echo "<form action='link' id='downloadForm' target='_self' style=\"display:none\"></form>";
	exit;
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



//echo" <tr id=\"tr_item_s_$row[id]\">
//    <td><input type=\"checkbox\" id=\"items_cb_$row[id]\"></td>";
//	if($roweltype["name"] == "items"){
//		echo "<td>$row[item_code]</td>
//		<td>$row[item_art]</td>
//		<td>$row[item_psevdoart]</td>";
//	}
//    echo "<td><img src=\"../imgres.php?resize=200&link=loadimages/$rowi[link]\" width=\"28\" height=\"21\" class=\"imggal\"></td>
//    <td id=\"item_name_$row[id]\"><font ";
//	if($row["page_show"]==0){
//		echo "color='#999999'";
//	} elseif($row["hot_item"]==1){
//		echo "color='#FF0000'";
//	}

		//$eltype = get_item_type($rowpp["id"]); 
		//$respeltype = mysql_query("select * from itemstypes where id=$eltype");
		//$roweltype = mysql_fetch_assoc($respeltype);

		echo "<div  class=\"ui-state-default-2 connectedSortable\" id=\"prm_$row[id]\">";
		echo __ff_reload_single_item( $row["id"] );
		echo "</div>";
//	echo ">$row[name]</td>
//    <td>$row[prior]</td>
//    <td>";
//	if($id=="recc") { 
//		echo "<a href=\"javascript:resc_item($row[id])\"><img src=\"images/green/__top_resc.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";
//	} else {
//		echo "<a href=\"javascript:getiteminfo($row[id])\"><img src=\"images/green/__top_edit.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";
//	}
	
	//if($id=="recc") { 
	//	echo "<a href=\"javascript:delete_item_form_recc($row[id])\"><img src=\"images/green/__top_delete.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";
	//} else {
	//	echo "<a href=\"javascript:delete_item($row[id])\"><img src=\"images/green/__top_delete.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";
	//}
		//echo "</td></tr><tr id=\"tr_item_$row[id]\" style=\"display:none;\"><td id=\"td_item_$row[id]\" colspan=8>test</td></tr>";
}
echo "</div>";
echo "<div class=\"asdqwe\" style=\"padding-left:20px;padding-top:5px;font-weight:bold;\">
<img src=\"images/green/myitemname_popup/select_all_arrow.gif\" align=\"absmiddle\" /> 
<a href=\"javascript:items_select_all()\" style=\"color:#2E4933;\">Отметить все</a> / 
<a href=\"javascript:items_deselect_all()\" style=\"color:#2E4933;\">Снять отметки</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Отмеченные: 
<a href=\"javascript:delete_select_items()\" style=\"color:#B90000;\">Удалить</a></div>";
if($id=='0'){ ?>
	<br/><br/><b style="font-size:14px;">Основные настройки</b>
	<div id="adminGlobalSettings"><table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<?  $restrResp = mysql_query("select * from pages where name='rests' ");
			$restsRow = mysql_fetch_assoc($restrResp); 
			//print_r($restsRow); ?>
			<td class="tdGlobalSettings" width="300">Включить/выключить учет остатков на складе</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="restsOnOff_id" onclick="restsOnOff()" <? if($restsRow['cont']=='1') echo " checked "; ?> /></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<?  $restrResp = mysql_query("select * from pages where name='rec' ");
			$restsRow = mysql_fetch_assoc($restrResp); 
			//print_r($restsRow); ?>
			<td class="tdGlobalSettings" width="300">Ваш е-mail для уведомлений</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;" value="<?=$restsRow['cont']?>" id="updateSiteSettingsEmail" /></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsEmail()">ok</a></td>
		</tr>
		<tr>
			<?  $restrResp = mysql_query("select * from pages where name='phone' ");
			$restsRow = mysql_fetch_assoc($restrResp); 
			//print_r($restsRow); ?>
			<td class="tdGlobalSettings" width="300">Ваш контактный телефон</td>
			<td class="tdGlobalSettings" width=""><input type="text" style="width: 200px;" value="<?=$restsRow['cont']?>" id="updateSiteSettingsPhone" /></td>
			<td class="tdGlobalSettings"><a href="javascript:updateSiteSettingsPhone()">ok</a></td>
		</tr>
		<tr>
			<?  $restrResp = mysql_query("select * from pages where name='phone' ");
			$restsRow = mysql_fetch_assoc($restrResp); 
			//print_r($restsRow); ?>
			<td class="tdGlobalSettings" width="300">Тело счета</td>
			<td class="tdGlobalSettings" width=""><a href="javascript:get_fast_order_cont()">Изменить</a></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
		<tr>
			<?  $restrResp = mysql_query("select * from pages where name='offert' ");
			$restsRow = mysql_fetch_assoc($restrResp); 
			//print_r($restsRow); ?>
			<td class="tdGlobalSettings" width="300">Активировать пользовательское соглашение</td>
			<td class="tdGlobalSettings" width=""><input type="checkbox" id="offertOnOff_id" onclick="offertOnOff()" <? if($restsRow['cont']=='1') echo " checked "; ?> /> <a href="javascript:get_fast_offert_cont()">Изменить</a></td>
			<td class="tdGlobalSettings">&nbsp;</td>
		</tr>
	</table></div>
<? } ?>
<script>
my_search_items = "qwerty";
//alert("qaz");
</script>
<div id="show_myitemblock_bg" style="display:none"></div>
<div id="show_myitemblock_cont" style="display:none">Загрузка...</div>
<div id="show_myitemblock_close" style="display:none"></div>
<!--</div>-->
</table>
<? if($id=="recc") {  ?>
<a href="javascript:delete_item_recc()">Очистить корзину</a>
<?  } ?>
<script>

</script>