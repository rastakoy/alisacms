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
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
$__page_name = "index";
$__page_title = "Загрузка обновленного прайс-листа";
?>
<html>
<?  require_once("__head.php"); ?>
<?  //require_once("__js_show_block.php"); ?>
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; line-height: 18px;"><?
//$asd = "asddds'sdsd";
//$asd = preg_replace("/'/", "\'", $asd);
//$q = "update name set name='$asd'   ";
//echo $q;

//PROGRAM CODE HERE
//****************
if ($_FILES["sp_link"]["name"]!="") {
	$mass_search = false;
	$count_search = 0;
	$count_unsearch = 0;
	$us_mass = array();
	$count_add = 0;
	echo "Файл загружен<br/>\n";
	$mass_csv = $csv_class->parse($_FILES["sp_link"]["tmp_name"]); 
	//print_r($mass_csv);
	$nmass = false;
	$count=0;
	$kkey=0;
	//for($i=0; $i<2; $i++) {
		foreach($mass_csv as $key=>$val){
			//if($cof){
				//echo "Цена до обработки: $val[5]";
				$price = $val[5];
				$price = preg_replace("/ /", "", $price);
				$price = preg_replace("/,/", ".", $price);
				$price=$price/100*(100+$cof);
				$price = round($price,2);
				//$price = __format_txt_price_format($price);
				//echo "My-price=$price:::$val[2]<br/>";
				$val[5]=$price;
				//echo " Цена после: $val[5]<br/>\n";
				$val[3] = preg_replace("/'/", "\'", $val[3]);
			//}
			//***********************
			//echo $str."<br/>\n";
			$query = "select * from items where item_code='$val[0]'  limit 0,1  ";
			//echo "$query<br/>\n";
			$resp = mysql_query($query);
			if(mysql_num_rows($resp) > 0){
				$count++;
				$row_art = mysql_fetch_assoc($resp);
				
				$foldernum = explode(" ", $val[4]);
				$foldernum = $foldernum[0];
				if($foldernum){
					$wwresp = mysql_query("select * from items where psevdonum=$foldernum && folder=1 limit 0,1 ");
					$wwrow = mysql_fetch_assoc($wwresp);
					if($wwrow["name"]){
						$query = "update items SET parent=$wwrow[id],  price=$val[5], page_show=1, name='$val[3]' 
						where id=$row_art[id]   ";
					} else {
						$query = "update items SET  price=$val[5], page_show=1, name='$val[3]' where id=$row_art[id]   ";
					}
				} else {
					$query = "update items SET  price=$val[5], page_show=1, name='$val[3]' where id=$row_art[id]   ";
				}
				
				//if($val[1]=="")
				echo " ";
				$resp_s = mysql_query($query);
				
				//if($val[0]=="4363"){
				//	print_r($val);
				//	echo "val_6 = $val[6]<br/>\n";
				//}
				
				$a=true;
				if($val[6]!=0) $a=false;
				if($a){
					//echo "<br/><b>Найден нулевой остаток — $val[6]</b>\n";
					$resp_st = mysql_query("select * from items where item_code=$val[0] limit 0,1 ");
					$row_st = mysql_fetch_assoc($resp_st);
					
					if($row_st["dost_pod_zakaz"]!=1){
						if($wwrow["name"]){
							$query = "update items SET parent=$wwrow[id],  page_show=0, tmp=0, recc=0 where id=$row_st[id]   ";
							echo "wwrow найден <br/>\n";
							echo $query."::$wwrow[name],$wwrow[id],$wwrow[psevdonum]<br/>\n";
						} else {
							$query = "update items SET  page_show=0 where id=$row_st[id]   ";
							echo "wwrow не найден <br/>\n";
						}
						
						$resp_s = mysql_query($query);
						echo "<br/>$val[3] <b>($val[0])</b> нет в наличие, <b>отключение от показа</b><br/>\n";
					} else {
						if($wwrow["name"]){
							$query = "update items SET parent=$wwrow[id], page_show=1, tmp=0, recc=0 where id=$row_st[id]   ";
						}
						echo "<br/>Модели $val[3] <b>($val[0])</b> <font color=red>не будет отключена от показа</font><br/>\n";
					}
				}
				
				//echo "Информация о моделе $row_art[name] ($row_art[item_art]) обновлена<br/>\n";
				$count_search++;
				$mass_search[] = $row_art["id"];
			}
			else {
				$n_mass[] = $val[1];
				//echo "Информация о моделе $val[1] ($val[0]) не найдена<br/>\n";
				$wrow=false;
				$val[4] = trim($val[4]);
				$foldernum = explode(" ", $val[4]);
				$foldernum = $foldernum[0];
				$wresp = mysql_query("select * from items where psevdonum=$foldernum && folder=1 limit 0,1 ");
				$wrow = mysql_fetch_assoc($wresp);
				if($wrow["name"]){
					//echo "<br/>Информация о моделе $val[3] <b>($val[0])</b> не найдена<br/>\n";
					//echo "Директория для добавления: <b>$wrow[name] ($foldernum)</b> найдена<br/>\n";
					echo "Автозапись <b>$val[3] ($val[0]) (родитель — $wrow[name]:$wrow[id])</b><br/>\n";
					$eng_link = __fp_rus_to_eng($val[3]);
					$eng_link = preg_replace("/\./", "", $eng_link);
					//$val[3] = preg_replace("/'/", "\'", $val[3]);
					
					$val[1] = trim($val[1]);
					$qq = "INSERT INTO items (
					recc, page_show, tmp,
					
					name, href_name, item_code, price, item_art, parent
					
					) VALUES (
					0, 1, 0,
					
					'$val[3]', '$eng_link', '$val[0]', $val[5], '$val[1]', $wrow[id]
					
					)  ";
					
					$qqresp = mysql_query($qq);
					if(!$qqresp) {
						echo "Автозапись <b>$val[3] ($val[0]) не удалась</b> Подробности:<br/>\n";
						echo "$qq<br/>\n";
					}
					$qqres = mysql_query("select * from items order by id desc limit 0,1 ");
					$qqrow = mysql_fetch_assoc($qqres);
					$mass_search[] = $qqrow["id"];
					$count_search++;
					$count_add++;
					//$count_unsearch--;
					//echo $qq."<br/>\n";
				} else {
					//echo "<pre>"; print_r($val); echo "</pre>";
					$us_mass[] = $val;
					$count_unsearch++;
					echo "<b>Директория элемента $val[3] (id:$val[0], id директории: $foldernum) — не найдена</b><br/>\n";
					
					//echo $query."<br/>\n";
				}
			}
			
			if($val[2]==""){
				$nmass[] = array($val[1], $row_art);
				//$nmass[] = array($val[1], $val[2]);
			}
			
			$kkey++;
		}
		//print_r($nmass);
		//echo $kkey."---".$count;
		echo "<br/><br/>Найдено: $count_search. Не найдено: $count_unsearch. Добавлено: $count_add<br/>\n ";
		
		echo "<br/><br/><b>Список необработанных элементов</b>:<br/>\n ";
		foreach($us_mass as $key=>$val){
			echo "<b>".($key+1)."</b> - $val[3]<br/>\n";
		}
		
		$mass_search_q = "";
		foreach($mass_search as $key=>$val){
			if($key!=0) $mass_search_q .= " && id!=$val";
			else 			$mass_search_q .= " id!=$val";
		}
		
		$query = "select * from items where $mass_search_q  && folder=0  order by id asc ";
		$resp = mysql_query($query);
		$cc=1;
		while($row=mysql_fetch_assoc($resp)){
			if($row["parent"]!=0 && $row["parent"]!=9047){
				echo "$cc.  $row[name]  ($row[item_art]) — нет в прайс-листе — \n ";
				$sresp = mysql_query("update items set page_show=0 where id=$row[id]  ");
				if($sresp) echo " <B>Выключено для показа</B> ";
				echo " <br/>\n ";
				$cc++;
			}
		}
	
	//}
	
	unlink($_FILES["sp_link"]["tmp_name"]);
	
}
//****************
?>
<table border="0" cellpadding="0" cellspacing="0" class="adminarea">
  <tr>
    <td class="adminarearight" valign="top">
		<div class="admintitle"><?  echo $__page_title; ?></div>
		<form action="manage_uploadprice.php" method="post" enctype="multipart/form-data" name="form1">
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Выберите файл нового прайс-листа <br>
              (формат csv) </td>
              <td class="inputinput" valign="middle">
                <input name="sp_link" type="file" id="sp_link">

              </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Выберите файл прайс-листа, формат файла: csv. </td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Коэффициент</td>
              <td class="inputinput" valign="middle"><input name="cof" type="text" id="cof" value="0" size="10">
                <span style="font-weight: bold">%</span></td>
              <td class="inputcomment" valign="middle">&nbsp;</td>
            </tr>
          </table>
		  <div class="inputsubmit">
		    <input type="submit" name="Submit" value="Отправить данные">
	      </div>
		</form>
	</td>
  </tr>
</table>
<?  require_once("__footer.php"); ?>
</body>
</html>
