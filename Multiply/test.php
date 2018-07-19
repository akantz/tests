<?php

/**
 * Складываем в столбик :)
 *
 * @param string $first
 * @param string $second
 * @return string
 */
function summ(string $first, string $second): string
{
    $firstLength = strlen($first);
    $secondLength = strlen($second);

    if ($firstLength > $secondLength) {
        $second = str_repeat('0', $firstLength - $secondLength) . $second;
        $secondLength = strlen($second);
    } else {
        $first = str_repeat('0', $secondLength - $firstLength) . $first;
    }

    $mem = 0;

    for ($i = $secondLength - 1; $i >= 0; $i--) {
        $mem += (int) $first[$i] + (int) $second[$i];
        $first[$i] = (string) ($mem % 10);
        $mem = (int) ($mem / 10);
    }

    if ($mem > 0) {
        $first = (string) $mem . $first;
    }

    return $first;
}

$num1 = '11230002288888833333341257098822341123111111231123567889099812312312';
$num2 = '129898677632111111222233333344444443488';

$result = summ($num1, $num2);

echo sprintf(
    "%s +\n%s \n=\n%s",
    $num1,
    $num2,
    $result
);

