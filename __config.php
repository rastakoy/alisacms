<?
$test=0;
$online=true;

if ($online){
$host="localhost";
$dbname="oksanalenta";
$dbusername="root"; 
$dbpassword=""; 
//$tree_array[] = "items";
$tree_array[] = "items";
}
function dbgo(){
global $host, $dbusername, $dbpassword, $dbname;
$link=mysql_connect($host,$dbusername,$dbpassword) or die ("ERROR 1 - Can't connect to database");
$s=mysql_select_db($dbname, $link) or die("ERROR 2 - DB selection failure");
$resp = mysql_query("SET NAMES cp1251");
return true;
} // end of function dbgo()

//$max_new_file_size=1500000;
$max_img_file_size = 1000000;
$max_csv_file_size = 30000;

$items_on_page = 6;

$my_left_limit = 3;

$show_edit_message = 0; // Показывать ли сообщение после редактирования странице в админзоне

$site = "http://oksanalenta.my/";

$dop_query = " && recc!=1 && tmp!=1 && page_show=1 ";

$items_allparent = 1;

//$global__post_message[0] = "office@micromed.ua";

$experimental = false;
$experimental2 = true;

$katalog_table = "items";

$has_user_register = true;

$admin_folders = array();
//$admin_folders[] = "images_formates";
//$admin_folders[] = "site_templates";
//$admin_folders[] = "novaposhta_states";
//$admin_folders[] = "constructor";
//$admin_folders[] = "ordersstatuses";

$useradmin_folders = array();
//$useradmin_folders[] = "alisa_filters";

$orders_folders = array();
$orders_folders[] = "orders";

$goo_folders = array();
$goo_folders[] = "alisa_goo";


$mytemplate = "tmpl-1";

$new_goods = "items/newgoods";

$usersOnPageLimit = 15;
?>