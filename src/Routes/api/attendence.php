<?php

use Hanafalah\ModuleEmployee\Controllers\API\Attendence\AttendenceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('attendence', AttendenceController::class)
    ->parameters(['attendence' => 'id']);