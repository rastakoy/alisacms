function initSelect(objId){
	objects = document.getElementById(objId).innerHTML;
	document.getElementById(objId).innerHTML = "";
	//*********************************
	__selectObject = document.getElementById(objId+"_selectObject");
	if(!__selectObject) {
		var __selectObject = document.createElement("DIV");
		document.getElementById(objId).appendChild(__selectObject);
	}
	__selectObject.style.display="";
	__selectObject.className = "__selectObject-class";
	__selectObject.id = objId+"_selectObject";
	__selectObject.objId = objId;
	//__selectObject.style.zIndex = 200;
	__selectObject.innerHTML = "";
	//*********************************
	__selectObject.__selectObjectInfo = document.getElementById(objId+"_selectObjectInfo");
	if(!__selectObject.__selectObjectInfo) {
		__selectObject.__selectObjectInfo = document.createElement("DIV");
		document.getElementById(objId).appendChild(__selectObject.__selectObjectInfo);
	}
	__selectObject.__selectObjectInfo.className = "__selectObjectInfo-class";
	__selectObject.__selectObjectInfo.id = objId+"_selectObjectInfo";
	__selectObject.__selectObjectInfo.style.zIndex = 200;
	__selectObject.__selectObjectInfo.innerHTML = "asd";
	__selectObject.__selectObjectInfo.open = 0;
	__selectObject.__selectObjectInfo.style.display = "none";
	__selectObject.__selectObjectInfo.innerHTML = objects;
	$(__selectObject.__selectObjectInfo).css("float", "none");
	$(__selectObject.__selectObjectInfo).css("clear", "both");
	
	objects = document.getElementById(objId).getElementsByClassName("selectItem");
	for(var j in objects){
		if(objects[j].mySelected == true){
			//__selectObject.appendChild(objects[j]);
		}
		objects[j].onclick = function(){
			//alert("ok");
			//__selectObject.appendChild(this);
			//alert($(this).index());

			myObj = this;
			sobjs = myObj.getElementsByTagName("a");
			sobjs[0].onclick();
			
			cur = document.getElementById(this.parentNode.id.replace(/Info/, ''));
			cur.selecting($(this).index());
			return false;
		}
	}
	
	__selectObject.onclick = function(){
		this.__selectObjectInfo.style.display="";
	}
	
	__selectObject.selecting = function(val){
		infoObj = document.getElementById(this.id+"Info");
		objects = infoObj.getElementsByClassName("selectItem");
		//alert(val);
		for(var j=0; j<objects.length; j++){
			if(val==j){
				//alert(this.parentNode.id);
				myObj = objects[j];
				inner = myObj.innerHTML;
				//alert (inner);
				inner = inner.replace(/document\.getElementById\('fmiId_[0-9]{1,10}'\)\.onclick\(\)/gi, '');
				inner = inner.replace(/multiitem_change\([0-9]{1,10},this\);/gi, '');
				inner = inner.replace(/fmiId_/gi, 'fmId____');
				//alert (this.id.replace(/Info/, ''));
				document.getElementById(this.id.replace(/Info/, '')).innerHTML = inner;
				myObj.parentNode.style.display="none";
			}
		}
	}
	
}
//******************************************