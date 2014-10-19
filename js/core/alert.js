function aAlert(message, callback, mtype){
	if(!mtype) mtype = "warning";
	aAlertBgObject = document.getElementById("aAlertBgObject");
	if(!aAlertBgObject) {
		var aAlertBgObject = document.createElement("DIV");
		document.body.appendChild(aAlertBgObject);
	}
		aAlertBgObject.style.display="";
		aAlertBgObject.className = "aAlertBgObject-class";
		aAlertBgObject.id = "aAlertBgObject";
		aAlertBgObject.style.zIndex = getMaxZIndex() + 1;
		aAlertBgObject.innerHTML = "";
		
	aAlertBoxObject = document.getElementById("aAlertBoxObject");
	if(!aAlertBoxObject) {
		var aAlertBoxObject = document.createElement("DIV");
		document.body.appendChild(aAlertBoxObject);
	}
		aAlertBoxObject.style.display="";
		aAlertBoxObject.className = "aAlertBoxObject-"+mtype;
		aAlertBoxObject.id = "aAlertBoxObject";
		aAlertBoxObject.style.zIndex = getMaxZIndex() + 1;
		aAlertBoxObject.style.top = (window.innerHeight / 2 - 250) + "px";
		aAlertBoxObject.style.left = (window.innerWidth / 2 - 180) + "px";
		inner = "<div id=\"aAlertBoxObject-topClose\"></div>";
		inner += "<div id=\"aAlertBoxObject-title\">Внимание!</div>";
		inner += "<div id=\"aAlertBoxObject-content\">"+message+"</div>";
		inner += "<div align=\"center\"><a id=\"aAlertBoxObject-button\" onClick=\"aAlertClose();"+callback+";\">Ok</a></div>";
		aAlertBoxObject.innerHTML = inner;
	//*********************************
	keyUpControls.aAlertBoxObject = {
		13: function (){
			aAlertClose();
			delete keyUpControls["aAlertBoxObject"];
			if(callback) setTimeout(callback, 1);
		}
		//27: function (){	mBox.closeWindow();  }
	}
}
//*********************************************
function aAlertClose(){
	document.getElementById("aAlertBgObject").style.display="none";
	document.getElementById("aAlertBoxObject").style.display="none";
}