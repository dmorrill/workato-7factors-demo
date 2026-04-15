<?php

use App\Data\Factors;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/campaign', function () {
    return view('campaign');
});

Route::get('/factor/{number}', function (int $number) {
    $factors = Factors::all();

    if (!isset($factors[$number])) {
        abort(404);
    }

    return view('factor', [
        'factor' => $factors[$number],
        'number' => $number,
        'allFactors' => $factors,
    ]);
})->where('number', '[1-7]');
