var __jr_activeElement = false;
var __jr_currentElement_old = false;
var __jr_currentElement_tmp = false;
var __jr_selecting_json_node = false;
$(document).ready(function(){
	var rootObject = document.getElementById("rootDiv");
	if(rootObject){
		rootObject.onmousemove = function(em){
			//!!!!!!!!!!!!!!!!!!!!!!!!
			var mmactive = true;
			mmactive = false;
			em = em || event;
			var targetElement = em.target || em.srcElement;
			//document.title = targetElement.tagName;
			if(__jr_currentElement_old!=targetElement && !rootObject.otherFocus && mmactive){
				
				targetElement.onclick = function(){
					if(__jr_activeElement!=this){
						__jr_currentElement_tmp = this;
						if(__jr_activeElement)  $(__jr_activeElement).css("outline", "");
						document.title = __jr_currentElement_old.tagName;
						$(this).css("outline", "solid #FF0000 3px");
						__jr_activeElement = this;
						//rootObject.currentElement = this;
						__jrmm_select_in_json(this);
					}
					return false;
				}
				//*********
				__jr_currentElement_old.onclick = false;
				__jr_currentElement_old = targetElement;
			}
			//__jr_currentElement_tmp
		}
		//**************************************
	}
});
//****************************************************
var __jr_object_key = "";
function __jrmm_select_in_json(mObj){
	//alert(mObj);
	var dKeys = __jrmm_get_dom_keys(mObj);
	//alert(dKeys);
	var correctKeys = __jrmm_superimposition_from_dom_keys(dKeys.replace(/~$/, ''));
	//alert(correctKeys);
	correctKeys = correctKeys.replace(/~$/, '');
	correctKeys = correctKeys.replace(/~childs$/, '');
	//alert(correctKeys);
	document.getElementById("jsonWindowContent").innerHTML = "";
	__ftree_render_branch(jsonObject, "jsonWindowContent", correctKeys);
	var selObj = document.getElementById(correctKeys);
	__jr_selecting_json_node = selObj;
	$(__jr_selecting_json_node).css("background-color", "#FFF000");
	//alert(document.getElementById("jsonWindowContent").scrollTop);
	//alert(document.getElementById("jsonWindowContent").offsetHeight);
	//alert(selObj.offsetTop);
	//alert(selObj.offsetTop   +   "-"   +  document.getElementById("jsonWindowContent").scrollTop  +  "="  +   document.getElementById("jsonWindowContent").offsetHeight );
	if(selObj.offsetTop-document.getElementById("jsonWindowContent").scrollTop >= document.getElementById("jsonWindowContent").offsetHeight){
		var st = selObj.offsetTop - document.getElementById("jsonWindowContent").offsetHeight + selObj.offsetHeight;
		//st = selObj.offsetTop - st;
		//alert(st);
		document.getElementById("jsonWindowContent").scrollTop = st;
	} else {
		//alert("<");
	}
	//alert(JSON.stringify(jsonBox.tabs));
	var count = 0;
	for(var j in jsonBox.tabs){
		if(j!="winBox" && j!="removeTab")  {
			count++;
		}
		
	}
	//alert("count_tabs="+count);
	for(var j=1; j<count; j++)  {
		//alert("remove_tab");
		jsonBox.tabs.removeTab(1);
	}
	__jr_object_key = correctKeys;
	__jrmm_add_htmlObject_tabs(jsonBox);
	//alert(selObj);
}
//****************************************************
function __jrmm_get_dom_keys(mObj, mKeys){
	if(!mKeys)  mKeys = "";
	//alert(mObj.tagName);
	if(mObj.id!="rootDiv") if(mObj.tagName!="tbody" && mObj.tagName!="TBODY") mKeys = $(mObj).index()+"("+mObj.tagName+")~"+mKeys;
	if(mObj.id=="rootDiv") mKeys = "0("+mObj.tagName+")~"+mKeys;
	if(mObj.id!="rootDiv")
		return __jrmm_get_dom_keys(mObj.parentNode, mKeys);
	else
		return mKeys;
}
//****************************************************
function __jrmm_get_json_from_dom_keys(dKeys){
	alert("dKeys="+dKeys);
}
//****************************************************
function __jrmm_superimposition_from_dom_keys(dKeys){
	var mdKeys = explode("~", dKeys);
	var keys = new Array();
	var tags = new Array();
	var correctKeys = "[\"site-template\"]";
	var retKeys = "jsonWindowContent~site-template~";
	for(var j=0; j<mdKeys.length; j++){
		keys[j] = mdKeys[j].replace(/\(.*$/, "");
		tags[j] = mdKeys[j].replace(/^.*\(/, "");
		tags[j] = tags[j].replace(/\)$/, "");
		//tags[j] = mdKeys[j].replace(/^\(/, "");
	}
	//alert(keys+"\n\n"+tags);
	//alert(JSON.stringify(psevdojsonObject));
	for(var j=0; j<keys.length; j++){
		var sjCount = 0;
		//alert("psevdojsonObject"+correctKeys);
		for(  var sj in eval(  "psevdojsonObject"+correctKeys  )  ){
			if(sjCount==keys[j]){
				correctKeys += "[\""+sj+"\"]";
				retKeys += sj+"~";
				//alert(eval("psevdojsonObject"+correctKeys+".pageRequire"));
				if(eval(  "psevdojsonObject"+correctKeys+".pageRequire"  )  )
						return retKeys;
				if(typeof eval(  "psevdojsonObject"+correctKeys+"[\"childs\"]") == "object"){
					
					
					correctKeys += "[\"childs\"]";
					retKeys += "childs~";
				}
				
			}
			sjCount++;
		}
		//alert(correctKeys);
	}
	return retKeys;
}
//****************************************************
var psevdojsonObject = {};
function __jrmm_consruct_psevdo_matrix(matrix){
	var pso = {};
	var wr = false;
	for(var j in matrix){
		wr = false;
		if(matrix[j].pageType){
			var mpt = explode(":", matrix[j].pageType);
			var flink = mpt[0];
			var ftype = mpt[1];
			if(root_request.match(RegExp(flink+"\/?")) && ftype=="folders" && is_folder==1)   wr=true;
			if(root_request.match(RegExp(flink+"\/?")) && ftype=="element" && is_folder==0)   wr=true;
			if(root_request.match(RegExp(flink+"\/?")) &&  (mpt[1]=="*" || mpt[1]==""))   wr=true;
			//alert("wr="+wr);
		} else {
			wr = true;
		}
		//************
		if(wr){
			if(typeof matrix[j] == "object")
				pso[j] = __jrmm_consruct_psevdo_matrix(matrix[j]);
			else
				pso[j] = matrix[j];
		}
	}
	return pso;
}
//****************************************************
function __jrmm_add_htmlObject_tabs(jsonBox){
	//for(var jj in __jrc_create_object_HTML_tabs()) alert("jj object = "+jj);
	//alert(JSON.stringify(__jrc_object_HTML_tabs));
	jsonBox.addTab(__jrc_create_object_HTML_tabs());
}
//****************************************************