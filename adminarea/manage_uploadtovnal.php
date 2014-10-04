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
dbgo();
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
$__page_name = "index";
$__page_title = "Загрузка обновленного прайс-листа";

//PROGRAM CODE HERE
//****************
if ($_FILES["sp_link"]["name"]!="") {
	$mass_search = false;
	$count_search = 0;
	$count_unsearch = 0;
	echo "Файл загружен<br/>\n";
	$mass_csv = $csv_class->parse($_FILES["sp_link"]["tmp_name"]); 
	//print_r($mass_csv);
	$nmass = false;
	$count=0;
	$kkey=0;
	foreach($mass_csv as $key=>$val){
		if($cof){
			$price = $val[2];
			$price = preg_replace("/ /", "", $price);
			$price = preg_replace("/,/", ".", $price);
			$price=$price/100*(100+$cof);
			$price = round($price,2);
			//$price = __format_txt_price_format($price);
			//echo "My-price=$price:::$val[2]<br/>";
			$val[2]=$price;
			
		}
		//***********************
		$str = "";
		for($i=0; $i<strlen($val[1]); $i++){
			if(substr($val[1], $i, 1)!="."){
				$str.= substr($val[1], $i, 1);
			} else {
				break;
			}
		}
		//$val[1]=$str;
		//***********************
		$str = "";
		for($i=0; $i<strlen($val[0]); $i++){
			if(substr($val[0], $i, 1)!="."){
				$str.= substr($val[0], $i, 1);
			} else {
				break;
			}
		}
		$val[0]=$str;
		//***********************
		//echo $str."<br/>\n";
		$query = "select * from items where item_art like('%$val[0]%') limit 0,1  ";
		//echo "$query<br/>\n";
		$resp = mysql_query($query);
		if(mysql_num_rows($resp) > 0 && $val[1]!="" && $val[2]!=""){
			$count++;
			$row_art = mysql_fetch_assoc($resp);
			
			$query = "update items SET  price='$val[2]' where id=$row_art[id]   ";
			//if($val[1]=="")
			
			$resp_s = mysql_query($query);
			//echo "Информация о моделе $row_art[name] ($row_art[item_art]) обновлена<br/>\n";
			$count_search++;
			$mass_search[] = $row_art["id"];
		}
		else {
			$n_mass[] = $val[1];
			echo "Информация о моделе $val[1] ($val[0]) не найдена<br/>\n";
			$count_unsearch++;
			//echo $query."<br/>\n";
		}
		
		if($val[2]==""){
			$nmass[] = array($val[1], $row_art);
			//$nmass[] = array($val[1], $val[2]);
		}
		
		$kkey++;
	}
	//print_r($nmass);
	//echo $kkey."---".$count;
	echo "Найдено: $count_search. Не найдено: $count_unsearch.<br/>\n ";
	
	$mass_search_q = "";
	foreach($mass_search as $key=>$val){
		if($key!=0) $mass_search_q .= " && id!=$val";
		else 			$mass_search_q .= " id!=$val";
	}
	
	$query = "select * from items where $mass_search_q  && folder=0  order by id asc ";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		echo "$row[name]  ($row[item_art]) — нет в прайс-листе <br/>\n ";
		$sresp = mysql_query("update items set page_show=0 where id=$row[id]  ");
		if($sresp) echo " <B>Выключено для показа</B> ";
		echo " <br/>\n ";
	}
	
}
//****************
?>
<html>
<?  require_once("__head.php"); ?>
<?  //require_once("__js_show_block.php"); ?>
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; line-height: 18px;">
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
