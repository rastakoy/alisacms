<?  require_once("alisaui_css/__backup_functions.php");  ?><script>
var buffer = false;
</script>
<link rel="stylesheet" type="text/css" href="/alisaui_css/icons.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/alisaui_css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/alisaui_css/panel.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/alisaui_css/itemstree.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/alisaui_css/top_tabs.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/alisaui_css/css.css" media="screen" />
<script type="text/javascript" src="/js/core/jquery-1.7.1.js"></script>
<script type="text/javascript" src="/alisaui_css/alisa_panel.js"></script>
<script type="text/javascript" src="/alisaui_css/css.js"></script>
<script type="text/javascript" src="/alisaui_css/lines_constructor.js"></script>
<script type="text/javascript" src="/alisaui_css/multiblock.js"></script>

<link rel="stylesheet" media="screen" type="text/css" href="/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="/colorpicker/js/colorpicker.js"></script>

<?
	//$amass = array("asd","dsa");
	//__fjs_json_stringify($amass);
	//__fa_clear_css($tmpl, $file, $mass);
	//__tmpl_tarray_to_style_items("/loadimages/", "tmpl-1");
	//__tmpl_tarray_to_styles("/loadimages/", "tmpl-1");
	
?>
<div id="aui_topTabs"></div>
<div id="root_alisa_cms">
<div id="rootAlisaBg" style="display:none;"></div>
<div id="divinfo" style="display:none;"></div>
<script src="/adminarea/js/mfu_ui.js" type="text/javascript"></script>
<link href="/adminarea/styles/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="/adminarea/styles/folders.css" rel="stylesheet" type="text/css"/>

<link href="/adminarea/styles/style.ui.css" rel="stylesheet" type="text/css" media="all">
<link href="/adminarea/styles/style.ui.drop.css" rel="stylesheet" type="text/css" media="all">

<link rel="Stylesheet" type="text/css" href="/adminarea/styles/jqcp.css" />
<script type="text/javascript" src="/adminarea/js/jquery.jqcp.min.js"></script>

<div id="black_bg" style="display:none;"></div>
<div id="se_css_menu" style="display:none;"><img onclick="getelementproperties_bg()" 
src="/adminarea/images/ui/button_css.jpg" /><br/>
<img onclick="elname_a+=':hover';getelementproperties_bg();" 
src="/adminarea/images/ui/button_css_h.jpg" /><br/>
<img onclick="get_constructor_start();" 
src="/adminarea/images/ui/button_constructor.jpg" /></div>
<!--  ---------------------------------------------------------  -->
<script type="text/javascript" src="/adminarea/js/jquery-ui.js"></script>
<div id="mydrop" style="display:none;">
	<span>sp1</span>
	<span>sp2</span>
</div>
<script>
$(function() {
	var $gallery = $( "#mydrop" );
	//**************
	// let the gallery items be draggable
    $( "span", $gallery ).draggable({
      cancel: "a.ui-icon", // clicking an icon won't initiate dragging
      revert: "invalid", // when not dropped, the item will revert back to its initial position
      containment: "document",
      helper: "clone",
      cursor: "move"
    });
    // let the trash be droppable, accepting the gallery items
});
var pageContentData = {};
<?
	$data_row =   __fp_get_row_from_way(   explode(   "/", preg_replace(   "/\/$/", "", $_REQUEST["do"]   )   ), "items"   );
	$ptype_id = get_item_type($data_row["id"]);
	$query = "select * from itemstypes where id=$ptype_id";
	$resp = mysql_query($query);
	$rowbb = mysql_fetch_assoc($resp);
	//-----------------------------------------
	$massb = explode("\n", $rowbb["pairs"]);
	$rmass = array();
	foreach($massb as $key=>$val){
		if($val!=""){
			$tmass = explode("===", $val);
			if(   $tmass[1]   )
				echo "pageContentData[\"$tmass[3]\"]=\"".$data_row[$tmass[1]]."\";\n";
		}
	}
?>
</script>
<!--  ---------------------------------------------------------  -->
<?  //print_r($_COOKIE);  ?>
<?  //print_r($_REQUEST);  ?>
<div id="start_aui"><div>
<div class="aui_control_block_move" style="float:none;width:35px;"></div>
<a class="foo" href="#"><span class="aui-icon-pencil"></span>Выделить объект</a>
<a class="foo" href="#" style="display:none;"><span class="aui-icon-cog"></span>Добавить виджет</a>
<a class="foo" href="#" style="display:none;"><span class="aui-icon-user">&nbsp;</span></a>
<a class="foo" href="#" style="display:none;"><span class="aui-icon-user">&nbsp;</span></a>
<a class="foo" href="#" style="display:none;"><span class="aui-icon-pages">&nbsp;</span></a>
<a class="foo" href="#"><span class="aui-icon-home">&nbsp;</span></a>
<a class="foo" href="#" style="margin-top:20px;"><span class="aui-icon-eye-open">&nbsp;</span></a>
<a class="foo" href="#" style="position:fixed; left:35px;top:142px;"><span class="aui-icon-undo">&nbsp;</span></a>
<a class="foo" href="#" style="position:fixed; left:115px;top:142px;"><span class="aui-icon-redo">&nbsp;</span></a>
<a class="foo" href="#"><span class="aui-icon-list-alt">&nbsp;</span></a>
<a class="foo" href="__publish.php"><span class="aui-icon-bullhorn">&nbsp;</span></a>
</div>
<div id="se_toggle_button" class="se_toggle_button">
		<img src="/adminarea/images/ui/button_spacer.gif" id="se_toggle_button"  width="47" height="25" border="0" />
  </div>
	<div bgcolor="#D4D0C8" id="sel_elem_property" style="display:none;">&nbsp;</div>
</div>
<div id="show_block_buttons" class="show_block_buttons" style="display:none;">
	<a class="block_buttons aui_selInsert" href="#"><span class="aui-icon-plus-sign"></span></a>
	<a class="block_buttons aui_editStyles" href="#"><span class="aui-icon-cog"></span></a>
	<a class="block_buttons aui_deleteBlock" href="#"><span class="aui-icon-remove-sign"></span></a>
	<a class="block_buttons" href="#"><span class="aui-icon-circle-arrow-up"></span></a>
	<a class="block_buttons" href="#"><span class="aui-icon-eye-open"></span></a>
	<a class="block_buttons" href="#"><span class="aui-icon-move"></span></a>
</div>
<div id="aui_selInsert_panel" style="display:none;">asd assad asd </div>
<div id="aui_selInsert_panel2" style="display:none;">asd</div>
<div id="aui_selInsert_panel8" style="display:none;"></div>
<div id="aui_selInsert_panel3" style="display:none;"></div>
<div id="aui_SiteProperties" style="display:none;"></div>
<div id="aui_SitePages" style="display:none;"></div>
<div id="aui_SelectPageFromAllPages" style="display:none;"></div>
<div id="aui_SelectAllPages" style="display:none;"></div>
<div id="aui_EditStyles" style="display:none;"></div>
<div id="aui_Confirm" style="display:none;"></div>
<script>
//******************************
function getJSON(gets, mycallback){
	var ajson = $.getJSON( "/adminarea/__ajax_user_interface.php", gets );
	ajson.done(function(data) {
		//alert("data="+data);
		if(data != "undefined"){
			if(mycallback) {
				if(mycallback=="stringify"){
					alert(JSON.stringify(data));
				} else if(mycallback=="return") {
					//eval(mycallback+"(data)");
				} else if(mycallback=="reload") {
					document.location.href = document.location.href;
				} else {
					eval(mycallback+"(data)");
				}
			}
		} else  {
			//myGridShowDialog("Произошла ошибка", "При передаче данных возникла ошибка!<br/>"+data);
		}
    });
    ajson.fail(function(statusObj,errInfo) {
        alert(statusObj.statusText+"\n"+errInfo);
    });
}
//**********************************
function constructAlisaInterface(aObj){
	var rv = "";
	for(var j in aObj){
		var jjCount = 1;
		if(aObj[j].multiType){  jjCount=aObj[j].multiType.count; }
		for(var jj=0; jj<jjCount; jj++) {
			rv +=  constructAlisaTag(aObj, j, jj);
		}
		if(jjCount > 1) __mb_multiblock_init(aObj[j]);
	}
	//alert(rv);
	
	return rv;
}
//**********************************
function constructAlisaTag(aObj, aIndex, level){
	var rv = ""; var myCss = "";
	if(aObj[aIndex].css) for(var j in aObj[aIndex].css) myCss+=j+":"+aObj[aIndex].css[j]+";";
	if(level>0){ myCss += "-moz-opacity: 0.5;opacity:.50;";  }
	//******************************
	if(aObj[aIndex].pageType){
		var a = aObj[aIndex].pageType;
		var am = explode(":", a);
		//alert(am);
		if(!root_request.match(RegExp(am[0]+"\/?$"))){
			if(!root_request.match(RegExp(am[0])))  myCss += "display:none;";
			if(root_request.match(RegExp(am[0])) && am[1]=="this")  myCss += "display:none;";
		}
	}
	if(aObj[aIndex].defaultValue&&aObj[aIndex].tagname=="input") aObj[aIndex].content = aObj[aIndex].defaultValue;
	//******************************
		//alert(JSON.stringify(pageContentData));
		rv += "<"+aObj[aIndex].tagname;
			if(aObj[aIndex].tagname == "img"){
				rv += " src=\""+aObj[aIndex].imgattr.src+"\" ";
			}
			if(  aObj[aIndex].href  ) 					rv += " href=\""+aObj[aIndex].href+"\" ";
			if(  aObj[aIndex].className  ) 			rv += " class=\""+aObj[aIndex].className+"\" ";
			if(  aObj[aIndex].id  ) 						rv += " id=\""+aObj[aIndex].id+"\" ";
			if(  aObj[aIndex].align  ) 					rv += " align=\""+aObj[aIndex].align+"\" ";
			if(  aObj[aIndex].valign  ) 					rv += " valign=\""+aObj[aIndex].valign+"\" ";
			if(  aObj[aIndex].type  ) 					rv += " type=\""+aObj[aIndex].type+"\" ";
			if(  aObj[aIndex].defaultValue  )			rv += " value=\""+aObj[aIndex].defaultValue+"\" ";
			//if(  aObj[aIndex].style  ) 					rv += " style=\""+aObj[aIndex].style+"\" ";
			if(  myCss  ) 										rv += " style=\""+myCss+"\" ";
			if(  aObj[aIndex].events  ){
				for(ej in aObj[aIndex].events)       rv += " "+ej+"=\""+aObj[aIndex].events[ej]+"\" ";
			}
		
		if(aObj[aIndex].tagname=="input"){
			if(aObj[aIndex].defaultValue) {
				rv += " value=\""+aObj[aIndex].defaultValue+"\" "; 
			} else if(aObj[aIndex].content) {
				
				rv += " value=\""+aObj[aIndex].content+"\" "; //onChange=\"changeInputContent(this, this.value)\" ";
			}
		}
		
		if(  aObj[aIndex].tagname == "form"  )
			rv += " method=\"POST\" ";
			
		//if(  aObj[aIndex].tagname == "select"  )
		//	rv += " disabled=\"disabled\" ";
		
		if(  aObj[aIndex].tagname == "br" ||  aObj[aIndex].tagname == "input"  ||  aObj[aIndex].tagname == "img"  )
			rv += "/";
		
		
		rv += " >";
	//******************************
	if(  aObj[aIndex].childs  ) 			rv += constructAlisaInterface(aObj[aIndex].childs);
	if(  aObj[aIndex].connectionField  &&  pageContentData[aObj[aIndex].connectionField]  ) {
		if(  aObj[aIndex].content  &&  aObj[aIndex].tagname!="input"  ) 		rv += pageContentData[aObj[aIndex].connectionField];
	} else {
		if(  aObj[aIndex].tagname!="input"  ) 		rv += aObj[aIndex].content;
	}
	if(  aObj[aIndex].tagname != "br" ||  aObj[aIndex].tagname != "input" ||  aObj[aIndex].tagname != "img"  )
		rv += "</"+aObj[aIndex].tagname+">";
	return rv;
}
//**********************************
function changeInputContent(elem, chText){
	//alert("ok");
	if(elem){
		blockKeys = auiGetBlockKeys(elem);
		jblockKeys = blockKeys;
		blockKeys = blockKeys.replace(/~$/, "");  	blockKeys = explode("~", blockKeys);  for(var j in blockKeys) {
			tmpa = eval("({"+blockKeys[j]+"})");   blockKeys[j]= tmpa;
		}
		aEval = auiGetBlockFromKeys(blockKeys, allInterfaceTemplate)+"[\"content\"]";
		eval("allInterfaceTemplate"+aEval+"= chText");
		gets = {"ajaxaction":"aui_replaceBlocks__content", "content":chText, "blockKeys":jblockKeys };
		//alert(JSON.stringify(gets));
		getJSON(gets, "return");
	}
}
//**********************************
function auiPanelShowPreview(panelId){
	//alert($("#"+panelId).width());
	obj = $("#"+panelId+" .aui_control_block_content")[0];
	obj_sep = $("#"+panelId+" .aui_control_block_content")[0];
	//alert(obj);
	$(obj).css("width", $(obj).width());
	$("#"+panelId+" .aui_control_block_content").css("float","left");
	$("#"+panelId).css("width", ($("#"+panelId).width()+335)+"px");
	
	$("#"+panelId+" .aui_control_block_content_preview").css("display","");
	$("#"+panelId+" .aui_control_block_content_preview_sep").css("display","");
	
	//$("#"+panelId).css("float","left");
	
}
//**********************************
var allInterfaceTemplate = false;
//**********************************
var auiNeedSave = false;
var saveproperty__interval = 20;
//**********************************
var sel_element_control = false;
var sel_element_name = "";
//**********************************
var multiblock_count = 10;
//**********************************
var old_cur_element = false;
var old_cur_sel_element = false;
//Id иключающих выделение полей sel_exclusion
var sel_exclusion = {  0:"#root_alisa_cms", 1:"#rootAlisaBg", 2:"#show_block_buttons", 3:"#aui_control_block", 4:"#aui_topTabs", 5:".colorpicker", 6:":firstChild.multiblock", 7:"subpage"  };
var aui_root_buttons = false;
var aui_editing = false;
var aui_mouse_out_of_editing = false;
var aui_old_mouse_x = 0;
var aui_old_mouse_y = 0;
var dx,dy;
var aui_mouse_interval_tout;
document.onmousemove = function(em) {
   em = em || event;
   var o = em.target || em.srcElement;
   if(o.className) if(o.className.match(/aui-icon-br/)) o = o.parentNode;
   if(em.y) { 
		cur_my = em.y;  
		cur_mx = em.x; 
		
	} else { 
		cur_my = em.pageY - document.body.scrollTop;  
		cur_mx = em.pageX - document.body.scrollLeft; 
	}
	cur_my -= document.getElementById("aui_topTabs").clientHeight;
	if(aui_root_buttons){
		if(  old_cur_element  &&  o != old_cur_element && old_cur_element.className  ) {
			old_cur_element.className = old_cur_element.className.replace(/ aoutline$/, "");
		}
		mmx = cur_mx+ document.body.scrollLeft;
		mmy = cur_my+document.body.scrollTop;
		if(aui_root_buttons[0].className.match(/fooactive/)  &&  !isInclusion(o, sel_exclusion)  ){
			//document.title = o.tagName+" id="+o.id+" name="+o.name;
			old_cur_element = o;
			//alert(aui__getValue_FromDomIndex(o.parentNode.firstChild).multiType);
			if(aui__getValue_FromDomIndex(o.parentNode.firstChild).multiType!="multiblock"  ){
					o.className = o.className.replace(/ aoutline$/, "") + " aoutline";
			}
			if(aui__getValue_FromDomIndex(o.parentNode.firstChild).multiType=="multiblock"  &&  o.parentNode.firstChild==o  ){
					o.className = o.className.replace(/ aoutline$/, "") + " aoutline";
			}
			if(aui__getValue_FromDomIndex(o.parentNode.firstChild).multiType!="multiblock"  )
				o.className = o.className.replace(/ aoutline$/, "") + " aoutline";
		} else {
			old_cur_element = false;
		}
	}
	if(old_cur_sel_element){
		if(   !isInclusion(o, {0:"#show_block_buttons"})   &&   isInclusion(o, {0:".editing"})   ){
			pos = __positions_getAbsolutePos(old_cur_sel_element);
			if( cur_mx>pos.x+40 && cur_mx<pos.x+old_cur_sel_element.clientWidth+40 && cur_mx < pos.x + old_cur_sel_element.clientWidth + 40 - document.getElementById("show_block_buttons").clientWidth ){
				document.getElementById("show_block_buttons").style.left = (cur_mx-40)+"px";
			}
		}
	}
	//*************************************
	dx = Math.abs(cur_mx - aui_old_mouse_x);
	dy = Math.abs(cur_my - aui_old_mouse_y);
	//document.title = dx+"x"+dy;
	if(dx > 20  ||  dy > 20){
		if(  old_cur_sel_element  &&  isInclusion(o, {0:".editing",1:"#show_block_buttons"})  ){
			if(aui_mouse_interval_tout) clearInterval(aui_mouse_interval_tout);
			$("#show_block_buttons").css("display","none")
			aui_mouse_interval_tout = setTimeout('$("#show_block_buttons").css("display","")', 1400);
			//alert("ok");
		}
	}
	aui_old_mouse_x = cur_mx;
	aui_old_mouse_y = cur_my;
}
//**********************************
function saveCSSToBlock__load(data){
	//alert("saveCSSToBlock__load");
	//alert(data);
	allInterfaceTemplate = data;
}
//**********************************
function saveBlockProperties__load(data){
	document.location.href = document.location.href;
}
//**********************************
var cur_mousedown_object = false;
window.onmousedown = function(e) {
	//if(propertiesFocus) return false;
	e = e || event;
	var o = e.target || e.srcElement;
	if(o.className) if(o.className.match(/aui-icon-br/)) o = o.parentNode;
	cur_mousedown_object = o;
	//if(o.className=="fastinput") return false;
	document.title = "pF="+propertiesFocus;
	//if(propertiesFocus) {
		if(auiNeedSave && !isInclusion(o, {0:"#aui_EditStyles",1:"#aui_Confirm",2:".colorpicker"})){
			tmpcss = {"width":"350", "top":"100", "left":"100", "z-index":"50"};
			var warInner = "<img src=\"/alisaui_css/icon_dontsave.png\" align=\"left\" style=\"margin-right:20px;\" ><br/>";
			warInner += "Данные не сохранены!<br/>Сохранить?";
			constructAuiControlBlock("aui_Confirm", tmpcss, "Предупреждение", warInner, "rootAlisaBg", "");
			$("#aui_Confirm .aui_control_block_content").css("background-color","#444444");
			$("#aui_Confirm .aui_control_block_content").css("color","#FFFFFF");
			$("#aui_Confirm .close").css("margin-left","12px");
			$("#aui_Confirm .fscreen").css("display","none");
			$("#aui_Confirm .cancel").css("display","");
			$("#aui_Confirm .ok").css("width","80px");
			$("#aui_Confirm .ok")[0].innerHTML="Сохранить";
			$("#aui_Confirm .ok").click(function (){
				var mb = $("#aui_EditStyles div.aui_control_block_content td:first-child");
				var mv = $("#aui_EditStyles div.aui_control_block_content td:last-child");
				var stylesBlocks = {};
				for(var j in mb){
					mval = mv[j].innerHTML;
					if(mval)  stylesBlocks[mb[j].innerHTML] = mval;
				}
				for(var j in stylesBlocks)
					if(!stylesBlocks[j].replace(/^&nbsp;|&nbsp;$/gi, ""))     delete(stylesBlocks[j]);
					else     stylesBlocks[j] = stylesBlocks[j].replace(/^&nbsp;|&nbsp;$/gi, "");
				//alert(JSON.stringify(stylesBlocks));
				//alert(mb.innerHTML);
				$("#aui_Confirm").css("display","none");
				$("#rootAlisaBg").css("display","none");
				auiNeedSave = false;
				stylesBlocks["ajaxaction"] = "saveCSSToBlock";
				stylesBlocks["startSaver"] = "true";
				stylesBlocks["blockKeys"] = auiGetBlockKeys(old_cur_sel_element);
				//alert(JSON.stringify(stylesBlocks));
				getJSON(stylesBlocks, "saveCSSToBlock__load");
				//--------------------
				propBlocks = auiGetBlockProperties();
				propBlocks["ajaxaction"] = "saveBlockProperties";
				propBlocks["blockKeys"] = auiGetBlockKeys(old_cur_sel_element);
				//alert(JSON.stringify(propBlocks));
				//--------------------
				propBlocks_b = auiGetBlockPropertiesTypes();
				for(var j in propBlocks_b) propBlocks[j]=propBlocks_b[j];
				//alert(JSON.stringify(propBlocks));
				//alert(JSON.stringify(propBlocks["blockKeys"]));
				setTimeout('getJSON(propBlocks, "saveBlockProperties__load")', saveproperty__interval);
				propertiesFocus = false;
				//alert(    );
				//blockKeys
			});
			$("#aui_Confirm .cancel").click(function (){
				auiNeedSave = false;
			});
			return false;
		}
	//}
	if(old_cur_sel_element  ){
		if(o == old_cur_sel_element && old_cur_sel_element.tagName.toLowerCase() == "input"){
			//alert("test");
			//old_cur_sel_element.disabled = "disableed";
		}
	}
}
//**********************************
var show_block_buttons_height = 27;
window.onclick = function(e) {
	e = e || event;
	var o = e.target || e.srcElement;
	//if(propertiesFocus) return false;
	if(o.className) if(o.className.match(/aui-icon-br/)) o = o.parentNode;
	if(aui__getValue_FromDomIndex(o.parentNode.firstChild).multiType=="multiblock"  &&  o.parentNode.firstChild!=o  ){
		return false;
	}
	if(o != old_cur_sel_element && aui_root_buttons[0].className.match(/fooactive/) && !isInclusion(o, sel_exclusion)){
		//if(old_cur_sel_element) {if(old_cur_sel_element.className.match(/ editing/) && auiNeedSave){
		//	
		//	//auiNeedSave = false;
		//	return false;
		//}}
		//if(aui__getValue_FromDomIndex(o.parentNode.firstChild).multiType=="multiblock"  &&  o.parentNode.firstChild==o  ){
		if(o.className) if(o.className.match(/aui-icon-br/)) o = o.parentNode;
		o.className = o.className + " editing";
		$("#aui_SelectAllPages").css("display","none");
		aui_editing = true;
		if(o != old_cur_sel_element && old_cur_sel_element){
			old_cur_sel_element.className = old_cur_sel_element.className.replace(/ editing/, "");
			old_cur_sel_element.className = old_cur_sel_element.className.replace(/ aoutline/, "");
		}
		aui__positionShowBlockButtons(o, old_cur_sel_element);
		old_cur_sel_element = o;
		jsobj = aui__getValue_FromDomIndex(old_cur_sel_element);
		if(jsobj.pagePost) if(jsobj.pagePost=="Добавить" || jsobj.pagePost=="Редактировать") alert("ok");
		//alert(JSON.stringify(jsobj));
		//return false;
	} 
	if(old_cur_sel_element){
		$("#show_block_buttons").css("display","");
	}
	if(isInclusion(o, {0:"aui_topTabs"})){
		
	}
	if(aui_root_buttons[0].className.match(/fooactive/) && !isInclusion(o, {0:"aui_topTabs"})){
		return false;
	}
}
//**********************************
var loIndex;
function auiGetBlockProperties(){
	var rv = {};
	var objs = $("#aui_EditStyles div.aui_control_block_content_dop .fastedit");
	loIndex = 6;
	for(var j=0; j<loIndex; j++) {
		if(j==0)  if(objs[j].innerHTML!="" && objs[j].innerHTML!=" ") {
			rv["id"] = objs[j].innerHTML;
		}
		if(j==1)  if(objs[j].innerHTML!="" && objs[j].innerHTML!=" ") {
			rv["className"] = objs[j].innerHTML;
		}
		if(j==2)  if(objs[j].innerHTML!="" && objs[j].innerHTML!=" ") {
			rv["content"] = objs[j].innerHTML;
		}
		if(j==3)  if(objs[j].innerHTML) {
			rv["multiType"] = objs[j].innerHTML.replace(/Не указан/, "");
		}
		if(j==4)  if(objs[j].innerHTML) {
			var awMass = explode(" » ", objs[j].innerHTML);
			rv["connectionField"] = awMass[0].replace(/^ | $/, "");
			rv["pagePost"] = awMass[1];
		}
		if(j==5)  if(objs[j].innerHTML) {
			rv["pageRequire"] = objs[j].innerHTML;
		}
	}
	
	return rv;
	//alert(rv.replace(/,$/, ""));
}
//**********************************
function auiGetBlockPropertiesTypes(){
	var rv = {};
	var objs = $("#aui_EditStyles div.aui_control_block_content_dop .fastedit");
	for(var j in objs) {
		if(j==loIndex)  if(objs[j].innerHTML!="" && objs[j].innerHTML!=" ") {
			rv["inputProperties_type"] = objs[j].innerHTML;
		}
		if(j==1+loIndex*1)  if(objs[j].innerHTML!="" && objs[j].innerHTML!=" ") {
			rv["inputProperties_check"] = objs[j].innerHTML;
		}
		if(j==2+loIndex*1)  if(objs[j].innerHTML) {
			rv["inputProperties_match"] = objs[j].innerHTML;
		}
		//if(j==3)  if(objs[j].innerHTML) {
		//	rv["multiType"] = objs[j].innerHTML.replace(/Не указан/, "");
		//}
		//if(j==4)  if(objs[j].innerHTML) {
		//	var awMass = explode(" » ", objs[j].innerHTML);
		//	rv["connectionField"] = awMass[0].replace(/ /, "");
		//	rv["pagePost"] = awMass[1];
		//}
		//if(j==5)  if(objs[j].innerHTML) {
		//	rv["pageRequire"] = objs[j].innerHTML;
		//}
	}
	return rv;
	//alert(rv.replace(/,$/, ""));
}
//**********************************
function aui__positionShowBlockButtons(_element){
	m = __positions_getAbsolutePos(_element);
	mleft = m.x
	$(".show_block_buttons").css("left", mleft+"px");
	mtop = m.y;
	$(_element).css("display", "block");
	$(".show_block_buttons").css("top", (mtop+_element.clientHeight-show_block_buttons_height)+"px");
	if(_element.clientHeight<=show_block_buttons_height+show_block_buttons_height/2)
		$(".show_block_buttons").css("top", (mtop+_element.clientHeight)+"px");
	$(_element).css("display", "");
	$(".show_block_buttons").css("display", "");
	
}
//**********************************
function close_aui_block(blockName){
	aui_editing = false;
	blockName.className = blockName.className.replace(/ editing$/,"");
}
//**********************************
function isInclusion(iObj, excl){
	if(!iObj) return false;
	for( var j in excl ){
		if(   iObj.className   ){
			if(   iObj.className.match(RegExp(excl[j].replace(/^\./, "")))   )   return true;
		}
		if(     excl[j].match(/:firstChild/)     ){
			//excl[j] = excl[j].replace(/^:firstChild/, "");
			if(iObj.tagName!="body"){
				if(iObj.parentNode)
					if(aui__getValue_FromDomIndex(iObj.parentNode.firstChild))
						if(aui__getValue_FromDomIndex(iObj.parentNode.firstChild).multiType=="multiblock" && iObj.parentNode.firstChild!=iObj)  return true;
			}
			//if(aui__getValue_FromDomIndex(iObj).multiType == "multitype"){
			//	alert("ok");
			//}
			
			//return true;
			//alert(auiGetBlockKeys(iObj));
			//if()
		}
		if(     iObj.id == excl[j].replace(/^\#/, "")     ) return true;
		if(     iObj.tagName     )     {
			if(     iObj.tagName.toLowerCase() == excl[j]     )  {//alert("Совпадение"); 
			}
		}
	}
	if(!iObj.parentNode ||  iObj.parentNode=="undefined") return false;
	return isInclusion(iObj.parentNode, excl);
}
//**********************************
function auiGetSiteProperties(){
	$.ajax({
		type: "POST",
		scriptCharset: "UTF-8",
		url: "/adminarea/__ajax_user_interface.php",
		data: "paction=auiGetSiteProperties",
		success: function(html) {
			//alert(html);
			props = eval("("+html+")");
			html = "";
			for(var j in props){
				html += j+"<br/>";
				html += "<input style=\"width:100%;\" type=\"text\" value=\""+props[j][0]+"\"/><br/>";
				html += props[j][1]+"<div class=\"aui_control_block_separator\"></div>";
			}
			tmpcss = {"width":"250", "top":"20px", "left":"80px"};
			constructAuiControlBlock("aui_SiteProperties", tmpcss, "Основные свойства сайта", html, false, "aui_root_buttons[5].className='foo'");
			$("#aui_SiteProperties div.aui_control_block_content").css("padding", "5px");
			$("#aui_SiteProperties div.aui_control_block_content").css("max-height", "500px");
		}
	});
}
//**********************************
function auiSelectPageFromAllPages__prev(sparent, liobj, args, replacer){
	//alert("prev  "+args.cbFunc);
	if(!replacer) var replacer="";
	if(liobj.className=="aui-icon-tree-plus"){
		liobj.className="aui-icon-tree-minus";
		auiSelectPageFromAllPages(sparent, args, replacer);
	} else {
		liobj.className="aui-icon-tree-plus";
		$("#dauisp_"+sparent).empty();
	}
}
//**********************************
function auiAddPage( apLink, apName, apIndex ){
	if(!apIndex) var apIndex = -1;
	//alert("apIndex="+apIndex);
	apLink = apLink.replace(/\/$/, "");
	if(apIndex!=-1)
		auiRenderPages__props[apIndex] = {"name":apName,"link":apLink};
	else
		auiRenderPages__props[auiRenderPages__props.length] = {"name":apName,"link":apLink};
	if(!aui_root_buttons[4].className.match(/fooactive/)) {
		gets = {"ajaxaction":"saveSitePages", "data":auiRenderPages__props};
		getJSON(gets, "auiRenderPages_Tabs__load");
	}
	auiSitePagesEditIndex = apIndex;
	auiRenderPages(JSON.stringify(auiRenderPages__props));
	
	$("#aui_SelectAllPages").css("display","none");
	$("#rootAlisaBg").css("display","none");
}
//**********************************
function auiSelectPageFromAllPages__constructor(idPref, props, args, needLink){
	//alert(args.cbFunc);
	if(!needLink) var needLink = "";
	//alert("needLink="+needLink);
	var iv = "";
			for(var j in props){
				iv += "<li><span";
				icempty = true;
				var replacer = ""+props[j]["href_name"]+"\/";
				replacer = needLink.replace(RegExp(replacer, "gi"), "");
				if(props[j]["folder"]==1 && props[j]["children"]){
					eval("argsobjeval_"+props[j]["id"]+"=args;");
					if(props[j]["class"]=="active")
						iv += " class=\"aui-icon-tree-minus\" onClick=\"auiSelectPageFromAllPages__prev("+props[j]["id"]+", this, argsobjeval_"+props[j]["id"]+", '"+replacer+"')\" >";
					else
						iv += " class=\"aui-icon-tree-plus\" onClick=\"auiSelectPageFromAllPages__prev("+props[j]["id"]+", this, argsobjeval_"+props[j]["id"]+", '')\" >";
					icempty = false;
				}
				if(icempty){
					iv += " style=\"cursor:auto;\" >&nbsp;";
				}
				iv += "</span>";
				if(args.onlyRecords && props[j]["folder"]==1)
					iv += "<a class=\"passive\" onClick=\"return false;"+args.cbFunc+"('"+props[j]["href"]+"', '"+props[j]["name"]+"' ";
				else
					iv += "<a onClick=\""+args.cbFunc+"('"+props[j]["href"]+"', '"+props[j]["name"]+"' ";
				//alert($("#aui_SelectAllPages div.aui_control_block_title")[0].innerHTML);
				if(  $("#aui_SelectAllPages div.aui_control_block_title")[0].innerHTML.match(/редактирование/)  )   iv += ", '"+auiSitePagesEditIndex+"'  ";
				iv += ")\"  ";
				if(props[j]["class"]=="active")  {iv += " class=\"active\" "; }
				iv += " >"+props[j]["name"]+"</a><ul id=\""+idPref+"_"+props[j]["id"]+"\">";
					if(props[j]["children_data"])  {
						iv +=   auiSelectPageFromAllPages__constructor(idPref, props[j]["children_data"], args, replacer);
					}
				iv += "</ul></li>";
			}
	return iv;
}
//**********************************
function auiSelectPageFromAllPages(sparent, args, needLink){
	if(!sparent) var sparent = "0";
	//alert("paction=auiSelectPageFromAllPages&sparent="+sparent+"&needLink="+needLink);
	var pdata = "paction=auiSelectPageFromAllPages&sparent="+sparent+"&needLink="+needLink;
	//alert(pdata);
	$.ajax({
		type: "POST",
		scriptCharset: "UTF-8",
		url: "/adminarea/__ajax_user_interface.php",
		data: pdata,
		success: function(html) {
			//alert(html);
			props = eval("("+html+")");
			alert(JSON.stringify(args));
			var iv = auiSelectPageFromAllPages__constructor("dauisp", props, args, needLink);
			obj = document.getElementById("dauisp_"+sparent);
			if(!obj) {
				sparent = sparent.replace(/\//gi, "_")
				obj = document.getElementById("dauisp_"+sparent);
			}
			//if(!$("#dauisp_"+sparent).tagName)alert("!=");
			$("#dauisp_"+sparent).empty();
			$("#dauisp_"+sparent).append(iv);
		}
	});
}
//**********************************
function auiSelectAllPages(spar, needLink){
	if($("#aui_SitePages span.aui-icon-plus")[0])
		plusblock_pos = __positions_getAbsolutePos($("#aui_SitePages span.aui-icon-plus")[0]);
	else
		plusblock_pos = {"x":cur_mx,"y":cur_my};
	tmpcss = {"width":"450", "top":plusblock_pos.y+15, "left":plusblock_pos.x+15, "z-index":"50"};
	constructAuiControlBlock("aui_SelectAllPages", tmpcss, "Выберите нужную запись или группу", "...загрузка...", "rootAlisaBg", "");
	inner = "<ul id=\"dauisp_0\" class=\"aui_tree_ul\" ></ul>";
	mb = $("#aui_SelectAllPages div.aui_control_block_content")[0];
	$(mb).empty();
	$(mb).append(inner);
	$("#aui_SelectAllPages .ok").css("display","none");
	$("#aui_SelectAllPages div.aui_control_block_content").css("max-height", "500px");
	auiSelectPageFromAllPages(spar, {"cbFunc":"auiAddPage"}, needLink);
	//if(!spar) spar = "0";
	//alert(spar);
}
//**********************************
function saveSitePages__load(data){
	if(data["result"]=="ok"){
		$("#aui_SitePages").css("display","none");
		aui_root_buttons[4].className = "foo";
	}
}
//**********************************
var auiSitePagesEditIndex = false;
function edit__auiSitePages(elink, editIndex){
	//alert("ok");
	auiSitePagesEditIndex = editIndex;
	if($("#aui_SitePages span.aui-icon-plus")[0])
		plusblock_pos = __positions_getAbsolutePos($("#aui_SitePages span.aui-icon-plus")[0]);
	else
		plusblock_pos = {"x":cur_mx,"y":cur_my};
	tmpcss = {"width":"450", "top":plusblock_pos.y+20, "left":plusblock_pos.x+20, "z-index":"50"};
	constructAuiControlBlock("aui_SelectAllPages", tmpcss, "Выберите нужную запись или группу (редактирование)", "...загрузка...", "rootAlisaBg", "");
	inner = "<ul id=\"dauisp_0\" class=\"aui_tree_ul\" ></ul>";
	mb = $("#aui_SelectAllPages div.aui_control_block_content")[0];
	$(mb).empty();
	$(mb).append(inner);
	$("#aui_SelectAllPages .ok").css("display","none");
	$("#aui_SelectAllPages div.aui_control_block_content").css("max-height", "500px");
	auiSelectPageFromAllPages(0, {"cbFunc":"auiAddPage"}, elink);
}
//**********************************
function delete__auiSitePages(deleteIndex){
	var delInner = "";
	if(auiRenderPages__props.link=="start"){
		tmpcss = {"width":"350", "top":"100", "left":"100", "z-index":"50"};
		var warInner = "<img src=\"/alisaui_css/icon_warning.png\" align=\"left\" style=\"margin-right:20px;\" ><br/>";
		warInner += "Невозможно удалить стартовую страницу!";
		constructAuiControlBlock("aui_Confirm", tmpcss, "Предупреждение", warInner, "rootAlisaBg", "");
		$("#aui_Confirm .aui_control_block_content").css("background-color","#444444");
		$("#aui_Confirm .aui_control_block_content").css("color","#FFFFFF");
		$("#aui_Confirm .cancel").css("display","none");
		$("#aui_Confirm .ok").click(function (){
			$("#aui_Confirm").css("display","none");
			$("#rootAlisaBg").css("display","none");
		});
		return false;
	}
	if(auiRenderPages__props.length==1 || $("#aui_SitePages .aui_control_block_item").length==1){
		tmpcss = {"width":"350", "top":"100", "left":"100", "z-index":"50"};
		var warInner = "<img src=\"/alisaui_css/icon_warning.png\" align=\"left\" style=\"margin-right:20px;\" ><br/>";
		warInner += "Какая-то страница должна остаться, чтобы можно было пользоваться сайтом";
		constructAuiControlBlock("aui_Confirm", tmpcss, "Предупреждение", warInner, "rootAlisaBg", "");
		$("#aui_Confirm .aui_control_block_content").css("background-color","#444444");
		$("#aui_Confirm .aui_control_block_content").css("color","#FFFFFF");
		$("#aui_Confirm .cancel").css("display","none");
		$("#aui_Confirm .ok").click(function (){
			$("#aui_Confirm").css("display","none");
			$("#rootAlisaBg").css("display","none");
		});
		return false;
	}
	delInner += "<img src=\"/alisaui_css/icon_delete.png\" align=\"left\" style=\"margin-right:20px;\" ><br/>Удалить<br/>";
	delInner += "<b>«"+auiRenderPages__props[deleteIndex]["name"]+"»?</b>";
	tmpcss = {"width":"350", "top":"100", "left":"100", "z-index":"50"};
	constructAuiControlBlock("aui_Confirm", tmpcss, "Удаление страницы из списка", delInner, "rootAlisaBg", "");
	$("#aui_Confirm .aui_control_block_content").css("background-color","#444444");
	$("#aui_Confirm .aui_control_block_content").css("color","#FFFFFF");
	$("#aui_Confirm .ok").click(function (){
		//alert("Удаляем!");
		$("#aui_Confirm").css("display","none");
		$("#rootAlisaBg").css("display","none");
		//delete auiRenderPages__props[deleteIndex];
		auiRenderPages__props_a = auiRenderPages__props;
		auiRenderPages__props = false;
		auiRenderPages__props = {};
		var count=0;
		for(var j in auiRenderPages__props_a){
			if(j != deleteIndex){
				auiRenderPages__props[count] = auiRenderPages__props_a[j];
				count++;
			}
		}
		//alert(auiRenderPages__props);
		if(!aui_root_buttons[4].className.match(/fooactive/)) {
			gets = {"ajaxaction":"saveSitePages", "data":auiRenderPages__props};
			getJSON(gets, "auiRenderPages_Tabs__load");
		}
		auiRenderPages(JSON.stringify(auiRenderPages__props));
	});
}
//**********************************
var auiRenderPages__props = false;
function auiRenderPages(html){
	//alert(html);
	if(!aui_root_buttons[4].className.match(/fooactive/)) return false;
	auiRenderPages__props = eval("("+html+")");
	html = "";
	for(var j in auiRenderPages__props){
		html += "<div style=\"float:right\"><span class=\"aui-icon-pencil\" style=\"cursor:pointer;\" ";
		html += " onClick=\"edit__auiSitePages('"+auiRenderPages__props[j]["link"]+"', '"+j+"')\" ></span> ";
		html += "<span class=\"aui-icon-remove-sign\" style=\"cursor:pointer;\" ";
		html += " onClick=\"delete__auiSitePages(  '"+j+"'  )\"></span></div>";
		var loc = document.location.href.replace(RegExp(root_link, "gi"), "");
		if( loc.match(RegExp(auiRenderPages__props[j]["link"]) ) )
			html += "<div class=\"aui_control_block_item acbi_active\"><b>"+auiRenderPages__props[j]["name"]+"</b><br/>";
		else
			html += "<div class=\"aui_control_block_item\"><b>"+auiRenderPages__props[j]["name"]+"</b><br/>";
		html += "расположение: "+auiRenderPages__props[j]["link"]+"</b></div>";
		html += "<div class=\"aui_control_block_separator\" style=\"margin:0px\"></div>";
	}
	tmpcss = {"width":"550", "top":"20px", "left":"80px"};
	constructAuiControlBlock("aui_SitePages", tmpcss, "Страницы сайта", html, false, "aui_root_buttons[4].className='foo'");
	$("#aui_SitePages div.aui_control_block_content").css("padding", "5px");
	$("#aui_SitePages div.aui_control_block_content").css("max-height", "500px");
	//*************************
	inblock = $("#aui_SitePages .aui_control_block_buttons")[0];
	ibtext = "<span class=\"aui-icon-plus\" onClick=\"auiSelectAllPages()\"></span>";
	$(inblock).append(ibtext);
	$("#aui_SitePages .ok").click(function(){
		gets = {"ajaxaction":"saveSitePages", "data":auiRenderPages__props};
		getJSON(gets, "saveSitePages__load");
	});
	//alert(inblock.className);//aui-icon-plus
}
//**********************************
function auiRenderPages_Tabs__load(){
	//alert("Сохранено. Обновить!");auiSitePagesEditIndex
	if(auiRenderPages__props[auiSitePagesEditIndex])
		document.location.href = root_link+auiRenderPages__props[auiSitePagesEditIndex]["link"];
	else
		document.location.href = root_link;
}
//**********************************
var objIdmoInterval;
var oldobjId;
function auiSubShow(objCb, objId){
	pos = __positions_getAbsolutePos(objCb);
	oldobjId = objId;
	$("#"+objId).css("left", pos.x);
	$("#"+objId).css("display", "block");
	$("#"+objId).mouseover(function(){
		clearInterval(objIdmoInterval);
	});
	$("#"+objId).mouseout(function(){
		clearInterval(objIdmoInterval);
		objIdmoInterval = setTimeout('$("#"+oldobjId).css("display", "none")' , 500);
	});
	$(objCb).mouseout(function(){
		clearInterval(objIdmoInterval);
		objIdmoInterval = setTimeout('$("#"+oldobjId).css("display", "none")' , 500);
	})
	//alert("asd");
}
//**********************************
var auiRenderPages_Tabs_start = -1;
var auiRenderPages_Tabs_stop = -1;
function auiRenderPages_Tabs(html){
	auiRenderPages__props = eval("("+html+")");
	var html = "";
	for(var j in auiRenderPages__props){
		if(auiRenderPages__props[j]["link"])
			idPref = auiRenderPages__props[j]["link"].replace(/\//gi, "_");
		html += "<a href=\""+auiRenderPages__props[j]["link"]+"\" "; 
		var loc = document.location.href.replace(RegExp(root_link, "gi"), "");
		if( loc.match(RegExp(auiRenderPages__props[j]["link"]+"\/?$") ) )
			html += " class=\"active\" ";
		if(auiRenderPages__props[j]["subPage"]) html += "  onMouseOver=\"auiSubShow(this, 'sub_"+idPref+"')\"  ";
		html += ">"+auiRenderPages__props[j]["name"];
		if( loc.match(RegExp(auiRenderPages__props[j]["link"]) ) ){
			html += " <span class=\"aui-icon-eye-open\" ></span>";
			html += " <span class=\"aui-icon-cog\" onClick=\"edit__auiSitePages('"+auiRenderPages__props[j]["link"]+"', '"+j+"');return false;\"></span>";
			html += " <span class=\"aui-icon-remove-sign\" onClick=\"delete__auiSitePages(  '"+j+"'  );return false;\"></span>";
		}
		if(auiRenderPages__props[j]["subPage"]){
			aapend = "<a style=\"display:none\" href=\"/"+root_request+"/[sub]\" id=\"sub_"+idPref+"\" class=\"subpage\">Тестирование</a>";
			$(document.body).append(aapend);
		}
		html += "</a>";
	}
	html += "<a class=\"tabsplus\" onClick=\"auiSelectAllPages()\"><span class=\"aui-icon-plus\"></span></a>";
	html += "<div style=\"float:none;clear:both;\"></div>";
	$("#aui_topTabs").empty();
	$("#aui_topTabs").append(html);
	$( "#aui_topTabs" ).sortable({
		start: function( event, ui ) {
			objs = $("#aui_topTabs a");
			for(var j in objs) if(objs[j]==cur_mousedown_object) auiRenderPages_Tabs_start = j;
		},
		stop: function( event, ui ) {
			objs = $("#aui_topTabs a");
			for(var j in objs) if(objs[j]==cur_mousedown_object) auiRenderPages_Tabs_stop = j;
			var tmpValue = auiRenderPages__props[auiRenderPages_Tabs_start];
			var auiRenderPages__props_tmp = auiRenderPages__props;
			if(auiRenderPages_Tabs_start < auiRenderPages_Tabs_stop){
				for(var jj=auiRenderPages_Tabs_start; jj<auiRenderPages_Tabs_stop; jj++){
					auiRenderPages__props[jj] = auiRenderPages__props_tmp[jj*1+1];
				}
				auiRenderPages__props[jj] = tmpValue;
				gets = {"ajaxaction":"saveSitePages", "data":auiRenderPages__props};
				getJSON(gets, "auiRenderPages_Tabs__load_sort");
			}
			if(auiRenderPages_Tabs_start > auiRenderPages_Tabs_stop){
				for(var jj=auiRenderPages_Tabs_start; jj>auiRenderPages_Tabs_stop; jj--){
					auiRenderPages__props[jj] = auiRenderPages__props_tmp[jj*1-1];
				}
				auiRenderPages__props[jj] = tmpValue;
				gets = {"ajaxaction":"saveSitePages", "data":auiRenderPages__props};
				getJSON(gets, "auiRenderPages_Tabs__load_sort");
			}
		}
	});
}
//**********************************
function auiRenderPages_Tabs__load_sort(){
	
}
//**********************************
function auiGetSitePages(){
	$.ajax({
		type: "POST",
		scriptCharset: "UTF-8",
		url: "/adminarea/__ajax_user_interface.php",
		data: "paction=auiGetSitePages",
		success: function(html) {
			//alert(html);
			if(!aui_root_buttons[4].className.match(/fooactive/)) {
				gets = {"ajaxaction":"saveSitePages", "data":auiRenderPages__props};
				getJSON(gets, "auiRenderPages_Tabs__load");
			}
			auiRenderPages(html);
			//auiRenderPages_Tabs(html);
		}
	});
}
var aui_blocksReplaceStart = -1;
var aui_blocksReplaceStop = -1;
var aui_blocksReplace__props = false;
var aui_oldDragabbleClassName;
//**********************************
$(document).ready(function(){
	aui_root_buttons = $("#start_aui div a");
	$(".foo").click(function () {
		//alert(this.parentNode.getElementsByTagName("a").length);
		ab=false; if(this.className == "foo") ab = true;
		for(i=0; i<this.parentNode.getElementsByTagName("a").length; i++){
			this.parentNode.getElementsByTagName("a")[i].className = "foo";
		}
		if(ab) this.className = "fooactive";
		if(old_cur_sel_element){
			$(".show_block_buttons").css("display", "none");
			old_cur_sel_element.className = old_cur_sel_element.className.replace(/ editing/, "");
			old_cur_sel_element.className = old_cur_sel_element.className.replace(/ aoutline/, "");
			if(aui_mouse_interval_tout) clearInterval(aui_mouse_interval_tout);
			
			old_cur_sel_element = false;
			old_cur_element = false;
		
		}
		//*************
		if(aui_root_buttons[0].className.match(/fooactive/)){
			//auiGetSiteProperties();
		} else {
			$("#aui_selInsert_panel").css("display", "none");
			$("#aui_SiteProperties").css("display", "none");
		}
		//*************
		if(aui_root_buttons[5].className.match(/fooactive/)){
			auiGetSiteProperties();
		} else {
			$("#aui_SiteProperties").css("display", "none");
		}
		//*************
		if(aui_root_buttons[4].className.match(/fooactive/)){
			auiGetSitePages();
		} else {
			$("#aui_SitePages").css("display", "none");
		}
		//*************
		if(aui_root_buttons[3].className.match(/fooactive/)){
			//gets = {"ajaxaction":"saveSitePages"};
			//getJSON(gets, "alert");
		} else {
			//$("#aui_SitePages").css("display", "none");
		}
		//*************
		if(aui_root_buttons[6].className.match(/fooactive/)){
			document.location.href = root_link + "__publish.php";
			//window.open("__publish.php", "_blank");
			//auiGetSiteProperties();
		} else {
			$("#aui_SiteProperties").css("display", "none");
		}
		//*************
		$("#rootAlisaBg").css("display", "none");
		$("#aui_SitePages").css("display", "none");
		return false;
		//alert( this.className );
	});
	//***************************************
	$("#show_block_buttons .aui-icon-move").click(function(){
		
		$( old_cur_sel_element.parentNode ).sortable({
			start: function( event, ui ) {
				aui_oldDragabbleClassName = old_cur_sel_element.className;
				old_cur_sel_element.className  = aui_oldDragabbleClassName.replace(/ editing| aoutline/gi, "");
				objs = old_cur_sel_element.parentNode.children;
				for(var j=0; j<old_cur_sel_element.parentNode.children.length; j++) if(objs[j]==cur_mousedown_object) aui_blocksReplaceStart = j;
				//----------------------------
				aui_blocksReplace__props = aui__getValue_FromDomIndex(old_cur_sel_element.parentNode);
				aui_blocksReplace__props = aui_blocksReplace__props["childs"];
				//alert(JSON.stringify(aui_blocksReplace__props));
			},
			stop: function( event, ui ) {
				aui__positionShowBlockButtons(old_cur_sel_element);
				$(old_cur_sel_element.parentNode).sortable("destroy");
				//----------------------------
				objs = old_cur_sel_element.parentNode.children;
				for(var j=0; j<old_cur_sel_element.parentNode.children.length; j++) if(objs[j]==cur_mousedown_object) aui_blocksReplaceStop = j;
				var tmpValue = aui_blocksReplace__props[aui_blocksReplaceStart];
				var aui_blocksReplace__props_tmp = aui_blocksReplace__props;
				if(aui_blocksReplaceStart < aui_blocksReplaceStop){
					for(var jj=aui_blocksReplaceStart; jj<aui_blocksReplaceStop; jj++){
						aui_blocksReplace__props[jj] = aui_blocksReplace__props_tmp[jj*1+1];
					}
					aui_blocksReplace__props[jj] = tmpValue;
					//----------------------------------------
					blockKeys = auiGetBlockKeys(old_cur_sel_element.parentNode);
					jblockKeys = blockKeys;
					blockKeys = blockKeys.replace(/~$/, "");  	blockKeys = explode("~", blockKeys);  for(var j in blockKeys) {
						tmpa = eval("({"+blockKeys[j]+"})");   blockKeys[j]= tmpa;
					}
					aEval = auiGetBlockFromKeys(blockKeys, allInterfaceTemplate)+"[\"childs\"]";
					eval("allInterfaceTemplate"+aEval+"= aui_blocksReplace__props");
					gets = {"ajaxaction":"aui_replaceBlocks", "from":aui_blocksReplaceStart, "to":aui_blocksReplaceStop, "blockKeys":jblockKeys };
					getJSON(gets, "return");
				}
				if(aui_blocksReplaceStart > aui_blocksReplaceStop){
					for(var jj=aui_blocksReplaceStart; jj>aui_blocksReplaceStop; jj--){
						aui_blocksReplace__props[jj] = aui_blocksReplace__props_tmp[jj*1-1];
					}
					aui_blocksReplace__props[jj] = tmpValue;
					//----------------------------------------
					blockKeys = auiGetBlockKeys(old_cur_sel_element.parentNode);
					jblockKeys = blockKeys;
					blockKeys = blockKeys.replace(/~$/, "");  	blockKeys = explode("~", blockKeys);  for(var j in blockKeys) {
						tmpa = eval("({"+blockKeys[j]+"})");   blockKeys[j]= tmpa;
					}
					aEval = auiGetBlockFromKeys(blockKeys, allInterfaceTemplate)+"[\"childs\"]";
					eval("allInterfaceTemplate"+aEval+"= aui_blocksReplace__props");
					gets = {"ajaxaction":"aui_replaceBlocks", "from":aui_blocksReplaceStart, "to":aui_blocksReplaceStop, "blockKeys":jblockKeys };
					getJSON(gets, "return");
				}
			}
		});
	});
	//***************************************
	$(".aui_selInsert").click(function () {
		//auiSitePagesEditIndex = editIndex;
		plusblock_pos = __positions_getAbsolutePos($("#show_block_buttons a.aui_selInsert")[0]);
		tmpcss = {"width":"250", "height":"500", "top":plusblock_pos.y+10, "left":plusblock_pos.x+10, "z-index":"50"};
		constructAuiControlBlock("aui_SelectAllPages", tmpcss, "Выберите блок", "...загрузка...", "", "");
		inner = "<ul id=\"dauisp_constructor_blocks\" class=\"aui_tree_ul\"></ul>";
		mb = $("#aui_SelectAllPages div.aui_control_block_content")[0];
		$(mb).empty();
		$(mb).append(inner);
		$("#aui_SelectAllPages .ok").css("display","none");
		$("#aui_SelectAllPages div.aui_control_block_content").css("max-height", "500px");
		auiSelectPageFromAllPages("constructor/blocks", {"cbFunc":"auiAddBlock","onlyRecords":"1"});
	});
	//***************************************
	$(".aui_editStyles").click(function () {
		//alert(JSON.stringify(auiRenderPages__props));
		gets = {"ajaxaction":"getStylesCSS", "data":auiRenderPages__props};
		getJSON(gets, "aui_getStyles");
	});
	//***************************************
	$.ajax({
		type: "POST",
		scriptCharset: "UTF-8",
		url: "/adminarea/__ajax_user_interface.php",
		data: "paction=getTemplateJSON",
		success: function(html) {
			//alert(html);
			allInterfaceTemplate = eval("("+html+")");
			html = constructAlisaInterface(eval("("+html+")"));
			$("#div_aui_all_constructor").empty();
			$("#div_aui_all_constructor").append(html);
			start_leaf();
		}
	});
	//***************************************
	$.ajax({
		type: "POST",
		scriptCharset: "UTF-8",
		url: "/adminarea/__ajax_user_interface.php",
		data: "paction=auiGetSitePages",
		success: function(html) {
			//alert(html);
			auiRenderPages_Tabs(html);
		}
	});
	//***************************************
	$(".aui_deleteBlock").click(function () {
		aui__DeleteBlock();
		
	});
	//***************************************
	$(".aui-icon-undo").click(function () {
		//alert("ok");
		gets = {"ajaxaction":"undoConfigCopy"};
		getJSON(gets, "reload");
	});
	//***************************************
	$(".aui-icon-redo").click(function () {
		//alert("false");
		gets = {"ajaxaction":"redoConfigCopy"};
		getJSON(gets, "reload");
	});
	//***************************************
	if(document.location.href == root_link){
		document.location.href = root_link+"start";
	}
	//alert(aui_root_buttons[0].className);
});
//**********************************
function aui__DeleteBlock( apLink, apName, apIndex ){
	//alert("aui__DeleteBlock");
	var delInner = "";
	delInner += "<img src=\"/alisaui_css/icon_delete.png\" align=\"left\" style=\"margin-right:20px;\" ><br/>Удалить<br/>";
	//delInner += "<b>«"+auiRenderPages__props[deleteIndex]["name"]+"»?</b>";
	tmpcss = {"width":"350", "top":"100", "left":"100", "z-index":"50"};
	constructAuiControlBlock("aui_Confirm", tmpcss, "Удаление страницы из списка", delInner, "rootAlisaBg", "");
	$("#aui_Confirm .aui_control_block_content").css("background-color","#444444");
	$("#aui_Confirm .aui_control_block_content").css("color","#FFFFFF");
	$("#aui_Confirm .ok").click(function (){
		blockKeys = auiGetBlockKeys(old_cur_sel_element);
		//alert(JSON.stringify(blockKeys));
		blockKeys["ajaxaction"] = "deletePageBlock";
		gets = {"ajaxaction":"deletePageBlock", "blockKeys":blockKeys};
		getJSON(gets, "auiDeleteBlock__load");
	});
}
//**********************************
function auiDeleteBlock__load( data ){
	//alert("auiDeleteBlock__load="+JSON.stringify( data ));
	$("#aui_Confirm").css("display","none");
	$("#rootAlisaBg").css("display","none");
	$("#show_block_buttons").css("display","none");
	allInterfaceTemplate = data;
	html = constructAlisaInterface(data);
	old_cur_sel_element = false;
	ld_cur_element = false;
	$("#div_aui_all_constructor").empty();
	$("#div_aui_all_constructor").append(html);
}
//**********************************
function auiAddBlock( apLink, apName, apIndex ){
	//alert( apLink+":"+apName+":"+apIndex );
	var blockKeys = auiGetBlockKeys(old_cur_sel_element);
	blockKeys = blockKeys.replace(/~$/, "");
	gets = {"ajaxaction":"addPageBlock", "block":apLink, "blockKeys":blockKeys};
	getJSON(gets, "auiAddBlock__load");
	 //auiPanelShowPreview("aui_SelectAllPages");
}
//**********************************
function aui__getValue_FromDomIndex(Elem){
	if(!Elem.tagName) return false;
	if(Elem.tagName.toLowerCase()=="body") return false;
	blockKeys = auiGetBlockKeys(Elem);
	//blockKeys = blockKeys.replace(/~$/, "");
	//alert(JSON.stringify(blockKeys));
	blockKeys = blockKeys.replace(/~$/, "");
	blockKeys = explode("~", blockKeys);
	for(var j in blockKeys) {
		tmpa = eval("({"+blockKeys[j]+"})");
		blockKeys[j]= tmpa;
	}
	//alert(JSON.stringify(blockKeys));
	aEval = auiGetBlockFromKeys(blockKeys, allInterfaceTemplate);
	if(!aEval) return false;
	//alert("aEval="+aEval);
	var rvObj = false;
	eval("rvObj = allInterfaceTemplate"+aEval);
	//alert(JSON.stringify(rvObj));
	return rvObj;
}
//**********************************
function auiAddBlock__load( data ){
	/*var blockKeys = auiGetBlockKeys(old_cur_sel_element);
	blockKeys = blockKeys.replace(/~$/, "");
	blockKeys = explode("~", blockKeys);
	for(var j in blockKeys) {
		tmpa = eval("({"+blockKeys[j]+"})");
		blockKeys[j]= tmpa;
	}
	//allInterfaceTemplate
	//alert(JSON.stringify(blockKeys));
	aEval = auiGetBlockFromKeys(blockKeys, allInterfaceTemplate);
	//if(eval("allInterfaceTemplate"+aEval+"[\"childs\"]"))  alert(JSON.stringify(eval("allInterfaceTemplate"+aEval+"[\"childs\"]")));
	if(eval("allInterfaceTemplate"+aEval+"[\"childs\"]")){
		var obj = false;
		eval("obj=allInterfaceTemplate"+aEval+"[\"childs\"];");
		//for(var jj in obj) for(var jjj in obj[jj]) alert(obj[jj][jjj]+"::"+jj+":::"+jjj);
		var len = 0;
		for(  var jj in eval("allInterfaceTemplate"+aEval+"[\"childs\"]")  )
			len++;
		//alert("len="+len);
		eval("allInterfaceTemplate"+aEval+"[\"childs\"]["+len+"]=data;");
	} else {
		eval("allInterfaceTemplate"+aEval+"[\"childs\"]={\"0\": data}");
	}
	//constructAlisaInterface(allInterfaceTemplate);
	*/
	//alert(JSON.stringify(data));
	//html = constructAlisaInterface(allInterfaceTemplate);
	html = constructAlisaInterface(data);
	//alert(html);
	$("#div_aui_all_constructor").empty();
	$("#div_aui_all_constructor").append(html);
	//old_cur_sel_element.className += " editing";
	//alert("a="+a);
}
//**********************************
function auiGetBlockFromKeys(blockKeys, tmpl, lvl){
	//alert("auiGetBlockFromKeys()");
	if(!lvl) var lvl=0;
	var count=0;
	var rv = "";
	if(!blockKeys[0][1]) return false;
	//alert(tmpl);
	//alert(allInterfaceTemplate);
	//alert("level="+lvl);
	for(var j in tmpl){
		//if(lvl==3) alert( blockKeys[0][1].toLowerCase()+"::"+tmpl[j]["tagname"].toLowerCase()+"::"+blockKeys[0][0]+"::"+count );
		if(!tmpl[j]["tagname"]) break;
		if(  blockKeys[0][1].toLowerCase() == tmpl[j]["tagname"].toLowerCase()  &&  blockKeys[0][0] == j  ){
			//if(lvl==3) alert("ok "+j);
			rv += "["+j+"]"; 
			//alert("a="+JSON.stringify(blockKeys));
			//alert("a="+JSON.stringify(blockKeys)+":::"+rv+":::"+j+JSON.stringify(tmpl)); 
			//alert("bUp");
			if(blockKeys[1]){
				blockKeys.splice(0,1);
				//alert("Загрузка блока  "+JSON.stringify(tmpl[j]["childs"]));
				rv += "[\"childs\"]"+auiGetBlockFromKeys(blockKeys, tmpl[j]["childs"], lvl+1);
			}
			//alert("a="+JSON.stringify(blockKeys)+":::"+rv+":::"+j); 
			return rv;
		}
		if(  blockKeys[0][1].toLowerCase() == tmpl[j]["tagname"].toLowerCase()  )	{
			//alert("count="+count);
			count++;
		}
	}
	return "";
}
//**********************************
function auiGetBlockKeys(obj, level){
	var rv = "";
	if(!obj) return rv;
	var r = objsGetDomIndex(obj);
	if(obj.id!="div_aui_all_constructor"){
		a = auiGetBlockKeys(obj.parentNode)
		if(a) rv += auiGetBlockKeys(obj.parentNode, 1);
		rv += "\"0\":\""+r+"\",\"1\":\""+obj.tagName+"\"~";
	}
	if(!level) rv = rv.replace(/~$/, "");
	return rv;
}
//**********************************
function close_aui_control_block(){
	$("#aui_control_block").css("display","none");
}
//**********************************
function se_init_mcontrols(){
	//alert("se_init_mcontrols();");
	//$("#se_toggle_button").click("enable");
	$("#se_toggle_button").click(function () {
		sel_element_control=!sel_element_control;
		cur_cname = document.getElementById("se_toggle_button").className;
		//alert(cur_cname);
		if(sel_element_control){
			$("#se_toggle_button").removeClass("se_toggle_button");
			$("#se_toggle_button").addClass("se_toggle_button_active");
		} else {
			$("#se_toggle_button").removeClass("se_toggle_button_active");
			$("#se_toggle_button").removeClass("se_toggle_button_hover");
			$("#se_toggle_button").addClass("se_toggle_button");
		}
		return false;
	});
	$("#black_bg").click(function () {
		sel_element_control = true;
		elementproperties_close_black_bg();
		return false;
	});
	//*************************************
	<?
	//$amass = __tmpl_template_items_to_array($mytemplate);
	//print_r($amass);
	//echo "amass[0][id]=".$amass[0]["id"]."\n";
	//$itemtypes_id = get_item_type($amass[0]["id"]);
	
	//echo $vmass;
	//$itmass = __ff_get_itemstypes_to_mass_by_id($itemtypes_id);
	//print_r($itmass);
	//print_r($mass);
	//*************************************
	echo __tmpl_items_from_css($mytemplate);
	
	//*************************************
	
	//*************************************
	//*************************************
	//*************************************
	//$resp_tpl = mysql_query("select * from items where href_name='site_templates' && folder=1 && parent=0 ");
	//$row_tpl = mysql_fetch_assoc($resp_tpl);
	//$resp_tpl = mysql_query("select * from items where parent=$row_tpl[id] $dop_query order by prior asc ");
	//while($row_tpl = mysql_fetch_assoc($resp_tpl)){
	////***********
	//$("<?  echo $row_tpl["model_name"]; ").click(function () {
	//	if(sel_element_control) {
	//		getelementproperties_light_element("<?  echo $row_tpl["model_name"]; ", this);
	//		return false;
	//	}
	//}); 
	//**************************************
//**********************************
?>
}
var elname_a = false;
var elobj_a = false;
var mystylefile = false;
function getelementproperties_light_element(elname, elobj, stylefile){
	//alert("elname="+elname);
	elname_a = elname;
	mystylefile = stylefile;
	$trash = $( elobj );
	$trash.droppable({
      activeClass: "drop_in_trash",
      drop: function( event, ui ) {
        //deleteImage( ui.draggable );
		alert("drop in trash:"+elname_a);
      }
	});
	//****************************
	elobj_a = elobj;
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	//*******************************
	$(elobj).css("position", "relative");
	$(elobj).css("z-index", "800");
	$("#black_bg").css("position", "absolute");
	$("#black_bg").css("top", "0px");
	$("#black_bg").css("left", "0px");
	$("#black_bg").css("width", wwidth+"px");
	$("#black_bg").css("height", wheight+"px");
	$("#black_bg").css("display", "");
	
	$("#se_css_menu").css("display", "");
	$("#se_css_menu").css("z-index", "850");
	var pos = $(elobj).position();
	$("#se_css_menu").offset({top:pos.top, left:pos.left});
	
	sel_element_control = false;
	//alert(elname_a);
}
//**********************************
function getelementproperties_bg(){
	paction = "paction=getelementproperties_bg&elname="+elname_a+"&mystylefile="+mystylefile;
	//alert(elname_a);
	$.ajax({
		type: "POST",
		url: "/adminarea/__ajax_user_interface.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#sel_elem_property").empty();
			$("#sel_elem_property").append(html);
			$("#sel_elem_property").css("display", "");
			sel_element_control = false;
			$("#se_toggle_button").removeClass("se_toggle_button_active");
			$("#se_toggle_button").removeClass("se_toggle_button_hover");
			$("#se_toggle_button").addClass("se_toggle_button");
			$("#start_ui").css("z-index", "860");
			//$("#cabinet_select_zone").css("display", "");
			__jl_init_uploader();
			sel_element_name = elname_a;
		}
	});
}
//**********************************
function getelementproperties_box(elname){
	paction = "paction=getelementproperties_box&elname="+elname+"&mystylefile="+mystylefile;;
	//alert(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: "/adminarea/__ajax_user_interface.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#sel_elem_property").empty();
			$("#sel_elem_property").append(html);
			$("#sel_elem_property").css("display", "");
			sel_element_control = false;
			$("#se_toggle_button").removeClass("se_toggle_button_active");
			$("#se_toggle_button").removeClass("se_toggle_button_hover");
			$("#se_toggle_button").addClass("se_toggle_button");
			//$("#cabinet_select_zone").css("display", "");
			//__jl_init_uploader();
			sel_element_name = elname;
		}
	});
}
//**********************************
function getelementproperties_pos(elname){
	paction = "paction=getelementproperties_pos&elname="+elname+"&mystylefile="+mystylefile;
	//alert(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: "/adminarea/__ajax_user_interface.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#sel_elem_property").empty();
			$("#sel_elem_property").append(html);
			$("#sel_elem_property").css("display", "");
			sel_element_control = false;
			$("#se_toggle_button").removeClass("se_toggle_button_active");
			$("#se_toggle_button").removeClass("se_toggle_button_hover");
			$("#se_toggle_button").addClass("se_toggle_button");
			//$("#cabinet_select_zone").css("display", "");
			//__jl_init_uploader();
			sel_element_name = elname;
		}
	});
}
//**********************************
function getelementproperties_txt(elname){
	paction = "paction=getelementproperties_txt&elname="+elname+"&mystylefile="+mystylefile;;
	//alert(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: "/adminarea/__ajax_user_interface.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#sel_elem_property").empty();
			$("#sel_elem_property").append(html);
			$("#sel_elem_property").css("display", "");
			sel_element_control = false;
			$("#se_toggle_button").removeClass("se_toggle_button_active");
			$("#se_toggle_button").removeClass("se_toggle_button_hover");
			$("#se_toggle_button").addClass("se_toggle_button");
			//$("#cabinet_select_zone").css("display", "");
			//__jl_init_uploader();
			sel_element_name = elname;
		}
	});
}
//**********************************
function getelementproperties_bor(elname){
	paction = "paction=getelementproperties_bor&elname="+elname+"&mystylefile="+mystylefile;
	//alert(paction);
	//return false;
	$.ajax({
		type: "POST",
		url: "/adminarea/__ajax_user_interface.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#sel_elem_property").empty();
			$("#sel_elem_property").append(html);
			$("#sel_elem_property").css("display", "");
			sel_element_control = false;
			$("#se_toggle_button").removeClass("se_toggle_button_active");
			$("#se_toggle_button").removeClass("se_toggle_button_hover");
			$("#se_toggle_button").addClass("se_toggle_button");
			//$("#cabinet_select_zone").css("display", "");
			//__jl_init_uploader();
			sel_element_name = elname;
		}
	});
}
//**********************************
function __getelementproperties_save_bg(){
	bgimg = document.getElementById("bg_prewiev_image").src;
	//alert(root_link);
	bgimg = bgimg.replace(root_link+"imgres.php?resize=260&link=", "/");
	imgobj = document.getElementById("imgbgoff");
	//alert(imgobj.src);
	if(imgobj.src == root_link+"adminarea/images/green/myitemname_popup/specpred_no.gif"){
		savestyle   = "background-image: none;\n";
	} else {
		savestyle   = "background-image: url("+bgimg+");\n";
	}
	
	savestyle += "background-color: "+document.getElementById("color_value").value+";\n";
	savestyle += "background-repeat: "+document.getElementById("se_bgrepaet").value+";\n";
	savestyle += "background-attachment: "+document.getElementById("se_bgattach").value+";\n";
	bgpos_x = document.getElementById("se_bgpos_x").value;
	if(bgpos_x != "left" && bgpos_x != "center" && bgpos_x != "right" && bgpos_x!=""){
		bgpos_x = document.getElementById("se_bgpos_x_val").value;
	}
	bgpos_y = document.getElementById("se_bgpos_y").value;
	if(bgpos_y != "top" && bgpos_y != "center" && bgpos_y != "bottom" && bgpos_y!=""){
		bgpos_y = document.getElementById("se_bgpos_y_val").value;
	}
	savestyle += "background-position: " + bgpos_x + " " + bgpos_y + ";";
	//alert(savestyle);
	paction = "paction=saveelementproperties&styles="+savestyle+"&elname="+sel_element_name+"&mystylefile="+mystylefile;
	//alert(paction);
	elementproperties_post_ajax(paction);
}
//**********************************
function __getelementproperties_look_bg(){
	bgimg = document.getElementById("bg_prewiev_image").src;
	//alert(root_link);
	bgimg = bgimg.replace(root_link+"imgres.php?resize=260&link=", "/");
	imgobj = document.getElementById("imgbgoff");
	//alert(imgobj.src);
	if(imgobj.src == root_link+"adminarea/images/green/myitemname_popup/specpred_no.gif"){
		$( sel_element_name ).css("background-image",  "none");
	} else {
		$( sel_element_name ).css("background-image",  "url("+bgimg+")");
	}
	
	$( sel_element_name ).css("background-color",  document.getElementById("color_value").value);
	$( sel_element_name ).css("background-repeat",  document.getElementById("se_bgrepaet").value);
	$( sel_element_name ).css("background-attachment",  document.getElementById("se_bgattach").value);
	bgpos_x = document.getElementById("se_bgpos_x").value;
	if(bgpos_x != "left" && bgpos_x != "center" && bgpos_x != "right" && bgpos_x!=""){
		bgpos_x = document.getElementById("se_bgpos_x_val").value;
	}
	bgpos_y = document.getElementById("se_bgpos_y").value;
	if(bgpos_y != "top" && bgpos_y != "center" && bgpos_y != "bottom" && bgpos_y!=""){
		bgpos_y = document.getElementById("se_bgpos_y_val").value;
	}
	$( sel_element_name ).css("background-position",  bgpos_x + " " + bgpos_y);

}
//**********************************
function __getelementproperties_save_box(){
	savestyle   = "";
	
	savestyle += "width: "+document.getElementById("se_boxwidth").value+";\n";
	savestyle += "height: "+document.getElementById("se_boxheight").value+";\n";
	
	savestyle += "float: "+document.getElementById("se_boxfloat").value+";\n";
	savestyle += "clear: "+document.getElementById("se_boxclear").value+";\n";
	
	savestyle += "padding-top: "+document.getElementById("se_box_ptop").value+";\n";
	savestyle += "padding-right: "+document.getElementById("se_box_pright").value+";\n";
	savestyle += "padding-bottom: "+document.getElementById("se_box_pbottom").value+";\n";
	savestyle += "padding-left: "+document.getElementById("se_box_pleft").value+";\n";
	
	savestyle += "margin-top: "+document.getElementById("se_box_mtop").value+";\n";
	savestyle += "margin-right: "+document.getElementById("se_box_mright").value+";\n";
	savestyle += "margin-bottom: "+document.getElementById("se_box_mbottom").value+";\n";
	savestyle += "margin-left: "+document.getElementById("se_box_mleft").value+";\n";
	//alert(savestyle);
	paction = "paction=saveelementproperties&styles="+savestyle+"&elname="+sel_element_name+"&mystylefile="+mystylefile;
	//alert("paction="+paction);
	elementproperties_post_ajax(paction);
}
//**********************************
function __getelementproperties_look_box(){
	$( sel_element_name ).css("width",  document.getElementById("se_boxwidth").value);
	$( sel_element_name ).css("height",  document.getElementById("se_boxheight").value);
	
	$( sel_element_name ).css("float",  document.getElementById("se_boxfloat").value);
	$( sel_element_name ).css("clear",  document.getElementById("se_boxclear").value);
	
	$( sel_element_name ).css("padding-top",  document.getElementById("se_box_ptop").value);
	$( sel_element_name ).css("padding-right",  document.getElementById("se_box_pright").value);
	$( sel_element_name ).css("padding-bottom",  document.getElementById("se_box_pbottom").value);
	$( sel_element_name ).css("padding-left",  document.getElementById("se_box_pleft").value);
	
	$( sel_element_name ).css("margin-top",  document.getElementById("se_box_mtop").value);
	$( sel_element_name ).css("margin-right",  document.getElementById("se_box_mright").value);
	$( sel_element_name ).css("margin-bottom",  document.getElementById("se_box_mbottom").value);
	$( sel_element_name ).css("margin-left",  document.getElementById("se_box_mleft").value);
}
//**********************************
function __getelementproperties_save_pos(){
	savestyle   = "";

	savestyle += "position: "+document.getElementById("se_pospos").value+";\n";
	savestyle += "visibility: "+document.getElementById("se_posvisibility").value+";\n";
	savestyle += "z-index: "+document.getElementById("se_posz").value+";\n";
	savestyle += "overflow: "+document.getElementById("se_posoverflow").value+";\n";
		
	savestyle += "left: "+document.getElementById("se_posleft").value+";\n";
	savestyle += "top: "+document.getElementById("se_postop").value+";\n";
	savestyle += "right: "+document.getElementById("se_posright").value+";\n";
	savestyle += "bottom: "+document.getElementById("se_posbottom").value+";\n";
	savestyle += "clip: "+document.getElementById("se_posclip").value+";\n";
	//alert(savestyle);
	paction = "paction=saveelementproperties&styles="+savestyle+"&elname="+sel_element_name+"&mystylefile="+mystylefile;
	//alert("paction="+paction);
	elementproperties_post_ajax(paction);
}
//**********************************
function __getelementproperties_look_pos(){
	$( sel_element_name ).css("position",  document.getElementById("se_pospos").value);
	$( sel_element_name ).css("visibility",  document.getElementById("se_posvisibility").value);
	$( sel_element_name ).css("z-index",  document.getElementById("se_posz").value);
	$( sel_element_name ).css("overflow",  document.getElementById("se_posoverflow").value);
		
	$( sel_element_name ).css("left",  document.getElementById("se_posleft").value);
	$( sel_element_name ).css("top",  document.getElementById("se_postop").value);
	$( sel_element_name ).css("right",  document.getElementById("se_posright").value);
	$( sel_element_name ).css("bottom",  document.getElementById("se_posbottom").value);
	$( sel_element_name ).css("clip",  document.getElementById("se_posclip").value);
}
//**********************************
function __getelementproperties_save_txt(){
	savestyle   = "";

	savestyle += "font-family: "+document.getElementById("se_txt_font").value+";\n";
	savestyle += "font-size: "+document.getElementById("se_txt_size").value+";\n";
	savestyle += "font-style: "+document.getElementById("se_txt_style").value+";\n";
	savestyle += "line-height: "+document.getElementById("se_txt_lheight").value+";\n";
	
	savestyle += "font-weight: "+document.getElementById("se_txt_weight").value+";\n";
	savestyle += "text-transform: "+document.getElementById("se_txt_transform").value+";\n";
	savestyle += "color: "+document.getElementById("se_txt_color").value+";\n";
	savestyle += "text-decoration: "+document.getElementById("se_txt_decor").value+";\n";
	//alert(savestyle);
	paction = "paction=saveelementproperties&styles="+savestyle+"&elname="+sel_element_name+"&mystylefile="+mystylefile;
	//alert("paction="+paction);
	elementproperties_post_ajax(paction);
}
//**********************************
function __getelementproperties_save_bor(){
	savestyle   = "";
	
	savestyle += "border-top-width: "+document.getElementById("se_btw").value+";\n";
	savestyle += "border-right-width: "+document.getElementById("se_brw").value+";\n";
	savestyle += "border-bottom-width: "+document.getElementById("se_bbw").value+";\n";
	savestyle += "border-left-width: "+document.getElementById("se_blw").value+";\n";
	
	savestyle += "border-top-style: "+document.getElementById("se_bts").value+";\n";
	savestyle += "border-right-style: "+document.getElementById("se_brs").value+";\n";
	savestyle += "border-bottom-style: "+document.getElementById("se_bbs").value+";\n";
	savestyle += "border-left-style: "+document.getElementById("se_bls").value+";\n";
	
	savestyle += "border-top-color: "+document.getElementById("se_btc").value+";\n";
	savestyle += "border-right-color: "+document.getElementById("se_brc").value+";\n";
	savestyle += "border-bottom-color: "+document.getElementById("se_bbc").value+";\n";
	savestyle += "border-left-color: "+document.getElementById("se_blc").value+";\n";
	
	//alert(savestyle);
	paction = "paction=saveelementproperties&styles="+savestyle+"&elname="+sel_element_name+"&mystylefile="+mystylefile;
	//alert("paction="+paction);
	elementproperties_post_ajax(paction);
}
//**********************************
function __getelementproperties_look_bor(){
	$( sel_element_name ).css("border-top-width",  document.getElementById("se_btw").value);
	$( sel_element_name ).css("border-right-width",  document.getElementById("se_brw").value);
	$( sel_element_name ).css("border-bottom-width",  document.getElementById("se_bbw").value);
	$( sel_element_name ).css("border-left-width",  document.getElementById("se_blw").value);
	
	$( sel_element_name ).css("border-top-style",  document.getElementById("se_bts").value);
	$( sel_element_name ).css("border-right-style",  document.getElementById("se_brs").value);
	$( sel_element_name ).css("border-bottom-style",  document.getElementById("se_bbs").value);
	$( sel_element_name ).css("border-left-style",  document.getElementById("se_bls").value);
	
	$( sel_element_name ).css("border-top-color",  document.getElementById("se_btc").value);
	$( sel_element_name ).css("border-right-color",  document.getElementById("se_brc").value);
	$( sel_element_name ).css("border-bottom-color",  document.getElementById("se_bbc").value);
	$( sel_element_name ).css("border-left-color",  document.getElementById("se_blc").value);
}
//**********************************
function __jl_init_uploader(){
	//alert("__jl_init_uploader");
	$(".ui-state-default").click(function() {
		prlnk = cur_el.src.replace("resize=60","resize=260");
		//alert(prlnk);
		document.getElementById("bg_prewiev_image").src = prlnk;
		imgoobj  = document.getElementById("imgbgoff");
		imgoobj.src = root_link+"adminarea/images/green/myitemname_popup/specpred.gif";
		$("#bg_prewiev_image").css("display", "");
		se_show_prev();
	});
	$(".ui-state-default").dblclick(function() {
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
	
	var uploader = new qq.FileUploader({
		// pass the dom node (ex. $(selector)[0] for jQuery users)
		element: $('#file-uploader')[0],
		action: 'upload_ui.php',
		params: {parent: false},
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
//**********************************
function images_get_images(){
	//alert("OK");
	$.ajax({
		type: "POST",
		url: "/adminarea/__ajax.php",
		data: "paction=images_get_images&name=site-img",
		success: function(html) {
			//alert(html);
			$("#myDiv").empty();
			$("#myDiv").append(html+"<div style=\"float:none; clear:both\"></div>");
			__jl_init_uploader();
		}
	});
}
//**********************************
function elementproperties_toggle_bgimgoff(imgoobj){
	if(imgoobj.src == root_link+"adminarea/images/green/myitemname_popup/specpred_no.gif"){
		imgoobj.src = root_link+"adminarea/images/green/myitemname_popup/specpred.gif";
		$("#bg_prewiev_image").css("display", "");
	} else {
		imgoobj.src = root_link+"adminarea/images/green/myitemname_popup/specpred_no.gif";
		$("#bg_prewiev_image").css("display", "none");
	}
}
//**********************************
function elementproperties_post_ajax(paction){
	$.ajax({
		type: "POST",
		url: "/adminarea/__ajax_user_interface.php",
		data: paction,
		success: function(html) {
			//alert(html);
			location.reload();
		}
	});
}
//**********************************
function elementproperties_close_black_bg(){
	$(elobj_a).css("position", "");
	$(elobj_a).css("z-index", "");
	$( elobj_a ).droppable( "destroy" );
	$("#black_bg").css("display", "none");
	$("#se_css_menu").css("display", "none");
}
//**********************************
function se_show_colors(){
	 objcol  = document.getElementById("color_picker");
	 if(objcol.style.display=="none"){
		$("#color_picker").css("display", "");
	} else {
		$("#color_picker").css("display", "none");
	}
}
//**********************************
var mousemove_bg_prev = false;
var crt = 0;
var se_mmove_tout = false;
//**********************************
function se_show_prev(){
	$("#start_ui").css("display", "none");
	$("#black_bg").css("display", "none");
	__getelementproperties_look_bg();
	//mousemove_bg_prev = true;
	clearInterval(se_mmove_tout);
	se_mmove_tout = setTimeout("mousemove_bg_prev = true", 500);
}
//**********************************
function se_show_prev_box(){
	$("#start_ui").css("display", "none");
	$("#black_bg").css("display", "none");
	__getelementproperties_look_box();
	//mousemove_bg_prev = true;
	clearInterval(se_mmove_tout);
	se_mmove_tout = setTimeout("mousemove_bg_prev = true", 500);
}
//**********************************
function se_show_prev_bor(){
	$("#start_ui").css("display", "none");
	$("#black_bg").css("display", "none");
	__getelementproperties_look_bor();
	//mousemove_bg_prev = true;
	clearInterval(se_mmove_tout);
	se_mmove_tout = setTimeout("mousemove_bg_prev = true", 500);
}
//**********************************
function se_show_prev_pos(){
	$("#start_ui").css("display", "none");
	$("#black_bg").css("display", "none");
	//alert("sel_element_name="+sel_element_name);
	__getelementproperties_look_pos();
	clearInterval(se_mmove_tout);
	se_mmove_tout = setTimeout("mousemove_bg_prev = true", 500);
}
//**********************************
function se_hide_menu_css(){
	sel_element_control = false;
	$("#se_toggle_button").removeClass("se_toggle_button_active");
	$("#se_toggle_button").removeClass("se_toggle_button_hover");
	$("#se_toggle_button").addClass("se_toggle_button");
	$("#black_bg").css("display", "none");
	$("#se_css_menu").css("display", "none");
	$("#sel_elem_property").css("display", "none");
	$("#start_ui").css("z-index", "500");
	$(elobj_a).css("position", "");
	$(elobj_a).css("z-index", "");
	sel_element_control = false;
	sel_element_name = "";
}
//**********************************
//setTimeout("se_init_mcontrols()", 3000);
setTimeout("se_init_mcontrols()", 500);
//**********************************
//**********************************
function get_constructor_start(){
	paction = "paction=get_constructor_start&elname="+elname_a;
	alert(paction);
	$.ajax({
		type: "POST",
		url: "/adminarea/__ajax_user_interface_constructor.php",
		data: paction,
		success: function(html) {
			alert(html);
			
		}
	});
}


function auiGetBlockFromKeys22(blockKeys, tmpl){
	//alert("auiGetBlockFromKeys()");
	var count=0;
	var rv = "";
	//alert(allInterfaceTemplate);
	for(var j in tmpl){
		if(  blockKeys[0][1].toLowerCase() == tmpl[j]["tagname"].toLowerCase()  &&  blockKeys[0][0] == count  ){
			rv += "["+j+"]"; 
			//alert("a="+JSON.stringify(blockKeys));
			alert("a="+JSON.stringify(blockKeys)+":::"+rv+":::"+j); 
			if(blockKeys[1]){
				blockKeys.splice(0,1);
				//alert(JSON.stringify(blockKeys));
				rv += "[\"childs\"]"+auiGetBlockFromKeys22(blockKeys, tmpl[j]["childs"]);
			}
			//alert("a="+JSON.stringify(blockKeys)+":::"+rv+":::"+j); 
			return rv;
		}
		if(  blockKeys[0][1].toLowerCase() == tmpl[j]["tagname"].toLowerCase()  )	
			count++;
	}
	return "";
}
//blockKeys = {"0":"3","1":"SPAN"};
//tmpl = {}
//auiGetBlockFromKeys22(blockKeys, tmpl)
  </script>
</div>
<div id="div_aui_all_constructor"></div>
<script>
//**********************************
function copy(cObj){
	buffer = "";
	var blockKeys = auiGetBlockKeys(old_cur_sel_element);
	blockKeys = blockKeys.replace(/~$/, "");
	buffer = blockKeys;
}
//**********************************
var copyCTRL=false
var undoCTRL=false;
var redoCTRL=false;
$(document).ready(function(){
	$(document).keydown(function(event){
		//alert(event.which);
		if(event.which==17){
			copyCTRL = true;
			undoCTRL = true;
			redoCTRL = true;
		}
		if(event.which==67 && copyCTRL){
			alert("copy");
			//copy(old_cur_sel_element);
		}
		if(event.which==90 && undoCTRL){
			alert("undo");
		}
		if(event.which==89 && redoCTRL){
			alert("redo");
		}
	});
	//*****************************************************
	$(document).keyup(function(event){
		if(event.which==17){
			copyCTRL =false;
			undoCTRL = false;
			redoCTRL = false;
		}
		if(event.which==67){
			copyCTRL =false;
		}
		if(event.which==90){
			undoCTRL = false;
		}
		if(event.which==89){
			redoCTRL = false;
		}
	});
	//*****************************************************
	$(document).dblclick(function(){
		//alert("ok");
		if(old_cur_sel_element){
			gets = {"ajaxaction":"getStylesCSS", "data":auiRenderPages__props};
			getJSON(gets, "aui_getStyles");
		}
	});
});
</script>