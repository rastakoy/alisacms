<?
$path = "../loadimages/oksana"; // ������� �� ��������
$dir = opendir($path);
while(($file = readdir($dir)) !== false){
	if($file!="." && $file!=".." &&  $file!=".ftpquota"){
		echo "������������ ���� ".$file."<br />";
		$resp = mysql_query("select * from items where item_art='".preg_replace("/\.jpg$/", "", $file)."'");
		$row = mysql_fetch_assoc($resp);
		if($row["id"]){
			echo "������������ ����������� � ������ ".$row["name"]."<br/>\n";
			echo "<br/>���������� � ���������������<br/>\n";
			
			$no_file = true;
			$new_name = __fp_rus_to_eng($file);
			echo "����� ��� �����: $new_name<br/>";
			if(file_exists("../loadimages/$new_name")){
				echo "����� ���� ����������. �������� �����������<br/>";
				$no_file=false;
			}
			
			if($no_file){
				$res = copy("../loadimages/oksana/$file", "../loadimages/$new_name");
				if(!$res) echo "�� ������� ����������� ������ ����<br/>\n";
				if($res) echo "������ ���� ����������<br/>\n";
				echo "������� ������ ����������� � ������� <b>images</b><br/>";
				$iresp = mysql_query("insert into images (name, parent, link, prior) values ('img', $row[id], '$new_name', 10  )  ");
				$iresp = mysql_query("  select * from images order by id desc limit 0,1 ");
				$irow = mysql_fetch_assoc($iresp);
				echo "������������� �������:<br/>\n";
				echo "<img src=\"../imgres_for_items.php?resize=1200&id=$irow[id]&link=loadimages/$irow[link]\" width=\"40\" height=\"30\" /><br/>\n";
				
			}
			
			echo "������� �������� ����<br/>\n";
			unlink("../loadimages/oksana/$file");
			echo "<br/><br/>\n";
		}
	}
}
closedir($dir);
?>