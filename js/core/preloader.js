function __preloader_open(wpInit){
	for(tj in wpInit.target){
		//alert(tj);
		var __wpObject = document.getElementById(tj+"_aPreloader");
		if(!__wpObject) {
			var __wpObject = document.createElement("DIV");
			document.body.appendChild(__wpObject);
		}
		__wpObject.id=tj+"_aPreloader";
		__wpObject.className="__aPreloader-class";
		__wpObject.style.display="";
		__wpObject.style.zIndex = getMaxZIndex() + 1;
		//alert(JSON.stringify(wpInit.target));
		var tObj = document.getElementById(tj);
		pos = __positions_getAbsolutePos(tObj);
		//alert(pos.x+" * "+pos.y);
		__wpObject.style.left=pos.x;
		__wpObject.style.top=pos.y;
		__wpObject.style.width=tObj.offsetWidth;
		__wpObject.style.height=tObj.offsetHeight;
	}
}
//*******************************************************
function __preloader_closeAllPreloaders(){
	var objs=document.getElementsByClassName("__aPreloader-class");
	for(i=0; i<objs.length; i++){
		objs[i].parentNode.removeChild(objs[i]);
	}
}
//*******************************************************
