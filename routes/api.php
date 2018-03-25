<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group( ['prefix' => 'fhir' /*, 'middleware' => ['App\Http\Middleware\CareProviderMiddleware'] */ ], function () {
    Route::resource('Patient', 'Fhir\Modules\FHIRPatient');
    Route::resource('Practitioner', 'Fhir\Modules\FHIRPractitioner');
    Route::resource('Organization', 'Fhir\Modules\FHIROrganization');
    Route::resource('Observation', 'Fhir\Modules\FHIRObservation');
});