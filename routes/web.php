<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrawController;

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

Route::get('/', [CrawController::class, 'crawTheGioiDiDong']);
Route::get('/quanaothethao', [CrawController::class, 'crawQuanAoTheThao']);

Route::get('/hoanghamobile', [CrawController::class, 'crawTheGioiDiDong']);

