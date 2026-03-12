<?php

$digit = (int)$_POST['digit'];

switch ($digit) {
    case 0:
        echo "Zero<br/>";
        break;
    case 1:
        echo "One<br/>";
        break;
    case 2:
        echo "Two<br/>";
        break;
    case 3:
        echo "Three<br/>";
        break;
    case 4:
        echo "Four<br/>";
        break;
    case 5:
        echo "Five<br/>";
        break;
    case 6:
        echo "Six<br/>";
        break;
    case 7:
        echo "Seven<br/>";
        break;
    case 8:
        echo "Eight<br/>";
        break;
    case 9:
        echo "Nine<br/>";
        break;
    default:
        echo "Unknown<br/>";
}