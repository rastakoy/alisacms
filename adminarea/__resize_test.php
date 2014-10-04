<html lang="en">
<head>
	<meta charset="utf-8">
	<title>jQuery UI Resizable - Default functionality</title>
	<link rel="stylesheet" href="http://jqueryui.com/themes/base/jquery.ui.all.css">
	<script src="http://jqueryui.com/jquery-1.7.1.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.core.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.widget.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.mouse.js"></script>
	<script src="http://jqueryui.com/ui/jquery.ui.resizable.js"></script>
	<link rel="stylesheet" href="http://jqueryui.com/demos.css">
	<style>
	#resizable { width: 150px; height: 150px; padding: 0.5em; }
	#resizable h3 { text-align: center; margin: 0; }
	</style>
	<script>
	$(function() {
		$( "#resizable" ).resizable();
	});
	</script>
</head>
<body>

<div class="demo">
	
<div id="resizable" class="ui-widget-content">
	<h3 class="ui-widget-header">Resizable</h3>
</div>

</div><!-- End demo -->



<div class="demo-description">
<p>Enable any DOM element to be resizable.  With the cursor grab the right or bottom border and drag to the desired width or height.</p>
</div><!-- End demo-description -->

</body>
</html>