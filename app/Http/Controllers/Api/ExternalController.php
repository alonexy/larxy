<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Overtrue\ChineseCalendar\Calendar;

class ExternalController extends Controller
{
    public function test()
    {
        $calendar = new Calendar();

        $result = $calendar->solar(1994, 10, 12); // 阳历
        dump($result);
        $dd = $calendar->lunar(2018,$result['lunar_month'], $result['lunar_day']);
        dump($dd);
    }
}
