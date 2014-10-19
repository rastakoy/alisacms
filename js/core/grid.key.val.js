function __gkv_construct_grid(grid, obj){
	//alert(JSON.stringify(grid));
	//obj.style.padding = "1px";
	//obj.style.backgroundColor = "#999999";
	obj.grid = grid;
	//alert(JSON.stringify(grid));
	obj.innerHTML = "";
	var ret = "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\" bordercolor=\"#000000\">";
	for(var j in grid){
		ret += "<tr>";
		if(typeof grid[j] == "object"){
			ret += "<td width=\"150\" height=\"23\" style=\"padding:2px;\">"+grid[j].name+"</td>";
		} else {
			ret += "<td width=\"150\" height=\"23\" style=\"padding:2px;\">"+grid[j]+"</td>";
		}
		var val = "";
		//alert(__jr_prepare_to_jsonData_from_keys(__jr_object_key));
		if(grid[j].connect){
			vv = __jr_prepare_to_jsonData_from_keys(__jr_object_key+"~"+grid[j].connect);
			myEval = true;
			if(grid[j].connect.match(/^multiType/)){
				prepvv = 	__jr_prepare_to_jsonData_from_keys(__jr_object_key+"~multiType");
				prepvv = eval(prepvv);
				if(!prepvv) myEval=false;
			}
			if(myEval){
				val = eval(vv);	
			}
			if(!val) val = "";
		}
		//alert(__jr_object_key);
		//if(grid[j].type=="string" || !grid[j].type)
			//val +=  	
		ret += "<td class=\"fastedit\">"+val+"</td>";
		ret += "</tr>";
	}
	ret += "</table>";
	//**********************
	obj.onclick = function(em){
		em = em || event;
		var targetElement = em.target || em.srcElement;
		var rootObject = document.getElementById("rootDiv");
		var testInputObject = document.getElementById("__fast_input__input");
		if((targetElement.tagName=="TD" || targetElement.tagName=="td") && targetElement == targetElement.parentNode.lastChild && !testInputObject){
			//alert(targetElement.innerHTML);
			//alert($(targetElement.parentNode).index());
			
			var myInput = document.createElement("input");
			myInput.value = targetElement.innerHTML;
			myInput.oldValue = targetElement.innerHTML;
			targetElement.innerHTML="";
			targetElement.appendChild(myInput);
			
			targetElement.paddingTop="0px";
			myInput.grid = this.grid;
			myInput.parentIndex = $(targetElement.parentNode).index();
			myInput.style.border = "none";
			myInput.style.marginTop = "0px";
			myInput.style.width = "100%";
			myInput.style.paddingLeft = "3px";
			myInput.style.height = "19px";
			myInput.style.backgroundColor = "#F7F7F7";
			myInput.id = "__fast_input__input";
			
			myInput.onfocus = function(){
				
				
			//	__focusbg = document.getElementById("__focusbg");
			//	if(!__focusbg) {
			//		var __focusbg = document.createElement("DIV");
			//		document.body.appendChild(__focusbg);
			//		//**************************************
			//		this.parentNode.style.width = this.parentNode.offsetWidth;
			//		this.parentNode.style.position = "absolute";
			//		//this.parentNode.style.top = this.offsetTop - 9;
			//		this.parentNode.style.zIndex = getMaxZIndex() + 10;
			//		//**************************************
			//		__focusbg.style.zIndex = getMaxZIndex() + 1;
			//		__focusbg.style.position = "fixed";
			//		__focusbg.style.top = "0px";
			//		__focusbg.style.bottom = "0px";
			//		__focusbg.style.left = "0px";
			//		__focusbg.style.right = "0px";
			//		this.focus();
			//		//__focusbg.style.backgroundColor = "#FF0000";
			//	} else {
			//		//this.focus();
			//	}
				
				
				this.currentInput = this;
					document.body.onclick = function(){
						var obj = document.getElementById("__fast_input__input");
						
						if(obj && document.activeElement != obj){
							if(obj.value==obj.oldValue){
								obj.parentNode.innerHTML = obj.value;
								return false;
							} else {
								//alert("Нажатие вне");
								__gkv_value_to_HTML(obj);
								document.body.onclick = false;
								obj.parentNode.innerHTML = obj.value;
								return false;
							}
						}
					}
				
				
								//if(document.activeElement!=focObjEdKey){
									//if(focObjEdKey.value=="") focObjEdKey.value="Новый блок";
									//else json_add_block(focObj);
								//	document.body.onclick = false;
								//	var objval = focObjEdKey.parentNode.parentNode.getElementsByClassName("tree-value")[0];
								//	__jr_tree_set_node_value(focObjEdKey.parentNode.parentNode.id, focObjEdKey.value, "", "editkey");
									//focObjEdKey.parentNode.innerHTML = focObjEdKey.value;
								//	focObjEdKey = false;
									//alert(focObj.value);
								//}
			
			}
			//myInput.onfocus.myObj = myInput;
			myInput.focus();
			
			//myInput.className = "__winBoxObject-contents";
		}
	}
	return ret;
}
//***********************************************************************
function __gkv_value_to_HTML(obj){
	//alert(obj.value+"::"+obj.parentIndex+"::"+obj.grid[obj.parentIndex].connect);
	//alert(__jr_activeElement.id);
	
	connect = obj.grid[obj.parentIndex].connect;
	
	//if(connect=="className")
	//	__jr_activeElement.className = obj.value;
	//	
	//if(connect=="id")
	//	__jr_activeElement.id = obj.value;	
	//
	//if(connect=="content")
	//	__jr_activeElement.InnerText = obj.value;	
	//	
	//if(connect=="content")
	//	__jr_activeElement.InnerText = obj.value;	
	
	var dKeys = __jrmm_get_dom_keys(__jr_activeElement);	
	var correctKeys = __jrmm_superimposition_from_dom_keys(dKeys.replace(/~$/, ''));
	correctKeys = correctKeys.replace(/~$/, '');
	correctKeys = correctKeys.replace(/~childs$/, '');
	
	//alert(correctKeys);
	
	var mkeys = correctKeys+"~"+connect;
	mkeys = mkeys.replace(/^jsonWindowContent~/, '');
	var mpkeys = mkeys;
	mkeys = "[\""+mkeys.replace(/~/gi, "\"][\"")+"\"]";
	//alert(mkeys);
	
	eval("jsonObject"+mkeys+"='"+obj.value+"'");
	
	//alert(mkeys);
	
	document.getElementById("jsonWindowContent").innerHTML = "";
	__ftree_render_branch(jsonObject, "jsonWindowContent", correctKeys);
	$.ajax({
		type: "POST",
		url: "__ajax.php",
		data: "ajax=jsonAddLevelValue&keys="+mpkeys+"&newVal="+obj.value,
		success: function(html) {
			window.location.href = "__publish.php";
			//alert(html);
		}
	});
	
	
	
	
	//alert(__jr_activeElement.id);
}





















