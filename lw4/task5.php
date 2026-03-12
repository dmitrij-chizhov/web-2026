<?php

function Factorial(int $number): ?int {
    if ($number == 0) {
        return 1;
    }
    else {
        return $number * Factorial($number - 1);
    }
}


$number = (int)$_POST['number'];

if ($number >= 0) {
    $factorial = Factorial($number);
    echo $factorial . "<br/>";
}
else {
    echo "The value should be positive<br/>";
}

