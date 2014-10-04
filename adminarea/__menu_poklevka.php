<div class="menuitem"><a href="/adminarea/admin.php" class="amenu">Корневая директория</a></div>
<div id="items_left_menu" style="padding-bottom: 25px;">
<?
/*
	if($__page_parent){
		$most_show=false;
		$link_mass =  __fmt_find_item_parent_id("0", $__page_parent);
		if(count($link_mass)>1)
			for($i=count($link_mass)-1; $i>0; $i--)
				$most_show[] = $link_mass[$i];
		echo __farmmed_rekursiya_show_semantik_tree("0", 0, false, $__page_parent, 0, $most_show);
	} else {
		echo __farmmed_rekursiya_show_semantik_tree("0", 0, false, false, 0); 
	}
*/
?>
</div>	
<div class="menuitem"><a href="javascript:show_recc()" class="amenu">Корзина</a></div>
<div class="menuitem"><a href="javascript:manage_configarator()" class="amenu">Конфигуратор</a></div>
<div class="menuitem"><a href="javascript:show_filemanager_upload()" class="amenu">Загрузка прайс-листа</a></div>
<div class="menuitem"><a href="javascript:show_zakazstat()" class="amenu">Статистика заказов</a></div>
<div class="menuitem"><a href="javascript:show_users()" class="amenu">Пользователи</a></div>

	<!--
	<div class="menuitem"><a href="javascript:show_news()" class="amenu">Новости</a></div>
	<div class="menupunkt">
		<img src="images/green/menu_shesternya.jpg" align="absmiddle" class="menuimg"/>Основное			
	</div>
	<div class="menuitem"><a href="manage_models.php" class="amenu">Каталог продукции</a></div>
	<div class="menuitem"><a href="manage_managers.php" class="amenu">Ответственные лица</a></div>
	<div class="menuitem"><a href="manage_addstat.php" class="amenu">Статистика добавлений</a></div>
	<div class="menuitem"><a href="manage_zakaz_stat.php" class="amenu">Статистика заказов</a></div>
	<div class="menuitem"><a href="manage_wrong.php" class="amenu">Страницы с ошибками</a></div>
	<div class="menupunkt"> <img src="images/green/menu_shesternya.jpg" align="absmiddle" class="menuimg"/>Дополнитьельно </div>
	<div class="menuitem"><a href="manage_uploadprice.php" class="amenu">Загрузка прайса</a></div>
	<div class="menuitem"><a href="manage_contact_all.php" class="amenu">Контакт в печати</a></div>
	<div class="menuitem"><a href="manage_schet.php" class="amenu">Шапка счета</a></div>
	<div class="menuitem"><a href="manage_rec.php" class="amenu">Отправка заказов</a></div>
	<div class="menuitem"><a href="manage_pasports.php" class="amenu">Паспорта моделей</a></div>
	<div class="menuitem"><a href="manage_news.php" class="amenu">Новости</a></div>
	<div class="menuitem"><a href="manage_gooest.php" class="amenu">Управление форумом</a></div>
	<div class="menuitem"><a href="manage_about.php" class="amenu">О комании</a></div>
	<div class="menuitem"><a href="manage_contact.php" class="amenu">Страница контактов</a></div>
	<div class="menuitem"><a href="manage_dostavka.php" class="amenu">Страница доставки</a></div>
	<div class="menuitem"><a href="manage_keywords.php" class="amenu">Ключевые слова</a></div>
	<!-- <div class="menuitem"><a href="create_catalog__.php" class="amenu">Создать каталог</a></div> -->