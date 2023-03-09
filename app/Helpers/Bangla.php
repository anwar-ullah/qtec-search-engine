<?php
function banglaDate($date, $format = 'jS F Y'){
    if(!empty($date) && strtotime($date)){
        $date = new \EasyBanglaDate\Types\BnDateTime(date('Y-m-d H:i:s', strtotime($date)), new DateTimeZone('Asia/Dhaka'));
        return $date->format($format);
        return $date->format('l jS F Y b h:i:s');
    }

    return '';
}

function bdt($amount = 0){
    if((float)($amount) <= 0){
        return '';
    }

    $tmp = explode('.',$amount); // for float or double values
    $strMoney = "";
    $divide = 1000;
    $amount = $tmp[0];
    $strMoney .= str_pad($amount%$divide,3,'0',STR_PAD_LEFT);
    $amount = (int)($amount/$divide);
    while($amount>0)
    {
    $divide = 100;
    $strMoney = str_pad($amount%$divide, 2,'0',STR_PAD_LEFT).','.$strMoney;
    $amount = (int)($amount/$divide);
    }

    if(substr($strMoney, 0, 1) == '0')
    $strMoney = substr($strMoney,1);

    if(isset($tmp[1])) // if float and double add the decimal digits here.
    {
    return $strMoney.'.'.$tmp[1];
    }
    return $strMoney;
}

function bnNumberToWord($number){
	$number = bn2enNumber($number);

    $text = '';
    $count = 0;
    $slashes = explode('/', $number);
    foreach ($slashes as $key => $slash) {
        if(!empty($slash)){
            $count++;
            if($count > 1){
                $text .= ' বাই ';
            }
            if (is_numeric($slash)){
                if(strpos($slash, ".") !== false || strpos($slash, ".") !== false){
                    $slash = minMaxDecimal($slash, 2);
                }else{
                    $slash = (int)$slash;
                }

                if(isset(explode(".", $slash)[1])){
                    $dot = explode(".", $slash);
                    $text .= bn_numberSelector($dot[0]).' দশমিক '.bn_numToBnDecimal($dot[1]);
                }else{
                    $text .= bn_numberSelector($slash);
                }
            }
            
        }
    }

    return $text;

}

function bn_numToBn($number){
    $word = strtr($number,num_to_bd());
    return $word;
}

function bn_numToBnDecimal($number){
    $word = strtr($number,num_to_bn_decimal());
    return $word;
}

function bn_numberSelector($number){
    if($number > 9999999){
        return bn_crore($number);
    }elseif($number > 99999){
        return bn_lakh($number);
    }elseif($number > 999){
        return bn_thousand($number);
    }elseif($number > 99){
        return bn_hundred($number);
    }else{
        return bn_underHundred($number);
    }
}

function bn_underHundred($number){
    $number = ($number == 0)?'': bn_numToBn($number);
    return $number;
}

function bn_hundred($number){
    $a = (int)($number/100);
    $b = $number%100;
    $hundred = ($a == 0)?'': bn_numToBn($a).' '.hundred();
    return $hundred.' '.bn_underHundred($b);
}

function bn_thousand($number){
    $a = (int)($number/1000);
    $b = $number%1000;
    $thousand = ($a == 0)?'': bn_numToBn($a).' '.thousand();
    return $thousand.' '.bn_hundred($b);
}

function bn_lakh($number){
    $a = (int)($number/100000);
    $b = $number%100000;
    $lakh = ($a == 0)?'': bn_numToBn($a).' '.lakh();
    return $lakh.' '.bn_thousand($b);
}

function bn_crore($number){
    $a = (int)($number/10000000);
    $b = $number%10000000;
    $more_than_core = ($a>99)?bn_lakh($a):bn_numToBn($a);
    return $more_than_core.' '.crore().' '.bn_lakh($b);
}

function num_to_bd(){
	return array('1'=>'এক','2'=>'দুই','3'=>'তিন','4'=>'চার','5'=>'পাঁচ','6'=>'ছয়','7'=>'সাত','8'=>'আট', '9'=>'নয়','10'=>'দশ','11'=>'এগার','12'=>'বার','13'=>'তের','14'=>'চৌদ্দ','15'=>'পনের','16'=>'ষোল','17'=>'সতের','18'=>'আঠার','19'=>'ঊনিশ','20'=>'বিশ','21'=>'একুশ','22'=>'বাইশ','23'=>'তেইশ','24'=>'চব্বিশ','25'=>'পঁচিশ','26'=>'ছাব্বিশ','27'=>'সাতাশ','28'=>'আঠাশ','29'=>'ঊনত্রিশ','30'=>'ত্রিশ','31'=>'একত্রিশ','32'=>'বত্রিশ','33'=>'তেত্রিশ','34'=>'চৌত্রিশ','35'=>'পঁয়ত্রিশ','36'=>'ছত্রিশ','37'=>'সাঁইত্রিশ','38'=>'আটত্রিশ','39'=>'ঊনচল্লিশ','40'=>'চল্লিশ','41'=>'একচল্লিশ','42'=>'বিয়াল্লিশ','43'=>'তেতাল্লিশ','44'=>'চুয়াল্লিশ','45'=>'পঁয়তাল্লিশ','46'=>'ছেচল্লিশ','47'=>'সাতচল্লিশ','48'=>'আটচল্লিশ','49'=>'ঊনপঞ্চাশ','50'=>'পঞ্চাশ','51'=>'একান্ন','52'=>'বায়ান্ন','53'=>'তিপ্পান্ন','54'=>'চুয়ান্ন','55'=>'পঞ্চান্ন','56'=>'ছাপ্পান্ন','57'=>'সাতান্ন','58'=>'আটান্ন','59'=>'ঊনষাট','60'=>'ষাট','61'=>'একষট্টি','62'=>'বাষট্টি','63'=>'তেষট্টি','64'=>'চৌষট্টি','65'=>'পঁয়ষট্টি','66'=>'ছেষট্টি','67'=>'সাতষট্টি','68'=>'আটষট্টি','69'=>'ঊনসত্তর','70'=>'সত্তর','71'=>'একাত্তর','72'=>'বাহাত্তর','73'=>'তিয়াত্তর','74'=>'চুয়াত্তর','75'=>'পঁচাত্তর','76'=>'ছিয়াত্তর','77'=>'সাতাত্তর','78'=>'আটাত্তর','79'=>'ঊনআশি','80'=>'আশি','81'=>'একাশি','82'=>'বিরাশি','83'=>'তিরাশি','84'=>'চুরাশি','85'=>'পঁচাশি','86'=>'ছিয়াশি','87'=>'সাতাশি','88'=>'আটাশি','89'=>'ঊননব্বই','90'=>'নব্বই','91'=>'একানব্বই','92'=>'বিরানব্বই','93'=>'তিরানব্বই','94'=>'চুরানব্বই','95'=>'পঁচানব্বই','96'=>'ছিয়ানব্বই','97'=>'সাতানব্বই','98'=>'আটানব্বই','99'=>'নিরানব্বই');
}

function num_to_bn_decimal(){
	return array('0'=>'শূন্য ','1'=>'এক ','2'=>'দুই ','3'=>'তিন ','4'=>'চার ','5'=>'পাঁচ ','6'=>'ছয় ','7'=>'সাত ','8'=>'আট ', '9'=>'নয় ');
}

function hundred(){
	return 'শত';
}

function thousand(){
	return 'হাজার';
}

function lakh(){
	return 'লক্ষ';
}

function crore(){
	return 'কোটি';
}