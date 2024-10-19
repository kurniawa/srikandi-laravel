<?php
function my_decimal_format($number) {
    if (is_string($number)) {
        $number = (float)$number;
    }

    // dump($number + 0);
    $number_divided_by_100 = ($number / 100) + 0;
    $str_devided = (string)$number_divided_by_100;
    $formatted_number = number_format($str_devided, 2, ',', '.');
    $exploded_number = explode(",", $formatted_number);

    if ( (int)$exploded_number[1] === 0 ) {
        $formatted_number = number_format($str_devided, 0, ',', '.') . ",-";
    } else {
        if (strlen($exploded_number[1]) === 1) {
            $formatted_number = "$exploded_number[0],$exploded_number[1]0";
        } else {
            $formatted_number = "$exploded_number[0],$exploded_number[1]";
        }
    }

    // dump($formatted_number);

    return $formatted_number;
}

function casual_decimal_format($number) {
    if (is_string($number)) {
        $number = (float)$number;
    }

    // dump($number + 0);
    $number_divided_by_100 = ($number / 100) + 0;
    // dump($number_divided_by_100);
    $str_number = (string)$number_divided_by_100;
    // dump($str_number);
    // $formatted_number = number_format($str_number, 2, ',', '.');
    // $exploded_number = explode(",", $formatted_number);
    $formatted_number = number_format($str_number, 2, ',', '.');
    // dump($formatted_number);
    if (str_contains($formatted_number, ',')) {
        $exploded_number = explode(",", $formatted_number);
        
        // dump((int)$exploded_number[1]);
        if ( (int)$exploded_number[1] === 0 ) {
            $formatted_number = number_format($str_number, 0, ',', '.');
            // echo($formatted_number);
        } elseif (substr($exploded_number[1], -1) == '0') {
            $exploded_number[1] = str_replace('0', '', $exploded_number[1]);
            $formatted_number = "$exploded_number[0],$exploded_number[1]";
        # code...
        } else {
            $formatted_number = "$exploded_number[0],$exploded_number[1]";
        }
    }

    // dd($exploded_number);

    // dump($formatted_number);

    return $formatted_number;
}

function pangkas_string_25($str_value) {
    $str_formatted = $str_value;
    if (strlen($str_value) > 25) {
        $str_formatted = substr($str_value, 0, 25) . "...";
    }

    return $str_formatted;
}
?>
