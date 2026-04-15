<?php

use App\Data\Factors;
use App\Http\Controllers\CampaignMakerController;
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

// Campaign Maker — internal tool
Route::prefix('make')->name('make.')->group(function () {
    Route::get('/',          [CampaignMakerController::class, 'index'])->name('index');
    Route::get('/new',       [CampaignMakerController::class, 'create'])->name('create');
    Route::post('/',         [CampaignMakerController::class, 'store'])->name('store');
    Route::get('/{campaign}',                            [CampaignMakerController::class, 'show'])->name('show');
    Route::post('/{campaign}/publish',                   [CampaignMakerController::class, 'publish'])->name('publish');
    Route::patch('/{campaign}/packages/{package}',       [CampaignMakerController::class, 'updatePackage'])->name('package');
});

// Generated pages — live at clean URLs (must be last to not shadow existing routes)
Route::get('/generated/{slug}',          [CampaignMakerController::class, 'landingPage'])->name('generated.landing');
Route::get('/generated/{slug}/campaign', [CampaignMakerController::class, 'campaignPage'])->name('generated.campaign');
