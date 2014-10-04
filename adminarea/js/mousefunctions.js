var cur_el = false;
var cur_simgid = false;
var item_fastpricedigit = false;
var input_fpd_click = false;
//**************
var gr_XL = 300;
var gr_XR = 650;
var gr_YT = 20;
var gr_YB = 100;
var open_ieditor = true;
var close_ieditor = true;
var tx;
var ty;
//**************
document.onmousemove = function(em) {
	em = em || event;
	var o = em.target || em.srcElement;
	if(em.y) { 
		cur_my = em.y;  
		cur_mx = em.x; 
		
	} else { 
		cur_my = em.pageY - document.body.scrollTop;  
		cur_mx = em.pageX - document.body.scrollLeft; 
	}
	tx = cur_mx+ document.body.scrollLeft;
   	ty = cur_my+document.body.scrollTop;
	
	//document.title = tx + ":::" + ty;
	/*
	 if(tx>gr_XL && tx<gr_XR && ty>gr_YT && ty<gr_YB){
		 //document.title = "true";
		 if(open_ieditor){
			function runEffect() {
				$( "#mycontrol" ).removeAttr( "style" ).hide().fadeIn();
			};
			function callback() {
				//	$( "#mycontrol" ).removeAttr( "style" ).hide().fadeIn();
			};
			
			open_ieditor = false;
			close_ieditor = true;
			runEffect();
			document.title = tx + ":::" + ty;
		}
	} else {
		//document.title = "false";
		if(close_ieditor){
			function runEffect() {
				var selectedEffect = "fade";
				var options = {};
				$( "#mycontrol" ).effect( selectedEffect, options, 500, callback );
			};
			function callback() {
				//	$( "#mycontrol" ).removeAttr( "style" ).hide().fadeIn();
			};
			
			open_ieditor = true;
			close_ieditor = false;
			runEffect();
			document.title = tx + ":::" + ty;
		}
	}*/
	
	//document.title = o.tagName+": id=>"+o.id+": name=>"+o.name;
	cur_el = o;  
	//document.title = cur_el.tagName;
	if(cur_el.className=="simgclass"){
		   cur_simgid = cur_el.id;
	}
}
//***************************************
showadditemtocatalog=false;
showinfo=false;
//***************************************
document.onmouseup = function(e) {
	e = e || event;
	var o = e.target || e.srcElement;
	//document.title = o.tagName+": id=>"+o.id+": name=>"+o.name;
	if(cur_el.id=="additemtocatalogbutton" || showadditemtocatalog) {
		ds_el = document.getElementById("additemtocatalogselect");
		if(ds_el.style.display == ""){
			ds_el.style.display = "none";
			showadditemtocatalog=false;
		} else {
			pos_el = document.getElementById("additemtocatalogbutton");
			as_pos = __images_getAbsolutePos(pos_el);
			ds_el.style.left=(as_pos.x)+"px";
			ds_el.style.top=(as_pos.y+23)+"px";
			ds_el.style.display = "";
			showadditemtocatalog=true;
		}
	}
	/**********
	if(cur_el.id!="mycontrol" && cur_el.parentNode.id!="mycontrol" && cur_el.parentNode.parentNode.id!="mycontrol") {
		close_ieditor = true;
	}
	if(cur_el.id=="mycontrol" && cur_el.parentNode.id=="mycontrol" && cur_el.parentNode.parentNode.id=="mycontrol"  && cur_el.parentNode.parentNode.parentNode.id=="mycontrol") {
		close_ieditor = false;
		alert(cur_el.parentNode.parentNode.id);
	}
	//**********/
	if(cur_el.className=="folders_td_cont") {
		//document.title ="OK TD";
	}
	//**********
	if(cur_el.id=="edititembutton" && editactive) {
		//alert("Начинаем процесс редактирования директории");
		editItemToCatalog("1");
	}
	//**********
	if(cur_el.id=="showinfobutton" || showinfo) {
		ds_el = document.getElementById("divinfo");
		if(ds_el.style.display == ""){
			ds_el.style.display = "none";
			showinfo=false;
		} else {
			pos_el = document.getElementById("showinfobutton");
			as_pos = __images_getAbsolutePos(pos_el);
			ds_el.style.left=(as_pos.x)+"px";
			ds_el.style.top=(as_pos.y+23)+"px";
			ds_el.style.display = "";
			showinfo=true;
		}
	}//**********
	if(cur_el.id=="deletefolderbutton") {
		//alert("ok");
		deleteFolder(cur_folder_id);
	}
	//**********
	if(item_fastpricedigit && !input_fpd_click){
		a = $("#"+item_fastpricedigit+" input");
		objfpd = a[0];
		newfpd = objfpd.value;
		$("#"+item_fastpricedigit).empty();
		$("#"+item_fastpricedigit).append(newfpd);
		paction = "paction=fast_pricedigit_change&newprice="+newfpd+"&pid="+item_fastpricedigit.replace("item_price_","");
		item_fastpricedigit = false;
		//alert(paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
			}
		});
	}
	if(item_fastpricedigit && input_fpd_click){
		input_fpd_click = false;
	}
	//*************************************
	$("#items_left_menu a").off( "mouseenter mouseleave" );
	$("#rootfoldermenu a").off( "mouseenter mouseleave" );
	$("#rootfoldermenu a").css("background-color", "");
	//rowToFolderDragNDrop = false;
	//itemToFolderDragNDrop = false;
	//alert(cur_el.id);
	//*************************************
	if(__au_init_active){
		__au_save_data();
	}
	//*************************************
}
//***************************************
function __images_getAbsolutePos(el)
{
var r = { x: el.offsetLeft, y: el.offsetTop }
	if (el.offsetParent){
		var tmp = __images_getAbsolutePos(el.offsetParent);
		r.x += tmp.x;
		r.y += tmp.y;
	}
	return r;
}
//*********************************
