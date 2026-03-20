<?php

function IsNumber(string $str){
    for ($i = 0; $i < strlen($str); $i++){
        if ($str[$i] < '0' || $str[$i] > '9'){
            return false;
        }
    }
    return true;
}

if ((string)$_POST['digit']) {
    $digit = (int)$_POST['digit'];
} else {
    $digit = -1;
}


switch ($digit) {
    case 0:
        echo "Zero";
        break;
    case 1:
        echo "One";
        break;
    case 2:
        echo "Two";
        break;
    case 3:
        echo "Three";
        break;
    case 4:
        echo "Four";
        break;
    case 5:
        echo "Five";
        break;
    case 6:
        echo "Six";
        break;
    case 7:
        echo "Seven";
        break;
    case 8:
        echo "Eight";
        break;
    case 9:
        echo "Nine";
        break;
    default:
        echo "Unknown";
}
echo "<br/>";