<?
$path = "../loadimages/oksana"; // каталог со скриптом
$dir = opendir($path);
while(($file = readdir($dir)) !== false){
	if($file!="." && $file!=".." &&  $file!=".ftpquota"){
		echo "Обрабатываем файл ".$file."<br />";
		$resp = mysql_query("select * from items where item_art='".preg_replace("/\.jpg$/", "", $file)."'");
		$row = mysql_fetch_assoc($resp);
		if($row["id"]){
			echo "Инсталлируем изображение в запись ".$row["name"]."<br/>\n";
			echo "<br/>Подготовка к инсталлированию<br/>\n";
			
			$no_file = true;
			$new_name = __fp_rus_to_eng($file);
			echo "Новое имя файла: $new_name<br/>";
			if(file_exists("../loadimages/$new_name")){
				echo "Такой файл существует. Операция остановлена<br/>";
				$no_file=false;
			}
			
			if($no_file){
				$res = copy("../loadimages/oksana/$file", "../loadimages/$new_name");
				if(!$res) echo "не удалось скопировать данный файл<br/>\n";
				if($res) echo "Данный файл скопирован<br/>\n";
				echo "Создаем запись изображения в таблице <b>images</b><br/>";
				$iresp = mysql_query("insert into images (name, parent, link, prior) values ('img', $row[id], '$new_name', 10  )  ");
				$iresp = mysql_query("  select * from images order by id desc limit 0,1 ");
				$irow = mysql_fetch_assoc($iresp);
				echo "Пропечатываем логотип:<br/>\n";
				echo "<img src=\"../imgres_for_items.php?resize=1200&id=$irow[id]&link=loadimages/$irow[link]\" width=\"40\" height=\"30\" /><br/>\n";
				
			}
			
			echo "Удаляем исходный файл<br/>\n";
			unlink("../loadimages/oksana/$file");
			echo "<br/><br/>\n";
		}
	}
}
closedir($dir);
?>