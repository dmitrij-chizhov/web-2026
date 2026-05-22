<?php

function isNumber(string $str) {
    for ($i = 0; isset($str[$i]); $i++) {
        if ($str[$i] < "0" || $str[$i] > "9") {
            return false;
        }
    }
    return true;
}

function toLower(string $str) {
    $map = [
        "А" => "а", "Б" => "б", "В" => "в", "Г" => "г", "Д" => "д", "Е" => "е", "Ё" => "ё",
        "Ж" => "ж", "З" => "з", "И" => "и", "Й" => "й", "К" => "к", "Л" => "л", "М" => "м",
        "Н" => "н", "О" => "о", "П" => "п", "Р" => "р", "С" => "с", "Т" => "т", "У" => "у",
        "Ф" => "ф", "Х" => "х", "Ц" => "ц", "Ч" => "ч", "Ш" => "ш", "Щ" => "щ", "Ъ" => "ъ",
        "Ы" => "ы", "Ь" => "ь", "Э" => "э", "Ю" => "ю", "Я" => "я",
        
        "A" => "a", "B" => "b", "C" => "c", "D" => "d", "E" => "e", "F" => "f", "G" => "g",
        "H" => "h", "I" => "i", "J" => "j", "K" => "k", "L" => "l", "M" => "m", "N" => "n",
        "O" => "o", "P" => "p", "Q" => "q", "R" => "r", "S" => "s", "T" => "t", "U" => "u",
        "V" => "v", "W" => "w", "X" => "x", "Y" => "y", "Z" => "z"
    ];

    $lower = "";

    for ($i = 0; isset($str[$i]); $i++) {
        if (isset($str[$i + 1])) {
            $twoBytes = $str[$i] . $str[$i+1];
            if (isset($map[$twoBytes])) {
                $lower .= $map[$twoBytes];
                $i++; 
                continue;
            }
        }

        if (isset($map[$str[$i]])) {
            $lower .= $map[$str[$i]];
        } else {
            $lower .= $str[$i];
        }
    }

    return $lower;
}

function TXTToMonth(string $strIn) {
    $str = toLower($strIn);
    if ($str === "янв" || $str === "jan") {
        return 1;
    } elseif ($str === "фев" || $str === "feb") {
        return 2;
    } elseif ($str === "мар" || $str === "mar") {
        return 3;
    } elseif ($str === "апр" || $str === "apr") {
        return 4;
    } elseif ($str === "май" || $str === "may") {
        return 5;
    } elseif ($str === "июн" || $str === "jun") {
        return 6;
    } elseif ($str === "июл" || $str === "jul") {
        return 7;
    } elseif ($str === "авг" || $str === "aug") {
        return 8;
    } elseif ($str === "сен" || $str === "sep") {
        return 9;
    } elseif ($str === "окт" || $str === "oct") {
        return 10;
    } elseif ($str === "ноя" || $str === "nov") {
        return 11;
    } elseif ($str === "дек" || $str === "dec") {
        return 12;
    } else {
        return 0;
    }
}

$dayOfMonths = [
    0 => 0,
    1 => 31,   
    2 => 29,   
    3 => 31,   
    4 => 30,   
    5 => 31,   
    6 => 30,   
    7 => 31,   
    8 => 31,   
    9 => 30,   
    10 => 31,  
    11 => 30,  
    12 => 31   
];
$zodiac = ["Овен", "Телец", "Близнецы", "Рак", "Лев", "Дева", "Весы", "Скорпион", "Стрелец", "Козерог", "Водолей", "Рыбы"];
$date = (string)$_POST["date"] . ".";
$year = 0;
$month = 0;
$day = 0;
$item = "";

for ($i = 0; isset($date[$i]); $i++) {
    if ($date[$i] != "." && $date[$i] != "-" && $date[$i] != "/" && $date[$i] != " ") {
        $item = $item . $date[$i];
    }
    elseif ($item !== "") {
        if (isNumber($item)) {
            if ((int)$item > 31 || ($day && $month)) {
                $year = (int)$item;
            }
            elseif ($day) {
                if ((int)$item > 12) {
                    $month = $day;
                    $day = (int)$item;
                }
                else {
                    $month = (int)$item;
                }
            }
            else {
                $day = (int)$item;
            }
        } 
        else {
            $month = TXTToMonth($item);
        }
        
        $item = "";
    }
}

if ($month == 2) {
    if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0)) {
        if ($day > 29) {
            $day = -1;
        }
    } else {
        if ($day > 28) {
            $day = -1;
        }
    }
}

if ($day > 0 && $day <= $dayOfMonths[$month] && $month > 0 && $month <= 12 && $year > 0) {
    if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 20)) {
        echo $zodiac[0];
    }
    else if (($month == 4 && $day >= 21) || ($month == 5 && $day <= 20)) {
        echo $zodiac[1];
    }
    else if (($month == 5 && $day >= 21) || ($month == 6 && $day <= 21)) {
        echo $zodiac[2];
    }
    else if (($month == 6 && $day >= 22) || ($month == 7 && $day <= 22)) {
        echo $zodiac[3];
    }
    else if (($month == 7 && $day >= 23) || ($month == 8 && $day <= 23)) {
        echo $zodiac[4];
    }
    else if (($month == 8 && $day >= 24) || ($month == 9 && $day <= 23)) {
        echo $zodiac[5];
    }
    else if (($month == 9 && $day >= 24) || ($month == 10 && $day <= 23)) {
        echo $zodiac[6];
    }
    else if (($month == 10 && $day >= 24) || ($month == 11 && $day <= 22)) {
        echo $zodiac[7];
    }
    else if (($month == 11 && $day >= 23) || ($month == 12 && $day <= 21)) {
        echo $zodiac[8];
    }
    else if (($month == 12 && $day >= 22) || ($month == 1 && $day <= 20)) {
        echo $zodiac[9];
    }
    else if (($month == 1 && $day >= 21) || ($month == 2 && $day <= 20)) {
        echo $zodiac[10];
    }
    else if (($month == 2 && $day >= 21) || ($month == 3 && $day <= 20)) {
        echo $zodiac[11];
    }  
}
else {
    echo "Uncorrected data";
}
echo "<br/>";