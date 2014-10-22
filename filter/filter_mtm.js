//***************************************
function __mtm_get_filter(level, pid, obj){
	if(obj.checked){
		ppdata = "paction=getfilter&filter_itemid="+filter_itemid+"&parid="+filter_parid+"&pid="+activate_filter+"&addfilter="+level+"-"+pid;
		//alert(ppdata);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: ppdata,
			success: function(html) {
				//alert(html);
				$("#filter_cont").empty();
				$("#filter_cont").append(html);
				init_mtm_arrow();
				//getfilternohide_json();
			}
		});
	} else {
		ppdata = "paction=getfilter&filter_itemid="+filter_itemid+"&parid="+filter_parid+"&pid="+activate_filter+"&clearfilter="+level+"-"+pid;
		//alert(ppdata);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: ppdata,
			success: function(html) {
				//alert(html);
				$("#filter_cont").empty();
				$("#filter_cont").append(html);
				init_mtm_arrow();
				//getfilternohide_json();
			}
		});
	}
}
//***************************************
function init_mtm_arrow(){
	obj_mtm_fc = document.getElementById("filter_cont");
	$("#filter_arrow").css("position", "absolute");
	obj_mtm_fc.onmousemove = function(em) {
		em = em || event;
		var o = em.target || em.srcElement;
		if(em.y) { 
			cur_my = em.y;  
			cur_mx = em.x; 
		} else { 
			cur_my = em.pageY - document.body.scrollTop;  
			cur_mx = em.pageX - document.body.scrollLeft; 
		}
		ammx = cur_mx+ document.body.scrollLeft;
		ammy = cur_my+document.body.scrollTop;//-document.getElementById("filter_cont").scrollHeight;
		$("#filter_arrow").css("top", ammy-120);
		pos = __positions_getAbsolutePos(obj_mtm_fc);
		wwwidth = document.body.clientWidth;
		//$("#filter_arrow").css("left", wwwidth/2-300);
		$("#filter_arrow").css("left", 200);
	}
	//***********
	$("#filter_arrow").hide();
	$("#filter_cont").hover(function() {
		$("#filter_arrow").fadeIn();
	}, function() {
		$("#filter_arrow").fadeOut();
	});
	//***********
	if(ffa_off){
		$("#filter_arrow").fadeIn();
	}
	$("#filter_arrow").css("top", mmy-120);
	pos = __positions_getAbsolutePos(obj_mtm_fc);
	wwwidth = document.body.clientWidth;
	//$("#filter_arrow").css("left", wwwidth/2-300);
	$("#filter_arrow").css("left", 200);
	ffa_off=true;
}
//***************************************
function getfilternohide_json(){
	ppdata = "paction=getfilternohide_json&parid="+filter_parid+"&pid="+activate_filter;
	$.ajax({
		type: "POST",
		url: "__ajax.php",
		data: ppdata,
		success: function(html) {
			//alert(html);
			jdata = eval( "(" + html + ")" );
			//alert(json_length(jdata));
			if(json_length(jdata)<0) return false;
			//***********
			li_items_ul = document.getElementById("ul_itemsid");
			li_items = li_items_ul.getElementsByTagName("li");
			for(jj=0; jj<li_items.length; jj++){
				li_item = li_items[jj];
				clid = li_item.id.replace(/itemid_/gi , "");
				hide = true;
				for(var i=0; i<json_length(jdata); i++){
					//alert(jdata[i]+"::"+clid);
					if(jdata[i] == clid)
						hide = false;
				}
				if(hide){
					li_item.style.display = "none";
				} else {
					li_item.style.display = "";
				}
			}
		}
	});
}
/***************************************
function clear_filter(){
		ppdata = "paction=getfilter&filter_clear=1&filter_itemid="+filter_itemid+"&parid="+filter_parid+"&pid="+activate_filter;
		//alert(ppdata);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: ppdata,
			success: function(html) {
				//alert(html);
				window.location.href = filter_folder;
			}
		});
}
//***************************************/
function filter_start(){
		ppdata = "paction=getfilter&filter_start=1&filter_itemid="+filter_itemid+"&parid="+filter_parid+"&pid="+activate_filter;
		//alert(ppdata);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: ppdata,
			success: function(html) {
				//alert(html);
				window.location.href = filter_folder;
			}
		});
}
//***************************************
function mtm_get_select(mtm_id, mtm_level){
		ppdata = "paction=mtm_get_select&mtm_level="+mtm_level+"&mtm_id="+mtm_id;
		if(mtm_init){
			mtm_dataselect = __mtm_dataselect();
			ppdata += "&mtm_dataselect="+mtm_dataselect;
		} else {
			ppdata += "&mtm_dataselect=0:-1~1:-1~2:-1~3:-1";
		}
		//alert(ppdata);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: ppdata,
			success: function(html) {
				//alert(html);
				$("#mtm_dsel").empty();
				$("#mtm_dsel").append(html);
				mtm_init = true;
			}
		});
}
//***************************************
function __mtm_dataselect(){
	rv = "";
	cc = 0;
	for(j=0; j<mtmLevels; j++){
		if(j>0) rv += "~";
		rv += j+":"+$("#mtm_sel_"+j).val();
	}
	return rv;
}
//***************************************
function add_to_r_mtm(torec){
	st = true;
	if(!document.getElementById("mtm_sel_0")) {
		alert("Выберите цвет");
		st = false;
	}
	ao = document.getElementById("mtm_sel_0").value;
	if(ao==-1 && st){
		alert("Выберите цвет");
		st = false;
	}
	if(!document.getElementById("mtm_sel_1") && st) {
		alert("Выберите размер");
		st = false;
	}
	bo = document.getElementById("mtm_sel_1").value;
	if(bo==-1 && st){
		alert("Выберите размер");
		st = false;
	}
	if(st) {
		ppdata = "basket="+torec+":1:"+ao+":"+bo+"&pid="+idrec;
		//alert(ppdata);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: ppdata,
			success: function(html) {
				//alert(html);
				if(idrec) {
					$("#reccrecc_"+idrec).empty();
					$("#reccrecc_"+idrec).append(html);
					idrec=false;	
				} else {
					$("#reccrecc").empty();
					$("#reccrecc").append(html);
				}
			}
		});
	}
}
//***************************************
function alert_filter_error(fenum){
	//alert(  document.getElementById("filter_name_"+fenum).innerHTML  );
	title_dlg = "Ошибка заполнения";
	info = "Выберите " + document.getElementById("filter_name_"+fenum).innerHTML;
	$("#mtm_sel_"+fenum).css("background-color", "#FE52B5");
	$("#dialog").empty();
	$("#dialog").append(info);
	$( "#dialog" ).dialog({
		title: title_dlg,
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Ok": function() {
				$("#dialog").dialog("close");
			}
		}
	});
}
//***************************************