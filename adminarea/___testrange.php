<html>
<head>
<script type="text/javascript" src="js/mousefunctions.js"></script>
<script language="JavaScript">
function function1(){
   var range = document.createRange();
   var myX = cur_mx;  
   var myY = cur_my;
   range.moveToPoint(myX, myY);
   range.expand("sentence");
   range.select();
}
</script></head>
<body onclick="function1();">
Sample text range, click here
</body>
</html>