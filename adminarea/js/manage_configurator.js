// JavaScript Document
var __ajax_url = "__ajax_manage_config.php";
var myitem = "";
var myitem_sub = "";
var popup_show=false;
//***************************************
function show_conf(pid){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=get_item_type&pid="+pid,
		success: function(html) {
			//alert(html);
			$("#itemtype_name_"+pid).empty();
			$("#itemtype_name_"+pid).append(html);
		}
	});
}
//***************************************
function show_popup(yindex, zindex) {
	myitem = yindex;
	myitem_sub = zindex;
	
	imgs = $("#it_img_"+myitem+"_"+myitem_sub);
	imgs_position = imgs.position();
	
	$("#div_mypopup").css("display", "");
	$("#div_mypopup").css("top", imgs_position.top);
	$("#div_mypopup").css("left", imgs_position.left);
	popup_show = true;
}
//***************************************
document.onmouseup = function(e) {
	e = e || event;
	var o = e.target || e.srcElement;
	//document.title = o.tagName+": id=>"+o.id+": name=>"+o.name;
	if(popup_show) {
		$("#div_mypopup").css("display", "none");
		popup_show = false;
	}
}
//***************************************
function show_pref(){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=get_it_pref&myitem="+myitem+"&myitem_sub="+myitem_sub,
		success: function(html) {
			//alert(html);
			$("#div_it_pref_"+myitem+"_"+myitem_sub).empty();
			$("#div_it_pref_"+myitem+"_"+myitem_sub).append(html);
		}
	});
}
//***************************************
function __lc_mconf_get_data(mconf_val){
	alert(mconf_val);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=__lc_mconf_get_data&myitem="+myitem+"&myitem_sub="+myitem_sub+"&mconf_val="+mconf_val,
		success: function(html) {
			alert(html);
			$("#div_it_pref_"+myitem+"_"+myitem_sub).empty();
			$("#div_it_pref_"+myitem+"_"+myitem_sub).append(html);
		}
	});
}
//***************************************
//function generate_select_itemstypes(){	
//}
//***************************************
