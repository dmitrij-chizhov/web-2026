<?php

$year = (int)$_POST['year'];

if ($year >= 1 && $year <= 30000) {
    if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0)) {
        echo "YES<br/>";
    } 
    else {
        echo "NO<br/>";
    }
} 
else {
    echo "ERROR INPUT<br/>";
}
