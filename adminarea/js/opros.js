function __fs_js_show_opros(){
	//alert(fs_final_cookie);
	var cookie_date = new Date ( fs_final_cookie_time[2], fs_final_cookie_time[1], fs_final_cookie_time[0] );
	document.title = "Opros ON :: " + cookie_date.toGMTString();
	document.cookie = "fs_js_opros_test="+fs_final_cookie+"; expires="+cookie_date.toGMTString()+"; path=/; domain=www.micromed.ua;";
	//set_cookie ( "fs_js_opros_test", fs_final_cookie_time, fs_final_cookie[2], fs_final_cookie[1], fs_final_cookie[0], "/", "www.micromed.ua");
}