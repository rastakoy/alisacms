function orders_sendOrder(oid){
	//alert(oid);
	paction = "paction=orders_send_order&pid="+oid,
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			alert(html);
			//alert("���� ������");
			show_ritems(cur_folder_id);
		}
	});
}
//******************************
function setOrderStatus(obj, pid){
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: "paction=setOrderStatus&pid="+pid+"&action="+obj.value,
		success: function(html) {
			//alert(html);
			show_ritems(cur_folder_id);
			//document.getElementById('divinfo').innerHTML += "����������� �������� ������� �"+ids+"�<br/>\n"; //html;
			//document.getElementById('divinfo').innerHTML += html;
			//images_get_images();
		}
	});
}
//******************************
