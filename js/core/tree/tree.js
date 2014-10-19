//********************************************

//********************************************
var focObj = false;
var focObjEdKey = false;
var focObjEdVal = false;
var focObjAddVal = false;
function __ftree_render_branch(obj, id, shellopen, level, lefts){
	if(!document.getElementById(id)) return false;
	//if(!lefts && shellopen) alert(shellopen);
	if(!lefts) var lefts = "";
	if(!lefts && !shellopen && getCookie("homenode_node")!=""  )
		shellopen = getCookie("homenode_node");
	//alert(JSON.stringify(obj));
	//alert(level+"::"+id);
	if(shellopen) {
		//so1 = shellopen.replace(/~.*$/, "");
		//var curOpen = shellopen.replace(/~.*$/, "");
		//alert(curOpen);
		//alert("BEFORE:\n"+shellopen);
		replArr = explode("~", shellopen);
		//alert(replArr);
		shellopen = "";
		for(var j=0; j<replArr.length; j++){
			if(j>1 ) shellopen += "~";
			if(j>0) shellopen +=  replArr[j];
		}
		//shellopen = shellopen.replace(RegExp(shellopen.replace(/~.*$/, "")+"~","gi"), "");
		//alert("AFTER:\n"+shellopen);
	}
	if(!level) var level = id+"~";
	var ret="";
	if(shellopen){
		//alert("shellopen="+shellopen);
		var thisOpen = shellopen.replace(/~.*$/, "");
		var nov = explode("~", shellopen);
		var nextOpen = nov[1];
		var curOpen = nov[0];
		//alert(thisOpen+":::"+nextOpen+":::"+id+":::"+shellopen);
	}
	for(var j in obj){
		ret += "<div class=\"treeDef\" id=\""+level+j+"\" >";
		if(lefts){
			lefts = lefts.replace(/^~/gi, "");
			var lArr = explode("~", lefts)
			//alert(lArr);
			for(var jj=0; jj<lArr.length; jj++){
				ret += "<span class=\"tree-icon-"+lArr[jj]+"\"></span>";
			}
		}
		if(typeof obj[j] == "object"){
			//alert(curOpen+"::"+j);
			if(curOpen && curOpen==j){
				ret += "<span class=\"tree-icon-minus\"></span>";
			} else {
				ret += "<span class=\"tree-icon-plus\"></span>";
			}
		} else {
			ret += "<span class=\"tree-icon-l-\"></span>";
		}
		//if(lefts){
		//	
		//	alert(document.getElementById(id).getElementsBy.id);
		//}
		ret += "<span class=\"tree-icon-v\"></span>";
		ret += " <span class=\"tree-content\">"+j+"</span>";
		if(typeof obj[j] == "string")  ret += " : <span class=\"tree-value\">"+obj[j]+"</span>";
		if(obj[j] == "")  ret += "<a href=\"#\" class=\"addSubLevel\">Добавить подуровень</a> или <a href=\"#\" class=\"addLevelValue\">добавить значение</a>";
		ret += "<span style=\"float:none;clear:both;display:block\"></span>";
		ret += "</div>";
	}
	ret += "<div class=\"treeDef\">";
	if(lefts){
		lefts = lefts.replace(/^~/gi, "");
		var lArr = explode("~", lefts)
		//alert(lArr);
		for(var jj=0; jj<lArr.length; jj++){
			ret += "<span class=\"tree-icon-"+lArr[jj]+"\"></span>";
		}
	}
	ret += "<span class=\"tree-icon-L\"></span>";
	ret += " <input type=\"text\" class=\"tree-add\" value=\"Новый блок\"  />";
	ret += "</div>";
	document.getElementById(id).innerHTML = document.getElementById(id).innerHTML+ret;
	document.getElementById(id).valObject = obj;
	//******************************************
	var objs = document.getElementById(id).getElementsByClassName("tree-icon-plus");
	for(var j=0; j<objs.length; j++){
		objs[j].onclick = function(){
			tree_plus_click(this, obj, shellopen, level, lefts);
		}
	}
	//******************************************
	var objs = document.getElementById(id).getElementsByClassName("tree-icon-minus");
	for(var j=0; j<objs.length; j++){
		objs[j].onclick = function(){
			tree_plus_click(this, obj, shellopen, level, lefts);
		}
	}
	//******************************************
	var objs = document.getElementById(id).getElementsByClassName("tree-add");
	for(var j=0; j<objs.length; j++){
		objs[j].onfocus = function(){
			if(focObjEdKey){
				document.body.onclick = false;
				focObjEdKey.parentNode.innerHTML = focObjEdKey.value;
				focObjEdKey = false;
			}
			if(focObj){
				if(focObj.value=="") focObj.value="Новый блок";
				document.body.onclick = false;
				focObj = false;
				this.onfocus();
			} else {
				if(this.value=="Новый блок") this.value="";
				focObj = this;
				document.body.onclick = function(){
					if(document.activeElement!=focObj){
						//alert(focObj.parentNode.parentNode.id);
						if(focObj.value=="") focObj.value="Новый блок";
						else __jr_tree_set_node_value(focObj.parentNode.parentNode.id+"~"+focObj.value, focObj.value, "", "addkey");  //json_add_block(focObj);
						document.body.onclick = false;
						focObj = false;
						//alert(focObj.value);
					}
				}
			}
		}
	}
	//******************************************
	if(shellopen){
		//alert(thisOpen+":::"+nextOpen);
		__ftree_render_branch(obj[thisOpen], level+thisOpen, shellopen, level+thisOpen+"~", lefts+"~I");
	}
	//******************************************
	var objs = document.getElementById(id).getElementsByClassName("tree-content");
	for( var j=0; j<objs.length; j++ ){
		objs[j].onclick = function(){
			if(focObj){
				if(focObj.value=="") focObj.value="Новый блок";
				document.body.onclick = false;
				focObj = false;
				//this.onfocus();
			} else {
				var elTest = this.getElementsByTagName("INPUT");
				if(elTest.length<1){
					var sdds = document.createElement("INPUT");
					sdds.type = "text";
					sdds.className = "tree-add";
					sdds.style.width = (this.offsetWidth+6)+"px";
					sdds.style.padding = "0";
					sdds.style.paddingLeft = "3";
					sdds.style.height = "14px";
					sdds.value = this.innerHTML;
					this.innerHTML = "";
					this.appendChild(sdds);
					
					sdds.onfocus = function(){
						if(focObjEdKey){
							document.body.onclick = false;
							focObjEdKey.parentNode.innerHTML = focObjEdKey.value;
							focObjEdKey = false;
							this.onfocus();
						} else {
							focObjEdKey = this;
							document.body.onclick = function(){
								if(document.activeElement!=focObjEdKey){
									//if(focObjEdKey.value=="") focObjEdKey.value="Новый блок";
									//else json_add_block(focObj);
									document.body.onclick = false;
									var objval = focObjEdKey.parentNode.parentNode.getElementsByClassName("tree-value")[0];
									__jr_tree_set_node_value(focObjEdKey.parentNode.parentNode.id, focObjEdKey.value, "", "editkey");
									//focObjEdKey.parentNode.innerHTML = focObjEdKey.value;
									focObjEdKey = false;
									//alert(focObj.value);
								}
							}
						}
					}
					sdds.focus();
				}
			}
			//this.innerHTML = "<input type=\"text\" class=\"tree-add\" style=\"margin-left:0px;width:"+(this.offsetWidth+6)+"px;\" value=\""+this.innerHTML+"\" />";
			//alert(this.innerHTML);
		}
	}
	//******************************************
	var objs = document.getElementById(id).getElementsByClassName("tree-value");
	for( var j=0; j<objs.length; j++ ){
		objs[j].onclick = function(){
			if(focObj){
				if(focObj.value=="") focObj.value="Новый блок";
				document.body.onclick = false;
				focObj = false;
				//this.onfocus();
			} else {
				var elTest = this.getElementsByTagName("INPUT");
				if(elTest.length<1){
					var sdds = document.createElement("INPUT");
					sdds.type = "text";
					sdds.className = "tree-add";
					sdds.style.width = (this.offsetWidth+6)+"px";
					sdds.style.padding = "0";
					sdds.style.paddingLeft = "3";
					sdds.style.height = "14px";
					sdds.value = this.innerHTML;
					this.innerHTML = "";
					this.appendChild(sdds);
					
					sdds.onfocus = function(){
						if(focObjEdKey){
							document.body.onclick = false;
							focObjEdKey.parentNode.innerHTML = focObjEdKey.value;
							focObjEdKey = false;
							this.onfocus();
						} else {
							focObjEdKey = this;
							document.body.onclick = function(){
								if(document.activeElement!=focObjEdKey){
									//alert("edit val work");
									//if(focObjEdKey.value=="") focObjEdKey.value="Новый блок";
									//else json_add_block(focObj);
									document.body.onclick = false;
									//__jr_tree_set_node_value(focObjEdKey.parentNode.parentNode.id, "", focObjAddVal.value, "addLevelValue");
									__jr_tree_set_node_value(focObjEdKey.parentNode.parentNode.id, "", focObjEdKey.value, "addLevelValue");
									//focObjEdKey.parentNode.innerHTML = focObjEdKey.value;
									focObjEdKey = false;
									
									//alert(focObj.value);
								}
							}
						}
					}
					sdds.focus();
				}
			}
			//this.innerHTML = "<input type=\"text\" class=\"tree-add\" style=\"margin-left:0px;width:"+(this.offsetWidth+6)+"px;\" value=\""+this.innerHTML+"\" />";
			//alert(this.innerHTML);
		}
	}
	//******************************************
	var objs = document.getElementById(id).getElementsByClassName("addSubLevel");
	for( var j=0; j<objs.length; j++ ){
		objs[j].onclick = function(){
			if(  focObjEdKey  ) {
				return false;
			}
			//alert(this.parentNode.id);
			__jr_tree_set_node_value(this.parentNode.id+"~New key", "New key", "", "addSubLevel");
			return false;
		}
	}
	//******************************************
	var objs = document.getElementById(id).getElementsByClassName("addLevelValue");
	for( var j=0; j<objs.length; j++ ){
		objs[j].onclick = function(){
			if(  focObjEdKey  ) {
				return false;
			}
			//alert("add level value");
			var pObj = this.parentNode;
			var newInner = pObj.innerHTML.replace(/<a.*$/gi, "")+"<span style=\"float:none;clear:both;display:block\"></span>";
			pObj.innerHTML = newInner;
			var vstEl = pObj.getElementsByClassName("tree-value")[0];
			vstEl.innerHTML = "<input type=\"text\" class=\"tree-add\" value=\"\" style=\"width:260px;\"  />";
			var inputObj = pObj.getElementsByClassName("tree-add")[0];
			focObjAddVal = inputObj;
			inputObj.onfocus = function(){
				document.body.onclick = function(){
					if(document.activeElement!=focObjAddVal){
						document.body.onclick = false;
						__jr_tree_set_node_value(focObjAddVal.parentNode.parentNode.id, "", focObjAddVal.value, "addLevelValue");
						focObjAddVal = false;
					}
				}
			}
			inputObj.focus();
			return false;
		}
	}
	//******************************************
				var objs = document.getElementById(id).getElementsByTagName("span");
				var objsCtn = {};
				var nCount = 0;
				//******************************
				for( var j=0; j<objs.length; j++ ){
					//alert(objs[j].className);
					if(    objs[j].className == "tree-icon-v"  ||  objs[j].className == "tree-icon-v-active"    ){
						objsCtn[nCount] = objs[j];
						nCount++;
					}
				}
				//******************************
				for( var j in objsCtn ){
					objsCtn[j].onclick = function(){
						//alert("click");
						//if(this.className=="tree-icon-v"){
						//	this.className = "tree-icon-v-active";
						//}
						//*********************************************
						var objs = this.parentNode.getElementsByTagName("span");
						var objsCtn = {};
						var nCount = 0;
						var curClass = this.className;
						for( var j=0; j<objs.length; j++ ){
							if(    objs[j].className == "tree-icon-v"  ||  objs[j].className == "tree-icon-v-active"    ){
								objsCtn[nCount] = objs[j];
								nCount++;
							}
						}
						for( var j in objsCtn ){
							if(curClass=="tree-icon-v"){
								objsCtn[j].className = "tree-icon-v-active";
							}
							if(curClass=="tree-icon-v-active"){
								objsCtn[j].className = "tree-icon-v";
							}
						}
					}
				}
	//******************************************
	
	//******************************************
	//return ret;
}
//********************************************
function tree_plus_click(tpcObj, obj, shellopen, level, lefts){
	//alert(JSON.stringify(obj));
	if(tpcObj.className == "tree-icon-plus"){
		var tmpArr = explode("~", tpcObj.parentNode.id);
		tpcObj.className = "tree-icon-minus";
		var tmpParent = tpcObj.parentNode;
		//alert("level="+level+":::: pid="+tpcObj.parentNode.id);
		__ftree_render_branch(obj[tmpArr[tmpArr.length-1]], tpcObj.parentNode.id, "", tpcObj.parentNode.id+"~", lefts+"~I");
		var aobjs = tmpParent.getElementsByClassName("tree-icon-minus");
		for(var jjao=0; jjao<aobjs.length; jjao++){
			aobjs[jjao].onclick = function(){
				var delObjs = this.parentNode.children;
				//alert(delObjs.length);
				for(var jjdel=0; jjdel<delObjs.length; jjdel++){
					//var m = this.parentNode.getElementsBy
					//alert(delObjs[jjdel].id);
					if(delObjs[jjdel].className=="treeDef"){
						this.parentNode.removeChild(delObjs[jjdel]);
						jjdel--;
					}
				}
				this.className = "tree-icon-plus";
				var saobjs = tmpParent.getElementsByClassName("tree-icon-plus");
				for(var sjjao=0; sjjao<saobjs.length; sjjao++){
					saobjs[sjjao].onclick = function(){
						tree_plus_click(this, obj, shellopen, level, lefts);
					}
				}
			}
		}
	}
	//********************
	if(tpcObj.className == "tree-icon-minus"){
		//aAlert("minus");
		//aAlert(JSON.stringify(obj));
		//alert("a");
		//alert(tpcObj.parentNode.children);
		if(tpcObj.parentNode){
			var delObjs = tpcObj.parentNode.children;
			for(var jjdel=0; jjdel<delObjs.length; jjdel++){
			//	//var m = this.parentNode.getElementsBy
				//alert(delObjs[jjdel].id);
				if(delObjs[jjdel].className=="treeDef"){
					tpcObj.parentNode.removeChild(delObjs[jjdel]);
					jjdel--;
				}
			}
			tpcObj.className = "tree-icon-plus";
			tpcObj.onclick = function(){
				//alert(JSON.stringify(this.parentNode.valObject));
				//alert("click");
				this.className = "tree-icon-minus";
				__ftree_render_branch(this.parentNode.valObject, this.parentNode.id, "", this.parentNode.id+"~", lefts);
			}
		}
		//var delObjs = this.parentNode.children;
		//alert()
	}
	//********************
}
//********************************************
function json_add_block(fObj){
	json_tree_get_node(fObj.parentNode.parentNode.id, fObj.value);
}
//********************************************
function json_tree_get_node(keyss, jkey){
	var keys = explode("~", keyss);
	var nkeys = "";
	for(var j=1; j<keys.length; j++){
		nkeys += "[\""+keys[j]+"\"]";
	}
	//alert("jsonObject"+nkeys+"[\""+jkey+"\"]");
	var test = eval("jsonObject"+nkeys+"[\""+jkey+"\"]");
	if(test || test=="") {
		//alert("Данный ключ для этой ветви уже существует");
		aAlert("Данный ключ для этой ветви уже существует");
		return false;
	}
	eval("jsonObject"+nkeys+"[\""+jkey+"\"] = \"\"");
	document.getElementById("jsonWindowContent").innerHTML = "";
	//alert(keyss);
	__ftree_render_branch(jsonObject, "jsonWindowContent", keyss);
	//jsonObject
	//alert(fObj.parentNode.parentNode.id);
}
//********************************************

//********************************************