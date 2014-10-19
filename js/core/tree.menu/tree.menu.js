//*********************************
function tree_menu(cMenu){
	myMenu = document.getElementById(cMenu);
	//alert(myMenu.id);
	//cascading_prepare_level(myMenu);
}
//*********************************
function __treeMenu_toggleBranch(id){
	//alert("ok="+id);
	objs = document.getElementById("branch_"+id).getElementsByTagName("li");
	if(objs.length>0){
		ul = document.querySelector("#branch_"+id+" > ul");
		if(ul.style.display=="none"){
			ul.style.display="";
		}else{
			ul.style.display="none";
		}
	}
	return objs.length;
}
//*********************************

//*********************************

//*********************************

//*********************************

//*********************************