<?php
$step=$_GET["step"];
$transform = $_POST["transform"];
$koef =$_POST["koef"];
$kurs =$_POST["kurs"];
$tree_index = "0";
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_prices.php");
require_once("../core/__functions_format.php");
dbgo();
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
$__page_name = "index";
$__page_title = "Загрузка обновленного прайс-листа";
$resp_postav = mysql_query("select * from postav where id=1");
$row_postav = mysql_fetch_assoc($resp_postav);
$postav = $row_postav;

//PROGRAM CODE HERE
//****************
function find_items($mass, $par, $level, $start, $postav, $koef, $transform, $kurs){
	//echo "<pre>"; print_r($mass); echo "</pre>";
	$i=0; $rv="";
	while($i < count($mass)){
		$val = $mass[$i];
		if($val[3]){
			$atd = true;
			$price_dol =  __format_txt_price_format(trim($val[3]));
			if($transform)  $price_dol = $kurs * $price_dol;  
			if($koef) $price = $price_dol + ($price_dol / 100 * $koef);
			$price = round($price, 2); 
			//$price =  __format_txt_price_format($price);
			//*************************************************
			$resp = mysql_query("select * from items where model_article='".trim($val[2])."' limit 0,1 ");
			if(mysql_num_rows($resp) > 0 && $val[2]){
				$sresp = mysql_query("UPDATE items SET model_price= '".$price."' WHERE model_article='".trim($val[2])."'  ");
				$atd = false;
				//$rv .= "<div id=\"all_item_div_$i\" style=\"padding-bottom: 15px;\"><b>Соответствие по артиклу
				// (".$mass[$i][0].")</b> ($price : $price_dol : $val[3])</div>";
			}
			//*************************************************
			$resp = mysql_query("select * from items where model_kod='".trim($val[1])."' limit 0,1 ");
			if(mysql_num_rows($resp) > 0 && $val[1] && $atd){
				$sresp = mysql_query("UPDATE items SET model_price= '".$price."' WHERE model_kod='".trim($val[1])."'  ");
				$atd = false;
				//$rv .= "<div id=\"all_item_div_$i\" style=\"padding-bottom: 15px;\"><b>Соответствие по коду поставщика
				// (".$mass[$i][0].")</b> ($price : $price_dol : $val[3])</div>";
			}
			//*************************************************
			if($atd){
				$rv .= "<div id=\"all_item_div_$i\" style=\"padding-bottom: 15px;\">"; //.$mass[$i][0];
				$rv .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
				$rv .= "<td width=\"350\"><span id=\"sname_$i\">$val[0]</span></td>";
				$rv .= "<td width=\"80\" align=\"center\"><span id=\"skod_$i\">$val[1]</span></td>";
				$rv .= "<td width=\"120\"><span id=\"sart_$i\">$val[2]</span></td>";
				$rv .= "<td width=\"80\"><span id=\"sprice_$i\">$price</span> ($val[3])</td>";
				$rv .= "<td width=\"30\"><a href=\"javascript:show_iframe($i)\">
				<img src=\"prices/add_to_catalog.jpg\" align=\"absmiddle\" border=0></a></td>";
				$rv .= "<td>&nbsp;</td></tr></table>
				<div id=\"div_item_iframe_$i\" style=\"display:none;\">test</div>
				</div>";
			}
		}
		$i++;
	}
	return $rv;
}
//****************
function find_items__($mass, $par, $level, $start, $postav){
	//global $mass_csv;
	$rv="";
	//print_r($mass);
	//echo "Родитель=".$par." ($val[4])<br/>\n";
	for($i=$start; $i<count($mass); $i++){
		//$val[15]=eregi_replace("\r", "", $val[15]);
		$val = $mass[$i];
		//if($i==0) print_r($val);
		
		$val[15]=trim($val[15]);
		if($val[15]=="$par"){
			$atd = true;
			//$resp = mysql_query("select * from items where model_article='".trim($val[2])."' limit 0,1 ");
			//if(mysql_num_rows($resp) > 0 && $val[2]){
			//	$sresp = mysql_query("UPDATE items SET model_price= '".trim($val[7])."' WHERE model_article='".trim($val[2])."'  ");
			//	$atd = false;
				//echo "<span id=\"artikul_$val[3]\" >$val[2]</span>";
				//echo "<span id=\"model_name_$val[3]\" >$val[4]</span>";
				//echo "<span id=\"model_id_$val[3]\" >$val[3]</span><br/><br/>\n";
			//} 
			//**************************************************
			//if($atd){
			//	$resp = mysql_query("select * from magnit_items where our_art='".$postav["psevdo"]."-".trim($val[3])."' limit 0,1 ");
			//	if(mysql_num_rows($resp) > 0){
			//		$sresp = mysql_query("UPDATE magnit_items SET model_price= '".trim($val[7])."' 
			//		WHERE our_art='".$postav["psevdo"]."-".trim($val[3])."'  ");
			//		$atd = false;
			//	}
			//}
			//**************************************************
			if($atd) {
				$rv.= "<div id=\"all_item_div_$val[3]\">";
				if($level>0) for($j=0; $j<$level*3;$j++) $rv.="&nbsp;";
				if($val[1]==""){
					$rv .= "<span id=\"pimg_$val[3]\"><a href=\"javascript:prices_show($val[3])\">";
					$rv .= "<img src=\"tree/plus.jpg\" align=\"absmiddle\" border=0></a></span>";
				}
				$rv.=$val[4];
				$rv .= "<span id=\"artikul_$val[3]\" style=\"display:none;\">$val[2]</span>";
				$rv .= "<span id=\"model_name_$val[3]\" style=\"display:none;\">$val[4]</span>";
				$rv .= "<span id=\"model_id_$val[3]\" style=\"display:none;\">$val[3]</span>";
				$rv .= "<span id=\"our_art_$val[3]\" style=\"display:none;\">".$postav["psevdo"]."-".trim($val[3])."</span>";
				if($val[1]!=""){
					$rv .= "($val[2])<a href=\"javascript:show_iframe($val[3])\">";
					$rv .= "<img src=\"prices/add_to_catalog.jpg\" align=\"absmiddle\" border=0></a>";
				}
				$rv .= "</div>\n";
			}
			//echo "$val[4]<br/>\n";
			//if(mysql_num_rows($resp)){
				if($val[1]==""){
					$rv .= "<div id=\"price_$val[3]\" style=\"display:none;\">";
					$rv .= find_items($mass, $val[3], $level+1, $i, $postav);
					$rv .="</div>";
				}
			//}
		}
		//if($val[15]==0 && $level>0) break;
	}
	return $rv;
}
//****************
?>
<html>
<?  require_once("__head.php"); ?>
<?  //require_once("__js_show_block.php"); ?>
<body>
<div class="div_insert_item_st" id="div_insert_item" style="display:none;">
</div>
<div class="div_insert_item_st_close" id="div_insert_item_close" style="display:none;">
<a href="javascript:close_iframe()"><img src="images/close.gif" width="25" height="25" border="0"></a></div>
<script><!--
var top_fval;
var all_all_parent = 0;
var top_art = "";
var top_kod = "";
var top_our_art = "";
var top_name = "";
var top_price = "";
function prices_show(pval){
	//alert("ok"+pval);
	ob = document.getElementById("price_"+pval);
	oi = document.getElementById("pimg_"+pval);
	if(ob.style.display == "none"){
		ob.style.display = "";
		oi.innerHTML = "<a href=\"javascript:prices_show("+pval+")\"><img src=\"tree/minus.jpg\" align=\"absmiddle\" border=0></a>";
	} else {
		ob.style.display = "none";
		oi.innerHTML = "<a href=\"javascript:prices_show("+pval+")\"><img src=\"tree/plus.jpg\" align=\"absmiddle\" border=0></a>";
	}
	
}
//******
function show_iframe(fval){
	top_fval = fval;
	top_name = document.getElementById("sname_"+fval).innerHTML;
	top_art = document.getElementById("sart_"+fval).innerHTML;
	top_kod = document.getElementById("skod_"+fval).innerHTML;
	if(top_kod!="") top_our_art = "zsu-"+top_kod;
	if(top_art!="") top_our_art = "zsu-"+top_art;
	top_price = document.getElementById("sprice_"+fval).innerHTML;
	//******************************** 
	//alert(top_name);
	obj = document.getElementById("div_item_iframe_"+fval);
	//inner = "<iframe name=\"div_insert_item_frame_n\" id=\"div_insert_item_frame\" frameborder=\"0\" width=\"960\" height=\"520\" src=\"http://images.google.ru/search?q=CNR-MPV2WI&biw=1024&bih=636&tbm=isch";
	inner = "<iframe name=\"div_insert_item_frame_n\" id=\"div_insert_item_frame\" frameborder=\"0\" width=\"960\" height=\"520\" src=\"manage_models_light2.php";
	//alert(all_all_parent);
	if(all_all_parent!=0){
		inner += "?parent="+all_all_parent;
	}
	inner += "\" />";
	
	//alert(inner);
	obj.style.display = "";
	obj.innerHTML = inner;
	//obj2 = document.getElementById("div_insert_item_close");
	//obj2.style.display = "";
	//obb_artikul = document.getElementById("artikul_"+fval);
	//top_artikul = obb_artikul.innerHTML;
	//obb_mname = document.getElementById("model_name_"+fval);
	//top_mname = obb_mname.innerHTML;
	//alert("inner="+obb_mname.innerHTML);
	//obb_mid = document.getElementById("model_id_"+fval);
	//top_mid = obb_mid.innerHTML;
	//obb_our_art = document.getElementById("our_art_"+fval);
	//top_our_art = obb_our_art.innerHTML;
	
	
}
//******
function close_iframe(){
	obj2 = document.getElementById("div_insert_item_close");
	obj2.style.display = "none";
	obj = document.getElementById("div_insert_item");
	obj.style.display = "none";
	obj.innerHTML = "";
}
//******
function close_item_sts(){
	//alert(top_mid);
	document.getElementById("all_item_div_"+top_mid).style.display = "none";
	//alert("close");
}
//******
function change_all_parent(val){
	//alert(val);
	all_all_parent = val;
}
--></script>
<table border="0" cellpadding="0" cellspacing="0" class="adminarea">
  <tr>
    <!-- <td class="adminarealeft"></td> -->
    <td class="adminarearight" valign="top">
		<div class="admintitle"><?  echo $__page_title; ?></div>
		<?  if(!$step) { ?>
		<form action="manage_uploadprice.php" method="post" enctype="multipart/form-data" name="form1">
<?
if ($_FILES["sp_link"]["name"]!="") {
	echo "Файл загружен";
	$mass_csv = $csv_class->parse($_FILES["sp_link"]["tmp_name"]); 
	//print_r($mass_csv); echo "::::";
	//@set_time_limit (240);
	echo "<br/><br/><br/><br/>";?><select id="sel_parent" name="parent" onChange="change_all_parent(this.value)">
<option value="0">--Выберите родительскую группу--</option>
<?
if($edit_folder)
	echo __fmt_rekursiya_show_items_for_select($tree_index, 0, $edit_mass, $edit_folder, 0);
else
	echo __fmt_rekursiya_show_items_for_select($tree_index, 0, false, false, 0, $parent);
?></select><?
	echo find_items($mass_csv, "0", "0", 0, $postav, $koef, $transform, $kurs);
}
?>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Выберите файл нового прайс-листа <br>
              (формат csv) </td>
              <td class="inputinput" valign="middle">
                <input name="sp_link" type="file" id="sp_link">
                <br>
                <input name="transform" type="checkbox" id="transform" value="1" checked> 
                - прайс в долларах 
                <br>
              <input name="kurs" type="text" id="kurs" value="8" size="3">
- Курс доллара            <br>
               <input name="koef" type="text" id="koef" value="7" size="3">
              % - коэффициент надбавки </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Выберите файл прайс-листа, формат файла: csv. </td>
            </tr>
          </table>
		  <div class="inputsubmit">
		    <input type="submit" name="Submit" value="Отправить данные">
	      </div>
		</form>
		<?  }   ?>
		<?  if($step==1) { ?>
		<? 
		$resp = mysql_query()
		?>
		
		<?  } ?>
	</td>
  </tr>
</table>
<script>
selo = document.getElementById("sel_parent");
if(selo.value != 0) all_all_parent = selo.value;
//*********
function close_div_iframe(){
	//alert(top_fval);
	seloo = document.getElementById("all_item_div_"+top_fval);
	seloo.innerHTML = "";
	seloo.style.display = "none";
}
</script>
<?  require_once("__footer.php"); ?>
</body>
</html>
