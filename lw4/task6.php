<?php 

function splitTokens($string)
{
    $tokens = [];
    $current = "";

    for ($i = 0; $i < strlen($string); $i++) {
        $ch = $string[$i];

        if ($ch === ' ') {
            if ($current !== "") {
                $tokens[] = $current;
                $current = "";
            }
        } else {
            $current .= $ch;
        }
    }

    if ($current !== "") {
        $tokens[] = $current;
    }

    return $tokens;
}

function isNumber($n)
{
    for ($i = 0; $i < strlen($n); $i++) {
        if (!($n[$i] >= '0' && $n[$i] <= '9')) {
            return false;
        }
    }
    return true;
}

function calculateRPN($expr)
{
    $tokens = splitTokens($expr);

    $stack = [];
    $top = -1;

    for ($i = 0; $i < count($tokens); $i++) {
        $token = $tokens[$i];

        if (isNumber($token)) {
            $top++;
            $stack[$top] = (int)$token;
        } else {
            if ($top < 1) {
                return "Ошибка: некорректное выражение";
            }

            $b = $stack[$top];
            $top--;

            $a = $stack[$top];
            $top--;

            if ($token === '+') {
                $res = $a + $b;
            } elseif ($token === '-') {
                $res = $a - $b;
            } elseif ($token === '*') {
                $res = $a * $b;
            } else {
                return "Ошибка: неизвестный оператор";
            }

            $top++;
            $stack[$top] = $res;
        }
    }

    if ($top !== 0) {
        return "Ошибка: некорректное выражение";
    }

    return $stack[0];
}

$input = (string)$_POST["expression"];
$result = calculateRPN($input);

echo $result . '</br>';