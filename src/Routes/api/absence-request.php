<?php

use Hanafalah\ModuleEmployee\Controllers\API\AbsenceRequest\AbsenceRequestController;
use Illuminate\Support\Facades\Route;

Route::apiResource('absence-request', AbsenceRequestController::class)
    ->parameters(['absence-request' => 'id']);