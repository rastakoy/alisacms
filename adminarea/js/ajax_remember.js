//var __ajax_url = "http://koko.my/adminarea/__ajax.php";
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
	if(load_json){
		load_json=false;
		//alert("asd");
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: "paction=getjsonpostdata&id="+itemid,
			success: function(html) {
				//alert(html);
				var npaction = "paction=savejsonpostdata&id="+itemid;
				post_object = eval( "(" + html + ")" );
				//alert(post_object[0][0]+": "+post_object[0][1]);
				//alert(json_length(post_object));
				for(var i=0; i<json_length(post_object); i++){
					//alert(i);
					if(document.getElementById(post_object[i][1]).type == "checkbox"){
						if(document.getElementById(post_object[i][1]).checked==true){
							npaction += "&" + post_object[i][0] + "=1"; 
						} else {
							npaction += "&" + post_object[i][0] + "=0"; 
						}
					} else if( post_object[i][0] == "item_cont" && tiny_init){
						npaction += "&" + post_object[i][0] + "=" + tinyMCE.get('item_cont').getContent().replace(/&/gi, "~~~aspirand~~~");;
						tinyMCE.execCommand('mceToggleEditor',false,'item_cont');
						tinyMCE.execCommand('mceRemoveControl',true,'item_cont');
					} else {
						//if(post_object[i][0] != "saveblock" )
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
						cur_item_id = 0;
						show_ritems(cur_folder_id);
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
	var folder_icon = $("#folder_icon").val();
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
		item_cont = item_cont.replace(/&/gi , "~~~aspirand~~~");
	}
	
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
	
	ii_params += "&psevdonum="+psevdonum;
	ii_params += "&folder_icon="+folder_icon;
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
			cur_item_id = 0;
			show_ritems(cur_folder_id);
			document.getElementById('divinfo').innerHTML += "Произведено редактирование"+html+"<br/>\n";
			//document.getElementById("tr_item_s_"+itemid).style.display = "";
			//document.getElementById("tr_item_"+itemid).style.display = "none";
			//document.getElementById("td_item_"+itemid).innerHTML = "";
			
		}
	});
}
//*****************
function getiteminfo_close(itemid){
	$("#tr_item_s_"+itemid).css("display", "");
	//document.getElementById("tr_item_s_"+itemid).style.display = "";
	$("#tr_item_"+itemid).css("display", "none");
	//document.getElementById("tr_item_"+itemid).style.display = "none";
	$("#td_item_"+itemid).empty();
	tinyMCE.execCommand('mceToggleEditor',false,'item_cont');
	tinyMCE.execCommand('mceRemoveControl',true,'item_cont');
	tiny_init = false;
	//document.getElementById("td_item_"+itemid).innerHTML = "";
	cur_item_id = 0;
}
//*****************
function getiteminfo(itemid){
//alert(cur_item_id);
if(cur_item_id!=0){
	getiteminfo_close(cur_item_id);
}
$.ajax({
	type: "POST",
	url: __ajax_url,
	data: "paction=getfolderinfo&id="+itemid,
	success: function(html) {
		cur_item_id = itemid;
		
		//alert(html);
		if(addnewitem){
			addnewitem = false;
			//alert(html);
			$("#edit_content").empty();
			$("#edit_content").append(html);
			
			//alert("ok");
		} else {
			document.getElementById("tr_item_s_"+itemid).style.display = "none";
			document.getElementById("tr_item_"+itemid).style.display = "";
			$("#td_item_"+itemid).empty();
			$("#td_item_"+itemid).append(html);
		}
		//$( "#accordion" ).accordion( "destroy" );
		//tinymce_init();
		// Show menu when #myDiv is clicked
		$("#myDiv").contextMenu({
			menu: 'myMenu'
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
			//alert(
			//	'Action: ' + action + '\n\n' +
			//	'Element ID: ' + $(el).attr('id') + '\n\n' + 
			//	'X: ' + pos.x + '  Y: ' + pos.y + ' (relative to element)\n\n' + 
			//	'X: ' + pos.docX + '  Y: ' + pos.docY+ ' (relative to document)'
			//	);
		});
		$("#various1").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none'
		});
		$("#various3").fancybox({
			'width'				: '90%',
			'height'				: '90%',
			'autoScale'			: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
		
		
		$(function() {
			$( "#datepicker" ).datepicker( $.datepicker.regional[ "ru" ] );
		});
				
		//	$( "#sortable" ).sortable();
		//	$( "#sortable" ).disableSelection();
		//});
		
				//var qwer = new Array('http://farm5.static.flickr.com/4044/4286199901_33844563eb.jpg', 'http://farm3.static.flickr.com/2687/4220681515_cc4f42d6b9.jpg' );
				//objsa = document.getElementById("myDiv");
				//objs = objsa.getElementsByTagName("IMG");
				//for(var i=0; i<objs.length; i++){
				//	alert(objs[0].src);
				//}
				
				
		
		__jl_init_uploader();
	}
});
}
//*****************
function processReqChange() {
    if (req.readyState == 4) {
        clearTimeout(reqTimeout);
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
	var tmpiname = document.getElementById("item_name_"+delid).innerHTML;
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
	
	ppdata += "&efolder_prior=" + $("#folder_prior").val();
	//alert($("#fassoc").val());
	ppdata += "&efolder_assoc=" + $("#fassoc").val();
	ppdata += "&efolder_parent=" + $("#folder_parent").val();
	ppdata += "&id=" + $("#ffolder_id").val();
	
	//fpage_show = "0";
	if(document.getElementById("fpage_show").checked==true){
		ppdata += "&fpage_show=1";
	} else {
		ppdata += "&fpage_show=0";
	}
	
	var folder_cont = tinyMCE.get('folder_cont').getContent();
	tinyMCE.execCommand('mceToggleEditor',false,'folder_cont');
	tinyMCE.execCommand('mceRemoveControl',true,'folder_cont');
	tiny_init=false;
	ppdata += "&efolder_cont=" + folder_cont.replace(/&/gi , "~~~aspirand~~~");
	
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
		root_folderhtml = folder;
		cur_folder_id=folder;
		//alert(cur_folder_id + ":" + cur_item_id)
		if(folder) cur_folder_id =cur_item_id;
		//requestdata("?paction=edititem&folder="+folder+"&id="+cur_item_id);
		$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=edititem&folder="+folder+"&id="+cur_item_id,
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
	tinymce_init();
	tiny_init = true;
	httpaction = "";
	
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
function show_ritems(rid){
	//************
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=rootgetfolderinfo&id="+rid,
		success: function(html) {
			efobj = document.getElementById("edit_content");
			efobj.style.display = "";
			efobj.innerHTML = html;
			cur_folder_id = rid;
			get_menu(cur_folder_id);
		}
	});
	test_edit_active(rid);
	
	//requestdata("?action=getfolderinfo&id="+rid);
	//alert(rid);
	//requestdata("?action=getdiritems&parent="+rid);
}
//******************************

//******************************
function test_edit_active(rid){
	//alert("rid="+rid);
	if(rid && rid!="0") {
		editactive = true;
		cur_item_id = rid;
		document.getElementById("edititembutton").src = "images/green/__top_edit.gif";
	} else {
		editactive = false;
		cur_item_id = "0";
		document.getElementById("edititembutton").src = "images/green/__top_edit_na.gif";
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
function __jl_init_uploader(){
	$(".ui-state-default").click(function() {
					//if(cur_el.parentNode.parentNode.parentNode.id  ==  "file-uploader"){
					//	//alert(cur_el.parentNode.parentNode.parentNode.id);
					//}
					if($("#galtype").val() == "1"  &&  cur_el.parentNode.parentNode.parentNode.id  !=  "file-uploader"){
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
function show_edit_img_popup(nipid){
	$.fancybox( {href : 'image_transform.php?img='+nipid, title : "",  titlePosition : 'inside',  type : "iframe", width: "85%", height : "85%" } );
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
var nztime=0;
var nzto=false;
function test_new_zakaz(){
	clearTimeout(nzto);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=test_new_zakaz&nztime="+nztime,
		success: function(html) {
			//alert(html);
			$("#nztime").empty();
			$("#nztime").append(html);
			nzto=setTimeout("test_new_zakaz()", 35000);
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




















