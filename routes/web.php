<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Http\Controllers\WebinarController;

Route::resource('webinars', WebinarController::class);
Route::get('/webinars/{id}/create-gotowebinar', [WebinarController::class, 'createGotoWebinar'])->name('webinars.create_goto_webinar');
Route::get('/webinars/get-all-gotowebinars', [WebinarController::class, 'getAllGotoWebinars'])->name('webinars.get_all_goto_webinars');
