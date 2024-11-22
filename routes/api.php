<?php

use App\Http\Controllers\WebinarController;

use Illuminate\Support\Facades\Route;

Route::post('/organizers/{organizerKey}/webinars', [WebinarController::class, 'create']);
