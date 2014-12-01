var curImageIndex = -1;
var changingNow = false;
function multiitem_change(bId, cbObj, aImgLink){
	//if(!cbObj){
	//	return false;
	//}
	if(!changingNow){
		//alert("multiitem_change");
		changingNow = true;
		paction = "ajax=getmultiiteminfo&pid="+bId;
		document.getElementById("qttyItem_"+reccIndex).value = "";
		document.getElementById("qttyItem_"+reccIndex).id = "qttyItem_"+bId;
		var curId = false;
		if(cbObj){
			var curId = cbObj.id.replace(/^fmiId_/, '');
		}
		curSimgParent = curId;
		//***************************************
		//alert(paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				//return false;
				changingNow = false;
				var object = eval("("+html+")");
				//******************************************************************
				//APriceBlock.restsValue = false;
				//if(object.index){
					//__pb_changeQtty(document.getElementById("qttyItem_"+bId));
					//alert(document.getElementById("qttyItem_"+bId).id);
					__pb_changeQtty(document.getElementById("qttyItem_"+bId), true);
					reccIndex = object.index;
					
					
				//}
				//APriceBlock = construct_price_block({"id":"myItemPriceBlock"});
				//***********************************
				//var basketValue = 1;
				//var basket = object.basket;
				//***********************************
				//if(object.rests <= 0 || basket.ret=="false"){
				//	//APriceBlock.hideBasket();
				//} else {
				//	//APriceBlock.showBasket();
				//}
				//***********************************
				//if(basket.ret=="true"){
				//	basketValue = basket.count;
				//	orderKey = basket.orderKey;
				//	orderIndex = basket.orderId;
				//	//APriceBlock.inbasket = true;
				//	//APriceBlock.basket.firstChild.style.backgroundImage = "url(/images/basket_full.gif)";
				//	//APriceBlock.basketButton.innerText = "В корзине";
				//	//APriceBlock.basketButton.href = "javascript:document.getElementById('hmkatalog2').mmOpenClick=true;document.getElementById('hmkatalog2').show_menu()";
				//} else {
				//	if(basket.ret=="nobasket"){
				//		//APriceBlock.inbasket = false;
				//		//APriceBlock.basket.firstChild.style.backgroundImage = "url(/images/basket_empty.gif)";
				//		//APriceBlock.basketButton.innerText = "Купить";
				//		//APriceBlock.basketButton.href = "javascript:add_to_r()";
				//	}
				//}
				//***********************************
				//APriceBlock.price.setPrice(object.price);
				//APriceBlock.setRests(object.rests);
				//APriceBlock.quantity.setMaxi(object.rests);
				//APriceBlock.quantity.setValue(basketValue);
				//APriceBlock.quantityUnit.setQuantityUnit(object.ediz);
				//APriceBlock.summ.setSumm();
				//***********************************
				if(  object.dindiscount_count  ){
					//APriceBlock.ddcount = object.dindiscount_count;
					//APriceBlock.ddperc = object.dindiscount_perc;
				}
				//***********************************
				//if(document.getElementById("item_rests"))     { document.getElementById("item_rests").innerHTML = object.rests;  }
				//if(reccRests<=0 && object.rests >= 1){
				//	reccRests = object.rests;
				//	var din = "<span id=\"item_kolvo_parent\"><input type=\"text\" class=\"item_kolvo\" value=\"1\" id=\"my_item_kolvo\" /></span>";
				//	din += object.ediz+"<br/><b>Итого:</b> <span id=\"item_summ\">"+(object.price*1)+"</span> грн.<br/><br/>";
				//	din += "	<span id=\"basket_icon\"></span><a id=\"basket_button\" href=\"javascript:add_to_r()\" ";
				//	din += "class=\"item_bye_butt\">Купить</a><div style=\"float:none; clear:both; height:5px;\"></div>";
				//	document.getElementById("myItemPriceBlock").innerHTML += din;
				//	init_inputDigitWithButtons("item_kolvo", reccRests); is_inrec(reccIndex); 
				//	__mii_computer_summ("item_summ", "my_item_kolvo", myPriceDigit, document.getElementById("item_rests"));
				//} else {
				//	if(document.getElementById("item_kolvo_parent")  &&  object.rests <= 0  ){
				//		var mm = explode("<span id=\"item_kolvo_parent\">", document.getElementById("myItemPriceBlock").innerHTML);
				//		document.getElementById("myItemPriceBlock").innerHTML = mm[0];
				//		reccRests = 0;
				//		document.getElementById("item_rests").innerHTML = reccRests;
				//	}
				//}
				//reccRests = object.rests;
				//******************************************************************
				var objs = document.getElementsByClassName("item_kolvo");
				var obj = false;
				for(var j=0; j<objs.length; j++){
					//obj = objs[j];
					//obj.value = "1";
					//document.getElementById("basket_icon").style.backgroundImage = "url(/images/basket_empty.gif)";
					//document.getElementById("basket_button").innerText = "Купить";
					//document.getElementById("basket_button").onclick = function(){
					//	add_to_r();
					//	return false;
					//}
				}
				//******************************************************************
				//if(object.price){
				//	document.getElementById("sPriceDigit").innerHTML = "";
				//	if(object.discount)
				//		document.getElementById("sPriceDigit").innerHTML = "<span class=\"sp_items_price\" style=\"text-decoration:line-through;color: #333333;font-weight: normal;\">"+object.discount+" грн.</span><br/>";
				//	document.getElementById("sPriceDigit").innerHTML += object.price+" грн.";
				//	myPriceDigit = object.price;
				//	__mii_computer_summ("item_summ", "my_item_kolvo", myPriceDigit, document.getElementById("item_rests"));
				//}
				//******************************************************************
				if(cbObj){
							if(object.images[0]){
								//alert("Есть картинки");
								//document.getElementById("itemgimg").src = "/loadimages/"+object.images[0]["lnk"];
								//var iObjs = document.getElementsByClassName("div_itemimg");
								//for(var j=iObjs.length-1; j>0; j--)
								//	iObjs[j].parentNode.removeChild(iObjs[j]);
								document.getElementById("subImagesContainer").innerHTML = "";
								var imgPrev = true;
								subImagesContainerStepMax = 0;
								for(var j in object.images) {  
									nI = document.createElement("img");
									document.getElementById("subImagesContainer").appendChild(nI);
									$(nI).css("cursor", "pointer");
									$(nI).css("width", "48px");
									$(nI).css("height", "80px");
									if(object.images[j]["parent"]==curId && imgPrev && !aImgLink){
										//alert(object.images[j]["lnk"].replace(/48x80\//, ''));
										msrc = object.images[j]["lnk"].replace(/48x80\//, '');
										document.getElementById("itemgimg").src = "/loadimages/"+msrc;
										imgPrev = false;
										curImageIndex = j;
										$(nI).css("border", "1px solid #A30001");
									}
									if(object.images[j]["parent"]==curId && imgPrev && aImgLink){
										//alert(aImgLink);
										msrc = object.images[j]["lnk"].replace(/48x80\//, '');
										if(msrc==aImgLink){
											document.getElementById("itemgimg").src = "/loadimages/"+msrc;
											imgPrev = false;
											curImageIndex = j;
											$(nI).css("border", "1px solid #A30001");
										}
									}
									nI.className = "item_image_small";
									nI.imgpar = object.images[j]["parent"];
									nI.src = "/loadimages/"+object.images[j]["lnk"];
									nI.onclick = function(){
										revolve_image(this);
									}
									
									//document.getElementById("subImagesContainer").innerHTML += "<img imgpar=\"test\" src=\"/loadimages/"+object.images[j]["lnk"]+"\" class=\"item_image_small\"  style=\"cursor:pointer; width:48px; height: 80px; "+border+" \" onClick=\"revolve_image(this)\"   />";
									
									subImagesContainerStepMax++;
									//nI.innerHTML = "<img src=\"/loadimages/"+object.images[j]["lnk"]+"\" class=\"item_image_small\"  style=\"cursor:pointer; width:48px; height: 80px; \" onClick=\"revolve_image(this)\"   />";
									//nI.className = "div_itemimg";
									//iObjs[0].parentNode.appendChild(nI);
									//document.getElementById("subImagesContainer").appendChild(nI);
								}
								subImagesContainerStepMax -= 5;
								//alert(subImagesContainerStepMax);
								//alert(subImagesContainerStep+"::"+curImageIndex);
								
								if(subImagesContainerStep > -curImageIndex){
									moveSubImages('right', curImageIndex);
								}else{
									moveSubImages('left', curImageIndex);
								}
								document.getElementById("subImagesContainer").style.width = (j*50+100)+"px";
							} else {
								var iObjs = document.getElementsByClassName("div_itemimg");
								for(var j=iObjs.length-1; j>0; j--)
									iObjs[j].parentNode.removeChild(iObjs[j]);
								document.getElementById("itemgimg").src = "/images/no_photo.jpg";
							}
							//******************************************************************
							$(cbObj).css("font-weight","bold");
							objs = document.getElementById("multiitem_block").getElementsByTagName("a");
							var mIndex=0;
							for(var j=0; j<objs.length; j++){
								$(objs[j].firstChild).css("border","none");
								if(objs[j] != cbObj)
									$(objs[j]).css("font-weight","normal");
								else
									mIndex = objs[j].className=="amultiitemimage"?j:j-1;
							}
							//alert(cbObj.className);
							for(var j=0; j<objs.length; j++){
								if(j==mIndex && objs[j].className=="amultiitemimage"){
									$(objs[mIndex].firstChild).css("border","1px solid #FF46FF");
									$(objs[mIndex+1]).css("font-weight","bold");
									//alert(mIndex+"::"+j);
									if(mIndex>0) {
										mIndex=j/2-1;
									}
									//else{
									//	mIndex=j/2;
									//}
									//alert(mIndex+"::"+j);
									document.getElementById("multiitem_block_selectObject").selecting(mIndex);
								}
							}
			}
				//for(var j=0; j<objs.length; j++){
				//	if(j==mIndex && objs[j].className!="amultiitemimage"){
						//if(objs[mIndex+2])
						//	if(objs[mIndex+2].firstChild) 
						//		$(objs[mIndex+2].firstChild).css("font-weight","bold");
						//alert(mIndex);
				//	}
				//}
				//******************************************************************
				
				//******************************************************************
				//is_inrec(reccIndex);
				//******************************************************************
				//alert(JSON.stringify(object));
				/**/
			}
		});
	}
}
//******************************************************************
var curSimgParent = false;
function revolve_image(rObj){
	var obj = document.getElementById("itemgimg");
	$(".item_image_small").css("border","1px solid #CCCCCC");
	obj.src = rObj.src.replace(/48x80\//, "");
	$(rObj).css("border","1px solid #A30001");
	//alert(rObj.imgpar);
	testSrc = rObj.src.replace(/^.*\//, '');
	//alert(testSrc);
	if(curSimgParent!=rObj.imgpar && curSimgParent){
		//alert(curSimgParent);
		//reccIndex = rObj.imgpar;
		multiitem_change(rObj.imgpar,document.getElementById('fmiId_'+rObj.imgpar), testSrc);
		//document.getElementById('fmiId_'+rObj.imgpar).onclick();
	}
}
//******************************************************************
function __mii_computer_summ(objInner, objCount, price, objRests){
	objInner = document.getElementById(objInner);
	objCount = document.getElementById(objCount);
	if(objInner && objRests){
		objInner.innerHTML = myRound(price * objCount.value, 2);
		if(objRests){
			//alert(reccRests);
			objRests.innerHTML = reccRests*1 - objCount.value;
		}
	}
}
//******************************************************************