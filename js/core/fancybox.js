function __fb_init(){
	//alert("ok");
	$("#itemgimg").click(function() {
					//alert(this.src);
					//if(cur_el.parentNode.parentNode.parentNode.id  ==  "file-uploader"){
					//	//alert(cur_el.parentNode.parentNode.parentNode.id);
					//}

						var index=false;
						var qwer = new Array();
						objsa = document.getElementById("div_fancybox");
						objs = objsa.getElementsByTagName("IMG");
						for(var i=0; i<objs.length; i++){
							if(objs[i].src == this.src){
								index=i;
							}
							qwer[i] = objs[i].src.replace("400x300/","");
							qwer[i] = qwer[i].replace("132x99/","");
						}
						//alert(cur_el.src);
						
							$.fancybox(
									qwer, 
									{
									'padding'			: 0,
									'index'				: index,
									'transitionIn'		: 'elastic',
									'transitionOut'		: 'elastic',
									'easingIn'      		: 'easeOutBack',
									'easingOut'     	: 'easeInBack',
									'type'           	    : 'image',
									'changeFade' 		: 0
							});
						
				
	});
	$(".itemsimg__").click(function() {
		//alert(this.src);
		var nsrc = this.src;
		$.fancybox(
		nsrc, 
			{
			'padding'			: 0,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'              : 'image',
			'changeFade'        : 0
		});
	});
	//$(".item_image_small").click(function() {
	//	//alert(this.src);
	//	lnk = this.src.replace("95x135/","");
	//	ch_lnk = document.getElementById("itemgimg").src;
	//	document.getElementById("itemgimg").src = lnk;
	//	$(this).css("width", "95px");
	//	$(this).css("height", "135px");
	//	this.src = ch_lnk.replace("300x428/","");
	//});
}
//******************************
$(document).ready(function() {

});
/***************************************/
function show_table_size(ts){
	//torec="undefined";
	$.fancybox( {href : "tablica.php?ts="+ts, title : "",  titlePosition : 'inside',  type : "iframe", width: "95%", height : "95%", onClosed	:																								function() {
            //basket_reload();
		} } );
}
/***************************************/
function show_order_info(os){
	//torec="undefined";
	$.fancybox( {href : "orders.php?order="+os, title : "",  titlePosition : 'inside',  type : "iframe", width: "95%", height : "95%", onClosed	:																								function() {
            //basket_reload();
		} } );
}