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


    Route::middleware('api')->get('/vehicles', 'VehicleController@getVehicles');
    Route::middleware('api')->get('/gps/vehicles', 'VehicleController@getVehiclesGps');
    Route::middleware('api')->get('/vehicles/{placa}', 'VehicleController@getVehicle');
    Route::middleware('api')->get('/branchoffices', 'BranchofficeController@getBranchs');
    Route::middleware('api')->get('/clients', 'ClientController@getClients');
    Route::middleware('api')->get('/client/{id}', 'ClientController@getClient');
    Route::middleware('api')->get('/titulares', 'InvestorController@getTitulares');
    Route::middleware('api')->get('/investors', 'InvestorController@getInvestors');
    Route::middleware('api')->get('/salesvehicles', 'VehicleController@getsalesVehicles');
    Route::middleware('api')->post('/validate/email','ValidateFormsController@ValidateEmail');
    Route::middleware('api')->post('/validate/document','ValidateFormsController@ValidateDocument');
    Route::middleware('api')->post('/validate/client/email','ValidateFormsController@ValidateClientEmail');
    Route::middleware('api')->get('/validate/employee/branchs','ValidateFormsController@ValidateEmployeeBranchs');
    Route::middleware('api')->get('/validate/investor/vehicles','ValidateFormsController@ValidateInvestorVehicles');
    Route::middleware('api')->get('/validate/branchoffice','ValidateFormsController@ValidateBranchs');
    Route::middleware('api')->get('/validate/client/sales','ValidateFormsController@ValidateClientSales');
    Route::middleware('api')->get('/validate/vehicle','ValidateFormsController@ValidateVehicle');
    Route::middleware('api')->get('/validate/payment','ValidateFormsController@ValidatePayment');
    Route::middleware('api')->get('/notifications','ValidateFormsController@getLatePays');
    Route::middleware('api')->post('/clientdelete','ValidateFormsController@clientDelete');
    Route::middleware('api')->post('/payment/ticketTest','PaymentController@storeTest');


