var __ajax_url = "__ajax.php";
var bro_ie=false;
var httpaction = "tree"; 
var editactive = false;
var cur_folder_id = 0;
var addnewitem = false;
var load_json = false;
var post_object = false;
var show_uc_window = false;
if (/MSIE (5\.5|6).+Win/.test(navigator.userAgent))	{
	bro_ie = true;
}
//*****************
$(document).ready(function(){
	$("#left_panel_close").click(function(){		  
		if(this.src.match(/left_panel_close\.gif$/)){
			$("#tdadminarealeft").css("display", "none");
			$("#inleftmenu").css("display", "none");
			$(this).css("left", "0px");
			this.src = "images/green/left_panel_open.gif";
		} else {
			$("#tdadminarealeft").css("display", "");
			$("#inleftmenu").css("display", "");
			$(this).css("left", "336px");
			this.src = "images/green/left_panel_close.gif";
		}
		
	})
})
//*****************
function get_menu(menu_id){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=getmenu&id="+menu_id,
		success: function(html) {
			$("#items_left_menu").empty();
			$("#items_left_menu").append(html);
		}
	});
}
//*****************
function replace_spec_simbols(spectxt){
	ret = spectxt;
	ret = ret.replace(/&sup2;/gi , "<sup>2</sup>");
	ret = ret.replace(/&sup3;/gi , "<sup>3</sup>");
	ret = ret.replace(/&deg;/gi , "<sup>o</sup>");
	ret = ret.replace(/&/gi , "~~~aspirand~~~");
	ret = ret.replace(/\+/gi , "~~~plus~~~");
	//ret = ret.replace(/&frac12;/gi , "1/2"); 
	return ret;
}
//*****************
function json_length (the_object) {
    var jcount = 0
    for (var item in the_object) {
        jcount++
    }
    return jcount;
}
//*****************
function show_li_item(t_index, item_id){
		httpaction = "tree";
		liobj = document.getElementById("li_item_" + item_id);
		ulobjs = liobj.getElementsByTagName("UL");
		imgobjs = liobj.getElementsByTagName("IMG");
		if(ulobjs.length > 0){
			liobj.removeChild(ulobjs[0]);
			imgobjs[0].src="tree/plus.jpg";
		} else {
			//alert("Ok");
			imgobjs[0].src="tree/minus.jpg";
			httpaction = "tree";
			requestdata("?action=loaditems&tree_index="+t_index+"&parent="+item_id);
		}
	//alert(liobj.id);
}
//*****************

var req;
var reqTimeout;
var temp = "";
var load_t = "";
var cur_item_id = "0";
var cur_parent = "0";

//*****************
function getiteminfo_save(itemid){
	//alert("load_json="+load_json);
	if(load_json){
		load_json=false;
		paction = "paction=getjsonpostdata&id="+itemid;
		//alert(paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				var npaction = "paction=savejsonpostdata&id="+itemid;
				post_object = eval( "(" + html + ")" );
				//alert(json_length(post_object));
				//alert(JSON.stringify(post_object));
				for(var i=0; i<json_length(post_object); i++){
					//alert(post_object[i][0]+" :::: "+post_object[i][1]);
					//alert(i);
					//alert(post_object[i][1]);
					if(document.getElementById(post_object[i][1]).type == "checkbox"){
						if(document.getElementById(post_object[i][1]).checked==true){
							npaction += "&" + post_object[i][0] + "=1"; 
						} else {
							npaction += "&" + post_object[i][0] + "=0"; 
						}
					} else if( post_object[i][0] == "item_cont"){
						if(tiny_init){
					npaction += "&" + post_object[i][0] + "=" + replace_spec_simbols(tinyMCE.get('item_cont').getContent());
							tinyMCE.execCommand('mceToggleEditor',false,'item_cont');
							tinyMCE.execCommand('mceRemoveControl',true,'item_cont');
						} else {
							item_cont_ss = document.getElementById("item_cont").value;
							npaction += "&" + post_object[i][0] + "=" + replace_spec_simbols(item_cont_ss);
							//alert("item_cont:\n\n "+item_cont_ss);
						}
						
					} else if(post_object[i][0] == "multiprice"){
						var mp = "";
						var mpObj = document.getElementById("tablemultiprice").firstChild.children;
						for(var mpj=1; mpj<mpObj.length; mpj++){
							mp += mpObj[mpj].children[0].firstChild.value+"~";
							mp += mpObj[mpj].children[1].firstChild.value+"~";
							mp += mpObj[mpj].children[2].firstChild.value+"~";
							if(mpObj[mpj].children[3].firstChild.tagName=="img"  ||  mpObj[mpj].children[3].firstChild.tagName=="IMG"){
								fid = mpObj[mpj].children[3].firstChild.id.replace(/^mtpi_/gi, "fileid=");
								fid = fid.replace(/_[0-9]*$/, "");
								mp += fid+"~";
							} else {
								mp += "~";
							}
							mp += mpObj[mpj].children[4].firstChild.value+"\n";
						}
						mp = mp.replace(/~\n/gi, "\n");
						mp = mp.replace(/\n$/gi, "");
						//alert(mp);
						npaction += "&multiprice="+mp;
						//return false;
					} else if(post_object[i][0] == "sfmany"){
						//alert("test");
						mobj = document.getElementById("sfmany");
						mobjs = mobj.getElementsByTagName("option");
						oobj_txt = "";
						for(moj=0; moj<mobjs.length; moj++){
							oobj = mobjs[moj];
							if(oobj.selected) {
								if(oobj_txt != "") oobj_txt += ",";
								oobj_txt += oobj.value;
							}
							//alert(oobj.selected+"::"+oobj.innerHTML+"::"+oobj.value);
						}
						npaction += "&" + post_object[i][0] + "=" +oobj_txt; 
					//} else if(post_object[i][0] == "parent"){
					//	npaction += "&" + post_object[i][0] + "=1"; 
					} else if(post_object[i][0] == "coder") {
							//alert("coder");
							npaction += "&coder="+replace_spec_simbols(document.getElementById(post_object[i][1]).value);
							//replace_spec_simbols
					} else {
						//if(post_object[i][0] != "saveblock" )
						//npaction += "&" + post_object[i][0] + "=" + document.getElementById(post_object[i][1]).value;
						npaction += "&" + post_object[i][0] + "=" + document.getElementById(post_object[i][1]).value;
					}
				}
				//alert(cur_item_id + ":::" + npaction); //return;
				$.ajax({
					type: "POST",
					url: __ajax_url,
					data: npaction,
					success: function(html) {
						//alert(html);
						//if(tiny_init){
						//	tinyMCE.execCommand('mceToggleEditor',false,'item_cont');
						//	tinyMCE.execCommand('mceRemoveControl',true,'item_cont');
						//	tiny_init = false;
						//}
						//obj_m.style.display="none";
						//obj_w.style.display="none";
						//reload_single_item(cur_item_id);
						cur_item_id = 0;
						show_ritems(cur_folder_id);
						citiesLoaded = false;
						if(verify)  verify.parentNode.removeChild(verify);
						pac = document.querySelector('.pac-container');
						if(pac) pac.parentNode.removeChild(pac);
						document.getElementById('divinfo').innerHTML += "Произведено редактирование элемента средствами json+ajax<br/>\n"+html+"<br/>\n";
					}
				});
			}
		});
		return false;
	}
	var item_name = $("#item_name").val();
	var item_code = $("#item_code").val();
	var item_art = $("#item_art").val();
	var item_psevdoart = $("#item_psevdoart").val();
	var item_href_name = $("#item_href_name").val();
	
	var item_mtitle = $("#item_mtitle").val();
	var item_mdesc = $("#item_mdesc").val();
	var item_mh = $("#item_mh").val();
	
	var item_prior = $("#item_prior").val();
	var item_parent = $("#item_parent").val();
	var item_price = $("#item_price").val();
	var galtype = $("#galtype").val();
	
	var psevdonum = $("#psevdonum").val();
	
	var folder_filter = $("#folder_filter").val();
	var fpage_show = "0";
	//if(document.getElementById("fpage_show").checked==true){
	//	fpage_show = "1";
	//}
	
	
	//alert(document.getElementById("page_show").checked); return false;
	var page_show = "0";
	if(document.getElementById("page_show").type == "checkbox"){
		if(document.getElementById("page_show").checked==true){
			page_show = "1";
		} else {
			page_show = "0";
		}
	}
	
	if(tiny_init){
		tinyMCE.execCommand('mceToggleEditor',false,'item_cont');
		var item_cont = tinyMCE.get('item_cont').getContent();
		tinyMCE.execCommand('mceRemoveControl',true,'item_cont');
		item_cont = replace_spec_simbols(item_cont);
	}
	//item_cont = item_cont.replace(/'/gi , "\\'");
	//alert("cont = " + item_cont); return false;
	//************
	var ii_params   = "&item_name="+item_name;
	ii_params += "&item_code="+item_code;
	ii_params += "&item_art="+item_art;
	ii_params += "&item_psevdoart="+item_psevdoart;
	
	ii_params += "&item_href_name="+item_href_name;
	ii_params += "&item_mtitle="+item_mtitle;
	ii_params += "&item_mdesc="+item_mdesc;
	ii_params += "&item_mh="+item_mh;
	
	ii_params += "&item_prior="+item_prior;
	ii_params += "&item_parent="+item_parent;
	ii_params += "&item_price="+item_price;
	ii_params += "&galtype="+galtype;
	
	//ii_params += "&psevdonum="+psevdonum;
	//ii_params += "&fpage_show="+fpage_show;
	
	ii_params += "&item_page_show="+page_show;
	
	if(tiny_init){
		ii_params += "&item_conta="+item_cont;
	}
	//************
	
	//alert(ii_params);
	
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=saveiteminfo&id="+itemid+ii_params,
		success: function(html) {
			//alert(html);
			//reload_single_item(cur_item_id);
			cur_item_id = 0;
			show_ritems(cur_folder_id);
			citiesLoaded = false;
			if(verify)  verify.parentNode.removeChild(verify);
			pac = document.querySelector('.pac-container');
			if(pac) pac.parentNode.removeChild(pac);
			document.getElementById('divinfo').innerHTML += "Произведено редактирование"+html+"<br/>\n";
			//document.getElementById("tr_item_s_"+itemid).style.display = "";
			//document.getElementById("tr_item_"+itemid).style.display = "none";
			//document.getElementById("td_item_"+itemid).innerHTML = "";
			
		}
	});
}
//*****************
function getiteminfo_close(itemid){
	//$("#tr_item_s_"+itemid).css("display", "");
	//document.getElementById("tr_item_s_"+itemid).style.display = "";
	//$("#tr_item_"+itemid).css("display", "none");
	//document.getElementById("tr_item_"+itemid).style.display = "none";
	//$("#td_item_"+itemid).empty();
	if(tiny_init){
		tinyMCE.execCommand('mceToggleEditor',false,'item_cont');
		tinyMCE.execCommand('mceRemoveControl',true,'item_cont');
		tiny_init = false;
	}
	obj_m.style.display="none";
	obj_w.style.display="none";
	$("#show_myitemblock_cont").empty();
	citiesLoaded = false;
	if(verify)  verify.parentNode.removeChild(verify);
	pac = document.querySelector('.pac-container');
	if(pac) pac.parentNode.removeChild(pac);
	//$("#show_myitemblock_cont").empty();
	//$("#root_body").removeClass("noscroll");
	//$(document).unbind('mousewheel');
	//$(window).unbind("scroll mousewheel");
	//$(document.body).css({
	//	overflow: ""
	//});

	//document.getElementById("td_item_"+itemid).innerHTML = "";
	cur_item_id = 0;
}
//*****************
var item_pop_up_init = false;
function getiteminfo(itemid){
	//alert("paction=getfolderinfo&id="+itemid);
	//if(cur_item_id!=0){
	//	getiteminfo_close(cur_item_id);
	//}
	//******************************
	//alert("getiteminfo");
	tiny_init = false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=getfolderinfo&id="+itemid,
		success: function(html) {
			cur_item_id = itemid;
			$("#show_myitemblock_cont").empty();
			$("#show_myitemblock_cont").append(html);
			//*****
			$("#myDiv").contextMenu({
						menu: 'myMenu',
						oncontext: function(){
										  alert("ok");
						},
						onShowMenu: function(){
										  alert("ok2");
						}
			},
			function(action, el, pos) {
				//obj_tt = document.getElementById(cur_simgid);
				//alert(obj_tt.style.backgroundImage);
				if(action=="sort"){
					images_set_sort();
				}
				if(action=="delete"){
					images_delete();
				}
				if(action=="edit"){
					show_new_img_popup(cur_simgid);
				}
				if(action=="editpic"){
					show_edit_img_popup(cur_simgid);
				}
				if(action=="pictotext"){
					movePicToText(cur_simgid);
				}
				if(action=="pictype"){
					changePicType(cur_simgid);
				}
				if(action=="pictotextef"){
					movePicToTextEf(cur_simgid);
				}
				if(action=="addlogo"){
					addLogo(cur_simgid);
				}
			});
			//*****
			$(function() {
				$( "#datepicker" ).datepicker( $.datepicker.regional[ "ru" ] );
			});
			//*****
			item_pop_up_init = true;
			//$("#show_myitemblock_cont").keyup(function(event) {
			//   //alert(event.which);
			//}).keydown(function(event) {
			//	//alert(event.which);
			//	if (event.which == 13) {
			//		getiteminfo_save(cur_item_id);
			//	}
			//	if (event.which == 27) {
			//		getiteminfo_close(cur_item_id);
			//	}
			//});
			//*****
			//obj_tt = $("#myDiv");
			__jl_init_uploader(); 
		}
		//**************
	});
}
//*****************
function forming_contextmenu(){
	obj_tt = document.getElementById(cur_simgid).parentNode;
	murl = obj_tt.style.backgroundImage;
	if(  murl.match(/pic_in_text*/i)  ){
		$("#pictype_txt").css("background-image", "url(images/green/icons/galochka.gif)");
		$("#pictype_gal").css("background-image", "none");
	}
	if(  murl.match(/pic_in_gal*/i)  ){
		$("#pictype_txt").css("background-image", "none");
		$("#pictype_gal").css("background-image", "url(images/green/icons/galochka.gif)");
	}
}
//*****************
function processReqChange() {
    if (req.readyState == 4) {
        clearTimeout(reqTimeout);
        //alert(req.status);
		if (req.status == 200) {
			//alert(req.responseText + "::" + httpaction);
			if(httpaction=="showadditemtocatalog"){
				//show_edit_folder(req.responseText);
				//setTimeout('nowaitload = true"', 500);
			}
			if(httpaction=="tree"){
				liobj.innerHTML += req.responseText;
				httpaction = "";
				//setTimeout('nowaitload = true"', 500);
			}
			if(httpaction=="getfolderinfo"){
				//alert(req.responseText);
				//showfolderinfo(req.responseText);
				//setTimeout('nowaitload = true"', 500);
				//test_edit_active(rid);
				//liobj.innerHTML += req.responseText;
			}
        } else {
            alert("Не удалось получить данные:\nПопробуйте повторить запрос\n" + req.statusText);
        }
    }  
}

function loadXMLDoc(url) {
	req = null;
    if (window.XMLHttpRequest) {
        try {
            req = new XMLHttpRequest();
        } catch (e){}
    } else if (window.ActiveXObject) {
        try {
            req = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e){
            try {
                req = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (e){}
        }
    }
 
    if (req) {
        req.onreadystatechange = processReqChange;
        req.open("GET", url, true);
        req.send(null);
        reqTimeout = setTimeout("req.abort();", 5000);
    } else {
        alert("Браузер не поддерживает AJAX");
    }
}

function requestdata(params)
{
  //alert(__ajax_url+params);
  loadXMLDoc(__ajax_url + params);
}

//************************************************************
//************************************************************
//************************************************************
//OTHER FUNCTIONS
//******************************
function show_news(){
	alert("news");
}

//FOLDERS FUNCTIONS
//******************************
function delete_item_recc(){
	if (confirm("Удалить все записи из корзины?")) {
		//alert("Ok"+cur_simgid);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=delete_item_recc",
			success: function(html) {
				//alert(html);
				document.getElementById('divinfo').innerHTML += "Произведена очистка корзины<br/>\n"; //html;
				show_ritems("recc");
				//document.getElementById('divinfo').innerHTML += html;
				//images_get_images();
			}
		});
	}
}
//******************************
function delete_item_form_recc(difr_id){
	if (confirm("Удалить запись из корзины?")) {
		//alert("Ok"+cur_simgid);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=delete_item_form_recc&id="+difr_id,
			success: function(html) {
				//alert(html);
				document.getElementById('divinfo').innerHTML += "Произведено удаление из корзины записи №"+difr_id+"<br/>\n"; //html;
				show_ritems("recc");
				//document.getElementById('divinfo').innerHTML += html;
				//images_get_images();
			}
		});
	}
}
//******************************
function resc_item(rescid){
	$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=resc_item&id="+rescid,
			success: function(html) {
				//alert(html);
				document.getElementById('divinfo').innerHTML += "Произведено восстановление записи «"+html+"»<br/>\n"; //html;
				show_ritems("recc");
				//document.getElementById('divinfo').innerHTML += html;
				//images_get_images();
			}
	});
}
//******************************
function show_recc(){
	//alert("test");
	show_ritems("recc");
}
//******************************
function delete_item(delid){
	var tmpiname = document.getElementById("span_myitemname_"+delid).innerHTML;
	if (confirm("Удалить запись «" + tmpiname + "»?")) {
		//alert("Ok"+cur_simgid);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=delete_item&id="+delid,
			success: function(html) {
				//alert(html);
				document.getElementById('divinfo').innerHTML += "Произведено удаление записи «"+tmpiname+"»<br/>\n"; //html;
				show_ritems(cur_folder_id);
				//document.getElementById('divinfo').innerHTML += html;
				//images_get_images();
			}
		});
	}
}
//******************************
function editItemToCatalog_post(folder){
	//alert(" cur_folder_id = " + cur_folder_id);
	var ppdata = "paction=editItemToCatalog_post";
	ppdata += "&efolder_name=" + $("#folder_name").val();
	ppdata += "&efolder_item_type=" + $("#folder_item_type").val();
	ppdata += "&efolder_href_name=" + $("#folder_href_name").val();
	
	ppdata += "&psevdonum=" + $("#psevdonum").val();
	ppdata += "&folder_icon=" + $("#folder_icon").val();
	ppdata += "&folder_title=" + $("#folder_title").val();
	ppdata += "&folder_desc=" + $("#folder_desc").val();
	
	ppdata += "&folder_art=" + $("#folder_art").val();
	ppdata += "&folder_code=" + $("#folder_code").val();
	
	ppdata += "&efolder_prior=" + $("#folder_prior").val();
	//alert($("#fassoc").val());
	ppdata += "&efolder_assoc=" + $("#fassoc").val();
	ppdata += "&efolder_parent=" + $("#folder_parent").val();
	ppdata += "&id=" + $("#ffolder_id").val();
	if(document.getElementById("cb_active_filter").checked){
		ppdata += "&folder_filter=" + $("#folder_filter").val();
	}
	
	//fpage_show = "0";
	if(document.getElementById("fpage_show").checked==true){
		ppdata += "&fpage_show=1";
	} else {
		ppdata += "&fpage_show=0";
	}
	//******************
	//alert(tiny_init);
	if(tiny_init){
		tinyMCE.execCommand('mceToggleEditor',false,'folder_cont');
		fcont = tinyMCE.get('folder_cont').getContent();
		tinyMCE.execCommand('mceRemoveControl',true,'folder_cont');
		tiny_init = false;
		ppdata += "&efolder_cont=" + replace_spec_simbols(fcont);
	} else {
		fcont = document.getElementById('folder_cont').value;
		tiny_init = false;
		ppdata += "&efolder_cont=" + replace_spec_simbols(fcont);
	}
	//******************
	
	
	
	//alert(ppdata);
	
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			//alert(" cur_folder_id = " + cur_folder_id);
			//alert(html);
			//show_edit_folder(html);
			get_menu(cur_folder_id);
			show_ritems(cur_folder_id);
			document.getElementById('divinfo').innerHTML += "Редактирование директории:<br/> "+html+"<br/>\n";
		}
	});
}
//******************************
function addItemToCatalog(folder){
	root_folderhtml = folder;
	if(folder!=1) {
		folder=0;
		pdata = "paction=newitem&folder="+folder+"&parent="+cur_folder_id
	} else {
		pdata = "paction=newitem&folder="+folder+"&parent="+cur_parent;
	}
	//alert(pdata);
	//var pdata = "paction=newitem&folder="+folder+"&parent="+cur_parent;
		
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: pdata,
		success: function(html) {
			//alert(html);
			if(folder){
				show_edit_folder(html);
			} else {
				addnewitem=true;
				show_myitemblock(html);
				getiteminfo(html);
				document.getElementById('divinfo').innerHTML += "Добавлена запись с идентификатором "+html+"<br/>\n";
				//alert(html);
			}
			//else 
				
		}
	});
}
//******************************
function editItemToCatalog(folder){
		//alert(" cur_folder_id = " + cur_folder_id);
		paction = "paction=edititem&folder="+folder+"&id="+cur_folder_id;
		//alert("paction="+paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				show_edit_folder(html);
			}
	});
}
//******************************
function show_edit_folder(folderhtml){
	efobj = document.getElementById("edit_content");
	efobj.style.display = "";
	efobj.innerHTML = folderhtml;
		
	//setTimeout("tinymce_init();", 500);
	//tinymce_init();
	//tiny_init = true;
	httpaction = "";
	//**********************************
	$("#myDiv").contextMenu({
				menu: 'myMenu',
				context: function(){
								  alert("ok");
				}
	},
	function(action, el, pos) {
		if(action=="sort"){
			images_set_sort();
		}
		if(action=="delete"){
			images_delete();
		}
		if(action=="edit"){
			show_new_img_popup(cur_simgid);
		}
		if(action=="editpic"){
			show_edit_img_popup(cur_simgid);
		}
		if(action=="pictotext"){
			movePicToText(cur_simgid);
		}
		if(action=="pictotextef"){
			movePicToTextEf(cur_simgid);
		}
		if(action=="addlogo"){
			addLogo(cur_simgid);
		}
	});
	//*****
	
	__jl_init_uploader();
	
	
	//alert(document.getElementById("edit_folder_id").value);
}
//******************************
function deleteFolder(fid){
	if(fid<1) {
		alert("Невозможно удалить корневую директорию"); return false;
	}
	if (confirm("Вы желаете удалить директорию «"+document.getElementById("folders_title").innerHTML+"»")) {
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=deletefolder&id="+fid,
			success: function(html) {
				get_menu("0");
				show_ritems("0");
			}
		});
	}
}
//******************************
function send_folder_name(folderhtml){
	alert("Send");
}
//******************************
var folderParam = false;
function show_ritems(rid, page, prefix){
	//************
	if(rid == "help"){
		//$("#edit_folder_cat_button").css("display", "none");
		//$("#deletefolderbutton").css("display", "none");
		get_outer_help_ajax();
		return;
	}
	//************
	if(rid!="orders") if(!page) page = "";
	if(!prefix) prefix = "";
	paction = "paction=rootgetfolderinfo&id="+rid+"&page="+page+"&prefix="+prefix;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			folderParam = false;
			if(html.match(/^folderparam=no\n/)){
				for(var mj=0; mj<html.length; mj++){
					if(html[mj]=="\n"){
						break;
					}
				}
				folderParam = html.substring(0, mj);
				folderParam = folderParam.replace(/^folderparam=/, "");
				//alert(folderParam);
				html = html.replace(/^folderparam=no\n/, "");
			}
			efobj = document.getElementById("edit_content");
			efobj.style.display = "";
			if(html.match(/^<!-- itemgoo -->/)) init_dop_popup_v_01_var = false;
			else init_dop_popup_v_01_var = true;
			//alert(html);
			efobj.innerHTML = html;
			if(rid=="users") {
				__au_init_all();
				$("#add_user_button").css("display", "");
				$("#edit_folder_cat_button").css("display", "none");
				$("#deletefolderbutton").css("display", "none");
				$("#add_item_to_cat_button").css("display", "none");
				$("#add_folder_to_cat_button").css("display", "none");
				//alert("ok");
				return false;
			}
			if(rid=="orders") {
				//__ao_init_all();
				$("#add_user_button").css("display", "none");
				$("#edit_folder_cat_button").css("display", "none");
				$("#deletefolderbutton").css("display", "none");
				$("#add_item_to_cat_button").css("display", "none");
				$("#add_folder_to_cat_button").css("display", "none");
				return false;
			}
			cur_folder_id = rid;
			get_menu(cur_folder_id);
			init_dop_popup_v_01();
			init_search();
			if(rid==0 || folderParam){
				$("#edit_folder_cat_button").css("display", "none");
				$("#deletefolderbutton").css("display", "none");
				$("#add_user_button").css("display", "none");
				$("#add_item_to_cat_button").css("display", "");
				$("#add_folder_to_cat_button").css("display", "");
			} else {
				$("#edit_folder_cat_button").css("display", "");
				$("#deletefolderbutton").css("display", "");
				$("#add_user_button").css("display", "none");
				$("#add_item_to_cat_button").css("display", "");
				$("#add_folder_to_cat_button").css("display", "");
			}
		}
	});
	test_edit_active(rid);
}
//******************************
function edit_agq(pid){
	var obj = document.getElementById("agq_"+pid);
	//alert(obj);
	var inner = obj.innerHTML;
	inner = inner.replace(/<br>/gi, '\n');
	inner = "<textarea style=\"height:135px;width:270px;\" id=\"agqta_"+pid+"\">"+inner+"</textarea><br/>";
	inner += "<input type=\"button\" value=\"Ок\" onClick=\"edit_agq_post("+pid+")\" >";
	obj.innerHTML = inner;
}
function edit_agq_post(pid){
	var paction = "paction=edit_agq_post&pid="+pid+"&item_conta="+replace_spec_simbols(document.getElementById("agqta_"+pid).value);
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			show_ritems(cur_folder_id);
		}
	});
}
//******************************
function edit_agr(pid){
	var obj = document.getElementById("agr_"+pid);
	//alert(obj);
	var inner = obj.innerHTML;
	inner = inner.replace(/<br>/gi, '\n');
	inner = "<textarea style=\"height:135px;width:270px;\" id=\"agrta_"+pid+"\">"+inner+"</textarea><br/>";
	inner += "<input type=\"button\" value=\"Ок\" onClick=\"edit_agr_post("+pid+")\" >";
	obj.innerHTML = inner;
}
function edit_agr_post(pid){
	var paction = "paction=edit_agr_post&pid="+pid+"&item_conta="+replace_spec_simbols(document.getElementById("agrta_"+pid).value);
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			show_ritems(cur_folder_id);
		}
	});
}
//******************************
function test_edit_active(rid){
	//alert("rid="+rid);
	if(rid && rid!="0") {
		editactive = true;
		cur_item_id = rid;
		//document.getElementById("edititembutton").src = "images/green/__top_edit.gif";
	} else {
		editactive = false;
		cur_item_id = "0";
		//document.getElementById("edititembutton").src = "images/green/__top_edit_na.gif";
	}
}
//******************************
function images_set_sort(){
	//alert("OK");
	if(document.getElementById("images_items").style.display==""){
		document.getElementById("images_items").style.display="none";
		document.getElementById("sortable").style.display="";
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=getimgprior_sort&id="+cur_item_id,
			success: function(html) {
				$("#sortable").empty();
				$("#sortable").append(html);
				$(function() {
					$( "#sortable" ).sortable();
					$( "#sortable" ).disableSelection();
				});
			}
		});
	} else {
		document.getElementById("images_items").style.display="";
		document.getElementById("sortable").style.display="none";
	}
}
//******************************
function images_delete(){
	if (confirm("Удалить изображение \n\n" + document.getElementById(cur_simgid).alt)) {
		//alert("Ok"+cur_simgid);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=images_delete&id="+cur_simgid,
			success: function(html) {
				document.getElementById('divinfo').innerHTML += html+"<br/>\n";
				images_get_images();
			}
		});
	}
}
//******************************
function delete_filemanager_item(itemId, confTitle, callback){
	if (confirm(confTitle)) {
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=delete_filemanager_item&id="+itemId,
			success: function(html) {
				setTimeout(callback, 1);
			}
		});
	}
}
//******************************
function save_myitems_prior(){
	var priors = $('#myitems_sortable').sortable('toArray');
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=save_myitems_prior&id="+priors,
		success: function(html) {
			//alert("ok");
		}
	});
}
//******************************
function change_item_parent_dnd(dndid, dndparent){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=change_item_parent_dnd&pid="+dndid+"&parent="+dndparent,
		success: function(html) {
			show_ritems(cur_folder_id);
			//alert(html);
			//alert("ok");
		}
	});
}
//******************************
function save_sort(){
//alert("Схранение сортировки");
var priors = $('#sortable').sortable('toArray');
$.ajax({
	type: "POST",
	url: __ajax_url,
	
	data: "paction=setimgprior&id="+priors,
	success: function(html) {
		//document.getElementById("tr_item_s_"+itemid).style.display = "";
		//document.getElementById("tr_item_"+itemid).style.display = "none";
		//images_set_sort();
		images_get_images();
		//**********************************
		__jl_init_uploader();
	}
});
}
//******************************
function images_get_images(){
	//alert("OK");
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=images_get_images&id="+cur_item_id,
		success: function(html) {
			//alert(html);
			$("#myDiv").empty();
			$("#myDiv").append(html);
			document.getElementById("sortable").style.display = "none";
			//alert("Очищаем див и вст. изображения");
			//init_sgallery();	
			__jl_init_uploader();
		}
	});
}
//******************************
var nf=0;
function files_get_files(){
	//alert("OK");
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=files_get_files&id="+cur_item_id,
		success: function(html) {
			//alert(html);
			$("#myDiv").empty();
			$("#myDiv").append(html);
			document.getElementById("sortable").style.display = "none";
			//alert("Очищаем див и вст. изображения");
			//init_sgallery();	
			$(".ui-state-default").click(function() {
					//alert(this.id);
					if(nf==1 && this.id!="li_load_images"){
						top.tiny_ed.focus(); 
						top.tiny_ed.selection.setContent('<a href=\"/files/'+this.id+'\">'+this.id+'</a>');
						parent.$.fancybox.close();
					} else {
						//alert("click");
						//alert(  cur_el.tagName  );
						if(  cur_el.tagName == "IMG"  ||  cur_el.tagName == "img"  )
							objst = cur_el.parentNode;
						else
							objst = cur_el;
						//alert(objst.className);
						if(  objst.className != "selected"  )
							objst.className = "selected";
						else
							objst.className = "ui-state-default";
						//if(cur_el.parentNode.parentNode.parentNode.id  !=  "file-uploader"){
					}
			});
			__jl_init_uploader();
		}
	});
}
//******************************
function myup_SendFile(spsrc) {
	alert("myupsf = ON");
	//top.document.getElementById('up_iframe').contentWindow.document.getElementById("myuptest_form").submit();
	inner = "<iframe id=\"up_iframe\" src=\"__up_iframe.php?spec="+spsrc+"&pid="+cur_item_id+"\" width=\"200\" height=\"100\" ></iframe>";
	document.getElementById('div_up_iframe').innerHTML = inner;
	//qq.FileUploader.upload()
}
//******************************
function __jl_init_uploader(){
	//alert("__jl_init_uploader");
	$(".ui-state-default").click(function() {
					//if(cur_el.parentNode.parentNode.parentNode.id  ==  "file-uploader"){
					//	//alert(cur_el.parentNode.parentNode.parentNode.id);
					//}
					if(cur_el.parentNode.parentNode.parentNode.id  !=  "file-uploader"){
						var index=false;
						var qwer = new Array();
						objsa = document.getElementById("myDiv");
						objs = objsa.getElementsByTagName("IMG");
						for(var i=0; i<objs.length; i++){
							if(objs[i].src == cur_el.src){
								index=i;
							}
							qwer[i] = objs[i].src.replace("imgres.php?resize=60&link=","");
						}
						//alert(cur_el.src);
						
							$.fancybox(
									qwer, 
									{
									'padding'			: 0,
									'index'				: index,
									'transitionIn'		: 'none',
									'transitionOut'		: 'none',
									'type'              : 'image',
									'changeFade'        : 0
							});
						
					}
				});
	//alert("jup id = "+cur_item_id);
	var uploader = new qq.FileUploader({
		// pass the dom node (ex. $(selector)[0] for jQuery users)
		element: $('#file-uploader')[0],
		action: 'upload.php',
		params: {parent: cur_item_id},
		onComplete: function(id, fileName, responseJSON){
			//alert("upload: "+fileName+"\n-------\n"+responseJSON);
			if(responseJSON["success"] == "true"){
				document.getElementById('divinfo').innerHTML += responseJSON["success"]+"<br/>\n";
			} else {
				document.getElementById('divinfo').innerHTML += "Загрузка файла завершилась неудачей<br/>";
				document.getElementById('divinfo').innerHTML += responseJSON["success"]+"<br/>\n";
				document.getElementById('divinfo').innerHTML += "----<br/>\n";
			}
			if(responseJSON["success"] == "true"){
				images_get_images();
				if(responseJSON["newimgid"]!="undefined"){
					show_new_img_popup(responseJSON["newimgid"]);
				}
			}
		}
	});
}
//******************************
function show_new_img_popup(nipid){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=show_new_img_popup&id="+nipid,
		success: function(html) {
			$("#popupmy").empty();
			$("#popupmy").append(html);
			document.getElementById('popupmy').style.display="";
			$.fancybox( {href : '#popupmy', title : "",  titlePosition : 'inside',  modal : "true"} );
		}
	});
}
//******************************
function movePicToText(nipid){
	if(!tiny_init){
		alert("Текстовый редактор выключен\nНажмите «Редактировать текстовый блок»");
		return false;
	}
	//alert("OK");
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=pic_in_text&id="+nipid,
		success: function(html) {
			tinyMCE.get('item_cont').selection.setContent(html);
		}
	});
}
//******************************
function movePicToTextEf(nipid){
	if(!tiny_init){
		alert("Текстовый редактор выключен\nНажмите «Редактировать текстовый блок»");
		return false;
	}
	//alert("OK");
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=pic_in_text_ef&id="+nipid,
		success: function(html) {
			tinyMCE.get('item_cont').selection.setContent(html);
		}
	});
}
//******************************
function changePicType(nipid){
	$("#ulpictotext").style("display", "");
	//if(!tiny_init){
	//	alert("Текстовый редактор выключен\nНажмите «Редактировать текстовый блок»");
	//	return false;
	//}
	//alert("OK");
	//$.ajax({
	//	type: "POST",
	//	url: __ajax_url,
	//	data: "paction=pic_in_text_ef&id="+nipid,
	//	success: function(html) {
	//		tinyMCE.get('item_cont').selection.setContent(html);
	//	}
	//});
}
$(document).ready(function(){
	
});
//******************************
function show_edit_img_popup(nipid, folder){
	var thref = "image_transform.php?";
	thref += "img="+nipid;
	if(folder) thref += "&folder="+folder;
		$.fancybox( {href : thref, title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
}
//******************************
function hide_edit_img_popup(){
	$.fancybox.close( true );
	//document.getElementById('popupmy').style.display="none";
}
//******************************
function hide_new_img_popup(){
	$.fancybox.close( true );
	document.getElementById('popupmy').style.display="none";
	document.getElementById('popupmy').innerHTML="";
}
//******************************
function save_new_img_popup(snipid){
	var snipid_cont = document.getElementById('snipid_cont').value;
	$.ajax({
		type: "POST",
		scriptCharset: "UTF-8",
		url: __ajax_url,
		data: "paction=save_new_img_popup&id="+snipid+"&snipid_cont="+snipid_cont,
		success: function(html) {
			document.getElementById('divinfo').innerHTML += html+"<br/>\n";
		}
	});
	$.fancybox.close( true );
	document.getElementById('popupmy').style.display="none";
}
//******************************
function edit_text_block(icid){
	document.getElementById('div_item_content').style.display="none";
	document.getElementById('item_cont').style.display="";
	document.getElementById('div_item_content_but').style.display="none";
	if(tiny_init) {
		tinyMCE.execCommand('mceToggleEditor',false,'item_cont');
	} else {
		tinymce_init();
		tiny_init = true;
	}
}
//******************************
function tiny_mce_save_text(){
	tinyMCE.execCommand('mceToggleEditor',false,'item_cont');
	var item_cont = tinyMCE.get('item_cont').getContent();
	tinyMCE.execCommand('mceRemoveControl',true,'item_cont');
	//document.getElementById('item_cont').style.display = "none";
	//alert(cur_item_id + ":::" + item_cont);
	item_cont = replace_spec_simbols(item_cont);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=save_item_cont&id="+cur_item_id+"&item_cont="+item_cont,
		success: function(html) {
			//alert("saved ::: "+html);
			document.getElementById('td_item_content').innerHTML = html;
			tiny_init = false;
		}
	});
}
//******************************
function pic_in_text(picsrc){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=save_item_cont&id="+cur_item_id+"&item_cont="+item_cont,
		success: function(html) {
			//alert("saved ::: "+html);
			document.getElementById('td_item_content').innerHTML = html;
			tiny_init = false;
		}
	});
}
//******************************
function init_sgallery(){
	
}
//******************************
//******************************  						ФУНКЦИИ   КОММЕНТАРИЕВ
//******************************
function show_usercomments(uc_id){
	//alert("OK");
	if(document.getElementById("div_uc_window").style.display=="none"){
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=getusercomments&id="+uc_id,
			success: function(html) {
				$( "#div_uc_window" ).draggable({
					handle: "h3",
					drag: function(event, ui) {	
					}
				});
				//alert(html);
				$("#div_ucw_cont").empty();
				$("#div_ucw_cont").append(html);
				show_usw();
			}
		});
	} else {
		close_ucw();
	}
}
//******************************
function show_usw(){
	oucw = document.getElementById("div_uc_window");
	oucw.style.top  = (cur_my + document.body.scrollTop)+"px";
	oucw.style.left = cur_mx+"px";
	oucw.style.display = "";
}
//******************************
function close_ucw(){
	document.getElementById("div_uc_window").style.display = "none";
}
//******************************
function show_popup_user_response(spur_id){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=show_popup_user_response&id="+spur_id,
		success: function(html) {
			$("#popupmy").empty();
			$("#popupmy").append(html);
			document.getElementById('popupmy').style.display="";
			$.fancybox( {href : '#popupmy', title : "",  titlePosition : 'inside',  modal : "true"} );
		}
	});
}
//******************************
function uc_show_edit(uce_id){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=show_popup_user_response&id="+uce_id,
		success: function(html) {
			$("#popupmy").empty();
			$("#popupmy").append(html);
			document.getElementById('popupmy').style.display="";
			$.fancybox( {href : '#popupmy', title : "",  titlePosition : 'inside',  modal : "true"} );
		}
	});
}
//******************************
function save_uc(uce_id){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=save_uc&id="+uce_id+"&cont="+$("#uc_cont").val()+"&respon="+$("#uc_respon").val(),
		success: function(html) {
			$("#popupmy").empty();
			$("#popupmy").append("");
			$.fancybox.close( true );
			document.getElementById('popupmy').style.display="none";
			document.getElementById('popupmy').innerHTML="";
			document.getElementById('divinfo').innerHTML += html+"<br/>\n";
		}
	});
}
//******************************
function uc_delete_comment(uce_id, uce_idp){
	if (confirm("Удалить комментарий "+uce_id+"?")) {
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=delete_uc&id="+uce_id,
			success: function(html) {
				$.ajax({
					type: "POST",
					url: __ajax_url,
					data: "paction=getusercomments&id="+uce_idp,
					success: function(html) {
						$("#div_ucw_cont").empty();
						$("#div_ucw_cont").append(html);
					}
				});
			}
		});
	}
}
//******************************
function load_img_from_link(lifl_id){
	if($("#linkimage").val()!=""){
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=load_img_from_link&id="+lifl_id+"&specimg="+$("#linkimage").val(),
			success: function(html) {
				images_get_images();
				document.getElementById("linkimage").value="";
				document.getElementById('divinfo').innerHTML += html+"<br/>\n";
			}
		});
	}
}
//******************************

function show_filemanager(){
	$.fancybox( {href : "filemanager.php", title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
}

//******************************
function show_filemanager_upload(){
	$.fancybox( {href : "manage_uploadprice.php", title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
}
//******************************
function show_filemanager_upload2(lnk){
	$.fancybox( {href : lnk, title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
}

//******************************
function show_tovnal(){
	$.fancybox( {href : "manage_zakaz_stat.php", title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
}


//******************************
function show_zakazstat(){
	$.fancybox( {href : "manage_zakaz_stat.php", title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
}



//******************************
function show_users(){
	$.fancybox( {href : "manage_users.php", title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
}



//******************************
function show_site_properties(){
	$.fancybox( {id : "myiframe", href : "manage_site_properties.php", title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
}



//******************************
function manage_configarator(){
	$.fancybox( {href : "manage_configurator.php", title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
}


//******************************
var nztime=0;
var nzto=false;
function test_new_zakaz(){
	clearTimeout(nzto);
	//alert("paction=test_new_zakaz&nztime="+nztime);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=test_new_zakaz&nztime="+nztime,
		success: function(html) {
			//alert(html);
			$("#nztime").empty();
			$("#nztime").append(html);
			nzto=setTimeout("test_new_zakaz()", 15000);
			//alert(html);
		}
	});
}
//******************************
function addLogo(addLogoId){
	//alert(addLogoId);
	addobj = document.getElementById(addLogoId);
	nsrc = addobj.src;
	nsrc = nsrc.replace("imgres.php?resize=60" , "imgres_for_items.php?resize=1200&id="+addLogoId.replace("simg_", ""));
	//alert(nsrc);
	//window.open(nsrc, "_blank");
	$.ajax({
		type: "POST",
		url: nsrc,
		data: "paction=test_new_zakaz&nztime="+nztime,
		success: function(html) {
			alert(html);
			images_get_images();
		}
	});
	
}
//******************************
function toogle_page_show_save(glazid){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=toogle_page_show_save&id="+glazid,
		success: function(html) {
			//alert(html);
			//images_get_images();
		}
	});
}
//******************************
function toogle_spec_show_save(glazid){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=toogle_spec_show_save&id="+glazid,
		success: function(html) {
			//alert(html);
			//images_get_images();
		}
	});
}
//******************************
function toogle_akc_show_save(akcid){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=toogle_akc_show_save&id="+akcid,
		success: function(html) {
			//alert(html);
		}
	});
}
//******************************
function toogle_new_show_save(newid){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=toogle_new_show_save&id="+newid,
		success: function(html) {
			//alert(html);
		}
	});
}
//******************************
function save_fast_cont(sfc_id){
	var fast_cont = tinyMCE.get('fast_cont').getContent();
	tinyMCE.execCommand('mceToggleEditor',false,'fast_cont');
	tinyMCE.execCommand('mceRemoveControl',true,'fast_cont');
	tiny_init=false;
	ppdata = "paction=fast_cont_save&id="+sfc_id+"&cont=" + replace_spec_simbols(fast_cont);
	//alert(ppdata);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			obj_m.style.display="none";
			$(obj_w).empty();
			obj_w.style.display="none";
			show_ritems(cur_folder_id);
		}
	});
}
//******************************
function get_fast_cont(gfc_id){
	ppdata = "paction=get_fast_cont&id="+gfc_id;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			fast_cont_html = html;
			show_myitemblock_cont(gfc_id);
		}
	});
}
//******************************
function cancel_fast_cont(gfc_id){
	tinyMCE.execCommand('mceToggleEditor',false,'fast_cont');
	tinyMCE.execCommand('mceRemoveControl',true,'fast_cont');
	tiny_init=false;
	obj_m.style.display="none";
	$(obj_w).empty();
	obj_w.style.display="none";
	mtm_fast_mtm = false;
	reload_single_item(gfc_id);
}
//******************************
function __jl_init_uploader_2(par_id){
	upl_el = document.getElementById("file-uploader-fc");
	//alert(upl_el.id);
	var uploader = new qq.FileUploader_2({
		// pass the dom node (ex. $(selector)[0] for jQuery users)
		element: upl_el,
		action: 'upload_fc.php',
		params: {parent: par_id},
		onComplete: function(id, fileName, responseJSON){
			//alert("upload: "+fileName+"\n-------\n"+responseJSON);
			if(responseJSON["success"] == "true"){
				document.getElementById('divinfo').innerHTML += responseJSON["success"]+"<br/>\n";
			} else {
				document.getElementById('divinfo').innerHTML += "Загрузка файла завершилась неудачей<br/>";
				document.getElementById('divinfo').innerHTML += responseJSON["success"]+"<br/>\n";
				document.getElementById('divinfo').innerHTML += "----<br/>\n";
			}
			if(responseJSON["success"] == "true"){
				images_get_images();
				if(responseJSON["newimgid"]!="undefined"){
					show_new_img_popup(responseJSON["newimgid"]);
				}
			}
		}
	});
}
//******************************
function get_fc_images(gfi_id){
	dropimg = false;
	dropimg_x = 0;
	dropimg_y = 0;
	ppdata = "paction=get_fc_images&id="+gfi_id;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			//alert("Первое место, тут программа работает\n"+html);
			$("#fc_images_box").empty();
			$("#fc_images_box").append(html);
			//alert(html);
			$(function() {
				$(".div_fc_images_in_box").draggable({
					/*revert: true,*/
					start: function(event, ui) {
						set_fc_mask_pos();
						dropimg = this;
						//set_fc_mask_pos_hid();
					},
					stop: function(event, ui) {
						set_fc_mask_pos_hid();	
					}
				});
			});
		}
	});
}
//******************************
function get_fast_table(gft_id){
	ppdata = "paction=get_fast_table&id="+gft_id;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			fast_table_html = "test";
			show_myitemblock_table(gft_id);
		}
	});
}
//******************************
function __jl_init_uploader_files(par_id){
	upl_el = document.getElementById("file-uploader-files");
	cur_item_id = par_id;
	//alert(upl_el.id);
	var uploader = new qq.FileUploader_files({
		// pass the dom node (ex. $(selector)[0] for jQuery users)
		element: upl_el,
		action: 'upload_files.php',
		params: {parent: par_id},
		onComplete: function(id, fileName, responseJSON){
			//alert("upload: "+fileName+"\n-------\n"+responseJSON);
			//alert(responseJSON["display"]);
			if(responseJSON["success"] == "true"){
				document.getElementById('divinfo').innerHTML += responseJSON["success"]+"<br/>\n";
			} else {
				document.getElementById('divinfo').innerHTML += "Загрузка файла завершилась неудачей<br/>";
				document.getElementById('divinfo').innerHTML += responseJSON["success"]+"<br/>\n";
				document.getElementById('divinfo').innerHTML += "----<br/>\n";
			}
			if(responseJSON["success"] == "true"){
				cur_item_id = par_id;
				fast_table_get_csv();
				//if(responseJSON["newimgid"]!="undefined"){
				//	show_new_img_popup(responseJSON["newimgid"]);
				//}
			}
		}
	});
}
//******************************
function fast_table_get_csv(){
	//alert("OK");
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=fast_table_get_csv&id="+cur_item_id,
		success: function(html) {
			//alert(html);
			$("#fc_images_box").empty();
			$("#fc_images_box").append(html);
			//document.getElementById("sortable").style.display = "none";
			//alert("Очищаем див и вст. изображения");
			//init_sgallery();	
			
			__jl_init_uploader_files(cur_item_id);
			
			$( ".div_fast_csv_img_icon" ).click(function () {
				//alert(this.id);
				fast_table_get_csvtable(this.id.replace("fast_csv_img_icon_",""));
			});
		}
	});
}
//******************************
function fast_table_get_csvtable(tid){
	//alert("tid="+tid);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=fast_table_get_csvtable&id="+tid,
		success: function(html) {
			//alert(html);
			$("#inc_tadiv").empty();
			$("#inc_tadiv").append(html);
			//document.getElementById("sortable").style.display = "none";
			//alert("Очищаем див и вст. изображения");
			//init_sgallery();	
			//__jl_init_uploader_files();
		}
	});
}
//******************************
function save_fast_table(sft_id){
	fast_tcont = document.getElementById('textarea_csv_0').value;
	cont = replace_spec_simbols(fast_tcont);
	//alert("tcont: "+cont);
	cells_csv = document.getElementById("cells_csv").value
	ppdata = "paction=fast_table_save&id="+csv_has+"&cells_csv="+cells_csv+"&cont=" + cont;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			//obj_m.style.display="none";
			//$(obj_w).empty();
			//obj_w.style.display="none";
			//show_ritems(cur_folder_id);
			//alert(html);
			cancel_fast_cont(sft_id);
		}
	});
}
//******************************
function __ajax_mtm_get_filter(afid, mtm_afid){
	ppdata = "paction=mtm_get_filter&id="+afid;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			amtmobj = document.getElementById("div_active_filter_"+afid);
			amtmobj.innerHTML = html;
		}
	});
}
//******************************
function reload_single_item(rsid){
	ppdata = "paction=reload_single_item&id="+rsid;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			$("#prm_"+rsid).empty();
			$("#prm_"+rsid).append(html);
			init_dop_popup_v_01();
		}
	});
}
//******************************
function generate_sitemap(){
	ppdata = "paction=generate_sitemap";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			alert(html);
		}
	});
}
//******************************
function change_ui_status(){
	chtest = document.getElementById("ui_status_check").checked;
	//alert(chtest);
	if(chtest){
		ppdata = "paction=chui&ui=1";
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: ppdata,
			success: function(html) {
				//alert(html);
			}
		});	
	} else {
		ppdata = "paction=chui&ui=0";
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: ppdata,
			success: function(html) {
				//alert(html);
			}
		});
	}
}
//******************************
var my_search_items = "";
function init_search(){
	//alert(cur_folder_id);
	if(!cur_folder_id) cur_folder_id = "0";
	ppdata = "paction=my_search_items&pid="+cur_folder_id;
	//alert(ppdata);
	my_search_items = false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			//alert(html);
			search_mass_object = eval( "(" + html + ")" );
			//alert(search_mass_object);
			my_search_items = new Array();
			for(var i=0; i<json_length(search_mass_object); i++){
				my_search_items[i] = search_mass_object[i];
			}
			init_search_after_ajax();
		}
	});
}
//******************************
function init_search_after_ajax(){
	//alert(my_search_items);
	if(document.getElementById("fast_search_items")){
		$( "#fast_search_items" ).css("background-color", "#FFFFFF");
		document.getElementById("fast_search_items").disabled = "";
		$(function() {
			$("#fast_search_items").keyup(function(event) {
				   //alert(event.which);
			}).keydown(function(event) {
				//alert(event.which);
				if (event.which == 13) {
					init_search_after_ajax_button();
				} 
			});
			$( "#fast_search_items" ).autocomplete({
				source: my_search_items,
				select: function( event, ui ) {
					siobj = document.getElementById("fast_search_items");
					siobj.value = ui.item.value;
					init_search_after_ajax_button();
				}
			});
		});
	}
}
//******************************
function init_search_after_ajax_button(){
				siobj = document.getElementById("fast_search_items");
				isa_pdata = "paction=rootgetfolderinfo&pid="+cur_folder_id+"&search_name="+siobj.value;
				//alert(isa_pdata);
				$.ajax({
					type: "POST",
					url: __ajax_url,
					data: isa_pdata,
					success: function(html) {
						//alert(html);
						efobj = document.getElementById("edit_content");
						efobj.style.display = "";
						efobj.innerHTML = html;
						init_dop_popup_v_01();
						init_search();
					}
				});
				test_edit_active(cur_folder_id);
}
//******************************
function start_users_search(){
	init_search_users();
	init_search_email();
}
//******************************
var my_search_users = "";
function init_search_users(){
	if(!cur_folder_id) cur_folder_id = "0";
	ppdata = "paction=my_search_users&pid=users";
	my_search_users = false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			//alert(html);
			search_mass_object = eval( "(" + html + ")" );
			//alert(search_mass_object);
			my_search_users = new Array();
			for(var i=0; i<json_length(search_mass_object); i++){
				my_search_users[i] = search_mass_object[i];
			}
			init_search_users_after_ajax();
		}
	});
}
//******************************
function init_search_users_after_ajax(){
	if(document.getElementById("fast_search_users")){
		$( "#fast_search_users" ).css("background-color", "#FFFFFF");
		document.getElementById("fast_search_users").disabled = "";
		$(function() {
			$("#fast_search_users").keyup(function(event) {
				 //alert(event.which);
			}).keydown(function(event) {
				//alert(event.which);
				if (event.which == 13) {
					init_search_users_after_ajax_button();
				} 
			});
			$( "#fast_search_users" ).autocomplete({
				source: my_search_users,
				select: function( event, ui ) {
					siobj = document.getElementById("fast_search_users");
					siobj.value = ui.item.value;
					init_search_users_after_ajax_button();
				}
			});
		});
	}
}
//******************************
function init_search_users_after_ajax_button(){
	siobj = document.getElementById("fast_search_users");
	isa_pdata = "paction=rootgetfolderinfo&pid=users&search_fio="+siobj.value;
	//alert(isa_pdata);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: isa_pdata,
		success: function(html) {
			//alert(html);
			efobj = document.getElementById("edit_content");
			efobj.style.display = "";
			efobj.innerHTML = html;
			init_search_users();
			init_search_email();
			__au_init_all();
		}
	});
	//test_edit_active(cur_folder_id);
}
//******************************
var my_search_email = "";
function init_search_email(){
	if(!cur_folder_id) cur_folder_id = "0";
	ppdata = "paction=my_search_email&pid=users";
	my_search_email = false;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			//alert(html);
			search_mass_object = eval( "(" + html + ")" );
			//alert(search_mass_object);
			my_search_email = new Array();
			for(var i=0; i<json_length(search_mass_object); i++){
				my_search_email[i] = search_mass_object[i];
			}
			init_search_email_after_ajax();
		}
	});
}
//******************************
function init_search_email_after_ajax(){
	if(document.getElementById("fast_search_email")){
		$( "#fast_search_email" ).css("background-color", "#FFFFFF");
		document.getElementById("fast_search_email").disabled = "";
		$(function() {
			$("#fast_search_email").keyup(function(event) {
				   //alert(event.which);
			}).keydown(function(event) {
				//alert(event.which);
				if (event.which == 13) {
					init_search_email_after_ajax_button();
				} 
			});
			$( "#fast_search_email" ).autocomplete({
				source: my_search_email,
				select: function( event, ui ) {
					siobj = document.getElementById("fast_search_email");
					siobj.value = ui.item.value;
					init_search_email_after_ajax_button();
				}
			});
		});
	}
}
//******************************
function init_search_email_after_ajax_button(){
	siobj = document.getElementById("fast_search_email");
	isa_pdata = "paction=rootgetfolderinfo&pid=users&search_email="+siobj.value;
	//alert(isa_pdata);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: isa_pdata,
		success: function(html) {
			//alert(html);
			efobj = document.getElementById("edit_content");
			efobj.style.display = "";
			efobj.innerHTML = html;
			init_search_users();
			init_search_email();
			__au_init_all();
		}
	});
	//test_edit_active(cur_folder_id);
}
//******************************
function __filemanager_delete_sel_files(){
	objfm = $("#files_items .selected");
	delids = "";
	for(  j=0; j<objfm.length; j++  ){
		delids += objfm[j].id;
		if(  j != objfm.length - 1  ) delids += "\n";
	}
	if(delids!=""){
		if (confirm("Удалить файлы \n"+delids+"?")) {
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: "paction=delete_files_filemanager&ids="+delids,
				success: function(html) {
					//alert(html);
					files_get_files();
				}
			});
		}
	}
}
//******************************
function toggle_item_check(tic_id){
	lnk = site+"adminarea/images/green/myitemname_popup/";
	ticimg = document.getElementById("imgcheck_"+tic_id)
	if(ticimg.src == lnk+"checkbox.gif"){
		ticimg.src = lnk+"checkbox_checked.gif";
	} else {
		ticimg.src = lnk+"checkbox.gif";
	}
}
//******************************
function items_select_all(){
	lnk = site+"adminarea/images/green/myitemname_popup/";
	objs = $("#myitems_sortable .items_select_all");
	for(j=0; j<objs.length; j++)
			objs[j].src = lnk+"checkbox_checked.gif";
}
//******************************
function items_deselect_all(){
	lnk = site+"adminarea/images/green/myitemname_popup/";
	objs = $("#myitems_sortable .items_select_all");
	for(j=0; j<objs.length; j++)
			objs[j].src = lnk+"checkbox.gif";
}
//******************************
function delete_select_items(){
	lnk = site+"adminarea/images/green/myitemname_popup/";
	objs = $("#myitems_sortable .items_select_all");
	ids = "";
	tmpiname = "";
	for(j=0; j<objs.length; j++) {
		if(objs[j].src == lnk+"checkbox_checked.gif"){
			ids += "\n"+objs[j].id.replace(/imgcheck_/, "");
			namestr = document.getElementById("span_myitemname_"+objs[j].id.replace(/imgcheck_/, "")).innerHTML;
			namestr = namestr.replace( /\(<span.*$/gi, "");
			if(j<15)  tmpiname += "\n"+namestr;
			if(j==15)  tmpiname += "\nи другие...";
		}
	}
	if (confirm("Удаление записей:\n"+tmpiname)) {
		//alert("Ok"+cur_simgid);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=delete_select_items&ids="+ids,
			success: function(html) {
				//alert(html);
				document.getElementById('divinfo').innerHTML += "Произведено удаление записей «"+ids+"»<br/>\n"; //html;
				show_ritems(cur_folder_id);
				//document.getElementById('divinfo').innerHTML += html;
				//images_get_images();
			}
		});
	}
}
//******************************