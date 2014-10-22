function addToFilter(shotname, pid, mfilter, fobj){
	if(fobj.checked)
		paction = "paction=addToFilter&sn="+shotname+"&pid="+pid+"&mfilter="+mfilter;
	else
		paction = "paction=addToFilter&sn="+shotname+"&pid="+pid+"&mfilter="+mfilter+"&del=1";
	//alert(paction);
	var __ajax_url = "filter/__ajax_simple_filter.php";
	$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				//alert(window.location.href);
				window.location.href=window.location.href;
				//document.getElementById('divinfo').innerHTML += "Произведено восстановление записи «"+html+"»<br/>\n"; //html;
			}
	});
	return false;
}
//**************************************
function price_sort(pval){
	paction = "paction=pricesort&pricesort="+pval;
	var __ajax_url = "filter/__ajax_simple_filter.php";
	$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				window.location.href=window.location.href;
			}
	});
}
//**************************************
function __sfilter_getPriceDiapason(pval, parent){
	paction = "paction=getPriceDiapason&min="+pval.min+"&max="+pval.max+"&parent="+parent;
	var __ajax_url = "filter/__ajax_simple_filter.php";
	document.getElementById("priceDiapasonButton").innerHTML = "Загрузка";
	document.getElementById("priceDiapasonButton").onclick = false;
	document.getElementById("priceDiapasonButton").parent = parent;
	document.getElementById("priceDiapasonButton").diapason = pval;
	$("#priceDiapasonButton").css("cursor", "");
	$("#priceDiapasonButton").css("display", "");
	$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				document.getElementById("priceDiapasonButton").innerHTML = html;
				$("#priceDiapasonButton").css("cursor", "pointer");
				document.getElementById("priceDiapasonButton").onclick = function(){
					__sfilter_setPriceDiapason();
				}
				//window.location.href=window.location.href;
			}
	});
}
//**************************************
function __sfilter_setPriceDiapason(){
	var pval = document.getElementById("priceDiapasonButton").diapason;
	parent = document.getElementById("priceDiapasonButton").parent
	paction = "paction=setPriceDiapason&min="+pval.min+"&max="+pval.max+"&parent="+parent;
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
function __sfilter_clearFilter(){
	var paction = "paction=clearFilter";
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