<?php

function IsNumber(string $str){
    for ($i = 0; $i < strlen($str); $i++){
        if ($str[$i] < '0' || $str[$i] > '9'){
            return false;
        }
    }
    return true;
}

if (IsNumber((string)$_POST['number1']) && strlen((string)$_POST['number1']) == 6) {
    $number1 = (int)$_POST['number1'];
} else {
    $number1 = -1;
}

if (IsNumber((string)$_POST['number2']) && strlen((string)$_POST['number2']) == 6) {
    $number2 = (int)$_POST['number2'];
} else {
    $number2 = -1;
}

if ($number1 >= 0 && $number1 <= 999999 && $number2 >= 0 && $number2 <= 999999 && $number1 < $number2) {
    for ($i = $number1; $i < $number2; $i++) {
        $leftSide = (int)($i / 100000) + (int)($i / 10000) % 10 + (int)($i / 1000) % 10;
        $rightSide = (int)($i / 100) % 10 + (int)($i / 10) % 10 + $i % 10;
        if ($leftSide == $rightSide) {
            for ($j = 5; $j > 0; $j--) {
                if (pow(10, $j) > $i) {
                    echo '0';
                }
            }
            echo $i . "</br>";
        }
    }
}
else {
    echo "The values should be in the range from 000000 to 999999 and first number less than second number";
}
echo "<br/>";