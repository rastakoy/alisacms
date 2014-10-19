//*********************************
function cascading_menu(cMenu){
	myMenu = document.getElementById(cMenu);
	//alert(myMenu.id);
	cascading_prepare_level(myMenu);
}
//*********************************
function cascading_prepare_level(mObj){
	if(!mObj) return false;
	var objs = mObj.children;
	//alert(objs.length);
	//alert(objs);
	for(var j=0; j<objs.length; j++){
		var obj = objs[j];
		obj.onmouseover = function(){
			cascading_menu_show_sublevel(this);
		}
		obj.onmouseout = function(){
			cascading_menu_hide_sublevel(this);
		}
	}
}
//*********************************
function cascading_menu_show_sublevel(mObj){
	
	var pos = __positions_getAbsolutePos(mObj)
	var objs = mObj.children;
	var obj = objs[objs.length-1];
	if(obj.children.length > 0){
		obj.style.display = "";
		obj.style.position = "absolute";
		obj.style.left = pos.x+240;
		obj.style.width = "280px"
		obj.style.zIndex = 1000;
		cascading_prepare_level(obj);
	}
	//for(var j in obj.style) if(obj.style[j]) alert(j+"="+obj.style[j]);
	//alert(mObj.style.paddingLeft);
}
//*********************************
function cascading_menu_hide_sublevel(mObj){
	var objs = mObj.children;
	var obj = objs[objs.length-1];
	obj.style.display = "none";
}
//*********************************

//*********************************

//*********************************