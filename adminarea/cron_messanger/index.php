<?
$online = true;
header("Content-type: text/plain; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
if($online){
	require_once("/home/oksanale/public_html/__config.php");
	require_once("/home/oksanale/public_html/core/__functions.php");
	require_once("/home/oksanale/public_html/core/__functions_tree_semantic.php");
	require_once("/home/oksanale/public_html/core/__functions_format.php");
	require_once("/home/oksanale/public_html/core/__functions_images.php");
	require_once("/home/oksanale/public_html/core/__functions_forms.php");
	require_once("/home/oksanale/public_html/core/__functions_loadconfig.php");
	require_once("/home/oksanale/public_html/core/__functions_full.php");
	require_once("/home/oksanale/public_html/core/__functions_pages.php");
	require_once("/home/oksanale/public_html/core/__functions_csv.php");
	require_once("/home/oksanale/public_html/core/__functions_mtm.php");
	require_once("/home/oksanale/public_html/filter/__functions_filter.php");
	require_once("/home/oksanale/public_html/core/__functions_sitemap_0.1.php");
	require_once("/home/oksanale/public_html/core/__function_saver.php");
	require_once("/home/oksanale/public_html/core/__function_post_2.0.php");
	require_once("/home/oksanale/public_html/core/__functions_zakaz.php");
	require_once("/home/oksanale/public_html/core/__functions_order.php");
	require_once("/home/oksanale/public_html/core/__functions_pages.php");
}else{
	require_once("../../__config.php");
	require_once("../../core/__functions.php");
	require_once("../../core/__functions_tree_semantic.php");
	require_once("../../core/__functions_format.php");
	require_once("../../core/__functions_images.php");
	require_once("../../core/__functions_forms.php");
	require_once("../../core/__functions_loadconfig.php");
	require_once("../../core/__functions_full.php");
	require_once("../../core/__functions_pages.php");
	require_once("../../core/__functions_csv.php");
	require_once("../../core/__functions_mtm.php");
	require_once("../../filter/__functions_filter.php");
	require_once("../../core/__functions_sitemap_0.1.php");
	require_once("../../core/__function_saver.php");
	require_once("../../core/__function_post_2.0.php");
	require_once("../../core/__functions_zakaz.php");
	require_once("../../core/__functions_order.php");
	require_once("../../core/__functions_pages.php");

}

//require_once("__functions_register.php");
//require_once("__functions_rating.php");
dbgo();
//*************************
//require_once("/home/oksanale/public_html/__class_csvToArray.php"); // �������� ����� ����������
//$csv_class = new csvToArray("csv_class"); //���������� ������ csv 
//*************************
	echo "start emails";
	$resp = mysql_query("select * from send_emails where is_send_email=1 order by id limit 0,150 ");
	while($row=mysql_fetch_assoc($resp)){
		$respo = mysql_query(" update send_emails set is_send_email=0 where id=$row[id]  ");
		$respo = mysql_query(" select * from items where id=$row[is_send_id]  ");
		$rowText = mysql_fetch_assoc($respo);
		$text = preg_replace("/\.\.\//", $site, $rowText['cont']);
		$text = preg_replace("/\/loadimages/", $site."loadimages", $text);
		if($row['email']!=''){
			$file = false;
			echo __fp_sendMail_v2($row["email"], "robot@oksanalenta.com.ua", 
			"����� � �����", "-->�������� ��������", $text, $file)."->$row[email]<br/>\n";
		}
	}
