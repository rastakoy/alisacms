<?
 //print write_price_in_words(5627.99);
 
  //���� ��������
  function write_price_in_words($price)
  {
    $price = number_format($price, 2, '.', '');
    $point = strpos($price, '.');
    //�������� ����� �� ������
    if(!empty($point))
    {
      $rub = substr($price, 0, $point);
      $kop = substr($price, $point + 1);
    }
    //����������� �����
    $str = write_number_in_words($rub) ;
    //����� ������(�,�)
    $word = " �������";
    //��������� �����
    $last_digit = $rub[(strlen($rub) - 1)];
    //������������� �����
    $pred_last_digit = $rub[(strlen($rub) - 2)];
    if($last_digit == '1' && $pred_last_digit != '1')
      $word = " ������";
    elseif(($last_digit == '2' || $last_digit == '3' || $last_digit == '4') && $pred_last_digit != '1')
      $word = " ������";
    $str .= $word;
    //����������� �������
    if(!empty($kop))
    {
 
      $str .= write_number_in_words($kop, 'femininum') ;
      //����� ������� (�, ��)
      $word = " ������";
      //��������� �����
      $last_digit = $kop[(strlen($kop) - 1)];
      //������������� �����
      $pred_last_digit = $kop[(strlen($kop) - 2)];
      if($last_digit == '1' && $pred_last_digit != '1')
               $word = " �������";
             elseif(($last_digit == '2' || $last_digit == '3' || $last_digit == '4') && $pred_last_digit != '1' )
               $word = " �������";
      $str .= $word;
    }
    return $str;
  }
 
  //���������� �������� ����� 0 .. 999999
  //����� ��������
  function write_number_in_words ($num, $genus = 'masculinum')
  {
    //������: �������, �������, �����, ������
    $cur_order = "�������";
    $cur_thousands_order = "�������";
    if($num == 0)
      return " 00";
    $num = strval($num);
    $limit = strlen($num) - 1;
    for($i = $limit; $i >= 0; $i--)
    {
      //�������� ������
      if($cur_order == "������")
      {
        //�����
        if($cur_thousands_order == "�����")
        {
          $str = write_units_hundreds($num[$i]).$str;
        }
        //�������
        if($cur_thousands_order == "�������")
        {
          $str = write_units_tens($num[$i], $next_digit).$str;
          $cur_thousands_order = "�����";
          $next_digit = '';
        }
        //�������
        if($cur_thousands_order == "�������")
        {
          if($num[$i-1] == "1")
          {
            $next_digit = $num[$i];
            $str = " �����".$str;
          }
          else
            $str = write_units_thousands_units($num[$i]).$str;
          $cur_thousands_order = "�������";
        }
      }
      //�����
      if($cur_order == "�����")
      {
        $str = write_units_hundreds($num[$i]).$str;
        $cur_order = "������";
      }
      //�������
      if($cur_order == "�������")
      {
        $str = write_units_tens($num[$i], $next_digit).$str;
        $cur_order = "�����";
        $next_digit = '';
      }
      //�������
      if($cur_order == "�������")
      {
        if($num[$i-1] == "1")
          $next_digit = $num[$i];
        else
          $str = write_units($num[$i], $genus);
        $cur_order = "�������";
      }
    }
    return($str);
  }
 
    //����������� ������� write_number_in_words
    //����������� �������
    function write_units_tens ($tens, $next_digit)
    {
      $tens .= $next_digit;
      if($tens == 2) $str_tens = " ��������";
      if($tens == 3) $str_tens = " ��������";
      if($tens == 4) $str_tens = " �����";
      if($tens == 5) $str_tens = " ���������";
      if($tens == 6) $str_tens = " ����������";
      if($tens == 7) $str_tens = " ���������";
      if($tens == 8) $str_tens = " �����������";
      if($tens == 9) $str_tens = " ���������";
      if($tens == 10) $str_tens = " ������";
      if($tens == 11) $str_tens = " �����������";
      if($tens == 12) $str_tens = " ����������";
      if($tens == 13) $str_tens = " ����������";
      if($tens == 14) $str_tens = " ������������";
      if($tens == 15) $str_tens = " ����������";
      if($tens == 16) $str_tens = " �����������";
      if($tens == 17) $str_tens = " ����������";
      if($tens == 18) $str_tens = " ������������";
      if($tens == 19) $str_tens = " ������������";
      return($str_tens);
    }
 
    //����������� ������� write_number_in_words
    //����������� �����
    function write_units_hundreds ($hundreds)
    {
      if($hundreds == 1) $str_hundreds = " ���";
      if($hundreds == 2) $str_hundreds = " ������";
      if($hundreds == 3) $str_hundreds = " ������";
      if($hundreds == 4) $str_hundreds = " ���������";
      if($hundreds == 5) $str_hundreds = " �������";
      if($hundreds == 6) $str_hundreds = " ��������";
      if($hundreds == 7) $str_hundreds = " �������";
      if($hundreds == 8) $str_hundreds = " ���������";
      if($hundreds == 9) $str_hundreds = " ���������";
      return($str_hundreds);
    }
 
    //����������� ������� write_number_in_words
    //����������� ������� ��������� �������
    function write_units_thousands_units ($hundreds)
    {
      if($hundreds == 0) $str_hundreds = " �����";
      if($hundreds == 1) $str_hundreds = " ���� ������";
      if($hundreds == 2) $str_hundreds = " ��� ������";
      if($hundreds == 3) $str_hundreds = " ��� ������";
      if($hundreds == 4) $str_hundreds = " ������ ������";
      if($hundreds == 5) $str_hundreds = " ���� �����";
      if($hundreds == 6) $str_hundreds = " ����� �����";
      if($hundreds == 7) $str_hundreds = " ���� �����";
      if($hundreds == 8) $str_hundreds = " ������ �����";
      if($hundreds == 9) $str_hundreds = " ������ �����";
      return($str_hundreds);
    }
 
    //����������� ������� write_number_in_words
    //����������� �������
    function write_units ($units, $genus='masculinum')
    {
      if($genus == 'masculinum')
      {
         if($units == 1) $str_units = " ����";
               if($units == 2) $str_units = " ���";
      }
      if($genus == 'femininum')
      {
         if($units == 1) $str_units = " ����";
               if($units == 2) $str_units = " ���";
 
      }
      if($units == 3) $str_units = " ���";
      if($units == 4) $str_units = " ������";
      if($units == 5) $str_units = " ����";
      if($units == 6) $str_units = " �����";
      if($units == 7) $str_units = " ����";
      if($units == 8) $str_units = " ������";
      if($units == 9) $str_units = " ������";
      return($str_units);
    }
 ?>