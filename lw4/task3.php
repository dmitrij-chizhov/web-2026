<?php

$zodiac = ["Aries", "Taurus", "Gemini", "Cancer", "Leo", "Virgo", "Libra", "Scorpio", "Sagittarius", "Capricorn", "Aquarius", "Pisces"];
$date = (string)$_POST['date'] . '.';
$year = 0;
$month = 0;
$day = 0;
$item = "";

for ($i = 0; $i < strlen($date); $i++){
    if ($date[$i] != '.') {
        $item = $item . $date[$i];
    }
    else {
        if ((int)$item > 31 || ($day && $month)){
            $year = (int)$item;
        }
        else if ($day) {
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
        $item = "";
    }
}

if ($day > 0 && $month > 0 && $year > 0) {
    if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 20)) {
        echo $zodiac[0] . "<br/>";
    }
    else if (($month == 4 && $day >= 21) || ($month == 5 && $day <= 20)) {
        echo $zodiac[1] . "<br/>";
    }
    else if (($month == 5 && $day >= 21) || ($month == 6 && $day <= 21)) {
        echo $zodiac[2] . "<br/>";
    }
    else if (($month == 6 && $day >= 22) || ($month == 7 && $day <= 22)) {
        echo $zodiac[3] . "<br/>";
    }
    else if (($month == 7 && $day >= 23) || ($month == 8 && $day <= 20)) {
        echo $zodiac[4] . "<br/>";
    }
    else if (($month == 8 && $day >= 24) || ($month == 9 && $day <= 23)) {
        echo $zodiac[5] . "<br/>";
    }
    else if (($month == 9 && $day >= 24) || ($month == 10 && $day <= 23)) {
        echo $zodiac[6] . "<br/>";
    }
    else if (($month == 10 && $day >= 24) || ($month == 11 && $day <= 22)) {
        echo $zodiac[7] . "<br/>";
    }
    else if (($month == 11 && $day >= 23) || ($month == 12 && $day <= 21)) {
        echo $zodiac[8] . "<br/>";
    }
    else if (($month == 12 && $day >= 22) || ($month == 1 && $day <= 20)) {
        echo $zodiac[9] . "<br/>";
    }
    else if (($month == 1 && $day >= 21) || ($month == 2 && $day <= 20)) {
        echo $zodiac[10] . "<br/>";
    }
    else if (($month == 2 && $day >= 21) || ($month == 3 && $day <= 20)) {
        echo $zodiac[11] . "<br/>";
    }
}
else {
    echo "Uncorrected data<br/>";
}

