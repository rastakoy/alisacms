<!--  <div class="menuitem">
<?
$resp = mysql_query("select * from manage_site where name='ui_on' ");
$row = mysql_fetch_assoc($resp);
?>
<input type="checkbox" onchange="change_ui_status()" id="ui_status_check" 
 <?  if($row["value"]==1) echo "checked"; ?>  /> UserInterface</div> -->
 
<!-- <div class="menuitem"><a href="javascript:show_filemanager_upload2('filemanager.php')" class="amenu">Отзывы</a></div> -->

<!--<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_basket_visible.php&title=Отображение корзины')" 
class="amenu"><img src="images/green/myitemname_popup/glaz.gif" border="0" align="absmiddle" style="margin-right: 5px;" />Отображение корзины</a></strong></div>

<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_help.php&title=Справочник')" 
class="amenu">Справка ???</a></strong></div>
<div class="menuitem"><a href="javascript:show_filemanager_upload2('out_file.php?of=__of_rezervmaker.php&title=Создание резервной копии&action=makecopy')" class="amenu">Резервное копирование</a></div>
<div class="menuitem"><a href="javascript:show_filemanager_upload2('out_file.php?of=__of_rezervmaker.php&title=Восстановление из резервной копии&action=readcopy')" class="amenu">Восстановление из копии</a></div>
<div class="menuitem"><a href="javascript:')" class="amenu">Данные сайта</a></div>
-->
<div class="menuitem"><a href="javascript:show_ritems('users')" class="amenu"><strong>Пользователи</strong></a></div>
<div class="menuitem"><a href="javascript:show_ritems('orders', 1, 'take')" class="amenu"><strong>Заказы</strong></a></div>
<div class="menuitem" id="rootfoldermenu"><a href="/adminarea/admin.php" class="amenu">Корневая группа</a></div>
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

<!--<div class="menuitem"><a href="javascript:manage_configarator()" class="amenu">Конфигуратор</a></div>
<div class="menuitem"><a href="javascript:show_filemanager_upload2('developers.php')" class="amenu">Производители</a></div>-->
<div class="menuitem"><a href="javascript:show_filemanager_upload2('filemanager.php')" class="amenu">Файловый менеджер	</a></div>

<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=manage_uploadp.php&title=Загрузка прайс-листа')" class="amenu">! Загрузка прайс-листа</a></strong></div> 

<!--<div class="menuitem"><a href="javascript:show_zakazstat()" class="amenu">Статистика заказов</a></div>-->

<div class="menuitem"><strong>
<a href="javascript:show_site_properties()" class="amenu">! Настройки сайта</a></strong></div>
<div class="menuitem"><strong>
<a href="javascript:generate_sitemap()" class="amenu">! Генерация sitemap.xml</a></strong></div>
<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_images_maker.php&title=Обработать изображения')" class="amenu">! Обработать изображения</a></strong></div>
<!--<div class="menuitem"><strong>
<a href="javascript:" class="amenu">! Файлы javascript</a></strong></div>-->
<!--<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('resize_images.php')" class="amenu">! Обжимка изображений</a></strong></div> -->
<!--  -------------------------------------------------------------------- -->
<!--<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_datas.php')" class="amenu">! Подсоединяемые данные</a></strong></div>-->
<!--  -------------------------------------------------------------------- -->
<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_form_maker.php&title=Конструктор форм')" class="amenu">! Конструктор форм</a></strong></div> 
<!--  -------------------------------------------------------------------- -->
<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_uploadp_maker.php&title=Конструктор загрузчика прайс-листа')" class="amenu">! Конструктор загрузчика прайс-листа</a></strong></div> 
<!--<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_grabber_maker.php&title=Конструктор граббера')" class="amenu">! Конструктор граббера</a></strong></div> 
<div class="menuitem">&nbsp;</div> -->
<!--  -------------------------------------------------------------------- -->
<div class="menuitem">&nbsp;</div> 
<!--  -------------------------------------------------------------------- -->

<!--  -------------------------------------------------------------------- -->


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