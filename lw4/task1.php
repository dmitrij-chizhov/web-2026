<?php

function IsNumber(string $str){
    for ($i = 0; $i < strlen($str); $i++){
        if ($str[$i] < '0' || $str[$i] > '9'){
            return false;
        }
    }
    return true;
}

if (IsNumber((string)$_POST['year'])) {
    $year = (int)$_POST['year'];
} else {
    $year = -1;
}

if ($year >= 1 && $year <= 30000) {
    if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0)) {
        echo "YES";
    } 
    else {
        echo "NO";
    }
} 
else {
    echo "ERROR INPUT";
}
echo "<br/>";