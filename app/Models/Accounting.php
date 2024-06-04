<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    static function simple_time_key($time_key) {
        $day = (int)date("d", $time_key);
        $month = (int)date("m", $time_key);
        $year = (int)date("Y", $time_key);
        $faktor_bagi = $day + $month + $year;
        $simple_time_key = (int)($time_key / $faktor_bagi);

        return $simple_time_key;
    }
}
