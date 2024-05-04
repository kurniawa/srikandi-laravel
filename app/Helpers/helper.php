<?php
function my_decimal_format($number) {
    if (is_string($number)) {
        $number = (float)$number;
    }

    // dump($number);
    $formatted_number = ($number / 100) + 0;
    // dump($formatted_number);
    // dump(is_float($formatted_number));

    if (!is_float($formatted_number)) {
        $formatted_number = number_format($formatted_number, 0, ',', '.') . ",-";
    } else {
        // dump('is float');
        $formatted_number = number_format($formatted_number, 2, ',', '.');
        // dump($formatted_number);
        $exploded_number = explode(",", $formatted_number);
        if (strlen($exploded_number[1]) === 1) {
            $formatted_number = "$exploded_number[0],$exploded_number[1]0";
        } else {
            $formatted_number = "$exploded_number[0],$exploded_number[1]";
        }
    }

    // dump($formatted_number);

    return $formatted_number;
}
?>
