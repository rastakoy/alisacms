//проверка на число при вводе
function validateInt(el){
    el.value = el.value.replace(/\D+/,'');
}

jQuery(document).ready(function($){

        //Редактир-е кол-ва товара в корзине
        if(jQuery('.cart-info .quantity').length) {/*    

            jQuery('input.quantity').live('keyup',function() {
                    thisId = parseInt(jQuery(this).siblings('.itemId').val());
                    thisQty = parseInt(jQuery(this).val());
                    
                    $.ajax ({     
                            type: "POST",
                           // url: '/sites/all/themes/mamamia/ajax/cart.php', 
                           url: '/cart/',
                            data: {thisQty:thisQty, thisId:thisId},
                            cache: false,
                            success: function(data) {
                                console.log(data);
                            }
                    });

            });
    */    }

        //Редактир-е корзины на странице доставки
        if(jQuery('.uc-cart-checkout-form').length) {  /*

            var i=1;
            var curQty = '';
            var priceItem = '';

            jQuery('.uc-cart-checkout-form tr').each(function() {
            jQuery(this).attr('id', 'qty_'+i);
            if(jQuery(this).find('td.qty').length) {

            //Текущее кол-во каждого товара
            curQty = parseInt(jQuery(this).find('td.qty').html());
            jQuery(this).find('.qty').html('<input type="text" class="qtyInt" value="'+curQty+'" onkeyup="validateInt(this)" name="newQty" id="check_'+i+'" />'); 

            //Поле для цены за ед-цу товара
            priceItem = parseInt(jQuery(this).find('td.price').find('.uc-price').html());
            jQuery(this).find('.price').prepend('<input type="hidden" class="priceItem" value="'+priceItem+'" id="price_'+i+'" />');
            }
            i++; 
            });



            // Пересчет цен
            jQuery('.qtyInt').live('keyup',function() {  
            var thSum = 0;

            var thId = parseInt(jQuery(this).attr('id').slice(6));    
            var thQty = parseInt(jQuery(this).val());
            if(isNaN(thQty)) {thQty=0;}

            //цена за ед-цу товара
            var thPr = jQuery('#price_'+thId).val();
            if(isNaN(thPr)) {thPr=0;}

            thSum = thQty*thPr;

            if(isNaN(thSum)) {thSum=0;}

            //console.log(thId+'#'+thQty+'#'+thPr+'#'+thSum);

            jQuery('#qty_'+thId+' .price'+' .uc-price').html(thSum+' Р');

            //Предварительная сумма:
            var subtotal = 0;
            jQuery('.uc-cart-checkout-form tr').each(function() {
            if(
            !jQuery(this).hasClass('subtotal')
            && !jQuery(this).hasClass('discount')
            && jQuery(this).find('td.price').length
            ) {
            subtotal += parseInt(jQuery(this).find('td.price').find('.uc-price').html());
            //console.log(parseInt(jQuery(this).find('td.price').find('.uc-price').html())); 
            }
            });

            if(isNaN(subtotal)) {subtotal=0;}

            jQuery('tr.subtotal .uc-price').html(subtotal+' Р');

            //Сумма с учетом скидки
            var orderDisc = parseInt(jQuery('tr.discount').eq(0).find('.uc-price').html());
            if(isNaN(orderDisc)) {orderDisc=0;}

            var orderPrice = subtotal*1+orderDisc;
            if(isNaN(orderPrice)) {orderPrice=0;}

            jQuery('tr.discount').eq(1).find('.uc-price').html(orderPrice+' Р'); 



            //Записываем данные в REQUEST

            //Количества
            var arQty=[];

            //Цены товаров
            var arPrices=[];

            jQuery('.uc-cart-checkout-form tr').each(function() {
            if(jQuery(this).find('.qtyInt').length) {
            //кол-во каждого товара
            arQty.push(parseInt(jQuery(this).find('.qtyInt').val()));
            }

            if(
            !jQuery(this).hasClass('subtotal')
            && !jQuery(this).hasClass('discount')
            && jQuery(this).find('td.price').length
            ) {

            //цена каждого товара
            arPrices.push(parseInt(jQuery(this).find('td.price').find('.uc-price').html()));
            }
            });

            $.ajax ({     
            type: "POST",
            url: '/sites/all/themes/mamamia/ajax/cart.php',
            data: {'arQty[]':arQty, 'arPrices[]':arPrices, discount:orderDisc},
            cache: false,
            success: function(data) {
            console.log(data);
            }
            });



            });   

            */}   


        //Окно при нажатии на справ. службу
        if(
            $('.top-left-block .delivery-bg').length 
            || $('.top-left-block .phone').length
        ) {
            $('.top-left-block .delivery-bg').click(function() {
                    jQuery('.darkBg').not('.phones').css('display', 'block');
            });

            $('.top-left-block .phone').click(function() {
                    jQuery('.darkBg').not('.phones').css('display', 'block');
            });

            //Закрываем окно
            jQuery('.modalClose').click(function(e) {
                    e.preventDefault();
                    jQuery('.darkBg').css('display', 'none'); 
            });

            jQuery('.modalLinks').eq(1).click(function(e) {
                    e.preventDefault();
                    jQuery('.darkBg').css('display', 'none'); 
            });



            jQuery('.modalLinks').eq(0).click(function() {
                    jQuery('.darkBg').css('display', 'none');

            });



            //закрытие формы по Esc
            jQuery('html').keydown(function(e){ 
                    if (e.keyCode == 27) { 
                        jQuery('.darkBg').css('display', 'none');
                    }
            });

        }


        // Проверяем раздел Напитки
        if(window.location.pathname.indexOf('napitki') + 1) {
            $('.goods-item').addClass('highest');
        }

        if($('.goods-item .image img').length) {
            $('.goods-item .image img').removeAttr('width');
            $('.goods-item .image img').removeAttr('height');
        }


        //Обнуляем кол-во пиццы и добавок после добавления в корзину

        // Цена и кол-во по умолч-ю

        jQuery('input[name="qty"]').val(0);
        jQuery('input[name="calcprice"]').val(0);

        jQuery('input[name=optionprice]').val(0);
        if(jQuery('.addtocart').length) {
            jQuery('.addtocart').click(function() {
                jQuery('.ingr-options input:checkbox').each(function() {
                    jQuery(this).removeAttr('checked');
                });
                jQuery('input[name=optionprice]').val(0);
                jQuery('input[name="qty"]').val(0);
                jQuery('input[name="calcprice"]').val(0); 
				console.log( 
					jQuery('input[name="calcprice"]').val(0)
				);
            });
        } 

        //Закрываем окно
        if($('.modalClose').length) {
            $('.modalClose').click(function(e) {
                    e.preventDefault();
                    $('.darkBg').css('display', 'none'); 
            });

            $('.modalLinks.snd').eq(0).click(function(e) {
                    e.preventDefault();
                    $('.darkBg').css('display', 'none'); 
            });


            //закрытие формы по Esc
            $('html').keydown(function(e){ 
                    if (e.keyCode == 27) { 
                        $('.darkBg').css('display', 'none');
                    }
            });
        }


        // Делаем кол-во пиццы = 1 при выборе добавок 
        jQuery('.qtyup').click(function() {

                if(jQuery(this).closest('form').find('.ingr').find('label').find('input:checkbox:checked').length > 0) {

                    if(parseInt(jQuery(this).siblings('input[name="qty"]').val())>1) {
                        jQuery(this).siblings('input[name="qty"]').val(1);

                        //Получаем цену

                        // Чекбоксы
                        var optionsPrice = 0;
                        jQuery(this).closest('form').find('.ingr').find('label').find('input:checkbox:checked').each(function() {
                                optionsPrice += parseInt($(this).attr('price')); 
                        });
                        //alert(optionsPrice);

                        // Размер
                        var sizePrice = 0;

                        jQuery(this).closest('form').find('.size').find('label').each(function() {
                                if(jQuery(this).hasClass('checked')) {
                                    arr = jQuery(this).find('input:radio').attr('onchange').split('changing(');
                                    arr2 = arr[1].split(',');
                                    sizePrice += parseInt(arr2[0]);
                                }                           
                        });

                        //Цена товара
                        itemPrice = parseInt(jQuery(this).closest('.goods-item').find('.price-hover').find('.uc-price').html());

                        allPrice = optionsPrice*1+sizePrice*1+itemPrice;
                        jQuery(this).closest('form').find('input[name="calcprice"]').val(allPrice);

                    }  

                }
				//console.log(jQuery(this).closest('form').find('.ingr').find('label').find('input:checkbox:checked').attr('price'));
        });

        /* Основной слайдер в шапке */
        $('.primary-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                fade: true,
                autoplay: true,
                autoplaySpeed: 2000,
                speed: 2000
        });


        /* фиксация меню меню */
        var bodyWidth = document.body.clientWidth;
		var indent = 710; /* отступ, при котором срабатывает фиксация */
        var panel=($(window).scrollTop()>indent)?$('#header-menu').addClass('hmenu-fixed'):$('#header-menu');
        window.onresize = function(){
			bodyWidth = document.body.clientWidth;
		}
		$(window).scroll(function(){
                if(bodyWidth>760){
					if($(this).scrollTop() > indent && !panel.hasClass('hmenu-fixed')){
						panel.addClass('hmenu-fixed');
					} else if($(this).scrollTop() <= indent && panel.hasClass('hmenu-fixed')){
						panel.removeClass('hmenu-fixed');
					}
					$('#header-menu').css("display","block");
					$('#content').css("padding-top","");
				}else{
					if($(this).scrollTop() > 50 && !panel.hasClass('hmenu-fixed')){
						$('#header-menu').css("display","none");
					}else{
						$('#header-menu').css("display","block");
					}
					if(document.getElementById("header-menu")){
						var paddingHeight = document.getElementById("header-menu").clientHeight;
						$('#content').css("transition","padding-top 1s ease");
						$('#content').css("padding-top",(100+paddingHeight)+"px");
					}else{
						$('#content').css("transition","padding-top 1s ease");
						$('#content').css("padding-top",100+"px");
					}
				}
		});
		if(document.body.scrollTop*1 > 50){
			setTimeout("if(document.getElementById('header-menu')){document.getElementById('header-menu').style.display='none'}", 1);
			$('#header-menu').css("display","none");
			panel.removeClass('hmenu-fixed');
		}
		if(window.location.pathname.match(/\/razdely-menyu\//gi)){
			//console.log()
		}


        /* фиксация правой колонки */
        var extra = $('#extra');
        var extra_indent = 750; /* отступ, при котором срабатывает фиксация */

        //Прокрутка до h1
        if ((window.location.pathname!='/') && ($('#wrapper').width() == 1280)) {
            $("html, body").animate({scrollTop:extra_indent},"slow");
        }

        var extra_panel=($(window).scrollTop()>extra_indent)?$(extra).addClass('extra-fixed'):$(extra);
        $(window).scroll(function(){
                if($(this).scrollTop() > extra_indent && !extra_panel.hasClass('extra-fixed')){
                    extra_panel.addClass('extra-fixed');
                } else if($(this).scrollTop() <= extra_indent && extra_panel.hasClass('extra-fixed')){
                    extra_panel.removeClass('extra-fixed');
        }});


        /* управление показом/скрытием добавок */
        var goods_items = $('.goods-item').has('.ingr'); /* ищем товары с добавками */
        goods_items.find('.ingr-btn').click(function(){ /* вешаем обработчик на кнопки добавок */
                /* ищем парную таблицу добавок и показываем/скрываем ее по нажатию кнопки */
                var goods_current = $(this).closest('.weight-ingr').siblings('.ingr-options');
                goods_current.slideToggle(0);
                /* скрываем добавки по нажатию кнопки заказа */
                $(this).closest('form').find('.buy-btn a').click(function(){
                        goods_current.css('display', 'none');
                });
                /* скрываем добавки по нажатию кнопки закрыть [x] */
                goods_current.find('.close').click(function(){
                        goods_current.css('display', 'none');
                });	
        });


        /* добавляем надпись 'календарь событий' в заголовок календаря событий */
        $('.content-body .view-calendar .view-header .date-heading h3').before('календарь событий');

        /* убираем ссылки с дней в календаре */
        $('.content-body .view-calendar table tr.date-box td a').removeAttr('href');

        /* ищем все ячейки таблицы с датами */
        /* и все строки таблицы с ячейками расписаний */
        var td_days = $('.content-body .view-calendar table tr.date-box td');
        var tr_events = $('.content-body .view-calendar table tr.single-day');

        /* показываем расписание при нажатии на соотв. день в календаре */
        /* в качестве ключа для сопоставления используется аттрибут data-date, присутствующий в обоих записях */
        td_days.each(function(indx){
                $(this).click(function(){
                        var day_index = 'td[data-date="' + $(this).attr('data-date') + '"]';
                        var this_day = tr_events.find(day_index);
                        if (this_day.find('> .inner > .item').is('.item')) {
                            $('.single-day').removeClass('visible');
                            this_day.addClass('visible');	
                        };
                });
        });

        /* добавляем иконку закрытия [x] на расписание и вешаем на нее скрипт-закрывашку */
        tr_events.find('td .inner .item:last-child').after('<div class="close">[ X ]</div>');
        tr_events.find('td .close').click(function(){
                console.log('click');
                $(this).closest('td.visible').removeClass('visible');
        });

        /* добавляем надпись 'календарь событий' в заголовок мини-календаря событий */
        /* НЕ ИСПОЛЬЗУЕТСЯ */
        $('#block-views-calendar-block-1 .view-calendar .view-header .date-heading h3').before('календарь событий');


        /* управление всплывающим сообщением 'Можете попробовать в нашем кафе' */ 
        /* ОТКЛЮЧЕНО */
        /*	
        var cafe_items = $('.goods-item').has('.cafe-only-popup'); // ищем товары с всплывахой
        cafe_items.find('.show-btn a').click(function(){ // вешаем обработчик на псевдокнопку заказа
        */	
        /* ищем парную всплываху и показываем ее по нажатию кнопки */
        /*		var cafe_current = $(this).closest('.goods-item').find('.cafe-only-popup');
        cafe_current.fadeIn(600).delay(3000).fadeOut(600); //показываем, ждем и скрываем
        });
        */	


        /* карусель на странице акций (новостей) - СТРАНИЦА ОТКЛЮЧЕНА */
        /*
        var news_img = $('body.page-news .news-big-image > .view-content');
        var news_thmb = $('body.page-news .news-navigation > .view-content');
        news_img.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: news_thmb,
        arrows: false,
        fade: true
        });
        news_thmb.slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: news_img,
        dots: false,
        centerMode: true,
        focusOnSelect: true
        });
        */

});


function calcweight(form) {
}

function calcprice(form) {

    var qty = form.elements.qty;
    var mainprice = form.elements.mainprice;
    if (typeof form.optionprice === 'undefined' || form.optionprice === null) {var optionprice = '0';}
    else {optionprice = (form.optionprice.value);}

    // alert(mainprice.value);
    // alert(form.sizeprice.value);
    var fullprice = +(mainprice.value) + +(form.sizeprice.value) + +(optionprice);
    jQuery(form).parent().find('.uc-price').text(fullprice + ' Р');
    form.calcprice.value = ( fullprice * +(qty.value) );
}
function clearIngrs(form) {
    jQuery(form).find('.ingr-options input:checked').removeAttr('checked');
    jQuery(form).find('input[name=optionprice]').val(0);
}
function calcprice_new(form) {
    var option = jQuery(form).find('input[name=options]:checked');
    var optionprice = 0;
    if (jQuery(option)[0]) {
        optionprice = +jQuery(option).attr('price');
    }
    var qty = +jQuery(form).find('input[name=qty]').val(); 
    var mainprice = +jQuery(form).find('input[name=mainprice]').val(); 

    jQuery(form).find('input[name=calcprice]').val( (mainprice + optionprice) * qty);
}


// При выборе размера:
function changing(price, element, thisweight) {
    var form = element.closest('form');
    //добавляем класс выбранному размеру (а сначала удаляем у кого есть)
    for (i=0; i < form.querySelectorAll('.checked').length; i++) { form.querySelectorAll('.checked')[i].classList.remove('checked'); }
    element.parentElement.classList.add('checked');
    var size = form.elements.size;
    var buynowlink = form.querySelector('.addtocart');
    // изменяем ссылку
    buynowlink.href = (buynowlink.href.replace(/a2o./, 'a2o'+size.value));
    // находим добавочную цену выбранного размера
    // 		for(var i = 0; i<size.length; i++) { if(size[i].checked) {var price = ((size[i]).getAttribute('price'));} }
    form.sizeprice.value = price;

    //подменяем вес значением из атрибута
    var weight = form.querySelector('.weight-attr span');
    weight.innerHTML = (thisweight);

    clearIngrs(form);
    calcprice(form);
    calcweight(form);
}

// При добавлении опций:
function addons(element) {
    var form = element.closest('form');
    var option = form.elements.options;
    var buynowlink = form.querySelector('.addtocart');
    var aid = form.elements.aid.value;
    var optionprice = 0;
    // находим добавочную цену выбранного размера
    for(var i = 0; i<option.length; i++) {
        if(option[i].checked) { //если галочка стоит
            optionprice = optionprice + +(option[i].getAttribute('price'));	//суммируем отмеченные 
            buynowlink.href = (buynowlink.href.replace('_a'+aid+'o'+option[i].value, '')); // удаляем имеющийся
            buynowlink.href = (buynowlink.href.replace('?', '_a'+aid+'o'+option[i].value+'?'));	// добавляем
        }
        else { //если галка не стоит
            buynowlink.href = (buynowlink.href.replace('_a'+aid+'o'+option[i].value, ''));	// удаляем
        }
        form.optionprice.value = optionprice;
    }
    calcprice(form);
}

// При добавлении опций для пиццы:
function addonsPizza(element) {
    var form = element.closest('form');
    var option = form.elements.options;
    var buynowlink = form.querySelector('.addtocart');
    var optionprice = 0;
    var qty = form.elements.qty;
    var aid = form.elements.aid.value;
    if (qty.value > 1) {
        qty.value = 1;
        buynowlink.href = (buynowlink.href.replace(/_q(\d)+/, '_q'+qty.value));
    }
    // находим добавочную цену выбранного размера
    for(var i = 0; i<option.length; i++) {
        if(option[i].checked) { //если галочка стоит
            optionprice = optionprice + +(option[i].getAttribute('price'));	//суммируем отмеченные
            buynowlink.href = (buynowlink.href.replace('_a'+aid+'o'+option[i].value, '')); // удаляем имеющийся
            buynowlink.href = (buynowlink.href.replace('?', '_a'+aid+'o'+option[i].value+'?'));	// добавляем
        }
        else { //если галка не стоит
            buynowlink.href = (buynowlink.href.replace('_a'+aid+'o'+option[i].value, ''));	// удаляем
        }
        form.optionprice.value = optionprice;
    }
    calcprice(form);
}

// При изменении радио-кнопок:
function addons_radio(element) {
    var form = jQuery(element).parents('form');
    var option = jQuery(form).find('input[name=options]:checked');
    var aid = jQuery(form).find('input[name=aid]').val();
    var optionprice = +jQuery(option).attr('price');
    var buynowlink = jQuery(form).find('.addtocart');
    jQuery(buynowlink).attr('href', jQuery(buynowlink).attr('href').replace(new RegExp("_a([0-9]+)o([0-9]+)", "g"), '')); // удаляем имеющийся
    //jQuery(buynowlink).attr('href', jQuery(buynowlink).attr('href').replace('_a'+aid+'o'+ jQuery(option).val(), '')); // удаляем имеющийся
    jQuery(buynowlink).attr('href', jQuery(buynowlink).attr('href').replace('?', '_a'+aid+'o'+ jQuery(option).val() +'?'));	// добавляем

    var qty = +jQuery(form).find('input[name=qty]').val(); 
    var mainprice = +jQuery(form).find('input[name=mainprice]').val(); 

    jQuery(form).find('input[name=calcprice]').val( (mainprice + optionprice) * qty);
}

// При выборе количества:
function quan(element) {
    var form = element.closest('form');
    var qty = form.elements.qty;
    var buynowlink = form.querySelector('.addtocart');
    buynowlink.href = (buynowlink.href.replace(/_q(\d)+/, '_q'+qty.value));
    calcprice(form);
}
// При выборе количества:
function quan_new(element) {
    var form = element.closest('form');
    var qty = form.elements.qty;
    var buynowlink = form.querySelector('.addtocart');
    buynowlink.href = (buynowlink.href.replace(/_q(\d)+/, '_q'+qty.value));
    calcprice_new(form);
}
// Для изменения количества
function qtydown(element) {
    var form = element.closest('form');
    var qty = form.elements.qty;
    if ((+(qty.value)) > 0) qty.value = +(qty.value)-1;
}
function qtyup(element) {
    var form = element.closest('form');
    var qty = form.elements.qty;
    qty.value = +(qty.value)+1;
}
/*function qtyup(element) {
var form = jQuery(element).closest('form');
var qty = jQuery(form).find('input[name=qty]');
var option = jQuery(form).find('input[type=checkbox][name=options]:checked');
if (jQuery(option)[0]) {
jQuery(qty).val(1);
}
else {
jQuery(qty).val(+jQuery(qty).val() + 1);
}
}*/

// Всплывающее окно выбора добавок —
// заменяем (+ и .) на <span></span> для "табличного" вида
window.onload = function() { //при загрузке страницы
    var labels = document.querySelectorAll('.view-taxonomy-term .ingr-options label'); //переменная labels — <label>
    for (i=0; i < labels.length; i++) {
        labels[i].innerHTML = (labels[i].innerHTML.replace('(+', '<span>'));
        labels[i].innerHTML = (labels[i].innerHTML.replace('.)', '.</span>'));
    }
};

jQuery(function(){
    jQuery('.menu-button').click(function(){
        jQuery('body').toggleClass('menu-open');
    });

    if (jQuery('#wrapper').width() <= 760) {
        jQuery('#footer').append('<div class="mobile-switch">Перейти на полную версию сайта</div>');
        jQuery('.mobile-switch').click(function(){
            document.cookie = "fullversion=1; path=/;"
            location.reload();
        });
    } else if (jQuery(window).width() <= 760) {
        jQuery('#footer').append('<div class="mobile-switch">Перейти на мобильную версию сайта</div>');
        jQuery('.mobile-switch').click(function(){
            document.cookie = "fullversion=1; path=/; expires=Thu, 02 Jan 1970 00:00:00 GMT"
            location.reload();
        });
    }

});


jQuery(function(){
	jQuery('.gal').eq(0).css({'background':'url("/sites/all/themes/mamamia/images/galka.png") no-repeat center center'}).addClass('actuality');
	jQuery('.gal').eq(0).parents('.block_gal').find('p').css('color','#3f8613');
	jQuery('.gal').click(function(){
		jQuery('.gal').css({'background':'#fff'}).removeClass('actuality');
		jQuery('.block_gal').find('p').css('color','#000');
		jQuery(this).css({'background':'url("/sites/all/themes/mamamia/images/galka.png") no-repeat center center'});
		jQuery(this).addClass('actuality');
		jQuery(this).parent('.block_gal').find('p').css('color','#3f8613');
		var temp = jQuery(this).parent('.block_gal').find('p').html();
		jQuery('.your_cafe').val(jQuery(this).parent('.block_gal').find('p').html());
		if (temp == 'Красноармейский пр-кт 17А'){
			jQuery('.your_sumail').val('ya.mama-m2016@yandex.ru');
		} else if (temp == 'Демонстрации 1А'){
			jQuery('.your_sumail').val('demonstraciy1a@mail.ru');
		} else {
			jQuery('.your_sumail').val('octoberskay16@mail.ru');
		}
	})
	
	jQuery('.sogl').click(function(){
		if (jQuery(this).hasClass("actuality") ) {
			jQuery(this).removeClass('actuality');
			jQuery(this).addClass('empty_field');
			jQuery('.your_soglas').val('');
			jQuery(this).css({'background':'#fff'});
		} else {
			jQuery(this).addClass('actuality');
			jQuery(this).removeClass('empty_field');
			jQuery('.your_soglas').val('Yes');
			jQuery(this).css({'background':'url("/sites/all/themes/mamamia/images/galka.png") no-repeat center center'});
		}
	})
	
	var ur = location.href;
	var url = 'http://'+location.hostname+'/online';
	if (ur == url){
		jQuery('#content-title').text('Оформить банкет со скидкой 5%');
	}
	
	jQuery('.y_h .opening').click(function(){
		jQuery('.res').hide(0);
		jQuery(this).parents('.timing').find('.res').toggle();
	})
	jQuery('.y_h .res > div').click(function(){
		jQuery('.y_h').children('span').html(jQuery(this).html());
		jQuery('.your_hours').val(jQuery(this).html());
		jQuery(this).parents('.timing').find('.res').toggle();
	})
	
	jQuery('.y_ms .opening').click(function(){
		jQuery('.res').hide(0);
		jQuery(this).parents('.timing').find('.res').toggle();
	})
	jQuery('.y_ms .res > div').click(function(){
		jQuery('.y_ms').children('span').html(jQuery(this).html());
		jQuery('.your_minutes').val(jQuery(this).html());
		jQuery(this).parents('.timing').find('.res').toggle();
	})
	
	jQuery('.y_d .opening').click(function(){
		jQuery('.res').hide(0);
		jQuery(this).parents('.datings').find('.res').toggle();
	})
	jQuery('.y_d .res').on('click', 'div', function(){
		jQuery('.y_d').children('span').html(jQuery(this).html());
		jQuery('.your_days').val(jQuery(this).html());
		jQuery(this).parents('.datings').find('.res').toggle();
	})
	jQuery('.y_m .opening').click(function(){
		jQuery('.res').hide(0);
		jQuery(this).parents('.datings').find('.res').toggle();
	})
	jQuery('.y_m .res > div').click(function(){
		jQuery('.y_m').children('span').html(jQuery(this).html());
		jQuery('.your_month').val(jQuery(this).html());
		jQuery(this).parents('.datings').find('.res').toggle();
		var temp = jQuery(this).html()
		if (temp == "Январь" || temp == "Март" || temp == "Май" || temp == "Июль" || temp == "Август" || temp == "Октябрь" || temp == "Декабрь"){
			if (jQuery('.y_d').find('.res').children('div').length <= 28){
				jQuery('.y_d').find('.res').append("<div>29</div><div>30</div><div>31</div>");
			} else if (jQuery('.y_d').find('.res').children('div').length <= 30){
				jQuery('.y_d').find('.res').append("<div>31</div>");
			}
			jQuery('.y_d').find('.res').children('div').show(0);
		} else if (temp == 'Апрель' || temp == 'Июнь' || temp == 'Сентябрь' || temp == 'Ноябрь'){
			jQuery('.y_d').find('.res').children('div:gt(29)').remove();
		} else {
			jQuery('.y_d').find('.res').children('div:gt(27)').remove();
		}
	})
	
	jQuery('.y_y .opening').click(function(){
		jQuery('.res').hide(0);
		jQuery(this).parents('.datings').find('.res').toggle();
	})
	jQuery('.y_y .res').on('click', 'div', function(){
		jQuery('.y_y').children('span').html(jQuery(this).html());
		jQuery('.your_years').val(jQuery(this).html());
		jQuery(this).parents('.datings').find('.res').toggle();
	})
	jQuery('.person_parent .opening').click(function(){
		jQuery('.res').hide(0);
		jQuery(this).parents('.person_parent').find('.res').toggle();
	})
	jQuery('.person_parent .res').on('click', 'div', function(){
		jQuery('.person_parent').find('span').html(jQuery(this).html());
		jQuery('.your_adults').val(jQuery(this).html());
		jQuery(this).parents('.person_parent').find('.res').toggle();
	})
	
	jQuery('.person_kids .opening').click(function(){
		jQuery('.res').hide(0);
		jQuery(this).parents('.person_kids').find('.res').toggle();
	})
	jQuery('.person_kids .res').on('click', 'div', function(){
		jQuery('.person_kids').find('span').html(jQuery(this).html());
		jQuery('.your_kids').val(jQuery(this).html());
		jQuery(this).parents('.person_kids').find('.res').toggle();
	})
	
})


jQuery(function() {

  jQuery('#zakaz_online').each(function(){
    // Объявляем переменные (форма и кнопка отправки)
	var form = jQuery(this),
        btn = form.find('.next_menus');

    // Добавляем каждому проверяемому полю, указание что поле пустое
	form.find('.text-bi').addClass('empty_field');

    // Функция проверки полей формы
    function checkInput(){
      form.find('.text_bi').each(function(){
        if(jQuery(this).val() != ''){
          // Если поле не пустое удаляем класс-указание
		jQuery(this).removeClass('empty_field');
        } else {
          // Если поле пустое добавляем класс-указание
		jQuery(this).addClass('empty_field');
        }
      });
    }

    // Функция подсветки незаполненных полей
    function lightEmpty(){
      form.find('.empty_field').css({'border-color':'#d8512d'});
      setTimeout(function(){
        form.find('.empty_field').removeAttr('style');
      },4000);
    }

    // Проверка в режиме реального времени
    setInterval(function(){
      // Запускаем функцию проверки полей на заполненность
	  checkInput();
      // Считаем к-во незаполненных полей
      var sizeEmpty = form.find('.empty_field').size();
      // Вешаем условие-тригер на кнопку отправки формы
      if(sizeEmpty > 0 && jQuery('.your_soglas').val() == ''){
        if(btn.hasClass('disabled')){
          return false
        } else {
          btn.addClass('disabled')
        }
      } else {
        btn.removeClass('disabled')
      }
    },500);

    // Событие клика по кнопке отправить
    btn.click(function(){
      if(jQuery(this).hasClass('disabled')){
        // подсвечиваем незаполненные поля и форму не отправляем, если есть незаполненные поля
		lightEmpty();
        return false
      } else {
        mm_name = jQuery('#user_name').val();
		mm_oth = jQuery('#user_oth').val();
		mm_fam = jQuery('#user_fam').val();
		mm_phone = jQuery('#user_phone').val();
		mm_comment = jQuery('#user_comment').val();
		mm_cafe = jQuery('.your_cafe').val();
		mm_adults = jQuery('.your_adults').val();
		mm_kids = jQuery('.your_kids').val();
		mm_days = jQuery('.your_days').val();
		mm_month = jQuery('.your_month').val();
		mm_years = jQuery('.your_years').val();
		mm_hours = jQuery('.your_hours').val();
		mm_minutes = jQuery('.your_minutes').val();
		mm_sumail = jQuery('.your_sumail').val();
		sessvars.myObj = {m_name: mm_name, m_oth: mm_oth, m_fam: mm_fam, m_phone: mm_phone, m_comment: mm_comment, m_cafe: mm_cafe, m_adults: mm_adults, m_kids: mm_kids, m_days: mm_days, m_month: mm_month, m_years: mm_years, m_hours: mm_hours, m_minutes: mm_minutes, m_sumail: mm_sumail, m_id: 1};
		sessvars.$.flush();
        form.submit();
      }
    });
  });
});

if ( '' != document.referrer ) { 
   var url = document.referrer;
   if (url == 'http://mamamia-pizza.ru/online'){
		
   }
   var url_n = location.href;
   url_new = url_n.split('/');
   if (url_new[3] == 'banketnoe-menyu' && sessvars.myObj.m_id == '1'){
	     jQuery(document).ready(function(){
			jQuery('#extra').find('#block-block-5 .content').hide(0);
			jQuery('.delivery-condition').hide(0);
			jQuery('.delivery-online').show(0).css('display','block');
			jQuery('.cart-block-checkout a').remove();
			jQuery('.gudvins').hide(0);
		})	 
   } else if (location.href == "http://mamamia-pizza.ru/checkout-banket" && sessvars.myObj.m_id == '1'){
	    jQuery(document).ready(function(){
			jQuery('.zakaz_itog').show(150);
			var sums = parseInt(sessvars.myObj.m_summary.replace(/\D+/g,""));
			skidka = sums - (sums * 0.05);
			jQuery('#POST_online_banket').find('.user_name_m').val(sessvars.myObj.m_name);
			jQuery('#POST_online_banket').find('.user_oth_m').val(sessvars.myObj.m_oth);
			jQuery('#POST_online_banket').find('.user_fam_m').val(sessvars.myObj.m_fam);
			jQuery('#POST_online_banket').find('.user_phone_m').val(sessvars.myObj.m_phone);
			jQuery('#POST_online_banket').find('.user_comment_m').val(sessvars.myObj.m_comment);
			jQuery('#POST_online_banket').find('.user_adults_m').val(sessvars.myObj.m_adults);
			jQuery('#POST_online_banket').find('.user_kids_m').val(sessvars.myObj.m_kids);
			jQuery('#POST_online_banket').find('.user_cafe_m').val(sessvars.myObj.m_cafe);
			jQuery('#POST_online_banket').find('.user_days_m').val(sessvars.myObj.m_days);
			jQuery('#POST_online_banket').find('.user_month_m').val(sessvars.myObj.m_month);
			jQuery('#POST_online_banket').find('.user_years_m').val(sessvars.myObj.m_years);
			jQuery('#POST_online_banket').find('.user_hours_m').val(sessvars.myObj.m_hours);
			jQuery('#POST_online_banket').find('.user_minutes_m').val(sessvars.myObj.m_minutes);
			jQuery('#POST_online_banket').find('.user_sumail_m').val(sessvars.myObj.m_sumail);
			jQuery('#POST_online_banket').find('.user_name_goods_m').val(sessvars.myObj.m_name_goods);
			jQuery('#POST_online_banket').find('.user_img_goods_m').val(sessvars.myObj.m_img_goods);
			jQuery('#POST_online_banket').find('.user_price_goods_m').val(sessvars.myObj.m_price_goods);
			jQuery('#POST_online_banket').find('.user_qu_goods_m').val(sessvars.myObj.m_qu_goods);
			jQuery('#POST_online_banket').find('.user_dob_goods_m').val(sessvars.myObj.m_dob_goods);
			jQuery('#POST_online_banket').find('.user_summary_m').val(sums);
			jQuery('#POST_online_banket').find('.user_skidka_m').val(skidka);
			jQuery('.zakaz_itog').find('.mesto').html(sessvars.myObj.m_cafe);
			jQuery('.zakaz_itog').find('.data').html(sessvars.myObj.m_days +'-'+ sessvars.myObj.m_month +'-'+ sessvars.myObj.m_years +'&nbsp'+ sessvars.myObj.m_hours +':'+ sessvars.myObj.m_minutes);
			jQuery('.zakaz_itog').find('.adults').html(sessvars.myObj.m_adults + ' чел.');
			jQuery('.zakaz_itog').find('.kids').html(sessvars.myObj.m_kids + ' чел.');
			var i = sessvars.myObj.m_name_goods.length;
			for (j = 0; j < i; j++){
				jQuery('.zakaz_itog').find('.bluda').html(jQuery('.zakaz_itog').find('.bluda').html() + '&nbsp;' + sessvars.myObj.m_name_goods[j] + ' x ' + sessvars.myObj.m_qu_goods[j] + 'шт.,');
			}
			//for (j = 1; j < i;j++){sessvars.myObj.m_name_goods[j] + sessvars.myObj.m_qu_goods+' x шт.';});
			jQuery('.zakaz_itog').find('.skidka').html(skidka + ' Руб.');
		})	
   } else {
	   jQuery(document).ready(function(){
		   jQuery('#extra').find('#block-block-5 .content').show(0);
		   jQuery('.delivery-condition').show(0);
		   jQuery('.delivery-online').hide(0);
		   jQuery('.gudvins').show(0);
		   sessvars.$.clearMem();
		   sessvars.myObj = {m_id: 0};
		   jQuery(document).ready(function(){
				jQuery('.block-uc-ajax-cart .content').prepend("<table class='cart_zakaz' style='width:100%'><tbody><tr class='cart-block-summary-links'><td colspan='2'><div class='item-list'><ul class='links'><li style='list-style-type:none;' class='cart-block-checkout last'><a href='/cart/checkout' rel='nofollow'>Доставить заказ</a></li></ul></div></td></tr></tbody></table>");
			})
	   })
   }
} else { 
   sessvars.$.clearMem();
   sessvars.myObj = {m_id: 0};
}

var img_goods = [];
var name_goods = [];
var price_goods = [];
var qu_goods = [];
var dob_goods = [];
var summary = 0;

function AjaxFormRequest(form_name,file_name,name_result){
	//jQuery("#" + form_name).submit(function(){return false;}); //Запрет отправки формы программно
	//jQuery('.delivery-online').click(function(){
		jQuery('.block-uc-ajax-cart .cart-info').each(function(i){
			img_goods[i] = jQuery.trim(jQuery(this).find('img').attr("src"));
			name_goods[i] = jQuery(this).find('p.title').html();
			price_goods[i] = jQuery.trim(jQuery(this).find('p.price').html());
			qu_goods[i] = jQuery.trim(jQuery(this).find('.quantity').val());
			dob_goods[i] = jQuery.trim(jQuery(this).find('.dobavki').text());
		});
		var summary = jQuery.trim(jQuery('.cart-block-summary-total').text());
		sessvars.myObj = {m_name: sessvars.myObj.m_name, m_oth: sessvars.myObj.m_oth, m_fam: sessvars.myObj.m_fam, m_phone: sessvars.myObj.m_phone, m_comment: sessvars.myObj.m_comment, m_cafe: sessvars.myObj.m_cafe, m_adults: sessvars.myObj.m_adults, m_kids: sessvars.myObj.m_kids, m_days: sessvars.myObj.m_days, m_month: sessvars.myObj.m_month, m_years: sessvars.myObj.m_years, m_hours: sessvars.myObj.m_hours, m_minutes: sessvars.myObj.m_minutes, m_sumail: sessvars.myObj.m_sumail, m_id: 1, m_dob_goods: dob_goods, m_qu_goods: qu_goods, m_price_goods: price_goods, m_img_goods: img_goods, m_name_goods: name_goods,m_summary: summary};
		sessvars.$.flush();
		var url = '/checkout-banket';
		setTimeout(function() {
			jQuery('#cart-block-contents-ajax').each(function(){
				jQuery(this).find('.cart-remove').children('a').trigger('click');
			}); //Чистим корзину
			jQuery(location).attr('href',url);
		}, 500);
	//})
	
	/*jQuery("#" + form_name).submit(function(){return false;}); //Запрет отправки формы программно
	jQuery.ajax({
		url:"/" + file_name, //Адрес файла обработчика php
		type:"POST", //Тип запроса
		dataType:"html", //Тип данных
		data: jQuery("#" + form_name).serialize(), 
		success: function(response) { //Если все нормально
			jQuery(".user_submit").val("Отправка");
			if (response = true){
				jQuery(".user_submit").attr('disabled','true');
				jQuery("#" + name_result).html("СПАСИБО ЗА ВАШ ЗАКАЗ! В БЛИЖАЙШЕЕ ВРЕМЯ С ВАМИ СВЯЖЕТСЯ АДМИНИСТРАТОР!");
			} else {
				jQuery("#" + name_result).html("Возникла проблема при отправке");
			}
			setTimeout(function() {
				jQuery("#" + form_name).trigger( 'reset' );
			}, 4000);
		},
		error: function() { //Если ошибка
			jQuery("#" + name_result).html("Ошибка отправки формы");
		}
	});*/
}
