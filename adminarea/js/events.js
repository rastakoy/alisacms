window.onkeyup=function(emo){
	//alert(obj);
	if(item_pop_up_init){
		if (emo.which == 13) {
				item_pop_up_init = false;
				getiteminfo_save(cur_item_id);
		}
		if (emo.which == 27) {
			item_pop_up_init = false;
			getiteminfo_close(cur_item_id);
		}
	}
	if(order_pop_up_init){
		//if (emo.which == 13) {
		//		item_pop_up_init = false;
		//		getiteminfo_save(cur_item_id);
		//}
		if (emo.which == 27) {
			order_pop_up_init = false;
			__ao_closeOrder();
		}
	}
};