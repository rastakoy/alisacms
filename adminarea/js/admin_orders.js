var order_pop_up_init = false;
function __ao_showOrder(orderId){
	if(mtout) clearInterval(mtout);
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	//*******************************
	obj_m = document.getElementById("show_myitemblock_bg");
	obj_m.style.width = wwidth+"px";
	obj_m.style.height = wheight+"px";
	obj_m.style.display="";
	obj_m.style.cursor="pointer";
	obj_m.onclick = function(){
		__ao_closeOrder();
	}
	//*******************************
	obj_w = document.getElementById("show_myitemblock_cont");
	obj_w.style.width = (wwidth-100)+"px";
	obj_w.style.height = (wwheight - 100)+"px";
	obj_w.style.top = (20+document.body.scrollTop)+"px";
	obj_w.style.left = (wwwidth/2-(wwidth-100)/2)+"px";
	obj_w.style.display="";
	//*******************************
	obj_c = document.getElementById("show_myitemblock_close");
	obj_c.style.top = (15+document.body.scrollTop)+"px";
	obj_c.style.left = (wwidth-40)+"px";
	obj_c.style.display="";
	obj_c.onclick = function(){
		__ao_closeOrder();
	}
	//*******************************
	order_pop_up_init = true;
	__ao_getOrder(orderId);
}
//************************************************
function __ao_closeOrder(){
	obj_m = document.getElementById("show_myitemblock_bg");
	obj_m.style.display="none";
	//*******************************
	obj_c = document.getElementById("show_myitemblock_close");
	obj_c.style.display="none";
	//*******************************
	obj_w = document.getElementById("show_myitemblock_cont");
	obj_w.innerHTML = "Загрузка...";
	obj_w.style.display="none";
}
//************************************************
function __ao_getOrder(orderId){
	var paction = "paction=ao_getOrder&id="+orderId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			$("#show_myitemblock_cont").empty();
			$("#show_myitemblock_cont").append(html);
		}
	});
}
//************************************************
function __ao_changeQtty(obj){
	var id = obj.id.replace(/^qtty_/gi, "");
	if(obj.max < parseInt(obj.value)) {
		obj.value = obj.max;
	}
	if(parseInt(obj.value) < 1) {
		obj.value = 1;
	}
	paction = "paction=changeSborkaQtty&qtty="+obj.value+"&id="+id;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			myobj = eval("("+html+")");
			//alert(myobj.onStore);
			document.getElementById("sum_"+myobj.id).innerHTML = myobj.sum;
			document.getElementById("discPrice_"+myobj.id).innerHTML = myobj.discPrice;
			document.getElementById("discount_"+myobj.id).innerHTML = myobj.discount;
			document.getElementById("qtty_"+myobj.id).max = myobj.onStore;
			document.getElementById("allOrderSum").innerHTML = myobj.allOrderSum;
			document.getElementById("allOrderDiscount").innerHTML = myobj.allOrderDiscount;
			document.getElementById("orderItogo").innerHTML = myobj.orderItogo;
			//$("#show_myitemblock_cont").empty();
			//$("#show_myitemblock_cont").append(html);
		}
	});
}
//************************************************
function showOrderInfo(){
	document.getElementById("orderInfo").style.display = "";
	document.getElementById("otInfo").className = "orderTab oActive";
	
	document.getElementById("orderContent").style.display = "none";
	document.getElementById("otCont").className = "orderTab";
}
//************************************************
function showOrderContent(){
	document.getElementById("orderContent").style.display = "";
	document.getElementById("otCont").className = "orderTab oActive";
	
	document.getElementById("orderInfo").style.display = "none";
	document.getElementById("otInfo").className = "orderTab";
}
//************************************************
function deleteItemFromOrder(id){
	if(confirm("Вы даействительно желаете удалить этот товар из заказа?")){
		paction = "paction=changeSborkaQtty&qtty=0&id="+id;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				myobj = eval("("+html+")");
				document.getElementById("sum_"+myobj.id).innerHTML = myobj.sum;
				document.getElementById("discPrice_"+myobj.id).innerHTML = myobj.discPrice;
				document.getElementById("discount_"+myobj.id).innerHTML = myobj.discount;
				document.getElementById("qtty_"+myobj.id).max = myobj.onStore;
				document.getElementById("allOrderSum").innerHTML = myobj.allOrderSum;
				document.getElementById("allOrderDiscount").innerHTML = myobj.allOrderDiscount;
				document.getElementById("orderItogo").innerHTML = myobj.orderItogo;
				$("#orderTR_"+id).hide(500);
				var paction = "paction=deleteItemFromOrder&id="+id;
				$.ajax({
					type: "POST",
					url: __ajax_url,
					data: paction,
					success: function(html) {
						//
					}
				});
			}
		});
	}
}
//************************************************
function delete_order(orderId){
	if(confirm("Вы даействительно желаете удалить этот заказ?")){
		var paction = "paction=deleteOrder&orderId="+orderId;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				show_ritems("orders");
			}
		});
	}
}
//************************************************
function __ao_getWord(orderId){
	var paction = "paction=ao_orderToWord&orderId="+orderId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			document.getElementById("downloadForm").action = html;
			document.getElementById('downloadForm').submit();
			// window.getBrowser().addTab(html);
			//$('a[rel=external]').attr(html,'_blank');
			//window.open(html, "_blank");
			//alert(html);
			//show_ritems("orders");
		}
	});
}
//************************************************
function __ao_postPrice(orderId){
	var paction = "paction=ao_postPrice&orderId="+orderId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			alert("Сообщение отправлено");
			//alert(html);
			//show_ritems("orders");
		}
	});
}
//************************************************
function __ao_cangeOrderStatus(orderId, orderStatus, orderPage, page){
	var paction = "paction=ao_cangeOrderStatus&orderId="+orderId+"&orderStatus="+orderStatus;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			show_ritems('orders', page, orderPage);
			//alert(html);
			//document.getElementById("downloadForm").action = html;
		}
	});
}
//************************************************
function __ao_saveOrderTTN(orderId){
	var paction = "paction=ao_saveOrderTTN&ttn="+document.getElementById("orderTTN").value+"&orderId="+orderId;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			if(confirm("Отправить SMS с ТТН этому пользователю?")){
				__ao_sendSMS();
			}
		}
	});
}
//************************************************
function __ao_sendSMS(){
	var paction = "paction=ao_sendSMS";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			alert(html);
			//if(confirm("Отправить SMS с ТТН этому пользователю?")){
			//	__ao_sendSMS();
			//}
		}
	});
}
//************************************************

//************************************************