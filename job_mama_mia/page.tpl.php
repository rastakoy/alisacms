<?php //drupal_set_message("<pre>".print_r(array_keys(get_defined_vars()), 1).'</pre>');?>
<div id="wrapper">
    <div id="container" class="clearfix">

        <?//Окно при нажатии на справ. службу?>
        <div class="darkBg">
            <div class="dWrap">
                <a class="modalClose" href=""></a>
                <div class="dText">ПОЗВОНИТЬ 8(4872)555-888</div>
                <a class="modalLinks fst" href="tel:+8(4872)555-888">Да</a>
                <a class="modalLinks snd" href="<?=$arParams['BASKET_URL']?>">Отмена</a>
            </div>
        </div>


        <div id="header">

            <div class="before-wrapper">
                <div class="center">
                    <div class="logo">
                        <?php if ($logo): ?>
                            <?php if (!$is_front) { ?><a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php } ?>
                                <img id="logo" src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
                            <?php if (!$is_front) { ?></a><?php } ?>
                            <?php endif; ?>
                    </div>
                </div>		
            </div>
            <div class="kayma-left"></div>
			<div id="adaptive-bascket" class="adaptive-bascket" onclick="showAdaptiveBasket()" style="display:none;"><span id="adaptive-bascket-sum">&nbsp;</span> Р</div>
            <div class="top-left-block">
                
                <div class="delivery-bg"></div>
                <div class="phone">Единая<br/>справочная служба<br><span class="tel">555-888</span></div>
                <div class="menu-button"><span></span></div>
                
                <?php if ($page['header-left']) { ?>
                    <?php print render($page['header-left']) ?>
                    <?php } ?>
            </div>
            <div class="picture">
                <?php if ($page['header-content']) { ?>
                    <?php print render($page['header-content']) ?>
                    <?php } ?>
            </div>
            <div class="kayma-right"></div>
            <div class="top-right-block">
                <?php if ($page['header-right']) { ?>
                    <?php print render($page['header-right']) ?>
                    <?php } ?>
            </div>
            <div class="left-pizza"></div>
            <div class="gallery">
                <?php if ($page['header-special']) { ?>
                    <?php print render($page['header-special']) ?>
                    <?php } ?>
            </div>
            <?php if ($page['header-menu']) { ?>
                <div id="header-menu">
                    <?php print render($page['header-menu']) ?>
                </div>
				<div style="clear:both;"></div>
                <?php } ?>
            <div class="right-pizza"></div>

        </div> <!-- /#header -->

        <div id="precontent" class="clearfix">

            <div id="content">

                <div class="content-head">
                    <!-- Хлебные крошки -->
                    <?php if ($breadcrumb): ?>
                        <?php //print $breadcrumb; ?>
                        <?php endif; ?>

                    <!-- Сообщение системы -->
                    <?php if ($messages): ?>
                        <div id="messages">
                            <?php print $messages; ?>
                        </div> <!-- /.section, /#messages -->
                        <?php endif; ?>


                    <?php print render($title_prefix); ?>
                    <?php if ($title): ?>
                      <? if ($_SERVER['REQUEST_URI'] != '/shema-stolov') {?>
                        <h1 id="content-title">
                            <?php print $title; ?>
                        </h1>
					<? } ?>
                        <?php endif; ?>
                    <?php print render($title_suffix); ?>


                    <?php if (render($tabs)): ?>
                        <div class="tabs">
                            <?php unset($tabs['#secondary']) ; print render($tabs); ?>
                        </div>
                        <?php endif; ?>

                    <?php print render($page['help']); ?>
                    <?php if ($action_links): ?>
                        <ul class="action-links">
                            <?php print render($action_links); ?>
                        </ul>
                        <?php endif; ?>
                </div>

                <div class="content-body">
                    <?php print render($page['content']); ?>
                </div>

            </div> <!-- /#content -->

            <?php if ($page['extra']) { ?>
                <div id="extra" style="padding-bottom:0;">
                    <?php print render($page['extra']); ?>
                    <button class="delivery-condition" onclick="jQuery('.delivery-condition-text').addClass('visible');" style="display: block;text-decoration: none;color: white;text-align: center;background-color: rgb(126, 87, 27);border-radius: 10px;padding: 10px 18px; border:none;margin: 20px auto;">Условия заказа и доставки</button>					
					<input type="submit" class="delivery-online" style="display: none;text-decoration: none;color: white;text-align: center;background-color: rgb(126, 87, 27);border-radius: 10px;padding: 10px 18px; border:none;margin: 20px auto;text-transform:uppercase;" value="Проверить заказ" onclick="AjaxFormRequest()" />
					<p id="form_result"></p>
					<!--  -->
                    <div class="gudvins" style="padding-top:10px; background:rgba(255,255,255,0.4); margin:20px -15px 0;">
                        <p><img style="display: block; margin-left:auto;" src="/sites/default/files/delivery.png" alt="Новый способ оплаты!"></p>
                        <div class="extra-goodwine"><b>Доставим алкоголь из</b><img src="/sites/all/themes/mamamia/images/card-sale-transparent.png" alt="ГудВин"></div>
                    </div>
                </div> <!-- /#extra -->

                <noindex>
                    <div class="delivery-condition-text">
                        <div>
                            <div>
                                <span class="close" onclick="jQuery('.delivery-condition-text').removeClass('visible'); "></span>
                                <h2 style="color:#333;">Условия заказа и доставки.</h2>
                                <p>Минимальная сумма заказа составляет 500 рублей (окончательная стоимость с учетом скидки).</p>
                                <p>Оформить заказ можно КРУГЛОСУТОЧНО по тел. 555-888 доб 1 или он-лайн на сайте. Обращаем ваше внимание: при оформлении заказа через сайт оператор перезвонит вам для уточнения всех деталей.</p>
                                <p>Вы можете заказать доставку блюд к определенному времени. Просто укажите в он-лайн заявке или в разговоре с оператором желаемую дату и время. Предварительные заказы принимаются не ранее, чем за 3 дня.</p>
                                <p>Мы готовим блюда индивидуально для каждого клиента, поэтому отменить или изменить заказ можно лишь в течение 2 минут. Если по каким-либо причинам вы отказываетесь от готового заказа надлежащего качества, мы оставляем за собой право не принимать ваши дальнейшие заказы. Пожалуйста, внимательно относитесь к составлению заказа, его стоимости, условиям доставки и к той информации, которую озвучивает оператор.</p>
                                <p>Оплата производится наличными или банковской картой курьеру при получении заказа. Если вы будете расплачиваться купюрой крупного достоинства, пожалуйста, предупредите об этом оператора при оформлении заказа.</p>
                                <p>Оплата производится только в рублях.</p>
                                <p>Доставка в пределах Тулы осуществляется БЕСПЛАТНО.</p>
                                <p>Стоимость доставки в отдаленные районы Тулы составит 100 рублей. Минимальная сумма заказа в отдаленные районы Тулы составляет 1000 рублей (окончательная стоимость с учетом скидки).</p>
                                <p>Отдаленные районы: Косая гора, Скуратово, Иншинка, Барсуки, Плеханово, Хомяково, Басово-Прудный, Старое Басово, Менделеевский.</p>
                            </div>
                        </div>
                    </div>
                </noindex>
                <?php } ?>

            <?php if ($page['right-column']) { ?>
                <div id="right-column">
                    <?php print render($page['right-column']); ?>
                </div> <!-- /#extra -->
                <?php } ?>

        </div> <!-- /#precontent -->


    </div> <!-- /#container -->
</div> <!-- /#wrapper -->

<div style="background: #fff; padding: 10px; z-index: 999; position: absolute">
    <?php
        //print_r ($node->attributes[2]);
        //print(count($node->attributes[2]->options));
        //print($node->attributes[2]->options[4]->name);

        //	foreach ($node->attributes[2]->options as $value) {
        //		print ($node->attributes[2]->options[($value->oid)]->name .'<br>');
        //		print ($node->attributes[2]->options[($value->oid)]->price .'<br>');
        //		print ($node->attributes[2]->options[($value->oid)]->weight .'<br><br>');

        //		foreach($node->attributes[2]->options[($value->oid)] as $key => $value) {echo "$key = $value <br />";}
        //	}
    ?>
</div>


<iframe name="adding" width="1" height="1" src="/adding.php" style="position: absolute; right: 0px; top: 0px;"></iframe>

<div id="footer">
    <?php if ($page['footer']) { ?>
        <?php print render($page['footer']) ?>
        <?php } ?>
</div> <!-- /#footer -->
