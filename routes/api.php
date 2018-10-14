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
    
    
    Route::group(['prefix' => 'fhir'], function () {
        Route::resource('Patient', 'Fhir\Modules\FHIRPatient');
        Route::resource('Practitioner', 'Fhir\Modules\FHIRPractitioner');
        Route::resource('RelatedPerson', 'Fhir\Modules\FHIRRelatedPerson');
        Route::resource('Observation', 'Fhir\Modules\FHIRObservation');
        Route::resource('Immunization', 'Fhir\Modules\FHIRImmunization');
        Route::resource('Encounter', 'Fhir\Modules\FHIREncounter');
        Route::resource('Condition', 'Fhir\Modules\FHIRCondition');
    });