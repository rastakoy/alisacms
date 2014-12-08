//require modal.js
function __fb_show_basket(){
	__modal("vpcontainer_cont", {
		"width":"90%",
		"height":"90%",
		"clickableBg":true,
		"effect":"fade",
		"closeButton":true
	});
	//inner = "<div class=\"vipimg\"  id=\"vpcontainer_cont\" ";
	//inner += " style=\"background-color:#EBEBEB;overflow:auto;\" ></div>";
	//document.getElementById("modalObject").innerHTML = inner;
}
function __fb_backToOrder(){
	$("#bascketOrder").css("display","");
	$("#basckerUser").css("display","none");
}