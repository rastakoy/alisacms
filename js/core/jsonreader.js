//********************************************
function __jr_addsublevel(obj){
	alert(obj);
}
//********************************************
function __jr_start_JSON_Reader(){
	
}
//********************************************
function __jr_tree_set_node_value(keyss, jkey, jval, action){
	var keys = explode("~", keyss);
	var myId = keyss.replace(/~.*$/gi, "");
	var oldKey = keyss.replace(/^.*~/gi, "");
	var nkeys = keyss.replace(RegExp("(~?"+oldKey+"$|~?"+jkey+"$|^"+myId+"~?)", "gi"), "");
	var nkeys_v = "";
	if(nkeys!="") nkeys_v = "[\""+nkeys.replace(/~/gi, "\"][\"")+"\"]";
	var shellopen = "";
	//alert("keyss="+keyss+" :: "+"jkey="+jkey+" :: "+"jval="+jval+" :: "+"nkeys="+nkeys+" :: "+"myId="+myId+" :: "+"oldKey="+oldKey+" :: "+"nkeys_v="+nkeys_v+" :: ");
	
	//alert("jsonObject"+nkeys_v+"[\""+jkey+"\"]");
	
	//alert(typeof test);
	
	//**************************************
	if(  action=="addLevelValue"  ){
		//alert("addLevelValue");
		//alert("jsonObject"+nkeys_v+"[\""+oldKey+"\"] = \""+jval+"\"");
		eval("jsonObject"+nkeys_v+"[\""+oldKey+"\"] = \""+jval+"\"");
		document.getElementById(myId).innerHTML = "";
		shellopen = myId+"~"+nkeys;
		__ftree_render_branch(jsonObject, myId, shellopen);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: "ajax=jsonAddLevelValue&keys="+keyss+"&newVal="+jval,
			success: function(html) {
				//alert(html);
			}
		});
	}
	//**************************************
	if(  action=="addSubLevel"  ){
		//alert("SUB add");
		//alert("jsonObject"+nkeys_v+"={\""+jkey+"\": \"\"}");
		eval("jsonObject"+nkeys_v+"={\""+jkey+"\": \"\"}");
		document.getElementById(myId).innerHTML = "";
		//alert(keyss);
		shellopen = myId+"~"+nkeys;
		//alert("shellopen="+shellopen);
		__ftree_render_branch(jsonObject, myId, shellopen);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: "ajax=jsonAddSubLevel&keys="+keyss+"&newKey="+jkey,
			success: function(html) {
				//alert(html);
			}
		});
	}
	//**************************************
	if(  action=="addkey"  ){
		var test = eval("jsonObject"+nkeys_v+"[\""+jkey+"\"]");
		shellopen = myId+"~"+nkeys;
		if(  test || test==""  ){
			aAlert("Данный ключ для этой ветви уже существует!<br/>Введите иной ключ.");
			return false;
			//document.getElementById(myId).innerHTML="";
			//__ftree_render_branch(jsonObject, myId, shellopen);
		}
		//alert("jsonObject"+nkeys_v+"[\""+jkey+"\"] = \"\"");
		eval("jsonObject"+nkeys_v+"[\""+jkey+"\"] = \"\"");
		document.getElementById(myId).innerHTML = "";
		//alert(keyss);
		__ftree_render_branch(jsonObject, myId, shellopen);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: "ajax=jsonAddkey&keys="+keyss,
			success: function(html) {
				//alert(html);
			}
		});
		//jsonObject
		//alert(fObj.parentNode.parentNode.id);
	}
	//**************************************
	if(  action=="editkey"  ){
		var test = eval("jsonObject"+nkeys_v+"[\""+jkey+"\"]");
		shellopen = myId+"~"+nkeys;
		if(  test || test==""  ){
			if(oldKey!=jkey)	
				aAlert("Данный ключ для этой ветви уже существует!<br/>Введите иной ключ.");
			document.getElementById(myId).innerHTML="";
			__ftree_render_branch(jsonObject, myId, shellopen);
		} else {
			var replaceParentObjects = eval("jsonObject"+nkeys_v);
			var insertObj = {};
			for(  var j in replaceParentObjects  ){
				if(  j != oldKey  ) insertObj[j] = replaceParentObjects[j];
				else insertObj[jkey] = replaceParentObjects[j];
			}
			eval("jsonObject"+nkeys_v+"=insertObj");
			document.getElementById(myId).innerHTML="";
			//shellopen = shellopen.replace(RegExp("~"+oldKey+"$", "gi"), )
			__ftree_render_branch(jsonObject, myId, shellopen);
			$.ajax({
				type: "POST",
				url: "__ajax.php",
				data: "ajax=jsonEditKey&keys="+keyss+"&newKey="+jkey,
				success: function(html) {
					//alert(html);
				}
			});
		}
	}
	//if(  action=="edit" && (test || test=="")  ){
	//	alert("test exists")
	//}
	//alert("delete jsonObject"+nkeys+";");
	//alert("jsonObject"+nkeys+" = \""+jval+"\"");
	//eval("jsonObject"+nkeys+" = \""+jval+"\"");
	//alert(JSON.stringify(jsonObject));
	//document.getElementById("jsonWindowContent").innerHTML = "";
	//alert(keyss);
	//var akeys = explode("~", keyss);
	//var shellopen = "";
	//for(var j=0; j<akeys.length; j++){
	//	if( j<akeys.length-1 ) shellopen +=  akeys[j];
	//	if( j<akeys.length-2 ) shellopen += "~";
	//}
	
	//alert("shellopen="+shellopen);
	//document.getElementById("jsonWindowContent").innerHTML = "";
	//__ftree_render_branch(jsonObject, "jsonWindowContent", shellopen);
	//jsonObject
	//alert(fObj.parentNode.parentNode.id);
}
//********************************************
function __jr_delete_items(){
	jsonWindowContent = document.getElementById("jsonWindowContent");
	delObjs = jsonWindowContent.getElementsByClassName("tree-icon-v-active");
	var dels = new Array();
	var count = 0;
	var test = true;
	var delKeys = "";
	for(var j =0; j<delObjs.length; j++){
		test = true;
		for(var jj=0; jj<dels.length; jj++){
			if(delObjs[j].parentNode.id.match(new RegExp(dels[jj], "gi"))){
				test = false;
			}	
		}
		if(test){
			dels[count] = delObjs[j].parentNode.id;
			count++;
		}
	}
	for(var j=dels.length-1; j>-1; j--){
		rObj = document.getElementById(dels[j]);
		tmp = dels[j];
		fElem = tmp.replace(/~.*$/gi, "");
		//alert(fElem);
		tmp = tmp.replace(RegExp("^"+fElem+"~", "gi"), "");
		//alert(tmp);
		tmp = "[\""+tmp.replace(/~/gi, "\"][\"")+"\"]";
		evalCode = "delete(jsonObject"+tmp+")";
		delKeys += dels[j]+"::::::::::";
		//alert(evalCode);
		eval(evalCode);
		//alert(rObj.parentNode.id);
		rObj.parentNode.removeChild(rObj);
	}
	document.getElementById("jsonWindowContent").innerHTML = "";
	__ftree_render_branch(jsonObject, "jsonWindowContent");
	pdata = "ajax=jsonDeleteKeys&";
	pdata += "delKeys="+delKeys;
	$.ajax({
				type: "POST",
				url: "__ajax.php",
				data: pdata,
				success: function(html) {
					//alert(html);
				}
			});
}
//********************************************
function __jr_set_home_node(){
	//alert("ok"); return false;
	jsonWindowContent = document.getElementById("jsonWindowContent");
	objs = jsonWindowContent.getElementsByClassName("tree-icon-v-active");
	var nodes = new Array();
	var count = 0;
	var test = true;
	var homeKeys = "";
	for(var j =0; j<objs.length; j++){
		test = true;
		for(var jj=0; jj<nodes.length; jj++){
			if(objs[j].parentNode.id.match(new RegExp(nodes[jj], "gi"))){
				test = false;
			}	
		}
		if(test){
			nodes[count] = objs[j].parentNode.id;
			count++;
		}
	}
	if(nodes[0]) setCookie("homenode_node", nodes[0], "", "/");
	else setCookie("homenode_node", "", "", "/");
	//alert(getCookie("homenode_node"));
	//alert(homes); return false;
}
//********************************************
var __jr_copy_index = false;
function __jr_copy_node(){
	jsonWindowContent = document.getElementById("jsonWindowContent");
	objs = jsonWindowContent.getElementsByClassName("tree-icon-v-active");
	var nodes = new Array();
	var count = 0;
	var test = true;
	var homeKeys = "";
	for(var j =0; j<objs.length; j++){
		test = true;
		for(var jj=0; jj<nodes.length; jj++){
			if(objs[j].parentNode.id.match(new RegExp(nodes[jj], "gi"))){
				test = false;
			}	
		}
		if(test){
			nodes[count] = objs[j].parentNode.id;
			count++;
		}
	}
	__jr_copy_index = nodes[0];
	alert("Скопировано");
}
//********************************************
function __jr_paste_node(){
	var jci = __jr_copy_index;
	var jpiKey = jci.replace(/^.*~/, '');
	//alert("jpiKey="+jpiKey);
	//alert(__jr_copy_index);
	//var keys = explode("~", __jr_copy_index);
	//var myId = keyss.replace(/~.*$/gi, "");
	//var oldKey = keyss.replace(/^.*~/gi, "");
	//var nkeys = keyss.replace(RegExp("(~?"+oldKey+"$|~?"+jkey+"$|^"+myId+"~?)", "gi"), "");
	//var nkeys_v = "";
	//if(nkeys!="") nkeys_v = "[\""+nkeys.replace(/~/gi, "\"][\"")+"\"]";
	//var shellopen = "";
	//************
	jsonWindowContent = document.getElementById("jsonWindowContent");
	objs = jsonWindowContent.getElementsByClassName("tree-icon-v-active");
	var nodes = new Array();
	var count = 0;
	var test = true;
	var homeKeys = "";
	for(var j =0; j<objs.length; j++){
		test = true;
		for(var jj=0; jj<nodes.length; jj++){
			if(objs[j].parentNode.id.match(new RegExp(nodes[jj], "gi"))){
				test = false;
			}	
		}
		if(test){
			nodes[count] = objs[j].parentNode.id;
			count++;
		}
	}
	jci = jci.replace(/jsonWindowContent~/, '');
	jci = "[\""+jci.replace(/~/gi, "\"][\"")+"\"]";
	var jpi = nodes[0];
	jpi = jpi.replace(/jsonWindowContent~/, '');
	jpi = "[\""+jpi.replace(/~/gi, "\"][\"")+"\"]";
	//alert(  "jsonObject"+jpi+"[\""+jpiKey+"\"] = jsonObject"+jci  );
	var tmp = eval("jsonObject"+jci);
	//alert(tmp);
	if(typeof eval("jsonObject"+jpi) == "object"){
		eval(  "jsonObject"+jpi+"[\""+jpiKey+"\"] = \"\";"  );
	} else {
		eval(  "jsonObject"+jpi+" = {}"  );
		eval(  "jsonObject"+jpi+"[\""+jpiKey+"\"] = tmp;"  );
	}
	
	//alert(eval("jsonObject"+jpi+"[\""+jpiKey+"\"]"));
	//return false;
	//eval(  "jsonObject"+jpi+"[\""+jpiKey+"\"] = jsonObject"+jci  );
	
	//alert(JSON.stringify(jsonObject.dsa))
	document.getElementById("jsonWindowContent").innerHTML = "";
	//alert(nodes[0]+"~"+jpiKey);
	__ftree_render_branch(jsonObject, "jsonWindowContent", nodes[0]);
	pdata = "ajax=jsonCopyKeys";
	pdata += "&from="+__jr_copy_index;
	pdata += "&to="+nodes[0];
	$.ajax({
		type: "POST",
		url: "__ajax.php",
		data: pdata,
		success: function(html) {
			//alert(html);
		}
	});
}
//********************************************
function __jr_prepare_to_jsonData_from_keys(keys){
	var oldKey = keys.replace(/^.*~/gi, "");
	var myId = keys.replace(/~.*$/gi, "");
	var nkeys = keys.replace(RegExp("(~?"+oldKey+"$|^"+myId+"~?)", "gi"), "");
	var nkeys_v = "";
	if(nkeys!="") nkeys_v = "[\""+nkeys.replace(/~/gi, "\"][\"")+"\"]";
	return "jsonObject"+nkeys_v+"[\""+oldKey+"\"]";
}
//********************************************
function __jr_construct_HTML(html){
	return __jrc_construct_HTML__operations;
}
//********************************************
var args = false;
function __jr_construct_Window_pages_tree(){
	//alert(iv);
	args = {"cbFunc":"auiAddBlock","onlyRecords":"1"}
	jsonBoxPages = __win_openWindow(jsonWindowAdminFolders);
	jsonBoxPages.setTitle("Выберите блок для вставки");
	document.getElementById("jsonWindowAdminFoldersContent").innerHTML = "<ul id=\"dauisp_constructor_blocks\" class=\"aui_tree_ul\"></ul>";
	auiSelectPageFromAllPages('constructor/blocks', args);
	$( "#jsonWindowAdminFolders" ).draggable({ 
				handle: ".__winBoxObject-move" ,
				start: function( event, ui ) {
					//alert("start");
				},
				stop: function( event, ui ) {
					m = __positions_getAbsolutePos(this);
					setCookie("panel_jsonWindowContent_x", m.x, "", "/");
					setCookie("panel_jsonWindowContent_y", m.y, "", "/");
				}
			});
}
//********************************************
var jsonBoxPages = false;
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
			//alert(JSON.stringify(args));
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
function auiSelectPageFromAllPages__constructor(idPref, props, args, needLink){
	//alert(args.cbFunc);
	if(!needLink) var needLink = "";
	//alert("needLink="+needLink);
	//alert(JSON.stringify(props));
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
				//if(  $("#aui_SelectAllPages div.aui_control_block_title")[0].innerHTML.match(/редактирование/)  )   iv += ", '"+auiSitePagesEditIndex+"'  ";
				iv += ")\"  ";
				if(props[j]["class"]=="active")  {iv += " class=\"active\" "; }
				//alert("props[j][\"name\"]="+props[j]["name"]);
				iv += " >"+props[j]["name"]+"</a><ul id=\""+idPref+"_"+props[j]["id"]+"\">";
					if(props[j]["children_data"])  {
						iv +=   auiSelectPageFromAllPages__constructor(idPref, props[j]["children_data"], args, replacer);
					}
				iv += "</ul></li>";
			}
	return iv;
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
function auiAddBlock( apLink, apName, apIndex ){
	//alert( apLink+":"+apName+":"+apIndex );
	//alert(__jr_activeElement);
	var dKeys = __jrmm_get_dom_keys(__jr_activeElement);	
	var correctKeys = __jrmm_superimposition_from_dom_keys(dKeys.replace(/~$/, ''));
	correctKeys = correctKeys.replace(/~$/, '');
	correctKeys = correctKeys.replace(/~childs$/, '');
	var mkeys = correctKeys+"~childs";
	mkeys = mkeys.replace(/^jsonWindowContent~/, '');
	
	//var blockKeys = auiGetBlockKeys(old_cur_sel_element);
	
	//blockKeys = blockKeys.replace(/~$/, "");
	gets = {"ajaxaction":"addPageBlock", "block":apLink, "blockKeys":mkeys};
	//alert("gets="+JSON.stringify(gets));
	//getJSON(gets, "stringify");
	 //auiPanelShowPreview("aui_SelectAllPages");
	 
	 var pdata = "ajax=addPageBlock&block="+apLink+"&blockKeys="+mkeys;
	 $.ajax({
		type: "POST",
		scriptCharset: "UTF-8",
		url: "/__ajax.php",
		data: pdata,
		success: function(html) {
			//alert(html);
			window.location.href = "__publish.php";
		}
	});
	 
}













