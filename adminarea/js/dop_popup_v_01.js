var rowToFolderDragNDrop = false;
var itemToFolderDragNDrop = false;
var init_dop_popup_v_01_var = true;
function init_dop_popup_v_01(){
//my_div_myitemname = document.getElementById("div_myitemname");
$(".div_myitemname").mousedown(function(){
	//alert("md");
	itemToFolderDragNDrop = this;
})
$(".div_myitemname").hover(function() {
		//alert("ok");
		if(this.className != "div_myitemname dmnoover")
			$(this).css('background-color', '#E0E0E0');
		//alert(this.className);
		
		//$("#div_myitemname_popup").css("top", myitemname_y);
		//div_myitemname_popup = document.getElementById(this.id+"_popup");
		//div_pos = __images_getAbsolutePos(this);
		//div_myitemname_popup.style.top=(div_pos.y-52)+"px";
		//div_myitemname_popup.style.display="";
		//jQuery(div_myitemname_popup).hide();
		//mtout = setTimeout("jQuery(div_myitemname_popup).fadeIn();", 1000);
		
	}, function() {
		if(this.className != "div_myitemname dmnoover")
			$(this).css('background-color', '#FFFFFF');
		//div_myitemname_popup.style.display="none";
		//jQuery(div_myitemname_popup).fadeOut();
		//clearInterval(mtout);
	});
//*******************************************************************
//$( "#myitems_sortable" ).sortable({ cursorAt: { left: -5 } });
if(init_dop_popup_v_01_var){
	$( "#myitems_sortable" ).sortable({
			cursorAt: { left: -20 },
			update: function() {
				save_myitems_prior();
				//$("#items_left_menu a").hover("destroy");
				//$("#rootfoldermenu a").hover("destroy");
				$("#items_left_menu a").off( "mouseenter mouseleave" );
				$("#rootfoldermenu a").off( "mouseenter mouseleave" );
				$("#rootfoldermenu a").css("background-color", "");
				rowToFolderDragNDrop = false;
				itemToFolderDragNDrop = false;
			},
			sort: function() {
				//alert(this.items);
				$("#items_left_menu a").hover(function() {
					$(this).css("background-color", "#FF0000");
					rowToFolderDragNDrop = this;
				}, function() {
					this.style.backgroundColor = "";
					rowToFolderDragNDrop = false;
				});
				$("#rootfoldermenu a").hover(function() {
					$(this).css("background-color", "#FF0000");
					rowToFolderDragNDrop = {"href":"javascript:show_ritems(0"};
				}, function() {
					$(this).css("background-color", "");
					rowToFolderDragNDrop = false;
				});
			},
			stop: function( event, ui ) {
				if(rowToFolderDragNDrop){
					hpp = itemToFolderDragNDrop.id.replace(/^div_myitemname_/, "");
					hrr = rowToFolderDragNDrop.href.replace(/^javascript:show_ritems\(/, "");
					hrr = hrr.replace(/\)$/, "");
					change_item_parent_dnd(hpp, hrr);
					//$("#items_left_menu a").hover("destroy");
					//$("#rootfoldermenu a").hover("destroy");
					$("#items_left_menu a").off( "mouseenter mouseleave" );
					$("#rootfoldermenu a").off( "mouseenter mouseleave" );
					$("#rootfoldermenu a").css("background-color", "");
					rowToFolderDragNDrop = false;
					itemToFolderDragNDrop = false;
				}
			}
	});
}
//*******************************************************************
//var $tabs = $( "#top_ul" ).tabs();
//var $tab_items = $( "#top_ul li", $tabs ).droppable({
//	accept: "",
//	hoverClass: "",
//	drop: function( event, ui ) {
//		alert("ok");
		//var $item = $( this );
		//var $list = $( $item.find( "a" ).attr( "href" ) )
		//	.find( ".connectedSortable" );
		
		//ui.draggable.hide( "slow", function() {
		//	$tabs.tabs( "option", "active", $tab_items.index( $item ) );
		//	$( this ).appendTo( $list ).show( "slow" );
		//});
//	}
//});
//*******************************************************************
if(init_dop_popup_v_01_var){
	$( "#myitems_sortable" ).disableSelection();
	//*****
	$( ".div_myitemname" ).dblclick(function () {
		//alert(this.id);
		show_myitemblock(this.id);	
	});
	//*****
	$( ".item_fastpricedigit" ).click(function () {
		//alert(this.id);
		//alert();
		if(!item_fastpricedigit){
			inner  = "<input type=\"text\" value=\""+this.innerHTML+"\" ";
			inner += "class=\"item_fastpricedigit_input\" onMouseUp=\"input_fpd_click=true;\" /> ";
			$(this).empty();
			$(this).append(inner);
			item_fastpricedigit = this.id;
		}
	});
	//*****
	$(".istext_hover_img").hover(function() {
			lnk = site+"adminarea/images/green/myitemname_popup/istext.gif";
			if(this.src==lnk){
				//clearInterval(mtout);
				//jQuery(div_myitemname_popup).fadeIn();
				//istextblock_list(this.id, 0);
				//blockid = this.id.replace("istext_","");
				//ist_obj = document.getElementById("div_myitemname_texta_sub_"+blockid);
				//alert(ist_obj.id);
				//ist_setinterval = setTimeout("istextblock_list('"+this.id+"', 0)", 400);
			}
		}, function() {
			//alert("out");
			if(this.src==lnk){
				//clearInterval(ist_setinterval);
				//$(ist_obj).css("margin-top", 0);
			}
	});
						//***************************************
						//*****
						$( ".istext_hover_img" ).click(function () {
							//alert(this.id);
							get_fast_cont(this.id.replace("istext_",""));
						});
						//*****
						$( ".istable_hover_img" ).click(function () {
							//alert(this.id);
							get_fast_table(this.id.replace("istable_",""));
						});
						//*****
						
						//*****
						//***************************************
}
}
//*******************************************************************************************
function istextblock_list(blockid, pad){
	//if(ist_setinterval)clearInterval(ist_setinterval);
	pad += 1;
	document.title = ist_obj.id;
	blockid = blockid.replace("istext_","");
	//alert(ist_obj.id);
	$(ist_obj).css("margin-top", "-"+pad);
	if(pad<$(ist_obj).outerHeight()-25){
		ist_setinterval = setTimeout("istextblock_list('istext_"+blockid+"', "+pad+")", 25);
	} else {
		clearInterval(ist_setinterval);
	}
}
//*******************************************************************************************
mtout = false;
function show_myitemblock(mib_obj_id){
	if(mtout) clearInterval(mtout);
	//alert("OK DBLClick");
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	//*******************************
	obj_m = document.getElementById("show_myitemblock_bg");
	obj_m.style.width = wwidth+"px";
	obj_m.style.height = wheight+"px";
	obj_m.style.display="";
	//*******************************
	obj_w = document.getElementById("show_myitemblock_cont");
	obj_w.style.width = (wwidth-100)+"px";
	obj_w.style.height = (wwheight - 100)+"px";
	obj_w.style.top = (20+document.body.scrollTop)+"px";
	obj_w.style.left = (wwwidth/2-(wwidth-100)/2)+"px";
	obj_w.style.display="";
	//*******************************
	//obj_b = document.getElementById("root_body");
	//$("#root_body").addClass("noscroll");
	//left = $(document).scrollLeft();
	//top = $(document).scrollTop();
	//$(document.body).css({
	//	overflow: "hidden"
	//});
	//function stop_scroll(event) {
	//	event.preventDefault();
	//	$(document).scrollLeft(left);
	//	$(document).scrollTop(top);
	//}
	//$(document).bind("mousewheel", stop_scroll);
	//$(window).bind("scroll mousewheel", stop_scroll);

	//*******************************
	linker = mib_obj_id.replace("div_myitemname_","");
	//alert(linker);
	getiteminfo(linker);
}
//*******************************************************************************************
function toggle_page_show(glazid){
	imgsrc = document.getElementById("glaz_"+glazid);
	lnk = site+"adminarea/images/green/myitemname_popup/";
	imgs = imgsrc.src.substring(lnk.length, lnk.length+8);
	//alert(imgs);
	//alert("glazid="+glazid);
	if(imgs=="glaz.gif"){
		imgsrc.src = lnk+"glaz_no.gif";
		document.getElementById("span_myitemname_"+glazid).style.color = "#666666";
		toogle_page_show_save(glazid);
		
	} else {
		imgsrc.src = lnk+"glaz.gif";
		document.getElementById("span_myitemname_"+glazid).style.color = "#000000";
		toogle_page_show_save(glazid);
		
	}
}
//*******************************************************************************************
function toggle_spec_show(glazid){
	imgsrc = document.getElementById("imgspecpred_"+glazid);
	lnk = site+"adminarea/images/green/myitemname_popup/";
	imgs = imgsrc.src.substring(lnk.length, lnk.length+12);
	//alert(imgs);
	if(imgs=="specpred.gif"){
		imgsrc.src = lnk+"specpred_no.gif";
		//document.getElementById("span_myitemname_"+glazid).style.color = "#666666";
		toogle_spec_show_save(glazid);
		
	} else {
		imgsrc.src = lnk+"specpred.gif";
		//document.getElementById("span_myitemname_"+glazid).style.color = "#000000";
		toogle_spec_show_save(glazid);
		
	}
}
//*******************************************************************************************
function toggle_akc_show(akcid){
	//alert(akcid)
	imgsrc = document.getElementById("imgakc_"+akcid);
	lnk = site+"adminarea/images/green/myitemname_popup/";
	imgs = imgsrc.src.substring(lnk.length, lnk.length+7);
	//alert(lnk + "::" + imgsrc.src);
	if(imgs=="akc.gif"){
		imgsrc.src = lnk+"akc_no.gif";
		toogle_akc_show_save(akcid);
	} else {
		imgsrc.src = lnk+"akc.gif";
		toogle_akc_show_save(akcid);
	}
}
//*******************************************************************************************
function toggle_new_show(newid){
	//alert(akcid)
	imgsrc = document.getElementById("imgnew_"+newid);
	lnk = site+"adminarea/images/green/myitemname_popup/";
	imgs = imgsrc.src.substring(lnk.length, lnk.length+7);
	//alert(lnk + "::" + imgsrc.src);
	if(imgs=="new.gif"){
		imgsrc.src = lnk+"new_no.gif";
		toogle_new_show_save(newid);
	} else {
		imgsrc.src = lnk+"new.gif";
		toogle_new_show_save(newid);
	}
}
//*******************************************************************************************
var close_mtm_id = false;
function filter_mtm_show(sfc_id){
	close_mtm_id = sfc_id;
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	//*******************************
	obj_m = document.getElementById("show_myitemblock_bg");
	obj_m.style.width = wwidth+"px";
	obj_m.style.height = wheight+"px";
	obj_m.style.display="";
	//*******************************
	obj_w = document.getElementById("show_myitemblock_cont");
	obj_w.style.width = (wwidth-100)+"px";
	obj_w.style.height = (wwheight - 100)+"px";
	obj_w.style.top = (20+document.body.scrollTop)+"px";
	obj_w.style.left = (wwwidth/2-(wwidth-100)/2)+"px";
	obj_w.style.display="";
	//*******************************
	obj_w.innerHTML = "<div id=\"fc_maskcont\" style=\"display:none\"></div><div  id=\"inc_tadiv\">test</div><div align=\"center\" style=\"margin-top: 10px;\"><a id=\"drophere\" href=\"javascript:cancel_fast_cont("+sfc_id+")\" class=\"inc_tadiv_saver_imgs\">OK</a></div>";
	document.getElementById("inc_tadiv").style.width = (wwidth-120)+"px";
	document.getElementById("inc_tadiv").style.height = (wwheight-100-60)+"px";
	__mtm_fast_mtm(sfc_id);
}
//*******************************************************************************************
tmce_width = 500;
tmce_height = 300;
function show_myitemblock_cont(sfc_id){
	//clearInterval(mtout);
	//alert("OK DBLClick");
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	//*******************************
	obj_m = document.getElementById("show_myitemblock_bg");
	obj_m.style.width = wwidth+"px";
	obj_m.style.height = wheight+"px";
	obj_m.style.display="";
	//*******************************
	obj_w = document.getElementById("show_myitemblock_cont");
	obj_w.style.width = (wwidth-100)+"px";
	obj_w.style.height = (wwheight - 100)+"px";
	obj_w.style.top = (20+document.body.scrollTop)+"px";
	obj_w.style.left = (wwwidth/2-(wwidth-100)/2)+"px";
	obj_w.style.display="";
	//*******************************
	sfc_id = sfc_id.replace("istext_","");
	//alert("sfc_id="+sfc_id);
	//get_fast_cont(sfc_id);
	obj_w.innerHTML = "<div id=\"fc_maskcont\" style=\"display:none\"></div><div id=\"inc_tadiv_imgs\" align=\"center\" style=\"display:none;\"><div class=\"inc_tavid_loadimgs\" id=\"file-uploader-fc\">asd</div><div id=\"fc_images_box\"></div></div><div  id=\"inc_tadiv\"><textarea name=\"fast_cont\" id=\"fast_cont\" style=\"width:550px;height:300px;\" >"+fast_cont_html+"</textarea></div><div align=\"center\" style=\"margin-top: 10px;\"><a href=\"javascript:save_fast_cont("+sfc_id+")\" class=\"inc_tadiv_saver_imgs\">Сохранить</a><a id=\"drophere\" href=\"javascript:cancel_fast_cont("+sfc_id+")\" class=\"inc_tadiv_saver_imgs\">Отменить</a></div>";
	//<a href=\"javascript:start_insert_img()\" class=\"inc_tadiv_saver_imgs\">Тест</a>
	document.getElementById("inc_tadiv_imgs").style.height = (wwheight-100-60+10)+"px";
	tmce_width = wwidth-100-180;
	tmce_height = wwheight-100-60;
	tinymce_init();
	document.getElementById("inc_tadiv").style.width = (wwidth-100-180)+"px";
	
	//alert(sfc_id);
	 //__jl_init_uploader_2(sfc_id);
	 //get_fc_images(sfc_id);
	 
	 
	//tinyMCE.width = 400;
	//tinyMCE.execCommand('width','400', "tmce_adminarea");
	//tinyMCE.execCommand('mceToggleEditor',false,'tmce_adminarea');
	//*******************************
}
//*******************************************************************************************
function set_fc_mask_pos(){
	//*******************************
	obj_x = document.getElementById("fc_maskcont");
	obj_x.style.width = (tinyMCE.settings["width"]-22)+"px";
	obj_x.style.height = (tinyMCE.settings["height"]-90)+"px";
	obj_x.style.top = "90px";
	obj_x.style.left = "10px";
	obj_x.style.display="";
}
//***********************************************
function set_fc_mask_pos_hid(){
	obj_x = document.getElementById("fc_maskcont");
	obj_x.style.display="none";
}
//***********************************************
function get_all_tiny_mass(tb){
	var mass = $(tb).children("");
	for(var i=0; i<mass.length; i++ ){
		all_tyny_mass[all_tyny_mass.length] = mass[i];
		mass[i].id = "test_"+all_tiny_count;
		all_tiny_count++;
		var a_mass = $(mass[i]).children("");
		if(a_mass.length>0){
			get_all_tiny_mass(mass[i]);
		}
		
	}
}
//***********************************************
function inser_img_in_tiny(){
	if(fun_iiit){
		fun_iiit = false;
		
		cur_index = "none";
		for(i=0; i<all_tyny_mass.length; i++){
			if(all_tyny_mass[i]==input_img_index){
				cur_index = i;
				break;
			}
		}
		
		document.getElementById("fc_maskcont").innerHTML = tinyMCE.get('fast_cont').getContent();
		tinyb = document.getElementById("fc_maskcont");
		all_tyny_mass = new Array();
		all_tiny_count = 0;
		get_all_tiny_mass(tinyb);
		inso = all_tyny_mass[cur_index];
		my_ins_img = dropimg.innerHTML;
		inso.innerHTML = inso.innerHTML + my_ins_img;
		
		set_fc_mask_pos_hid();
		ed = tinyMCE.get('fast_cont');
		ed.setContent(tinyb.innerHTML);
		
	}
}
//***********************************************
old_tiny_cont = "";
input_img_index = "none";
function start_insert_img(){
	document.getElementById("fc_maskcont").innerHTML = tinyMCE.get('fast_cont').getContent();
	tinyb = document.getElementById("fc_maskcont");
	all_tyny_mass = new Array();
	all_tiny_count = 0;
	get_all_tiny_mass(tinyb);
	for(i=0; i<all_tyny_mass.length; i++){
		$(all_tyny_mass[i]).hover(function() {
			$(this).css("border", "1px solid #FFFF00;");
		}, function() {
			$(this).css("border", "0px");
		});
		//************************
		$(all_tyny_mass[i]).droppable({drop:function(){
			fun_iiit = true;
			//alert("dropped :: "+this.tagName);
			input_img_index = this;
			my_ins_img = "<img src=>"
			//to = 500 - i*10
			input_img_to = setTimeout("inser_img_in_tiny()", 200);
		}});
	}
}
//*******************************************************************************************
tmce_width = 500;
tmce_height = 300;
function show_myitemblock_table(sft_id){
	//clearInterval(mtout);
	//alert("OK uploader files");
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	//*******************************
	obj_m = document.getElementById("show_myitemblock_bg");
	obj_m.style.width = wwidth+"px";
	obj_m.style.height = wheight+"px";
	obj_m.style.display="";
	//*******************************
	obj_w = document.getElementById("show_myitemblock_cont");
	obj_w.style.width = (wwidth-100)+"px";
	obj_w.style.height = (wwheight - 100)+"px";
	obj_w.style.top = (20+document.body.scrollTop)+"px";
	obj_w.style.left = (wwwidth/2-(wwidth-100)/2)+"px";
	obj_w.style.display="";
	//*******************************
	sft_id = sft_id.replace("istable_","");
	//alert("sfc_id="+sfc_id);
	//get_fast_cont(sfc_id);
	obj_w.innerHTML = "<div id=\"fc_maskcont\" style=\"display:none\"></div><div id=\"inc_tadiv_imgs\" align=\"center\"><div class=\"inc_tavid_loadimgs\" id=\"file-uploader-files\">test</div><div id=\"fc_images_box\"></div></div><div  id=\"inc_tadiv\">"+fast_table_html+"</div><div align=\"center\" style=\"margin-top: 10px;\"><a href=\"javascript:save_fast_table("+sft_id+")\" class=\"inc_tadiv_saver_imgs\">Сохранить</a><a id=\"drophere\" href=\"javascript:cancel_fast_cont("+sft_id+")\" class=\"inc_tadiv_saver_imgs\">Отменить</a></div>";
	//<a href=\"javascript:start_insert_img()\" class=\"inc_tadiv_saver_imgs\">Тест</a>
	document.getElementById("inc_tadiv_imgs").style.height = (wwheight-100-60+10)+"px";
	document.getElementById("inc_tadiv").style.width = (wwidth-100-150) + "px";
	document.getElementById("inc_tadiv").style.height = (wwheight-100-50) + "px";
	//tmce_width = wwidth-100-150;
	//tmce_height = wwheight-100-60;
	//tinymce_init();
	
	//alert(sfc_id);
	cur_item_id = sft_id;
	fast_table_get_csv();
	// __jl_init_uploader_files(sft_id);
	 //get_fc_images(sfc_id);
	 
	 
	//tinyMCE.width = 400;
	//tinyMCE.execCommand('width','400', "tmce_adminarea");
	//tinyMCE.execCommand('mceToggleEditor',false,'tmce_adminarea');
	//*******************************
}
//*******************************************************************************************
function show_myitemblock_mi_config(sft_id, mElem){
	var pos = __positions_getAbsolutePos(mElem);
	obj_w = document.getElementById("show_myitemblock_cont");
	if(obj_w.style.display == ""){
		obj_w.style.display="none";
		obj_w.innerHTML = "Загрузка...";
		return false;
	}
	//*******************************
	obj_w.style.width = (300)+"px";
	obj_w.style.height = (300)+"px";
	obj_w.style.top = (pos.y)+"px";
	obj_w.style.left = (pos.x+20)+"px";
	//obj_w.style.left = (wwwidth/2-(300)/2)+"px";
	obj_w.style.display="";
	//*******************************
	inner = "<div>TEST</div>";
	inner += "<a id=\"drophere\" href=\"javascript:cancel_fast_cont("+sft_id+")\" class=\"inc_tadiv_saver_imgs\" style=\"text-align:center\">Закрыть</a>";
	//***************************************
	paction = "paction=get_item_type_items&pid="+sft_id;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			obj_w.innerHTML = html;
		}
	});
}
//*******************************************************************************************
function multiitem_off(pid){
	paction = "paction=stop_multiitem&pid="+pid;
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
//*******************************************************************************************
function start_multiitem(pid){
	//alert("start_multiitem");
	paction = "paction=start_multiitem&pid="+pid;
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
//*******************************************************************************************
function mi_set_config_default(miKey, chObj, pid){
	paction = "paction=set_item_type_in_multiitem_default&value="+miKey+"&pid="+pid;
	alert(paction);
	//***************************************
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
		}
	});
}
//*******************************************************************************************
function mi_set_config(miKey, chObj, pid){
	if(chObj.checked)
		paction = "paction=set_item_type_in_multiitem&action=set&value="+miKey+"&pid="+pid;
	else
		paction = "paction=set_item_type_in_multiitem&action=unset&value="+miKey+"&pid="+pid;
	alert(paction);
	//***************************************
	var aos = {};
	var avs = {};
	var as = chObj.parentNode.getElementsByTagName("input");
	var count = 0;
	for(var j=0; j<as.length; j++){
		//alert(as[j].type);
		if(as[j].type=="radio"){
			if(as[j-1].checked)
				as[j].disabled=false;
			else
				as[j].disabled=true;
		}
	}
	//alert(aos.innerHTML);
	//***************************************
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			//obj_w.innerHTML = html;
		}
	});
}