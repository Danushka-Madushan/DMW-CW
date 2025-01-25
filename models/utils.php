<?php
function customFormatPrice($number)
{
    $formatted = number_format($number, 2, '.', '');
    $length = strlen((string) intval($number));

    if ($length > 5) {
        $firstPart = substr($formatted, 0, $length - 5);
        $secondPart = substr($formatted, $length - 5);
        return $firstPart . ',' . $secondPart;
    }

    return $formatted;
}
?>
