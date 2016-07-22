<?php
    /**
    * @file
    *
    * Theme file for non empty cart.
    */
?>
<?php
    $imgG = array(
        '3' => '/sites/all/themes/mamamia/images/pz32_a.png',
        '4' => '/sites/all/themes/mamamia/images/pz40_a.png',
        '5' => '/sites/all/themes/mamamia/images/pzshef_a.png',
        '6' => '/sites/all/themes/mamamia/images/pzcheese_a.png'
    );
?>
<table>
    <tbody>
        <tr class="cart-block-summary-links">
            <td colspan="2">
                <?php //print $cart_links; ?>
            </td>
        </tr>
        <tr>
            <td class="cart-block-summary-items">
                <?php print $items_text; ?>
            </td>
            <td class="cart-block-summary-total">
                <label><?php print t('Total'); ?>: </label><?php print $total ;?>
            </td>
        </tr>
    </tbody>
</table>
<br>
<div id="cart-block-contents-ajax">
    <table class="cart-block-items">
        <thead>
            <tr>
                <th colspan="4">
                    <?php print t('Products')?>
                </th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td colspan="2" class="cartT">кол-во</td>
            </tr>

            <?php foreach ( $items as $item ): $atr = $item['item']->data['attributes'];
                    //print_r($item);
                ?>
                <tr>
                    <td class="cart-info">
                        <table style="border:none; margin-bottom: 10px; width:100%;">

                            <tr>
                                <?php if ($item['item']->taxonomy_catalog['und'][0]['tid'] == 15) : ?>
                                    <td width="80"><img src="<?=$imgG[$atr[2]] ?>" style="width:90%;"></td>
                                    <td width="100">
                                    <?php else : ?>
                                    <td colspan="2" style="width:100%;">
                                        <?php endif; ?>
                                    <p class="title" style="margin: 0 0 5px 0;font-weight: bold;"><?php print strip_tags($item['title']); ?></p>
                                    <p class="dobavki" style="font-size: 12px; margin: 5px 10px; color: grey;">
                                        <?php
                                            foreach($atr as $key => $ingr) :
                                                if ($key != 2) :
                                                    if (!is_array($ingr)) $ingr = array($ingr);
                                                    foreach ($ingr as $single) :
                                                        $options = $item['item']->attributes[$key]->options[$single];
                                                        echo $options->name . ' - ' . (int) $options->price . 'р. <br/>';
                                                    ?>

                                                    <?php endforeach; endif; endforeach; ?>
                                    </p>
                                    <p class="price" style="margin: 0 0 5px 0;font-weight: bold;"><?php print $item['total'] ?></p>
                                </td>
                                <td>
                                    <input type="text" readonly="readonly" onkeyup="setTimeout(ajaxCartUpdateBlockCart, 500); setTimeout(ajaxCartUpdateBlockCart, 500); setTimeout(ajaxCartUpdateBlockCart, 1000); setTimeout(ajaxCartUpdateBlockCart, 4000);" class="quantity" value="<?print $item['item']->qty;?>" />
                                    <input type="hidden" class="itemId" id="it_<?=$item['item']->cart_item_id?>" value="<?=$item['item']->cart_item_id?>">
                                    <?/*<a class="addtocart" onclick="setTimeout(ajaxCartUpdateBlockCart, 500); setTimeout(ajaxCartUpdateBlockCart, 500); setTimeout(ajaxCartUpdateBlockCart, 1000); setTimeout(ajaxCartUpdateBlockCart, 4000);" target="adding" href="http://mamamia-pizza.ru/cart/add/p35_a2o3_q0?destination=adding.php">Add</a>*/?>
                                </td>
                            </tr>
                        </table>
                        <?php
                            //print $item['qty'];
                            //print strip_tags($item['title']);
                            //print $item['descr'];
                        ?>
                        <!--				<div class="cart-qty-price">-->
                        <!--					--><?php //print $item['total'] ?><!--				-->
                        <!--				</div>-->
                    </td>
                    <td class="cart-remove">
                        <?php print $item['remove_link'] ?>
                    </td>
                </tr>

                <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
if(document.getElementById("adaptive-bascket")){
	var obj = document.getElementsByClassName("cart-block-summary-total")[0];
	if(obj){
		var text = obj.innerHTML.split(">")[2].replace(/ .*$/, '');
		//console.log("text = "+text);
		if(document.getElementById("adaptive-bascket-sum")){
			document.getElementById("adaptive-bascket-sum").innerHTML = text;
		}
	}
	document.getElementById("adaptive-bascket").style.display = "";
}
</script>