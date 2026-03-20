<?php

function Factorial(int $number): ?int {
    if ($number == 0) {
        return 1;
    }
    else {
        return $number * Factorial($number - 1);
    }
}

function IsNumber(string $str){
    for ($i = 0; $i < strlen($str); $i++){
        if ($str[$i] < '0' || $str[$i] > '9'){
            return false;
        }
    }
    return true;
}

if (IsNumber((string)$_POST['number'])){
    $number = (int)$_POST['number'];
}else{
    $number = -1;
}

if ($number >= 0) {
    $factorial = Factorial($number);
    echo $factorial;
}
else {
    echo "The value should be positive";
}
echo "<br/>";