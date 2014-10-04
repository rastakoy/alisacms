<!-- TinyMCE -->
<script type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
var tiny_init = false;
function tinymce_init(){
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		convert_urls : false,
		//languages:"ru",
		skin : "o2k7",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "mybuttonsave,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect,|,fullscreen",
		theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,mybutton,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,


		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",
		
		width: tmce_width,
		height: tmce_height,

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		},
		
		setup : function(ed) {
        	tiny_ed=ed;
			// Register example button
        	ed.addButton('mybutton', {
				title : '—сылка на файл',
				image : 'images/green/icons/link_file.gif', 
				onclick : function() {
					top.curfname = "";
					show_filemanager_upload2('filemanager.php?nf=1');
			}
		});
		 //ed.addButton('mybuttonsave', {
		//	 title : '—охранить текст',
		//	 image : 'images/green/save_tiny.gif',
		//	 onclick : function() {
		//		//alert("save data");
		//		//tinyMCE.execCommand('mceToggleEditor',false,'item_cont');
		//		tiny_init = true;
		//		tiny_mce_save_text();
		//	 }
		 // });
	   	} 
		
		
	});
}
</script>
<!-- /TinyMCE -->