<?php
$devname = $_POST["devname"];
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
//************
$__ajax_url = "__ajax.php";
$mytable = "out_datas";
$myfield = " 'name' , 'eng_name', 'ukr_name' ";
$mysptype = "span_fast_name";
//************
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_format.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_forms.php");
require_once("../core/__functions_loadconfig.php");
require_once("../core/__functions_full.php");
require_once("../core/__functions_pages.php");
require_once("../core/__functions_csv.php");
require_once("../filter/__functions_filter.php");
dbgo();
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
$__page_title = "Список производителей";

if($devname){
	$resp = mysql_query("INSERT INTO $mytable ($myfield) VALUES ('$devname')");
}
?>
<html>
<?  require_once("__head.php"); ?>
<?  //require_once("__js_show_block.php"); ?>
<script>
function show_block(vis){
	if(document.getElementById("adminforms").style.display=="block"){
		document.getElementById("adminforms").style.display = "none";
		document.getElementById("sb_plus").style.display = "block";
		document.getElementById("sb_minus").style.display = "none";
	}
	else{
		document.getElementById("adminforms").style.display = "block";
		document.getElementById("sb_plus").style.display = "none";
		document.getElementById("sb_minus").style.display = "block";
	}
}
</script>
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; line-height: 18px; padding: 16px;" id="bodys">
<h1 style="font-weight:normal; text-align:center;">Список производителей</h1><?

//PROGRAM CODE HERE
//****************
?><div class="manageadminforms"><?  require_once("templates/__manage_input_forms.php"); ?></div><?
//****************
?><form action="<?  echo $form_link; ?>?<? if($edit) echo "edited=$edit"; ?>" method="post" enctype="multipart/form-data" name="form1">
		<div class="adminforms" id="adminforms" style="display:none;">
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle-comm" valign="middle" style="height:100px;">Название производителя</td>
              <td valign="middle" class="inputcomment" style="height:100px;"><input name="devname" type="text" id="devname" style="width:100%" value="<? echo $row["name"]; ?>"></td>
            </tr>
          </table>
		  <div class="inputsubmit"><input type="submit" name="Submit" value="Отправить данные"></div>
</div></form><?
//****************
echo "<div class=\"ui-state-default-3\" id=\"myitems_sortable\">";
	$resp = mysql_query("select * from $mytable order by $myfield asc");
	while($row=mysql_fetch_assoc($resp)){
		echo "<div  class=\"ui-state-default-2\" id=\"prm_$row[id]\">";
		echo  "<div id=\"div_myitemname_$row[id]\" class=\"div_myitemname\">
		<span class=\"span_fast_name\" id=\"csfn_0_$row[id]\">$row[name]&nbsp;</span>
		<span class=\"span_fast_name\" id=\"csfn_1_$row[id]\">$row[eng_name]&nbsp;</span>
		<span class=\"span_fast_name\" id=\"csfn_2_$row[id]\">$row[ukr_name]&nbsp;</span>
		</div>";
		echo "</div>";
	}
echo "</div>";
?>
<script>
sp_status = "off";
__ajax_url = "<?  echo $__ajax_url; ?>";
mytable = "<?  echo $mytable; ?>";
myfield = new Array(<?  echo $myfield; ?>);
mysptype = "<?  echo $mysptype; ?>";



$(document).ready(function(){
	$( "."+mysptype ).click(function () {
		if(sp_status=="off"){
			sp_status = "ready";
			span_obj=this;
		} else if(sp_status=="on"){
			if(span_obj == this){
				sp_status = "nohide";
			}
		}
	});
	$( "#bodys" ).click(function () {
		read_bodys_sp_status();
	});
});
//***********************
function read_bodys_sp_status(){
	//alert("sp_status="+sp_status);
	if(sp_status == "ready"){
			inners = span_obj.innerHTML;
			inner = "<input style=\"\" class=\"span_fast_name_inp\" ";
			inner += "type=\"text\" id=\"cur_spfast_name\" value=\""+inners+"\">";
			$(span_obj).empty();
			$(span_obj).append(inner);
			sp_status = "on";
			document.getElementById("cur_spfast_name").focus();
			$("#cur_spfast_name").keyup(function(event) {
			   //alert(event.which);
			}).keydown(function(event) {
				if (event.which == 13) {
					//alert("OK");
					sp_status == "on";
					read_bodys_sp_status();
				} 
				if (event.which == 27) {
					//alert("OK");
					inner = inners;
					$(span_obj).empty();
					$(span_obj).append(inner);
					sp_status = "off";
					span_obj = false;
				}  
			});
		//*******************************
		} else if(sp_status == "on"){
			inner = document.getElementById("cur_spfast_name").value;
			$(span_obj).empty();
			$(span_obj).append(inner+"&nbsp;");
			sp_status = "off";
			inner = top.replace_spec_simbols(inner);
			mindex = get_mindex(span_obj.id);
			repls = "/csfn_"+mindex+"_/";
			//alert(repls);
			myid = span_obj.id.replace(/csfn_[0-9]_/gi , "");
			//alert("myid="+myid);
			span_obj = false;
			pactionn = "paction=save_spfast_name&table="+mytable+"&field="+myfield[mindex]+"&myid="+myid+"&cont="+inner;
			//alert("pactionn="+pactionn);
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: pactionn,
				success: function(html) {
					//alert("Сохранено успешно!\n"+html);
				}
			});
		//*******************************
		} else if(sp_status == "nohide"){
			sp_status = "on";
		}
}
//***********************
function save_span_fast_name(sobj){
	alert(sobj.id);
}
//***************************************/
function get_mindex(miid){
	for( var i=0; i<50; i++){
		for(var j=0; j<miid.length-3; j++){
			var a = miid.substring(j, j+3);
			if(a == "_"+i+"_" ){
				//alert("index="+i);
				return i;
			}
		}
	}
}
//***************************************/
</script>
</body>
</html>
