<div id="colorbox">
<input type="text" id="jqcp_h" size="3" value="0" style="display:none;">
<input type="text" id="jqcp_s" size="3" value="0" style="display:none;">
<input type="text" id="jqcp_l" size="3" value="0" style="display:none;">
<input type="text" id="jqcp_r" size="3" value="255" style="display:none;">
<input type="text" id="jqcp_g" size="3" value="255" style="display:none;">
<input type="text" id="jqcp_b" size="3" value="255" style="display:none;">
<div id="color_picker" style="display:none;" onclick="thisw.style.display='none'"></div>
</div>

<script>
jQuery(document).ready(function(){
   $("#color_picker").jqcp();
   $("#color_value").jqcp_setObject();
   //jQuery.jQCP.setColor("color_value","#5EE9F4");
});
</script>