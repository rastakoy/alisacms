<html>
<head>
<style>
#szf{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	padding-top: 10px;
	padding-left: 8px;
	text-align: center;
}
</style>
</head>
<body style="padding:0px; margin:0px;">
<? if ($_FILES["sp_link"]["name"]!="") {  
	if(file_exists("../tmp/csvtmp.csv")){
		unlink("../tmp/csvtmp.csv");
	}
	$res_dopfile = copy($_FILES["sp_link"]["tmp_name"], "../tmp/csvtmp.csv");
?>
<script>
top.myuploadfile = "<?  echo "../tmp/csvtmp.csv";  ?>";
</script>
<div id="szf">Обработка файла</div>
<? }  else  { ?>
<form action="manage_uploadp_file.php" method="post" enctype="multipart/form-data" 
name="form1" style="margin:0px; padding:0px;" id="form1" >
<input name="sp_link" type="file" id="sp_link" onchange="document.form1.submit()" />
</form>
<?  } ?>
</body>
</html>