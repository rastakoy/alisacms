//Инициализация переменных и массивов
rows_csv = 0;
cells_csv = 0;
mass_csv = new Array();
actions_csv = new Array();
t_rows_csv = new Array();
t_cells_csv = new Array();
a_count_csv=0;
csv_complite = true;

//Инициализация функций
//******************
function init_new_csv(){	
	mass_csv[0] = new Array();
	mass_csv[0][0] = "";
	mass_csv[0][1] = "";
	mass_csv[1] = new Array();
	mass_csv[1][0] = "";
	mass_csv[1][1] = "";
	//****************
	rows_csv = 2;
	cells_csv = 2;
	render_table_csv();
}
//******************
function render_table_csv(){
	actions_csv[a_count_csv]=new Array();
	actions_csv[a_count_csv]=mass_csv;
	t_rows_csv[a_count_csv] = rows_csv;
	t_cells_csv[a_count_csv] = cells_csv;
	a_count_csv++;
	
	inner_csv = render_mass_csv();
	//alert("test");
	document.getElementById("cells_csv").value = cells_csv;
	document.getElementById("table_csv").innerHTML = inner_csv;
	//alert(document.getElementById("table"));
	//alert(document.getElementById("textarea_csv_0").value);
}
//******************
function render_mass_csv(){
	var ret_val = "";
	ret_val += "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"#EEEEEE\">";
	for(i=0; i<rows_csv+1; i++){
		ret_val += "<tr>\n";
		for(j=0; j<cells_csv+1; j++){
			if(i == 0 && j==0){
				ret_val += "<td bgcolor=\"#999999\">&nbsp;</td>";
			}
			else{
				if(i == 0){
					ret_val += "<td align=\"center\" bgcolor=\"#CCCCCC\" width=\"150\" height=\"25\">";
					ret_val += "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" ><tr>";
						ret_val += "<td align=\"center\" >";
							ret_val += "<a href=\"javascript:add_cell_csv()\"><img src=\"csv/plus.jpg\" border=\"0\" /></a>";
						ret_val += "</td>";
						ret_val += "<td align=\"center\" >";
							ret_val += "<a href=\"javascript:delete_cell_csv("+(j-1)+")\"><img src=\"csv/minus.jpg\" border=\"0\" /></a>";
						ret_val += "</td>";
						ret_val += "<td align=\"center\" >";
							ret_val += "<a href=\"javascript:__mc_replace_left("+(j-1)+")\"><img src=\"csv/left.jpg\" border=\"0\" /></a>";
						ret_val += "</td>";
						ret_val += "<td align=\"center\" >";
							ret_val += "<a href=\"javascript:__mc_replace_right("+(j-1)+")\"><img src=\"csv/right.jpg\" border=\"0\" /></a>";
						ret_val += "</td>";
					ret_val += "</tr></table>";
					//ret_val += "<a href=\"javascript:delete_cell_csv("+(j-1)+")\">Удалить столбец</a>";
					//ret_val += "<br/><a href=\"javascript:__mc_replace_left("+(j-1)+")\">Влево</a>";
					ret_val += "</td>";
				}
				else if(j == 0){
					ret_val += "<td width=\"120\" bgcolor=\"#CCCCCC\">";
					ret_val += "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" ><tr>";
						ret_val += "<td align=\"center\" >";
							ret_val += "<a href=\"javascript:add_row_csv()\"><img src=\"csv/plus.jpg\" border=\"0\" /></a>";
						ret_val += "</td>";
						ret_val += "<td align=\"center\" >";
							ret_val += "<a href=\"javascript:delete_row_csv("+(i-1)+")\"><img src=\"csv/minus.jpg\" border=\"0\" /></a>";
						ret_val += "</td>";
						ret_val += "<td align=\"center\" >";
							ret_val += "<a href=\"javascript:__mc_replace_up("+(i-1)+")\"><img src=\"csv/up.jpg\" border=\"0\" /></a>";
						ret_val += "</td>";
						ret_val += "<td align=\"center\" >";
							ret_val += "<a href=\"javascript:__mc_replace_down("+(i-1)+")\"><img src=\"csv/down.jpg\" border=\"0\" /></a>";
						ret_val += "</td>";
					ret_val += "</tr></table>";
					//ret_val += "<a href=\"javascript:delete_row_csv("+(i-1)+")\">Удалить рядок</a>";
					//ret_val += "<a href=\"javascript:__mc_replace_down("+(i-1)+")\">Переместить вверх</a>";
					ret_val += "</td>";
				}
				else{
					ret_val += "<td align=\"center\" bgcolor=\"#CCCCCC\">";
					ret_val += "<input onChange=\"change_value_csv("+(i-1)+","+(j-1)+", this.value)\" name=\"data_csv[" + (i-1) + "][" + (j-1) + "]\" type=\"text\" value=\""+mass_csv[i-1][j-1]+"\">";
					ret_val += "</td>";
				}
			}
		}
		ret_val += "</tr>";
	}
	ret_val += "</table>";
	//alert(ret_val);
	return ret_val;
	
}
//******************
function add_row_csv(){
	mass_csv[rows_csv] = new Array();
	for(i=0; i<cells_csv; i++){
		mass_csv[rows_csv][i] = "";
	}
	rows_csv++;
	render_table_csv();
}
//******************
function add_cell_csv(){
	//mass[cells] = new Array();
	for(i=0; i<rows_csv; i++){
		//alert(cells);
		mass_csv[i][cells_csv] = "";
	}
	cells_csv++;
	render_table_csv();
}
//******************
function change_value_csv(v_row, v_cell, v_cont){
	mass_csv[v_row][v_cell] = v_cont;
	on_edit_cell_csv();
	//alert(mass[v_row][v_cell]);
}
//******************
function delete_row_csv(num){
	for(i=0; i<rows_csv; i++){
		if(i>=num){
			mass_csv[i] = mass_csv[i+1];
		}
	}
	rows_csv--;
	render_table_csv();
	on_edit_cell_csv();
}
//******************
function delete_cell_csv(num){
	for(i=0; i<rows_csv; i++){
		for(j=0; j<cells_csv; j++){
			if(j>=num){
				mass_csv[i][j] = mass_csv[i][j+1];
			}
		}
	}
	cells_csv--;
	render_table_csv();
	on_edit_cell_csv();
}
//******************
function undo_csv(){

}
//******************
function show_table_csv(){
	if(document.getElementById("show_table_csv").style.display == "none"){
		document.getElementById("show_table_csv").style.display = "block";
		document.getElementById("manage_show_scv").innerHTML = "- <a href = \"javascript:show_table_csv()\">Редактировать таблицу</a>";
	}
	else{
		document.getElementById("show_table_csv").style.display = "none";
		document.getElementById("manage_show_scv").innerHTML = "+ <a href = \"javascript:show_table_csv()\">Редактировать таблицу</a>";
	}
}
//******************
function __mc_replace_up(num){
	for(i=0; i<rows_csv; i++){
		if(i==num-1){
			tmp = mass_csv[i+1];
			mass_csv[i+1] = mass_csv[i];
			mass_csv[i] = tmp;
		}
	}
	render_table_csv();
	on_edit_cell_csv();
}
//******************
function __mc_replace_down(num){
	for(i=0; i<rows_csv; i++){
		if(i==num){
			tmp = mass_csv[i+1];
			mass_csv[i+1] = mass_csv[i];
			mass_csv[i] = tmp;
		}
	}
	render_table_csv();
	on_edit_cell_csv();
}
//******************
function __mc_replace_right(num){
	for(i=0; i<rows_csv; i++){
		for(j=0; j<cells_csv; j++){
			if(j==num && j!=cells_csv-1){
				tmp = mass_csv[i][j+1];
				mass_csv[i][j+1] = mass_csv[i][j];
				mass_csv[i][j] = tmp;
			}
		}
	}
	render_table_csv();
	on_edit_cell_csv();
}
//******************
function __mc_replace_left(num){
	for(i=0; i<rows_csv; i++){
		for(j=0; j<cells_csv; j++){
			if(j==num && j!=0){
				tmp = mass_csv[i][j-1];
				mass_csv[i][j-1] = mass_csv[i][j];
				mass_csv[i][j] = tmp;
			}
		}
	}
	render_table_csv();
	on_edit_cell_csv();
}
//******************

//******************
function on_edit_cell_csv(){
	csv_complete = false;
	document.getElementById("textarea_csv_0").value = "";	
	for(i=0; i<rows_csv; i++){
		for(j=0; j<cells_csv; j++){
			document.getElementById("textarea_csv_0").value += mass_csv[i][j]+"~+~";		
		}
	document.getElementById("textarea_csv_0").value += "^^~^";	
	}
	csv_complite = true;
}
//******************