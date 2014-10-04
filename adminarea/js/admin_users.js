var __au_init_active = false;
var __au_init_active_value = false;
//****************************
function __au_init_all(){
	__au_init_discount();
	__au_init_fio();
	__au_init_email();
	__au_init_pass();
}
//****************************
function __au_save_data(){
	if(__au_init_active.id.match(/^edit_discount_/)  &&  cur_el.className!="ud_input") {
		__au_save_discount();
		return false;
	}
	if(__au_init_active.id.match(/^edit_fio_/)  &&  cur_el.className!="ufio_input") {
		__au_save_fio();
		return false;
	}
	if(__au_init_active.id.match(/^edit_email_/)  &&  cur_el.className!="uemail_input") {
		__au_save_email();
		return false;
	}
	if(__au_init_active.id.match(/^edit_pass_/)  &&  cur_el.className!="upass_input") {
		__au_save_pass();
		return false;
	}
}
//****************************
function __au_init_pass(){
	$(".user_pass").click(function(){
		if(!__au_init_active){
			__au_init_active = this;
			__au_init_active_value = this.innerHTML;
			this.innerHTML = "<input type=\"text\" value=\"\" class=\"upass_input\" >";
			this.firstChild.select();
			this.firstChild.focus();
		}
	})
}
//****************************
function __au_init_email(){
	$(".user_email").click(function(){
		if(!__au_init_active){
			__au_init_active = this;
			__au_init_active_value = this.innerHTML.replace(/^\(/, "");
			__au_init_active_value = __au_init_active_value.replace(/\)$/, "")
			this.innerHTML = "<input type=\"email\" value=\""+__au_init_active_value+"\" class=\"uemail_input\" >";
			this.firstChild.select();
			this.firstChild.focus();
		}
	})
}
//****************************
function __au_init_fio(){
	$(".user_fio").click(function(){
		if(!__au_init_active){
			__au_init_active = this;
			__au_init_active_value = this.innerHTML.replace(/%$/, "");
			this.innerHTML = "<input type=\"text\" value=\""+this.innerHTML.replace(/%$/, "")+"\" class=\"ufio_input\" >";
			this.firstChild.select();
			this.firstChild.focus();
		}
	})
}
//****************************
function __au_init_discount(){
	$(".user_discount").click(function(){
		if(!__au_init_active){
			__au_init_active = this;
			__au_init_active_value = this.innerHTML.replace(/%$/, "");
			this.innerHTML = "<input type=\"number\" value=\""+this.innerHTML.replace(/%$/, "")+"\" class=\"ud_input\" min=\"0\" max=\"100\">";
			this.firstChild.select();
			this.firstChild.focus();
		}
	})
}
//****************************
function __au_save_discount(){
	var value = __au_init_active.firstChild.value;
	$(__au_init_active).empty();
	$(__au_init_active).append(value+"%");
	pid = __au_init_active.id.replace(/^edit_discount_/, "");
	__au_init_active = false;
	__au_init_active_value = false;
	//***********************
	var paction = "paction=edit_user_discount&pid="+pid+"&value="+value;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			//show_ritems(cur_folder_id);
		}
	});
}
//****************************
function __au_save_fio(){
	var value = __au_init_active.firstChild.value;
	$(__au_init_active).empty();
	$(__au_init_active).append(value);
	pid = __au_init_active.id.replace(/^edit_fio_/, "");
	__au_init_active = false;
	__au_init_active_value = false;
	//***********************
	var paction = "paction=edit_user_fio&pid="+pid+"&value="+value;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			//show_ritems(cur_folder_id);
		}
	});
}
//****************************
function __au_save_email(){
	var value = __au_init_active.firstChild.value;
	$(__au_init_active).empty();
	$(__au_init_active).append(value);
	pid = __au_init_active.id.replace(/^edit_email_/, "");
	__au_init_active = false;
	__au_init_active_value = false;
	//***********************
	var paction = "paction=edit_user_email&pid="+pid+"&value="+value;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			//show_ritems(cur_folder_id);
		}
	});
}
//****************************
function __au_save_pass(){
	var value = __au_init_active.firstChild.value;
	$(__au_init_active).empty();
	$(__au_init_active).append(__au_init_active_value);
	if(value=="") {
		__au_init_active = false;
		__au_init_active_value = false;
		return false;
	}
	pid = __au_init_active.id.replace(/^edit_pass_/, "");
	__au_init_active = false;
	__au_init_active_value = false;
	//***********************
	var paction = "paction=edit_user_pass&pid="+pid+"&value="+value;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			//show_ritems(cur_folder_id);
		}
	});
}

//****************************
//****************************
//****************************

function addUserToUsers(){
	var paction = "paction=addUserToUsers";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			show_ritems("users");
		}
	});
}
//****************************
function registering_user(pid){
	var paction = "paction=registeringUser&pid="+pid;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			show_ritems("users");
		}
	});
}
//****************************
function delete_user(pid){
	var paction = "paction=deletingUser&pid="+pid;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			alert("Пользователь будет удален в течении суток автоматически");
			show_ritems("users");
		}
	});
}
//****************************
function cancel_delete_user(pid){
	var paction = "paction=cancelDeletingUser&pid="+pid;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			show_ritems("users");
		}
	});
}
//****************************
function toggle_user_spam(id){
	var lnk = document.getElementById("dog_"+id).src;
	if(lnk.match(/dog\.gif$/)){
		document.getElementById("dog_"+id).src = document.getElementById("dog_"+id).src.replace(/dog\.gif$/gi, "dog_no.gif");
		var paction = "paction=toggleUserSpam&pid="+id+"&value=0";
	} else {
		document.getElementById("dog_"+id).src = document.getElementById("dog_"+id).src.replace(/dog_no\.gif$/gi, "dog.gif");
		var paction = "paction=toggleUserSpam&pid="+id+"&value=1";
	}
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//show_ritems("users");
		}
	});
}