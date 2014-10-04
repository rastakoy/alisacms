<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Untitled Document</title>

<script src="tu/jquery-1.4.2.min.js" type="text/javascript"></script>

<link href="tu/fileuploader.css" rel="stylesheet" type="text/css" />
<script src="tu/fileuploader.js" type="text/javascript"></script>

</head>

<body>

<div id="file-uploader">       
    <noscript>          
        <p>Please enable JavaScript to use file uploader.</p>
        <!-- or put a simple form for upload here -->
    </noscript>         
</div>

<script>
var uploader = new qq.FileUploader({
    // pass the dom node (ex. $(selector)[0] for jQuery users)
    element: document.getElementById('file-uploader'),
    // path to server-side upload script
    action: 'upload.php',
	onComplete: function(id, fileName, responseJSON){alert("upload: "+responseJSON.success)}
});
</script>

</body>
</html>
