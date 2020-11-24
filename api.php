<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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




    Route::Post('user/login', 'API\UserLoginController@login')->name('user.login');
    Route::Post('provider/register', 'API\UserLoginController@registerProvider')->name('user.register');

    Route::Post('pharmacy/login', 'API\UserLoginController@login')->name('pharmacy.login');
    Route::Post('nurse/login', 'API\UserLoginController@login')->name('nurse.login');

    Route::get('countries', 'API\DoctorController@getCountries')->name('countries');
    Route::Post('cities', 'API\DoctorController@getCities')->name('cities');
    Route::Post('districts', 'API\DoctorController@getDistricts')->name('districts');


    Route::group(['prefix' => 'doctor', 'as' => 'doctor.', 'middleware' => ['jwtMiddleware']], function () {

        Route::get('logout', 'API\UserLoginController@logout')->name('logout');

        Route::post('profile', 'API\DoctorController@getDoctor')->name('profile');
        Route::post('abbreviated/profile', 'API\DoctorController@getAbbreviatedDoctorProfile')->name('abbreviated.profile');

        Route::Post('accepted/reservations', 'API\DoctorController@AcceptedReservations')->name('accepted.reservations');
        Route::Post('waiting/reservations', 'API\DoctorController@waitingReservations')->name('waiting.reservations');
        Route::Post('rejected/reservations', 'API\DoctorController@RejectedReservations')->name('rejected.reservations');
        Route::Post('done/reservations', 'API\DoctorController@DoneReservations')->name('done.reservations');

        Route::get('services', 'API\DoctorController@getServiceForDoctor')->name('services');

        Route::post('accept/reservation', 'API\DoctorController@acceptReservation')->name('accept.reservation');
        Route::post('reject/reservation', 'API\DoctorController@rejectReservation')->name('reject.reservation');

        Route::post('start/a_medical', 'API\DoctorController@start_Amedical')->name('start.a_medical');

        Route::get('medical_department', 'API\DoctorController@getMedicalDepartment')->name('medical_department');

        Route::post('departments', 'API\DoctorController@getDepartmentDoctors')->name('departments');


        Route::post('search', 'API\DoctorController@searchDoctor')->name('search');
        Route::post('timed/reservation', 'API\DoctorController@getReservationByTime')->name('timed.reservation');


        Route::post('available/times', 'API\DoctorController@getAvailableTimeForDoctor')->name('available.times');
        Route::post('make/reservation', 'API\DoctorController@makeReservation')->name('make.reservation');

        Route::get('patient/reservations', 'API\DoctorController@getPatientReservations')->name('patient.reservations');

        Route::post('get/a_medical', 'API\DoctorController@getAmedicalForReservation')->name('get.a_medical');

        Route::post('by_service', 'API\DoctorController@getDoctorsByService')->name('by_service');

    });

    Route::group(['prefix' => 'pharmacy', 'as' => 'pharmacy.', 'middleware' => ['jwtMiddleware']], function () {

        Route::post('profile', 'API\PharmacyController@getPharmacy')->name('profile');
        Route::post('abbreviated/profile', 'API\PharmacyController@getAbbreviatedPharmacyProfile')->name('abbreviated.profile');

        Route::Post('accepted/orders', 'API\PharmacyController@AcceptedOrders')->name('accepted.orders');
        Route::Post('waiting/orders', 'API\PharmacyController@waitingOrders')->name('waiting.orders');
        Route::Post('rejected/orders', 'API\PharmacyController@RejectedOrders')->name('rejected.orders');
        Route::Post('done/orders', 'API\PharmacyController@doneOrders')->name('rejected.orders');
        Route::Post('old/orders', 'API\PharmacyController@oldOrders')->name('old.orders');
        Route::Post('new/orders', 'API\PharmacyController@newOrders')->name('new.orders');

//        Route::get('services', 'API\PharmacyController@getServiceForPharmacy')->name('services');

        Route::post('accept/order', 'API\PharmacyController@acceptOrder')->name('accept.reservation');
        Route::post('reject/order', 'API\PharmacyController@rejectOrder')->name('reject.reservation');

        Route::post('update/order', 'API\PharmacyController@updateOrder')->name('update.order');
        Route::post('create/order', 'API\PharmacyController@createOrder')->name('create.order');
        Route::post('reminder/order', 'API\PharmacyController@reminderOrder')->name('reminder.order');

//        Route::get('medical_department', 'API\PharmacyController@getMedicalDepartment')->name('medical_department');

//        Route::post('departments', 'API\PharmacyController@getDepartmentPharmacies')->name('departments');

        Route::post('search', 'API\PharmacyController@searchPharmacy')->name('search');
//        Route::post('timed/order', 'API\PharmacyController@getOrderByTime')->name('timed.order');
        Route::post('/check-day','API\PharmacyController@checkOrderDay')->name('checkOrderDay');
        Route::get('get-all','API\PharmacyController@getAll')->name('get-all');
        Route::post('confirm-order', 'API\PharmacyController@confirmOrder')->name('confirm.order');

        Route::get('orders','API\PharmacyController@getOrders')->name('get.orders');

    });


    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['jwtMiddleware']], function () {

        Route::get('get', 'API\UserLoginController@getUser')->name('get');
        Route::get('logout', 'API\UserLoginController@logout')->name('logout');

        Route::get('/services','API\CenterController@getServices')->name('services');
    });

    Route::group(['prefix' => 'center', 'as' => 'center.', 'middleware' => ['jwtMiddleware']], function () {

        Route::group(['prefix' => 'xray', 'as' => 'xray.'], function () {
          Route::get('departments', 'API\CenterController@getXrayDepartments')->name('departments');

          Route::get('patient/reservations', 'API\CenterController@xrayReservationsForPatient')->name('patient.reservations');
        });

        Route::group(['prefix' => 'analysis', 'as' => 'analysis.'], function () {
            Route::get('departments', 'API\CenterController@getAnalysisDepartments')->name('departments');
            Route::get('patient/reservations', 'API\CenterController@analysisReservationsForPatient')->name('patient.reservations');
          });


        Route::post('accept/reservation', 'API\CenterController@acceptReservation')->name('accept.reservation');
        Route::post('reject/reservation', 'API\CenterController@rejectReservation')->name('reject.reservation');

        Route::post('start/medical', 'API\CenterController@startMedical')->name('start.medical');


        Route::post('service/departments', 'API\CenterController@getServiceDepartments')->name('service.deparment');

        Route::post('search', 'API\CenterController@getCenters')->name('search');
        Route::post('choose', 'API\CenterController@chooseCenter')->name('choose');

        Route::post('department', 'API\CenterController@getCentersOfDepartment')->name('department');
        Route::post('view/profile', 'API\CenterController@getPublicProfile')->name('view.profile');

        Route::post('services', 'API\CenterController@getCenterWithServices')->name('services');
        Route::post('times', 'API\CenterController@getTimesForCenter')->name('times');

        //get departments for specfic center
        Route::post('get/departments', 'API\CenterController@getDepartmentForSecificCenter')->name('get.departments');

        Route::post('make/reservation', 'API\CenterController@makeReservation')->name('make.reservation');


        Route::get('waiting', 'API\CenterController@getWaitingReservations')->name('waiting');
        Route::get('accepted', 'API\CenterController@getAcceptedReservations')->name('accepted');
        Route::get('rejected', 'API\CenterController@getRejectedReservations')->name('rejected');
        Route::get('done', 'API\CenterController@getDoneReservations')->name('done');
    });


    Route::group(['prefix' => 'nurse', 'as' => 'nurse.', 'middleware' => ['jwtMiddleware']], function () {
        Route::post('create/order', 'API\NurseController@createOrder')->name('create.order');
        Route::post('profile', 'API\NurseController@getNurse')->name('profile');
        Route::post('get/notifications', 'API\NurseController@getNotifications')->name('get.notifications');
        Route::post('accept/order', 'API\NurseController@acceptOrderNotification')->name('accept.order');
        Route::post('reject/order', 'API\NurseController@rejectOrderNotification')->name('reject.order');
        Route::post('accepted', 'API\NurseController@getAcceptedNurses')->name('accepted');
        Route::post('assigned/orders', 'API\NurseController@getAssignedOrders')->name('assigned.orders');
        Route::post('examine', 'API\NurseController@examine')->name('examine');
        Route::post('assign/order', 'API\NurseController@assignOrder')->name('assign.order');
        Route::get('departments', 'API\NurseController@getDepartments')->name('nurse_departments');
        Route::post('choose', 'API\NurseController@chooseNurse')->name('choose');
        Route::get('accepted/orders', 'API\NurseController@AcceptedOrders')->name('accepted.orders');
        Route::get('rejected/orders', 'API\NurseController@RejectedOrders')->name('rejected.orders');
        Route::post('delete/order', 'API\NurseController@deleteOrder')->name('delete.orders');
        Route::post('edit/order', 'API\NurseController@editOrder')->name('edit.orders');

        Route::get('orders','API\NurseController@getOrders')->name('get.orders');

    });



    Route::group(['prefix' => 'emergency', 'as' => 'emergency.', 'middleware' => ['jwtMiddleware']], function () {
        Route::get('get/chronic-diseases', 'API\EmergencyOrderController@getChronicDiseases')->name('create.order');
        Route::post('create/order', 'API\EmergencyOrderController@createOrder')->name('create.order');
        Route::post('refresh/order', 'API\EmergencyOrderController@refreshOrder')->name('refresh.order');
        Route::post('get/notifications', 'API\EmergencyOrderController@getNotifications')->name('get.notifications');
        Route::post('accept/order', 'API\EmergencyOrderController@acceptOrderNotification')->name('accept.order');
        Route::post('reject/order', 'API\EmergencyOrderController@rejectOrderNotification')->name('reject.order');
        Route::post('assign/order', 'API\EmergencyOrderController@assignOrder')->name('assign.order');
        Route::post('accepted/orders', 'API\EmergencyOrderController@getAcceptedEmergencyOrders')->name('accepted.orders');
        Route::post('assigned/orders', 'API\EmergencyOrderController@getAssignedOrders')->name('assigned.orders');
        Route::post('examine', 'API\EmergencyOrderController@examine')->name('examine');

    });
