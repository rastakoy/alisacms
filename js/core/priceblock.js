//**********************************
function __pb_changeQtty(obj, aqtty){
	var itemId = obj.id.replace(/^qttyItem_/gi, "");
	if(obj.max < obj.value*1) {
		obj.value = obj.max;
	}
	if(obj.value < 1) {
		obj.value = 1;
	}
	if(aqtty)
		paction = "ajax=changeSborkaQtty&itemId="+itemId;
	else
		paction = "ajax=changeSborkaQtty&qtty="+obj.value+"&itemId="+itemId;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			myobj = eval("("+html+")");
			if(myobj.onStore!="hide" && myobj.onStore!="show"){
				myobj.onStore = myRound(myobj.onStore*1, 2);
				myobj.qtty = myRound(myobj.qtty*1, 2);
				sumQtty = myRound(myobj.onStore + myobj.qtty, 2);
				if(myobj.qtty<myobj.min) {
					myobj.onStore = myobj.onStore*1-(1-myobj.qtty);
					myobj.qtty = 1;
					//alert(myobj.onStore);
				}
			}
			if(myobj.discPrice){
				document.getElementById("itemPrice").innerHTML = myobj.discPrice+" грн.";
			}else{
				document.getElementById("itemPrice").innerHTML = myobj.price+" грн.";
			}
			document.getElementById("itemItogo").innerHTML = myobj.sum;
			//if(document.getElementById("qttyItem_"+myobj.itemId).value==""){
			//	alert("myobj.qtty="+myobj.qtty);
				document.getElementById("qttyItem_"+myobj.itemId).value = myobj.qtty;
			//}
			document.getElementById("qttyItem_"+myobj.itemId).max = myobj.qttyMax;
			if(myobj.onStore!="hide" && myobj.onStore!="show"){
				document.getElementById("onStore").innerHTML = myobj.onStore; //  / 100;
			}else{
				if(myobj.onStore=="show"){
					document.getElementById("onStore").innerHTML = "есть";
					myobj.qttyMax = 1000;
					document.getElementById("basket_icon").style.display = "";
					document.getElementById("basket_button").style.display = "";
					document.getElementById("qttyItem_"+myobj.itemId).style.display = "";
				}else{
					document.getElementById("onStore").innerHTML = "нет";
					document.getElementById("basket_icon").style.display = "none";
					document.getElementById("basket_button").style.display = "none";
					document.getElementById("qttyItem_"+myobj.itemId).style.display = "none";
					document.getElementById("itemItogo").innerHTML = "";
				}
			}
			if(document.getElementById("spanEdiz")){
				document.getElementById("spanEdiz").innerHTML = myobj.ediz;
			}
			if(myobj.id){
				document.getElementById("basket_icon").style.backgroundImage = "url(/images/basket_full.gif)";
				document.getElementById("basket_button").innerHTML = "В корзине";
				document.getElementById("basket_button").href = "javascript:__fb_show_basket()";
			}else{
				document.getElementById("basket_icon").style.backgroundImage = "url(/images/basket_empty.gif)";
				document.getElementById("basket_button").innerHTML = "Купить";
				document.getElementById("basket_button").href = "javascript:add_to_r()";
			}
			//if()
			if(myobj.onStore!="hide" && myobj.onStore!="show"){
				if(sumQtty>myobj.qttyMax*1){
					//alert(myobj.onStore*1+myobj.qtty*1+" :: "+myobj.qttyMax*1)
					document.getElementById("basket_icon").style.display = "none";
					document.getElementById("basket_button").style.display = "none";
					document.getElementById("qttyItem_"+myobj.itemId).style.display = "none";
					document.getElementById("itemItogo").innerHTML = "";
					document.getElementById("onStore").innerHTML = "нет";
				} else {
					document.getElementById("basket_icon").style.display = "";
					document.getElementById("basket_button").style.display = "";
					document.getElementById("qttyItem_"+myobj.itemId).style.display = "";
				}
			}
			if(myobj.step){
				document.getElementById("qttyItem_"+myobj.itemId).step = myobj.step;
				document.getElementById("qttyItem_"+myobj.itemId).min = myobj.step;
			}
			document.getElementById("qttyItem_"+myobj.itemId).max = myobj.qttyMax;
			//if(document.getElementById("hmkatalog2").status=="hide")
			//	getBasket();
		}
	});
}
//**********************************
function construct_price_block(params){
	//alert(JSON.stringify(params));
	var APriceBlock = document.getElementById(params.id);
	//************************************************
	APriceBlock.priceTitle = document.createElement("span");
	APriceBlock.priceTitle.innerHTML = "<b>Цена:</b><br/>\n";
	APriceBlock.appendChild(APriceBlock.priceTitle);
	APriceBlock.priceTitle.setTitle = function(title){
		this.firstChild.innerText = title;
	}
	//************************************************
	APriceBlock.price = document.createElement("span");
	APriceBlock.price.style.marginTop = "0px"; 
	APriceBlock.price.style.marginBottom = "5px";
	APriceBlock.price.className = "filtername";
	APriceBlock.appendChild(APriceBlock.price);
	APriceBlock.price.setPrice = function(price, newPrice, discount){
		var inner = "";
		if(newPrice){
			inner += "<span class=\"sp_items_price\" style=\"text-decoration:line-through;color: #333333;font-weight: normal;\">"+price+" грн.</span><br/>";
			inner += "<span>"+newPrice+" грн.</span>";
		} else {
			inner += price+" грн.";
		}
		this.innerHTML = inner;
	}
	APriceBlock.price.getPrice = function(){
		var ac = this.getElementsByTagName("span");
		if(ac.length>0)
			return this.lastChild.innerHTML.replace(/ грн\.$/, "");
		else
			return this.innerHTML.replace(/ грн\.$/, "");
	}
	//************************************************
	APriceBlock.appendChild(document.createElement("br"));
	APriceBlock.appendChild(document.createElement("b"));
	APriceBlock.lastChild.innerHTML = "На складе: ";
	APriceBlock.appendChild(document.createElement("span"));
	APriceBlock.rests = APriceBlock.lastChild;
	APriceBlock.setRests = function(srests){
		//alert(srests);
		if(!this.restsValue) this.restsValue = srests;
		if(srests > 0) this.rests.innerHTML = srests;
		else
			this.rests.innerHTML = "0";
	}
	APriceBlock.getRests = function(){
		return this.restsValue;
	}
	//************************************************
	APriceBlock.appendChild(document.createElement("span"));
	APriceBlock.lastChild.innerHTML = "<input type=\"text\" value=\"1\" />";
	APriceBlock.quantity = APriceBlock.lastChild.lastChild;
	APriceBlock.quantity.className = "item_kolvo";
	APriceBlock.quantity.id = "my_item_kolvo";
	init_inputDigitWithButtons(APriceBlock.quantity);
	APriceBlock.quantity.setMaxi = function(maxi){
		this.maxi = maxi;
	};
	APriceBlock.quantity.buttonUp.click = function(){
		APriceBlock.setRests(  APriceBlock.getRests()  -  APriceBlock.quantity.value  );
		APriceBlock.summ.setSumm();
		APriceBlock.recount();
	};
	APriceBlock.quantity.buttonDown.click = function(){
		APriceBlock.setRests(  APriceBlock.getRests()  -  APriceBlock.quantity.value  );
		APriceBlock.summ.setSumm();
		APriceBlock.recount();
	};
	APriceBlock.quantity.setValue = function(mval){
		this.value = mval;
		APriceBlock.setRests(APriceBlock.getRests()-mval);
	};
	//************************************************
	APriceBlock.appendChild(document.createElement("span"));
	APriceBlock.quantityUnit = APriceBlock.lastChild;
	APriceBlock.quantityUnit.setQuantityUnit = function(value){
		this.innerHTML = value;
	}
	//************************************************
	APriceBlock.appendChild(document.createElement("br"));
	APriceBlock.appendChild(document.createElement("b"));
	APriceBlock.lastChild.innerHTML = "Итого: ";
	APriceBlock.appendChild(document.createElement("span"));
	APriceBlock.summ = APriceBlock.lastChild;
	APriceBlock.summ.setSumm = function(){
		//alert(APriceBlock.price.getPrice());
		//alert(APriceBlock.ddcount+"::"+APriceBlock.ddperc);
		if(APriceBlock.ddcount){
			if(APriceBlock.ddcount*1 <= APriceBlock.quantity.value*1 ){
				prc = APriceBlock.price.getPrice() - APriceBlock.price.getPrice()*APriceBlock.ddperc/100;
				//prc = prc;
				this.innerHTML = myRound(prc * APriceBlock.quantity.value, 2) + " грн. (-"+APriceBlock.ddperc+"%)";
			} else {
				this.innerHTML = myRound(APriceBlock.price.getPrice() * APriceBlock.quantity.value,  2) + " грн.";
			}
		} else {
			this.innerHTML = (APriceBlock.price.getPrice() * APriceBlock.quantity.value) + " грн.";
		}
	}
	//************************************************
	APriceBlock.appendChild(document.createElement("div"));
	APriceBlock.basket = APriceBlock.lastChild;
	APriceBlock.basket.innerHTML = "<span id=\"basket_icon\"></span><a id=\"basket_button\" href=\"javascript:add_to_r()\" class=\"item_bye_butt\">Купить</a>";
	APriceBlock.basketButton = APriceBlock.basket.lastChild;
	APriceBlock.basket.style.display = "none";
	APriceBlock.quantity.buttonDown.style.display = "none";
	APriceBlock.quantity.buttonUp.style.display = "none";
	APriceBlock.quantity.style.display = "none";
	APriceBlock.quantityUnit.style.display = "none";
	APriceBlock.rests.style.display = "none";
	APriceBlock.hideBasket  = function(){
		this.basket.style.display = "none";
		APriceBlock.quantity.buttonDown.style.display = "none";
		APriceBlock.quantity.buttonUp.style.display = "none";
		APriceBlock.quantity.style.display = "none";
		APriceBlock.quantityUnit.style.display = "none";
		APriceBlock.summ.style.display = "none";
		APriceBlock.rests.style.display = "none";
	}
	APriceBlock.showBasket  = function(){
		this.basket.style.display = "";
		APriceBlock.quantity.buttonDown.style.display = "";
		APriceBlock.quantity.buttonUp.style.display = "";
		APriceBlock.quantity.style.display = "";
		APriceBlock.quantityUnit.style.display = "";
		APriceBlock.summ.style.display = "";
		APriceBlock.rests.style.display = "";
	}
	//************************************************
	APriceBlock.recount = function(){
		var paction = "kol_vo["+orderIndex+"]["+orderKey+"]="+this.quantity.value;
		//alert(paction);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: paction,
			success: function(html) {
				//alert(html);
			}
		});
	}
//	<div style="float:none; clear:both; height:5px;"></div>
	//************************************************
	//APriceBlock.rests = APriceBlock.lastChild;
	//APriceBlock.rests.setRests = function(srests){
	//	this.innerHTML = srests;
	//	alert(this.innerHTML);
	//}
	//APriceBlock.innerHTML += "<br/>\n";
	//************************************************
	return APriceBlock;
}
//	ret += "<span id=\"basket_icon\"></span><a id="basket_button" href="javascript:add_to_r()" 
//	class="item_bye_butt">Купить</a>
//	<div style="float:none; clear:both; height:5px;"></div>



//	ret += "<b>Цена:</b><br/>\n";
//	ret += "<span class=\"filtername\" style=\"margin-top:0px; margin-bottom: 5px;\" id=\"sPriceDigit\">\n";
//	ret += "<span class=\"sp_items_price\" style=\"text-decoration:line-through;color: #333333;font-weight: normal;\">$old_price грн.</span><br/>\n";
//	ret += "555  грн.";


//	ret += "<br/><b>Доступно:</b> <span id=\"item_rests\">100</span><br/>\n";


//	
//	ret += "<span id=\"item_kolvo_parent\"><input type=\"text\" class=\"item_kolvo\" value=\"1\" id=\"my_item_kolvo\" /></span>\n";
//	ret += "Единиц<br/>\n";
//	
//	ret += "<b>Итого:</b> <span id=\"item_summ\">тут цифра</span> грн.<br/><br/>\n";

	
	
	
	