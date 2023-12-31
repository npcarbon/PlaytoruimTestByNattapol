<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('coupon', [CampaignsController::class, 'Coupon'])->name('coupon');

Route::get('ontop', [CampaignsController::class, 'Ontop'])->name('ontop');

Route::get('seasonal', [CampaignsController::class, 'Seasonal'])->name('seasonal');
