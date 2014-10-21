$(document).ready(function(){
	//alert("modal init");
	//__modal("modalObject", {
	//	"width":500,
	//	"height":300,
	//	"clickableBg":true
	//});
})

function __modal(modalId, attrs){
	if(typeof attrs != "object"){
		var attrs = {};
	}
	if(!attrs.width) attrs.width = 400;
	if(!attrs.height) attrs.height = 200;
	if(!attrs.clickableBg) attrs.clickableBg = true;
	//***************************************
	__modalObjectBg = document.getElementById("bg_"+modalId);
	//var mzIndex = getMaxZIndex();
	mzIndex=1000;
	if(!mzIndex) mzIndex=1000;
	//alert(mzIndex);
	if(!__modalObjectBg) {
		var __modalObjectBg = document.createElement("DIV");
		document.body.appendChild(__modalObjectBg);
	}
	__modalObjectBg.id = "bg_"+modalId;
	__modalObjectBg.className = "__modal_background";
	if(attrs.effect=="fade"){
		$(__modalObjectBg).fadeIn(500);
	}else{
		__modalObjectBg.style.display = "";
	}
	__modalObjectBg.style.zIndex = mzIndex*1;
	if(attrs.clickableBg){
		__modalObjectBg.style.cursor = "pointer";
	}
	__modalObjectBg.onclick = function(){
		document.getElementById(this.id.replace(/^bg_/, "")).close();
		//document.getElementById("close_"+(this.id.replace(/^bg_/, ""))).close();
	}
	mzIndex = mzIndex*1+1;
	//***************************************
	__modalObject = document.getElementById(modalId);
	if(!__modalObject) {
		var __modalObject = document.createElement("DIV");
		document.body.appendChild(__modalObject);
	}
	__modalObject.id = modalId;
	__modalObject.className = "__modal_window";
	if(attrs.effect=="fade"){
		$(__modalObject).fadeIn(500);
		__modalObject.effect = attrs.effect;
	}else{
		__modalObject.style.display = "";
	}
	__modalObject.style.zIndex = mzIndex*1;
	mzIndex++;
	//***************************************
	if(attrs.width.match(/\%/)){
		 attrs.width = window.innerWidth/100*attrs.width.replace(/%/, "");
	}
	if(attrs.height.match(/\%/)){
		 attrs.height = window.innerHeight/100*attrs.height.replace(/%/, "");
	}
	__modalObject.style.left = (  window.innerWidth/2 - attrs.width/2  )+"px";
	__modalObject.style.top = (  window.innerHeight/2 - attrs.height/2  )+"px";
	__modalObject.style.width = attrs.width + "px";
	__modalObject.style.height = attrs.height + "px";
	//***************************************
	__modalObject.close = function(){
		document.body.style.overflow = "";
		//alert(this.effect);
		if(this.effect=="fade"){
			$("#bg_"+this.id).fadeOut(500);
			$(this).fadeOut(500);
			//alert("asd");
		}else{
			this.style.display = "none";
			document.getElementById("bg_"+this.id).style.display = "none";
		}
		//document.getElementById("close_"+this.id).style.display = "none";
	};
	//***************************************
	document.body.style.overflow = "hidden";
	//alert(document.body.style.overflow);
	//document.body.style
	//***************************************
	//__modalObjectClose = document.getElementById("close_"+modalId);
	//if(!__modalObjectClose) {
	//	var __modalObjectClose = document.createElement("DIV");
	//	document.body.appendChild(__modalObjectClose);
	//}
	//__modalObjectClose.id = "close_"+modalId;
	//__modalObjectClose.className = "__modal_window";
	//__modalObjectClose.style.display = "";
	//__modalObjectClose.style.zIndex = mzIndex*1;
	//mzIndex++;
	//***************************************
	//__modalObjectClose.onclick = function(){
	//	this.style.display = "none";
	//	document.getElementById(this.id.replace(/^close_/, "")).close();
	//	document.getElementById("bg_"+(this.id.replace(/^close_/, ""))).close();
	//};
	//***************************************
}