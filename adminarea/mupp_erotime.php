<?php
$cof = $_POST["cof"];
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_prices.php");
require_once("../core/__functions_post.php");
require_once("../core/__functions_format.php");
require_once("../core/__functions_pages.php");
dbgo();
require_once("__class_csvToArray.php"); // �������� ����� ����������
$csv_class = new csvToArray("csv_class"); //���������� ������ csv 
$__page_name = "index";
$__page_title = "�������� ������������ �����-�����";
?>
<html>
<?  require_once("__head.php"); ?>
<?  //require_once("__js_show_block.php"); ?>
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; line-height: 18px;"><?

//PROGRAM CODE HERE
//****************
echo "��������� ���� ���������� � �������<br/>\n";
$mass_csv = $csv_class->parse("EF_PerechenSkollekciyami.csv");
//print_r($mass_csv);
//****************
foreach($mass_csv as $key=>$val){
	if($key < 2000){
		$resp = mysql_query("select * from items where item_code='$val[1]'  ");
		//���� �� ������
		if($val[0]!=0){
			if(mysql_num_rows($resp)>0){
				echo "���������� �$val[3]� ����������<br/>\n";
			} else {
				echo "���������� �$val[3]� �� ����������, <b>������������ �������� ����������:</b><br/>\n";
				echo "���� ������������ ����������<br/>\n";
				$resp_spar = mysql_query("select * from items where item_code='$val[2]'  ");
				if(mysql_num_rows($resp_spar) > 0){
					$row_spar = mysql_fetch_assoc($resp_spar);
					echo "������������ ���������� ������� �$row_spar[name]�<br/>\n";
					$itemeditdate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
					$href_name = __fp_rus_to_eng($val[3]);
					$query_md = "INSERT INTO items (name, href_name, parent, 
					page_show, folder, item_code, 
					itemadddate, itemeditdate, tmp, recc) VALUES ( '$val[3]', '$href_name', $row_spar[id],
					1, 1, '$val[1]',
					$itemeditdate, $itemeditdate, 0, 0 )";
					$resp_md = mysql_query($query_md);
					if(!$resp_md) echo "���������� �� �������: ������ mysql <br/><b>$query_md</b><br/>\n";
				} else {
					echo "������������ ���������� �� �������, ������ ������������<br/>\n";
				}
				//$query_md = "  insert into items  ";
				//$resp_md = mysql_query($query_md);
			}
		} else {
			//���� ������!
			if(mysql_num_rows($resp)>0){
				$row = mysql_fetch_assoc($resp);
				$pid = $row["id"];
				echo "������ �$val[3]� ����������<br/>\n";
				echo "<b>������������ �������������� ����:</b><br/>\n";
				$query_md = "update items  set price='$val[8]', developers='$val[13]' where item_code='$val[1]'  ";
				$resp_md = mysql_query($query_md);
				echo "<b>������������ �������������� �������������: developers='$val[13]'</b><br/>\n";
				//if(!file_exists("../loadimages/".$val[4]."_a.jpg")){
					//-----------------  ---  ------
					//$filename = "http://www.eroticfantasy.com.ua/photo/".$val[4]."_a.jpg";
					//$handle = fopen($filename, "r");
					//$contents = '';
					//while (!feof($handle)) {
					//	$contents .= fread($handle, 8192);
					//}
					//fclose($handle);
					//-----------------  ---  ------
					//$handle = fopen("../loadimages/".$val[4]."_a.jpg", 'a');
					//fwrite($handle, $contents);
					//fclose($handle);
					
					if(file_exists("../loadimages/".$val[4]."_a.jpg")){
						$query = "INSERT INTO images (name, parent, link, prior) VALUES ('img', $pid, '".$val[4]."_a.jpg', 0)";
						//$resp = mysql_query($query);
						echo "������ ����������� �����������<br/>\n";
					} else {
						echo "������ ����������� �� �������<br/>\n";
					}
				//}
			} else {
				echo "������ �$val[3]� �� ����������, <b>������������ �������� ������:</b><br/>\n";
				echo "���� ������������ ����������<br/>\n";
				$resp_spar = mysql_query("select * from items where item_code='$val[2]'  ");
				if(mysql_num_rows($resp_spar) > 0){
					$row_spar = mysql_fetch_assoc($resp_spar);
					echo "������������ ���������� ������� �$row_spar[name]�<br/>\n";
					$itemeditdate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
					$href_name = __fp_rus_to_eng($val[3]);
					$query_md = "INSERT INTO items (name, href_name, parent, 
					page_show, folder, item_code, item_art, cont, price,
					itemadddate, itemeditdate, tmp, recc,
					developers) VALUES ( '$val[3]', '$href_name', $row_spar[id],
					1, 0, '$val[1]', '$val[4]', '$val[6]', '$val[8]',
					$itemeditdate, $itemeditdate, 0, 0,
					$val[13] )";
					$resp_md = mysql_query($query_md);
					if(!$resp_md) echo "���������� �� �������: ������ mysql <br/><b>$query_md</b><br/>\n";
				} else {
					echo "������������ ���������� �� �������, ������ ������������<br/>\n";
				}
				//$query_md = "  insert into items  ";
				//$resp_md = mysql_query($query_md);
			}
		}
	}
}
//****************

//****************
?>

</body>
</html>
