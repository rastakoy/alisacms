<?php 
$node = node_load($data->nid);  
$field_weight_value = field_get_items('node', $node, 'field_product_weight'); 
/*print '�������� ���� ���: ' . $field_weight_value[0]['value'];*/ 

$hide_btn_value = field_get_items('node', $node, 'field_hide_btn'); 
/*print $hide_btn_value[0]['value'];*/ 
if (($hide_btn_value[0]['value']) == 1) { 


  print ('<form name="selectform">');          
// ����� ������ ��� �������� 

if ( isset($node->attributes) && isset($node->attributes[6]) ) { 
    print '<div class="ingr">'; 
    print '<div class="weight-ingr clearfix">'; 
    print '<div class="weight-attr">���: <span>' . $field_weight_value[0]['value'] . '</span> �.</div>'; 
    print '<div class="ingr-btn">+ �����������</div>'; 
    print '</div>'; 
    print '<div class="ingr-options">'; print '<input type="hidden" name="aid" value="6" />';
    foreach ($node->attributes[6]->options as $value) { 
      print ('<label><input type="checkbox" name="options" value="'.$node->attributes[6]->options[($value->oid)]->oid.'" price="'.$node->attributes[6]->options[($value->oid)]->price.'" onchange="addons(this);" />'.$node->attributes[6]->options[($value->oid)]->name.' (+'.number_format($node->attributes[6]->options[($value->oid)]->price, 0, '','').' ���.)</label>'); 
    } 
    print ('<div class="ingr-sum"><input type="text" name="optionprice" value="0" disabled="true"><span>���.</span></div>'); 
    print '<div class="close">+</div>'; 
    print '</div>'; 
    print '</div>'; 
}          

// ����� ��������� 
if ( isset($node->attributes) && isset($node->attributes[7]) ) { 
  print '<div class="ingr">'; 
  print '<div class="weight-ingr clearfix">'; 
  print '<div class="weight-attr">���: <span>' . $field_weight_value[0]['value'] . '</span> �.</div>'; 
  print '<div class="ingr-btn">+ �������</div>'; 
  print '</div>'; 
  print '<div class="ingr-options">'; print '<input type="hidden" name="aid" value="7" />';
  foreach ($node->attributes[7]->options as $value) { 
    print ('<label><input type="checkbox" name="options" value="'.$node->attributes[7]->options[($value->oid)]->oid.'" price="'.$node->attributes[7]->options[($value->oid)]->price.'" onchange="addons(this);" />'.$node->attributes[7]->options[($value->oid)]->name.' (+'.number_format($node->attributes[7]->options[($value->oid)]->price, 0, '','').' ���.)</label>'); 
  } 
  print ('<div class="ingr-sum"><input type="text" name="optionprice" value="0" disabled="true"><span>���.</span></div>'); 
  print '<div class="close">+</div>'; 
  print '</div>'; 
  print '</div>'; 
}  

// ����� ������� ��� ��������, �� ����������� 
if ( isset($node->attributes) && isset($node->attributes[5]) ) { 
  print '<div class="ingr">'; 
  print '<div class="weight-ingr clearfix">'; 
  print '<div class="ingr-btn ingr-center">������� �����</div>'; 
  print '</div>'; 
  print '<div class="ingr-options">'; print '<input type="hidden" name="aid" value="5" />';
  foreach ($node->attributes[5]->options as $value) { 
    print ('<label><input type="radio" name="options" value="' 
      .$node->attributes[5]->options[($value->oid)]->oid 
      .'" price="'.$node->attributes[5]->options[($value->oid)]->price 
      .'" onchange="addon_drinks(this);" />'.$node->attributes[5]->options[($value->oid)]->name 
      .' (+' 
        .number_format(($node->attributes[5]->options[($value->oid)]->price)+60, 0, '','') 
        .' ���.)</label>'); 

//
    print ($node->attributes[3]->options[($value->oid)]->weight .'<br/>'); 
//print ($node->attributes[5]->options[($value->oid)]->price)+60; 
  } 
  print '<div class="close">+</div>'; 
  print '</div>'; 
  print '</div>'; 
}

//����
/*
if ( isset($node->attributes) && isset($node->attributes[10]) ) {
  print '<div class="weight-ingr clearfix">'; 
  print '<div class="weight-attr">���: <span>' . $field_weight_value[0]['value'] . '</span> �.</div>'; 
  print '</div>';
  print '<div class="size bread">'; 
  foreach ($node->attributes[10]->options as $value) { 
    if ($node->attributes[10]->options[($value->oid)]->oid == 50) { print ('<label class="checked">
        <input type="radio" checked name="size" value="'.$node->attributes[10]->options[($value->oid)]->oid.'" onchange="changing('.$node->attributes[10]->options[($value->oid)]->price.', this, '. $node->attributes[10]->options[($value->oid)]->weight .');" />'.$node->attributes[10]->options[($value->oid)]->name.' ('.$node->attributes[10]->options[($value->oid)]->weight.')</label>'); 
    } 
    else { 
      print ('<label class=""><input type="radio" name="size" value="'.$node->attributes[10]->options[($value->oid)]->oid.'" onchange="changing('.$node->attributes[10]->options[($value->oid)]->price.', this, '. $node->attributes[10]->options[($value->oid)]->weight .');" />'.$node->attributes[10]->options[($value->oid)]->name.' ('.$node->attributes[10]->options[($value->oid)]->weight.')</label>'); 
    } 
  } 
  //echo "<pre>";
  //print_r($node->attributes[10]->options);
  //echo "</pre>";
  print '</div>'; 
} 
*/

// ����� ������� 
if ( isset($node->attributes) && isset($node->attributes[3]) ) { 

  print '<div class="ingr">'; 
  print '<div class="weight-ingr clearfix">'; 
  print '<div class="weight-attr">���: <span>' . $field_weight_value[0]['value'] . '</span> �.</div>'; 
  print '<div class="ingr-btn">+ �������</div>'; 
  print '</div>'; 
  print '<div class="ingr-options">'; print '<input type="hidden" name="aid" value="3" />';
  foreach ($node->attributes[3]->options as $value) { 
    print ('<label><input type="checkbox" name="options" value="'.$node->attributes[3]->options[($value->oid)]->oid.'" price="'.$node->attributes[3]->options[($value->oid)]->price.'" onchange="addonsPizza(this);" />'.$node->attributes[3]->options[($value->oid)]->name.' (+'.number_format($node->attributes[3]->options[($value->oid)]->price, 0, '','').' ���.)</label>'); 
//print ($node->attributes[3]->options[($value->oid)]->weight .'<br/>'); 
  } 
  print ('<div class="ingr-sum"><input type="text" name="optionprice" value="0" disabled="true"><span>���.</span></div>'); 
  print '<div class="close">+</div>'; 
  print '</div>'; 
  print '</div>'; 
}  
// ����� ������� 
if ( isset($node->attributes) && isset($node->attributes[2]) ) { 
  print '<div class="size">'; 
  foreach ($node->attributes[2]->options as $value) { 
    if ($node->attributes[2]->options[($value->oid)]->oid == 3) { 
      print ('<label class="checked"><input type="radio" checked name="size" value="'.$node->attributes[2]->options[($value->oid)]->oid.'" onchange="changing('.$node->attributes[2]->options[($value->oid)]->price.', this, '. $node->attributes[2]->options[($value->oid)]->weight .');" />'.$node->attributes[2]->options[($value->oid)]->name.' ('.$node->attributes[2]->options[($value->oid)]->weight.')</label>'); 
    } 
    else { 
      print ('<label class=""><input type="radio" name="size" value="'.$node->attributes[2]->options[($value->oid)]->oid.'" onchange="changing('.$node->attributes[2]->options[($value->oid)]->price.', this, '. $node->attributes[2]->options[($value->oid)]->weight .');" />'.$node->attributes[2]->options[($value->oid)]->name.' ('.$node->attributes[2]->options[($value->oid)]->weight.')</label>'); 
    } 
  } 
  print '</div>'; 
}  
/* ��������� ��� ������� ��� ���������(�������) */ 
if (!isset($node->attributes)) { 
  print '<div class="weight-no-attr">���: <span>' . $field_weight_value[0]['value'] . '</span> �.</div>'; 
} 
print ('<div class="attr-hidden"> 
  <input type="text" name="mainprice" value="'.$row->sell_price.'" disabled="true"/> 
  <input type="text" name="sizeprice" value="0" disabled="true"> 
  </div> 
  <div class="controls clearfix"> 
  <div class="show-qty"> 
  <span class="qtytitle">���-��</span> 
  <span class="qtyinput"> 
  <span class="qtydown" onclick="qtydown(this);quan(this);">�</span> 
  <input type="text" name="qty" value="0" disabled="true"> 
  <span class="qtyup" onclick="qtyup(this);quan(this);">+</span> 
  </span> 
  </div> 
  <!-- ������ ������ --> 
  <div class="buy-btn" id="buy-btn-'.$data->nid.'"> 
  <a href="http://mamamia-pizza.ru/cart/add/p'.$data->nid.'_a2o3_q0?destination=adding.php" target="adding" onclick="setTimeout(ajaxCartUpdateBlockCart, 500); setTimeout(ajaxCartUpdateBlockCart, 500); setTimeout(ajaxCartUpdateBlockCart, 1000); setTimeout(ajaxCartUpdateBlockCart, 4000);" class="addtocart">+</a> 
  </div> 
  <!-- ���� ����� --> 
  <div class="show-price"> 
  <!-- <input type="text" name="calcprice" disabled="true" value="'.number_format($row->sell_price, 0 ,'','').'"/> <span class="rub">�</span>-->                 <input type="text" name="calcprice" disabled="true" value="0"/> <span class="rub">�</span> 
  </div> 
  </div> 
  ');  
print ('</form>');

/*
} else {
  print '<div class="cafe-only-popup">����� ����������� � ����� ����</div>';
  print '<div class="cafe-only-weight">���: ' . $field_weight_value[0]['value'] . ' �.</div>';
  print '<div class="cafe-only clearfix">';
    //print '<div class="cafe-only-text">����� �����������<br />� ����� ����</div>';
    print '<div class="show-btn"><a></a></div>';
    print '<div class="show-price">
      <input autocomplete="off" type="text" name="calcprice" disabled="true" value="0"/> <span class="rub">�</span>
      </div>';
  print '</div>';
*/  
};
?>