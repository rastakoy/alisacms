var init_inputDigitWithButtons_obj = false;
function init_inputDigitWithButtons(obj, maxi){
	//var objs = document.getElementsByClassName(mClass);
	//var obj = false;
	//for(var j=0; j<objs.length; j++){
		//obj = objs[j];
		obj.maxi = maxi;
		ea = document.createElement("img");
		ea.src = "/js/core/forms/input.digit.wb.up.gif";
		ea.style.width = "8px";
		ea.style.height = "7px";
		ea.style.position = "relative";
		ea.style.top = "-7px";
		ea.style.left = "-15px";
		//ea.style.zIndex = "50";
		ea.style.cursor = "pointer";
		obj.parentNode.appendChild(ea);
		ea.click = false;
		ea.onclick = function(){
			//alert(this.parentNode.firstChild.maxi);
			if(this.parentNode.firstChild.value*1 <= this.parentNode.firstChild.maxi-1){
				this.parentNode.firstChild.value = this.parentNode.firstChild.value*1 + 1;
				//__mii_computer_summ("item_summ", "my_item_kolvo", myPriceDigit, document.getElementById("item_rests"));
			}
			if(this.click) this.click();
			//var ica = document.getElementById("basket_button");
			//if(ica.innerText == "В корзине"){
			//	//alert("В корзине, начинаем пересчет");
			//	paction = "kol_vo["+orderIndex+"]["+orderKey+"]="+this.parentNode.firstChild.value;
			//	//alert(paction);
			//	$.ajax({
			//		type: "POST",
			//		url: "__ajax.php",
			//		data: paction,
			//		success: function(html) {
			//			//alert(html);
			//		}
			//	});
			//}
		}
		obj.buttonUp = ea;
		//*****************************
		eb = document.createElement("img");
		eb.src = "/js/core/forms/input.digit.wb.down.gif";
		eb.style.width = "8px";
		eb.style.height = "7px";
		eb.style.position = "relative";
		eb.style.top = "3px";
		eb.style.left = "-23px";
		//eb.style.zIndex = "1000";
		eb.style.cursor = "pointer";
		obj.parentNode.appendChild(eb);
		eb.onclick = function(){
			if(this.parentNode.firstChild.value > 1)
				this.parentNode.firstChild.value = this.parentNode.firstChild.value*1 - 1;
			if(this.click) this.click();
		}
		obj.buttonDown = eb;
		//*****************************
		obj.onkeyup = function(ev){
			if(!this.value.match(/^[0-9]*$/))
				this.value = this.value.replace(/.?$/, "");
			if(this.value.match(/^[0-9]*$/))
				if(this.value==0) this.value = 1;
			if(this.value>this.maxi) {
				this.value = this.maxi;
				this.parentNode.children[1].onclick();
			}
			//__mii_computer_summ("item_summ", "my_item_kolvo", myPriceDigit);
		}
		//*****************************
		obj.onfocus = function(){
			init_inputDigitWithButtons_obj = this;
			setTimeout("init_inputDigitWithButtons_obj.select()", 30);
		}
		//*****************************
	//}
}