<?
$__page_row = $current;
$show_simple_filter = false;
$my_filter = get_item_type($__page_row["id"]);
//echo "MF=$my_filter";
if( $my_filter ) {
$fquery = "select * from itemstypes where id=$my_filter  ";
$fresp = mysql_query($fquery);
$frow = mysql_fetch_assoc($fresp);
$mass = explode("\n", $frow["pairs"]);
//echo "<pre>"; print_r($mass); echo "</pre>";
foreach ($mass as $key=>$val){
	$vmass = explode("===", $val);
	if(trim($vmass[count($vmass)-1])=="alisa_activefilter"){
		$show_simple_filter = true;
	}
}
if($show_simple_filter){ ?>
<div id="div_filter"><div id="filter_cont">
<?
echo "<div class=\"leftName\"><span>Параметры</span></div>"; 
//**************************************
echo "<div id=\"\" class=\"mtm_v2_level\" style=\"padding-bottom:10px;\" >";
echo "<span class=\"span_mtm\" style=\"float:none;\" ";
echo "><b></b></span>";
echo "<span class=\"span_mtm\" >";  
echo "<input onClick=\"__sfilter_setFilterNalichie('all');\" type=\"checkbox\" value=\"1\" id=\"filterShowWithoutNal\" ";
if($_SESSION["filterNalichie"]=="all" || $_SESSION["filterNalichie"]==""){ echo " checked "; }
echo "  /> ";
$fcount = __mtm_getItemCountFromFilterAll( $_SESSION, $__page_row["id"] );
echo "<span class=\"span_mtm_name\">Показать все ($fcount)</span></span>\n";
echo "<span class=\"span_mtm\" >";  
echo "<input onClick=\"__sfilter_setFilterNalichie('nal');\" type=\"checkbox\" value=\"1\" id=\"filterShowOnlyNal\" ";
if($_SESSION["filterNalichie"]=="nal"){ 
	echo " checked ";
}
echo "  /> ";
$fcount = __mtm_getItemCountFromFilterNal( $_SESSION, $__page_row["id"] );
echo "<span class=\"span_mtm_name\">В наличие ($fcount)</span></span>\n";
echo "</div>";
//**************************************
$specmass = explode("&", $_SESSION["filterSpec"]);
echo "<div id=\"\" class=\"mtm_v2_level\" style=\"padding-bottom:10px;\" >";
echo "<span class=\"span_mtm\" style=\"float:none;\" ";
echo "><b>Специальное</b></span>";
echo "<span class=\"span_mtm\" >";  
echo "<input onClick=\"addToFilterSpec('is_akc', this)\" type=\"checkbox\" value=\"1\" ";
foreach($specmass as $val) if($val=='is_akc') echo " checked ";
echo "  /> ";
$fcount = __mtm_getItemCountFromFilterSpec( $_SESSION, $__page_row["id"], "is_akc" );
echo "<span class=\"span_mtm_name\">Товары по акции ($fcount)</span></span>\n";
echo "<span class=\"span_mtm\" >";  
echo "<input onClick=\"addToFilterSpec('is_new', this)\" type=\"checkbox\" value=\"1\" ";
foreach($specmass as $val) if($val=='is_new') echo " checked ";
echo "  /> ";
$fcount = __mtm_getItemCountFromFilterSpec( $_SESSION, $__page_row["id"], "is_new" );
echo "<span class=\"span_mtm_name\">Новинки ($fcount)</span></span>\n";
echo "</div>";
//**************************************
echo "<div id=\"\" class=\"mtm_v2_level\" style=\"padding-bottom:10px;\" >";
echo "<span class=\"span_mtm\" style=\"float:none;\" ";
echo "><b>Диапазон цен</b></span>"; ?>
<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;margin-bottom:5px;">
<div id="slider-range" style="width:150px;"></div>
<? $prices = __fprices_getDiapason($__page_row["id"]);  ?>
<div class="priceDiapasonButton" id="priceDiapasonButton" style="display:none;">Показать товаров</div>
<?
echo "</div>";
//echo "<pre>"; print_r($_SESSION);; echo "</pre>";
//*******************************************
$showTtitle = true;
$mass = explode("\n", $frow["pairs"]);
foreach ($mass as $key=>$val){
	$vmass = explode("===", $val);
	//echo "<pre>"; print_r($vmass); echo "</pre>";
	if(trim($vmass[count($vmass)-1])=="alisa_activefilter"){
		$ret = "";
		//echo "TEST";
		//echo "<b>$vmass[3]</b><br/>\n";
		$parrow = __fp_get_row_from_way(  explode(  "/", $vmass[5]  ), "items"  );
		//$squery = "select * from $vmass[4] where parent=$parrow[id] $dop_query order by prior asc";
		//$sresp = mysql_query($squery);
		//****************************
		//$dq = "";
		//$dqresp = mysql_query("");
		//****************************
		$squery = "select * from $vmass[4] where parent=$parrow[id] $dop_query order by prior asc";
		//echo $squery."<br/><br/>\n";
		$sresp = mysql_query($squery);
		$count=0;
		while($srow = mysql_fetch_assoc($sresp)){
			$flink = __fp_create_folder_way("items", $srow["id"], 1);
			$flink = preg_replace(  "/\/$/", "", $flink  );
			$dqquery = "select * from $vmass[4] where parent=$__page_row[id] && $vmass[1]='$flink' $dop_query ";
			//echo "$dqquery<br/><br/>\n";
			$dqresp = mysql_query($dqquery);
			if(  mysql_num_rows($dqresp)  >  0  ){
				//$ret .= "addToFilter('$vmass[6]', $srow[id], $my_filter, this)";
				$ret .= "<span class=\"span_mtm\" >";  
				$ret .= "<input onClick=\"addToFilter('$vmass[6]', $srow[id], $my_filter, this)\" type=\"checkbox\" value=\"1\" ";
				if(__ff_test_simple_filter_active($_SESSION["simpleFilter"], $srow["id"]))
					$ret .= " checked ";
				$ret .= "  /> ";
				$fcount = __mtm_getItemCountFromFilter($srow["id"], $val, $_SESSION, $__page_row["id"]);
				$ret .= "<span class=\"span_mtm_name\">$srow[name] ($fcount)</span></span>\n";
				$count++;
			}
			
		}
		if($count>0){
			if($showTtitle){
				
			}
			echo "<div id=\"mtm_level_$level\" class=\"mtm_v2_level\" style=\"padding-bottom:\" >";
			echo "<span class=\"span_mtm\" style=\"float:none;\" ";
			echo "><b>$vmass[3]</b></span>"; //   NAME  ----
			echo $ret;
			//echo "<br/>&nbsp;";
			echo "</div><div style=\"float:none;clear:both;height:10px;\"></div>\n\n";
		}
		//echo "<span class=\"span_mtm\" style=\"
		//	border-bottom-width: 1px; border-bottom-style: dashed; border-bottom-color: #999999;\" ";
		//echo "></span>";
	}
	//print_r($vmass);
}
//print_r($mass);
//echo $my_filter;
/*
?>
<b>Сортировка по цене:</b><br/>
<select onchange="price_sort(this.value)">
	<option value="">По умолчанию</option>
	<option value="tobig" <?  if($_SESSION["simpleFilterSort"] == "tobig")  echo "selected" ?>
	>От дешевых к дорогим</option>
	<option value="tosmall" <?  if($_SESSION["simpleFilterSort"] == "tosmall")  echo "selected" ?>
	>От дорогих к дешевым</option>
</select>
 */ 
//print_r($_SESSION);
echo "<a style=\"font-size: 11px;font-weight: bold;color: #000000;text-decoration: none;\" id=\"aclear_filter\" href=\"javascript:__sfilter_clearFilter()\">Очистить фильтр</a>";
?>
<script>
//**************************************
$(document).ready(function(){
	$(".span_mtm_name").click(function(){
		var objs = this.parentNode.getElementsByTagName("input");
		if(objs.length>0){
			var obj = objs[0];
			if(obj.checked){
				obj.checked = false;
			} else {
				obj.checked = true;
			}
			obj.onclick();
		}
	})
})
//**************************************
$(function() {
	$( "#slider-range" ).slider({
		range: true,
		min: <?=$prices[0]?>,
		max: <?=$prices[1]?>,
		<? if($_SESSION["priceDiapason"]!=""){ ?>values: [ <?=$prices[0]?>, <?=$prices[1]?> ],<? 
			$pdmass = explode("&", $_SESSION["priceDiapason"]);
			$pdrv = "\nvalues: [  ";
			$pdrv .= str_replace("min=", "", $pdmass[0]).", ";
			$pdrv .= str_replace("max=", "", $pdmass[1]);
			echo $pdrv."  ],";
		}else { ?>values: [ <?=$prices[0]?>, <?=$prices[1]?> ],<? } ?>
		slide: function( event, ui ) {
			$( "#amount" ).val( "Цена " + ui.values[ 0 ] + " — " + ui.values[ 1 ] + "грн." );
		},
		change: function( event, ui ) {
			__sfilter_getPriceDiapason({min: ui.values[ 0 ], max: ui.values[ 1 ]}, <?=$__page_row["id"]?>);
		}
	});
	$( "#amount" ).val( "Цена " + $( "#slider-range" ).slider( "values", 0 ) +
	" — " + $( "#slider-range" ).slider( "values", 1 ) + "грн." );
});
//**************************************
function __sfilter_setFilterNalichie(type){
	if(type=="all"){
		document.getElementById("filterShowOnlyNal").checked = false;
	}else{
		document.getElementById("filterShowWithoutNal").checked = false;
	}
	var paction = "paction=setFilterNalichie&type="+type;
	//alert(paction);
	var __ajax_url = "filter/__ajax_simple_filter.php";
	$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				window.location.href=window.location.href;
			}
	});
}
//**************************************
function addToFilterSpec(value, obj){
	var type = "remove";
	if(obj.checked) type = "add";
	var paction = "paction=setFilterSpec&type="+type+"&value="+value;
	var __ajax_url = "filter/__ajax_simple_filter.php";
	$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				window.location.href=window.location.href;
			}
	});
}
//**************************************
</script>
<? //echo "<pre>"; print_r($_SESSION); echo "</pre>"; ?>
</div><div style="float:none; clear:both;"></div>
</div>
<?  }		}  ?>