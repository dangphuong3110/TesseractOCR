<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesseractOCRController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('ocr.index');
});

Route::get('/ocr/convert-image-to-text', [TesseractOCRController::class, 'index'])->name('ocr.index');
Route::post('/ocr/convert-image-to-text', [TesseractOCRController::class, 'processImage'])->name('ocr.processImage');

Route::get('/{any}', function () {
    return view('error.blade.php.error.blade.php');
})->where('any', '.*');
