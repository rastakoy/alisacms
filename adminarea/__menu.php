<!--  <div class="menuitem">
<?
$resp = mysql_query("select * from manage_site where name='ui_on' ");
$row = mysql_fetch_assoc($resp);
?>
<input type="checkbox" onchange="change_ui_status()" id="ui_status_check" 
 <?  if($row["value"]==1) echo "checked"; ?>  /> UserInterface</div> -->
 
<!-- <div class="menuitem"><a href="javascript:show_filemanager_upload2('filemanager.php')" class="amenu">������</a></div> -->

<!--<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_basket_visible.php&title=����������� �������')" 
class="amenu"><img src="images/green/myitemname_popup/glaz.gif" border="0" align="absmiddle" style="margin-right: 5px;" />����������� �������</a></strong></div>

<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_help.php&title=����������')" 
class="amenu">������� ???</a></strong></div>
<div class="menuitem"><a href="javascript:show_filemanager_upload2('out_file.php?of=__of_rezervmaker.php&title=�������� ��������� �����&action=makecopy')" class="amenu">��������� �����������</a></div>
<div class="menuitem"><a href="javascript:show_filemanager_upload2('out_file.php?of=__of_rezervmaker.php&title=�������������� �� ��������� �����&action=readcopy')" class="amenu">�������������� �� �����</a></div>
<div class="menuitem"><a href="javascript:')" class="amenu">������ �����</a></div>
-->
<div class="menuitem"><a href="javascript:show_ritems('users')" class="amenu"><strong>������������</strong></a></div>
<div class="menuitem"><a href="javascript:show_ritems('orders', 1, 'take')" class="amenu"><strong>������</strong></a></div>
<div class="menuitem" id="rootfoldermenu"><a href="/adminarea/admin.php" class="amenu">�������� ������</a></div>
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
<div class="menuitem"><a href="javascript:show_recc()" class="amenu">�������</a></div>

<!--<div class="menuitem"><a href="javascript:manage_configarator()" class="amenu">������������</a></div>
<div class="menuitem"><a href="javascript:show_filemanager_upload2('developers.php')" class="amenu">�������������</a></div>-->
<div class="menuitem"><a href="javascript:show_filemanager_upload2('filemanager.php')" class="amenu">�������� ��������	</a></div>

<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=manage_uploadp.php&title=�������� �����-�����')" class="amenu">! �������� �����-�����</a></strong></div> 

<!--<div class="menuitem"><a href="javascript:show_zakazstat()" class="amenu">���������� �������</a></div>-->

<div class="menuitem"><strong>
<a href="javascript:show_site_properties()" class="amenu">! ��������� �����</a></strong></div>
<div class="menuitem"><strong>
<a href="javascript:generate_sitemap()" class="amenu">! ��������� sitemap.xml</a></strong></div>
<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_images_maker.php&title=���������� �����������')" class="amenu">! ���������� �����������</a></strong></div>
<!--<div class="menuitem"><strong>
<a href="javascript:" class="amenu">! ����� javascript</a></strong></div>-->
<!--<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('resize_images.php')" class="amenu">! ������� �����������</a></strong></div> -->
<!--  -------------------------------------------------------------------- -->
<!--<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_datas.php')" class="amenu">! �������������� ������</a></strong></div>-->
<!--  -------------------------------------------------------------------- -->
<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_form_maker.php&title=����������� ����')" class="amenu">! ����������� ����</a></strong></div> 
<!--  -------------------------------------------------------------------- -->
<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_uploadp_maker.php&title=����������� ���������� �����-�����')" class="amenu">! ����������� ���������� �����-�����</a></strong></div> 
<!--<div class="menuitem"><strong>
<a href="javascript:show_filemanager_upload2('out_file.php?of=__of_grabber_maker.php&title=����������� ��������')" class="amenu">! ����������� ��������</a></strong></div> 
<div class="menuitem">&nbsp;</div> -->
<!--  -------------------------------------------------------------------- -->
<div class="menuitem">&nbsp;</div> 
<!--  -------------------------------------------------------------------- -->

<!--  -------------------------------------------------------------------- -->


	<!--
	<div class="menuitem"><a href="javascript:show_news()" class="amenu">�������</a></div>
	<div class="menupunkt">
		<img src="images/green/menu_shesternya.jpg" align="absmiddle" class="menuimg"/>��������			
	</div>
	<div class="menuitem"><a href="manage_models.php" class="amenu">������� ���������</a></div>
	<div class="menuitem"><a href="manage_managers.php" class="amenu">������������� ����</a></div>
	<div class="menuitem"><a href="manage_addstat.php" class="amenu">���������� ����������</a></div>
	<div class="menuitem"><a href="manage_zakaz_stat.php" class="amenu">���������� �������</a></div>
	<div class="menuitem"><a href="manage_wrong.php" class="amenu">�������� � ��������</a></div>
	<div class="menupunkt"> <img src="images/green/menu_shesternya.jpg" align="absmiddle" class="menuimg"/>�������������� </div>
	<div class="menuitem"><a href="manage_uploadprice.php" class="amenu">�������� ������</a></div>
	<div class="menuitem"><a href="manage_contact_all.php" class="amenu">������� � ������</a></div>
	<div class="menuitem"><a href="manage_schet.php" class="amenu">����� �����</a></div>
	<div class="menuitem"><a href="manage_rec.php" class="amenu">�������� �������</a></div>
	<div class="menuitem"><a href="manage_pasports.php" class="amenu">�������� �������</a></div>
	<div class="menuitem"><a href="manage_news.php" class="amenu">�������</a></div>
	<div class="menuitem"><a href="manage_gooest.php" class="amenu">���������� �������</a></div>
	<div class="menuitem"><a href="manage_about.php" class="amenu">� �������</a></div>
	<div class="menuitem"><a href="manage_contact.php" class="amenu">�������� ���������</a></div>
	<div class="menuitem"><a href="manage_dostavka.php" class="amenu">�������� ��������</a></div>
	<div class="menuitem"><a href="manage_keywords.php" class="amenu">�������� �����</a></div>
	<!-- <div class="menuitem"><a href="create_catalog__.php" class="amenu">������� �������</a></div> -->