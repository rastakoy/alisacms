//**
var jsonWindowAdminFolders = {
	modal: true,
	resizeable: true,
	css:{
		width: 300,
		height: 400,
		//"background-color": "#FFFFFF"
		"background-color": "#C1C1C1"
	},
	id: "jsonWindowAdminFolders",
	tabs: { "Консоль":{
			content: "Консоль",
			id: "jsonWindowAdminFoldersContent"
			//jsonGrid: 
		}
	},
	buttons:{
		"wSave":function(){  
			alert("ok");
		}
	}
}

//**
var __jrc_construct_HTML__operations = "<a href=\"javascript:__jr_construct_Window_pages_tree()\">Добавить блок</a><br/>";
__jrc_construct_HTML__operations += "<a href=\"javascript:\">Добавить блок</a><br/>";
__jrc_construct_HTML__operations += "<a href=\"javascript:\">Добавить блок</a><br/>";
__jrc_construct_HTML__operations += "<a href=\"javascript:\">Добавить блок</a><br/>";
__jrc_construct_HTML__operations += "<a href=\"javascript:\">Добавить блок</a><br/>";

//**
__jrc_grid_HTML_block_visibility = {
	0:	{name: "Отображение", connect: "pageType"}
}

//**
__jrc_grid_HTML_block_connection = {
	0:	{name: "Поле соединение", connect: "connectionField"},
	1: {name: "Тип передачи данных", connect: "pagePost"}
}

//**
__jrc_grid_HTML_block_type = {
	0:	{name: "Тип блока", connect: "multiType~name"},
	1: {name: "Id блока", connect: "multiType~id"},
	2: {name: "Количество элементов", connect: "multiType~count"},
	3: {name: "Поле фильтра", connect: "multiType~requirement"},
	4: {name: "Значение фильтра", connect: "multiType~requirement_value"},
	5: {name: "Тип знеачения", connect: "multiType~requirement_type"},
	6: {name: "Родитель элементов", connect: "multiType~fromlink"},
	7: {name: "Родительска ветка", connect: "multiType~requirement_parent"}
}

//**
__jrc_grid_HTML_block_properties = {
	0:	{name: "Тэг (tag)", connect: "tagname"},
	1:	{name: "Идентификатор", connect: "id"},
	2: {name: "Класс (class)", connect: "className"},
	3: {name: "Текст", connect: "content"},
	4: {
		name: "Соединение с полем",
		type: "connectionField"
	},
	5: {name: "Подгрузка (require)", connect: "pageRequire"},
	6: {name: "Растягивание", connect: "stretch"}
}

//**
function __jrc_create_object_HTML_tabs(){
	var __jrc_object_HTML_tabs = {
		"Консоль":{
			content: "Консоль",
			id: "jsonWindowContent"
			//jsonGrid: 
		},
		"Свойства блока":{
			content: { key: "__gkv_construct_grid", value: "__jrc_grid_HTML_block_properties" },
			id: "jsonWindowProperties"
			//jsonGrid: 
		},
		"Мультиблок":{
			content: { key: "__gkv_construct_grid", value: "__jrc_grid_HTML_block_type" },
			id: "jsonWindowType"
			//jsonGrid: 
		},
		"Соединение с полем":{
			content: { key: "__gkv_construct_grid", value: "__jrc_grid_HTML_block_connection" },
			id: "jsonWindowConnection"
			//jsonGrid: 
		},
		"Отображение":{
			content: { key: "__gkv_construct_grid", value: "__jrc_grid_HTML_block_visibility" },
			id:"jsonWindowVisible",
		},
		"CSS встроенный":{
			content:"CSS стиль", 
			id:"jsonWindowCSSinner",
		},
		"CSS внешний":{
			content:"asd", 
			id:"jsonWindowCSSouter",
		},
		"Операции":{
			content:{ key: "__jr_construct_HTML", value: "__jrc_construct_HTML__operations" }, 
			id:"jsonWindowCSSouter",
		}
	}
	return __jrc_object_HTML_tabs;
}
