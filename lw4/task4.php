<?php

$number1 = (int)$_POST['number1'];
$number2 = (int)$_POST['number2'];

if ($number1 > 0 && $number1 <= 999999 && $number2 > 0 && $number2 <= 999999) {
    for ($i = $number1; $i < $number2; $i++) {
        $leftSide = (int)($i / 100000) + (int)($i / 10000) % 10 + (int)($i / 1000) % 10;
        $rightSide = (int)($i / 100) % 10 + (int)($i / 10) % 10 + $i % 10;
        if ($leftSide == $rightSide) {
            echo $i . "<br/>";
        }
    }
}
else {
    echo "The values should be in the range from 0 to 999999<br/>";
}