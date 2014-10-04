semp_parent = 0;
function add_semp(){
	semp_parent = cur_folder_id;
	obj = document.getElementById("semp_as_frame");
	obj.innerHTML = "<iframe src=\"__semp_menu.php\" width=\"100%\"  frameborder=\"0\" />";
	obj.style.display = "";
	document.getElementById("semp_all").style.display = "none";
}

function insert_semp(semp_id, semp_name){
	if(semp_id == cur_item_id) { 
		alert("Вы выбрали исходную модель.\nВыберите что-нибудь другое"); 
		return; 
	}
	obj = document.getElementById("semp_all");
	semp_mass = obj.getElementsByTagName("div");
	for(i=0; i<semp_mass.length; i++){
		str = semp_mass[i].id;
		if(str.substring(5) == semp_id) { 
			alert("Такая модель уже есть в списке.\nВыберите что-нибудь другое"); 
			return; 
		}
	}
	//***********************
	strd = obj.innerHTML;
	new_div = "";
	//new_div += "<div id=\"semp_"+semp_id+"\"><a href=\"manage_models.php?parent="+semp_parent+"&edit="+semp_id;
	//new_div += "\">"+semp_name+"</a>&nbsp;<a href=\"javascript:delete_semp("+semp_id;
	new_div += "<div id=\"semp_"+semp_id+"\">"+semp_name+"&nbsp;<a href=\"javascript:delete_semp("+semp_id;
	new_div += ")\"><img src=\"tree/delete_item.gif\"></a></div>";
	obj.innerHTML = strd+new_div;
	//***********************
	strd = "";
	for(i=0; i<semp_mass.length; i++){
		str = semp_mass[i].id;
		if(i==semp_mass.length-1) { 
			strd += str.substring(5);
		} else {
			strd += str.substring(5)+"\n";
		}
	}
	//***********************
	document.getElementById("semp").value=strd;
	//alert(document.getElementById("semp_all").innerHTML);
	document.getElementById("semp_all").style.display = "";
	obj = document.getElementById("semp_as_frame");
	obj.style.display = "none";
	obj.innerHTML = "";
}
//***********************
function delete_semp(semp_id){
	obj = document.getElementById("semp_"+semp_id);
	var Parent = obj.parentNode; 
	Parent.removeChild(obj); 
	//***********************
	obj = document.getElementById("semp_all");
	semp_mass = obj.getElementsByTagName("div");
	strd = "";
	for(i=0; i<semp_mass.length; i++){
		str = semp_mass[i].id;
		if(i==semp_mass.length-1) { 
			strd += str.substring(5);
		} else {
			strd += str.substring(5)+"\n";
		}
	}
	//***********************
	document.getElementById("semp").value=strd;
}