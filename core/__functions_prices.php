<?
 //print write_price_in_words(5627.99);
 
  //цена прописью
  function write_price_in_words($price)
  {
    $price = number_format($price, 2, '.', '');
    $point = strpos($price, '.');
    //отдел€ем рубли от копеек
    if(!empty($point))
    {
      $rub = substr($price, 0, $point);
      $kop = substr($price, $point + 1);
    }
    //преобразуем рубли
    $str = write_number_in_words($rub) ;
    //пишем рублей(ь,€)
    $word = " гривень";
    //последнее число
    $last_digit = $rub[(strlen($rub) - 1)];
    //предпоследнее число
    $pred_last_digit = $rub[(strlen($rub) - 2)];
    if($last_digit == '1' && $pred_last_digit != '1')
      $word = " гривна";
    elseif(($last_digit == '2' || $last_digit == '3' || $last_digit == '4') && $pred_last_digit != '1')
      $word = " гривны";
    $str .= $word;
    //преобразуем копейки
    if(!empty($kop))
    {
 
      $str .= write_number_in_words($kop, 'femininum') ;
      //пишем копейка (и, ек)
      $word = " копеек";
      //последнее число
      $last_digit = $kop[(strlen($kop) - 1)];
      //предпоследнее число
      $pred_last_digit = $kop[(strlen($kop) - 2)];
      if($last_digit == '1' && $pred_last_digit != '1')
               $word = " копейка";
             elseif(($last_digit == '2' || $last_digit == '3' || $last_digit == '4') && $pred_last_digit != '1' )
               $word = " копейки";
      $str .= $word;
    }
    return $str;
  }
 
  //допустимый диапазон чисел 0 .. 999999
  //число прописью
  function write_number_in_words ($num, $genus = 'masculinum')
  {
    //разр€д: единицы, дес€тки, сотни, тыс€чи
    $cur_order = "единицы";
    $cur_thousands_order = "единицы";
    if($num == 0)
      return " 00";
    $num = strval($num);
    $limit = strlen($num) - 1;
    for($i = $limit; $i >= 0; $i--)
    {
      //тыс€чный разр€д
      if($cur_order == "тыс€чи")
      {
        //сотни
        if($cur_thousands_order == "сотни")
        {
          $str = write_units_hundreds($num[$i]).$str;
        }
        //дес€тки
        if($cur_thousands_order == "дес€тки")
        {
          $str = write_units_tens($num[$i], $next_digit).$str;
          $cur_thousands_order = "сотни";
          $next_digit = '';
        }
        //единицы
        if($cur_thousands_order == "единицы")
        {
          if($num[$i-1] == "1")
          {
            $next_digit = $num[$i];
            $str = " тыс€ч".$str;
          }
          else
            $str = write_units_thousands_units($num[$i]).$str;
          $cur_thousands_order = "дес€тки";
        }
      }
      //сотни
      if($cur_order == "сотни")
      {
        $str = write_units_hundreds($num[$i]).$str;
        $cur_order = "тыс€чи";
      }
      //дес€тки
      if($cur_order == "дес€тки")
      {
        $str = write_units_tens($num[$i], $next_digit).$str;
        $cur_order = "сотни";
        $next_digit = '';
      }
      //единицы
      if($cur_order == "единицы")
      {
        if($num[$i-1] == "1")
          $next_digit = $num[$i];
        else
          $str = write_units($num[$i], $genus);
        $cur_order = "дес€тки";
      }
    }
    return($str);
  }
 
    //принадлежит функции write_number_in_words
    //преобразует дес€тки
    function write_units_tens ($tens, $next_digit)
    {
      $tens .= $next_digit;
      if($tens == 2) $str_tens = " двадцать";
      if($tens == 3) $str_tens = " тридцать";
      if($tens == 4) $str_tens = " сорок";
      if($tens == 5) $str_tens = " п€тьдес€т";
      if($tens == 6) $str_tens = " шестьдес€т";
      if($tens == 7) $str_tens = " семьдес€т";
      if($tens == 8) $str_tens = " восемьдес€т";
      if($tens == 9) $str_tens = " дев€носто";
      if($tens == 10) $str_tens = " дес€ть";
      if($tens == 11) $str_tens = " одиннадцать";
      if($tens == 12) $str_tens = " двенадцать";
      if($tens == 13) $str_tens = " тринадцать";
      if($tens == 14) $str_tens = " четырнадцать";
      if($tens == 15) $str_tens = " п€тнадцать";
      if($tens == 16) $str_tens = " шестнадцать";
      if($tens == 17) $str_tens = " семнадцать";
      if($tens == 18) $str_tens = " восемнадцать";
      if($tens == 19) $str_tens = " дев€тнадцать";
      return($str_tens);
    }
 
    //принадлежит функции write_number_in_words
    //преобразует сотни
    function write_units_hundreds ($hundreds)
    {
      if($hundreds == 1) $str_hundreds = " сто";
      if($hundreds == 2) $str_hundreds = " двести";
      if($hundreds == 3) $str_hundreds = " триста";
      if($hundreds == 4) $str_hundreds = " четыреста";
      if($hundreds == 5) $str_hundreds = " п€тьсот";
      if($hundreds == 6) $str_hundreds = " шестьсот";
      if($hundreds == 7) $str_hundreds = " семьсот";
      if($hundreds == 8) $str_hundreds = " восемьсот";
      if($hundreds == 9) $str_hundreds = " дев€тьсот";
      return($str_hundreds);
    }
 
    //принадлежит функции write_number_in_words
    //преобразует единицы тыс€чного разр€да
    function write_units_thousands_units ($hundreds)
    {
      if($hundreds == 0) $str_hundreds = " тыс€ч";
      if($hundreds == 1) $str_hundreds = " одна тыс€ча";
      if($hundreds == 2) $str_hundreds = " две тыс€чи";
      if($hundreds == 3) $str_hundreds = " три тыс€чи";
      if($hundreds == 4) $str_hundreds = " четыре тыс€чи";
      if($hundreds == 5) $str_hundreds = " п€ть тыс€ч";
      if($hundreds == 6) $str_hundreds = " шесть тыс€ч";
      if($hundreds == 7) $str_hundreds = " семь тыс€ч";
      if($hundreds == 8) $str_hundreds = " восемь тыс€ч";
      if($hundreds == 9) $str_hundreds = " дев€ть тыс€ч";
      return($str_hundreds);
    }
 
    //принадлежит функции write_number_in_words
    //преобразует единицы
    function write_units ($units, $genus='masculinum')
    {
      if($genus == 'masculinum')
      {
         if($units == 1) $str_units = " одна";
               if($units == 2) $str_units = " две";
      }
      if($genus == 'femininum')
      {
         if($units == 1) $str_units = " одна";
               if($units == 2) $str_units = " две";
 
      }
      if($units == 3) $str_units = " три";
      if($units == 4) $str_units = " четыре";
      if($units == 5) $str_units = " п€ть";
      if($units == 6) $str_units = " шесть";
      if($units == 7) $str_units = " семь";
      if($units == 8) $str_units = " восемь";
      if($units == 9) $str_units = " дев€ть";
      return($str_units);
    }
 ?>