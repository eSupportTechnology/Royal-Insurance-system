<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorsController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DynamicFormController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CustomerResponseController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

 Route::get('/', function () {
    return view('AdminDashboard.home');
 });

// Route::get('/test', function () {
    // return view('test');
// });

// Route::prefix('dashboard')->group(function () {
//     Route::view('index', 'dashboard.index')->name('index');
//     Route::view('dashboard-02', 'dashboard.dashboard-02')->name('dashboard-02');

// });
Route::get('/logiiiii', [AuthController::class, 'showLoginForm'])->name('login.form');

Route::prefix('authentication')->group(function () {
    Route::post('login/page', [AuthController::class, 'login'])->name('login.store');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('register/store', [AuthController::class, 'signup'])->name('register.store');

        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/not-send', [MotorsController::class, 'notsend'])->name('indexxx');
Route::get('/send', [MotorsController::class, 'send'])->name('sendindex');
Route::get('/send-quatationreport/{id}', [MotorsController::class, 'quatationreport'])->name('quatationreport');
Route::post('/quatationreport/{id}', [MotorsController::class, 'quatationreportstore'])->name('quotation.store');
Route::get('/create', [MotorsController::class, 'create'])->name('createmotors');
Route::post('/store', [MotorsController::class, 'store'])->name('storemotors');
Route::get('/edit/{id}', [MotorsController::class, 'edit'])->name('editmotors');
Route::put('/update/{id}', [MotorsController::class, 'update'])->name('updatemotors');
Route::delete('/delete/{id}', [MotorsController::class, 'destroy'])->name('deletemotors');
Route::get('/mail/{id}', [MotorsController::class, 'mail'])->name('mailmotors');
Route::post('/mail/{id}/store', [MotorsController::class, 'storeMail'])->name('storemailmotors');
Route::get('/viewRequest',[MotorsController::class, 'viewRequest'])->name('viewRequest');
Route::get('/customer responce/show/{id}', [MotorsController::class, 'show'])->name('seemore');


//insurance health//

Route::get('/health/index', [HealthController::class, 'index'])->name('health.index');
Route::get('/health/create', [HealthController::class, 'create'])->name('health.create');
Route::post('/health/store', [HealthController::class, 'store'])->name('health.store');
Route::get('/health/edit/{id}', [HealthController::class, 'edit'])->name('health.edit');
Route::put('/health/update/{id}', [HealthController::class, 'update'])->name('health.update');
Route::delete('/health/delete/{id}', [HealthController::class, 'destroy'])->name('health.delete');

//insurance company//

Route::get('/company/index', [CompanyController::class, 'index'])->name('company.index');
Route::get('/company/create', [CompanyController::class, 'create'])->name('company.create');
Route::post('/company/store', [CompanyController::class, 'store'])->name('company.store');
Route::get('/company/edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');
Route::put('/company/update/{id}', [CompanyController::class, 'update'])->name('company.update');
Route::delete('/company/delete/{id}', [CompanyController::class, 'destroy'])->name('company.delete');
Route::get('/{company_id}/status', [CompanyController::class, 'status'])->name('company.status');

Route::get('/{company_id}/status', [CompanyController::class, 'status'])->name('company.status');

Route::get('/subcategories/private-car', [DynamicFormController::class, 'showPrivateCar'])->name('private.car');


//insurance types

Route::get('/insurance_type/index', [InsuranceController::class, 'index'])->name('insuranceType.index');
Route::get('/insurance_type/create', [InsuranceController::class, 'create'])->name('insuranceType.create');
Route::post('/insurance_type/store', [InsuranceController::class, 'store'])->name('insuranceType.store');
Route::get('/insurance_type/edit/{id}', [InsuranceController::class, 'edit'])->name('insuranceType.edit');
Route::put('/insurance_type/update/{id}', [InsuranceController::class, 'update'])->name('insuranceType.update');
Route::delete('/insurance_type/delete/{id}', [InsuranceController::class, 'delete'])->name('insuranceType.delete');


//categories

Route::get('/categories/index', [InsuranceController::class, 'categoriesindex'])->name('categories.index');
Route::get('/categories/create', [InsuranceController::class, 'categoriescreate'])->name('categories.create');
Route::post('/categories/store', [InsuranceController::class,'categoriesstore'])->name('categories.store');
Route::get('/categories/edit/{id}', [InsuranceController::class, 'categoriesedit'])->name('categories.edit');
Route::put('/categories/update/{id}', [InsuranceController::class, 'categoriesupdate'])->name('categories.update');
Route::delete('/categories/delete/{id}', [InsuranceController::class, 'categoriesdelete'])->name('categories.delete');


//sub categories

Route::get('/subcategories/index', [InsuranceController::class,'subcategoriesindex'])->name('subcategories.index');
Route::get('/subcategories/create', [InsuranceController::class,'subcategoriescreate'])->name('subcategories.create');
Route::post('/subcategories/store', [InsuranceController::class,'subcategoriesstore'])->name('subcategories.store');
Route::get('/subcategories/edit/{id}', [InsuranceController::class,'subcategoriesedit'])->name('subcategories.edit');
Route::put('/subcategories/update/{id}', [InsuranceController::class,'subcategoriesupdate'])->name('subcategories.update');
Route::delete('/subcategories/delete/{id}', [InsuranceController::class,'subcategoriesdelete'])->name('subcategories.delete');

//form field

Route::get('/formField/index', [FormController::class,'index'])->name('formField.index');
Route::get('/formField/create', [FormController::class,'create'])->name('formField.create');
Route::post('/formField/store', [FormController::class,'store'])->name('formField.store');
Route::get('/formField/edit/{id}', [FormController::class,'edit'])->name('formField.edit');
Route::put('/formField/update/{id}', [FormController::class,'update'])->name('formField.update');
Route::delete('/formField/delete/{id}', [FormController::class,'destroy'])->name('formField.delete');
Route::get('/form-fields/{groupKey}', [FormController::class, 'show'])->name('formField.show');
Route::get('/formField/addNew', [FormController::class, 'addNew'])->name('formField.addNew');
Route::post('/formField/storeNew', [FormController::class, 'storeNew'])->name('formField.storeNew');

//customer resposes

Route::get('/customerResponses', [CustomerController::class, 'index'])->name('customerResponses.index');
Route::get('/customerResponses/create', [CustomerController::class, 'create'])->name('customerResponses.create');
Route::post('/customerResponses/store', [CustomerController::class, 'store'])->name('customerResponses.store');
Route::get('/customerResponses/delete/{id}', [CustomerController::class, 'destroy'])->name('customerResponses.destroy');
Route::get('/customers/{id}/view', [CustomerController::class, 'view'])->name('view-customer');


// new-customer

Route::get('/new-customer', [CustomerController::class, 'newCustomer'])->name('new-customer');
Route::get('/new-customer/create', [CustomerController::class, 'createCustomer'])->name('create-customer');
Route::post('/new-customer/store', [CustomerController::class,'storeCustomer'])->name('store-customer');
Route::get('/new-customer/edit/{id}', [CustomerController::class,'editCustomer'])->name('edit-customer');
Route::put('/new-customer/update/{id}', [CustomerController::class,'updateCustomer'])->name('update-customer');
Route::delete('/new-customer/delete/{id}', [CustomerController::class,'deleteCustomer'])->name('delete-customer');


// Agent Routes
Route::get('/agents', [AgentController::class, 'index'])->name('agents.index');
Route::get('/agents/create', [AgentController::class, 'create'])->name('agents.create');
Route::post('/agents/store', [AgentController::class, 'store'])->name('agents.store');
Route::get('/agents/edit/{id}', [AgentController::class, 'edit'])->name('agents.edit');
Route::put('/agents/update/{id}', [AgentController::class, 'update'])->name('agents.update');
Route::delete('/agents/delete/{id}', [AgentController::class, 'destroy'])->name('agents.destroy');
Route::get('/agents/view/{id}', [AgentController::class, 'show'])->name('agents.show');


Route::get('/create-response', [CustomerResponseController::class, 'create'])->name('customerResponse.create');
Route::post('/agents/store-response', [CustomerResponseController::class, 'store'])->name('customerResponse.store');
Route::get('/get-form-fields', [CustomerResponseController::class, 'getFormFields'])->name('getFormFields');
Route::get('/customer-responses/{id}/edit', [CustomerResponseController::class, 'edit'])->name('customerResponse.edit');
Route::put('/customer-responses/{id}', [CustomerResponseController::class, 'update'])->name('customerResponse.update');
Route::get('/mailmotors/{id}', [CustomerResponseController::class, 'mailForm'])->name('customerResponse.mail');
Route::post('/send-quotation-mail', [CustomerResponseController::class, 'sendQuotationMail'])->name('sendQuotationMail');


//QuotationController
Route::get('/quotations/{id}', [QuotationController::class, 'show'])->name('quotation.show');
Route::post('/quotations/{id}/save', [QuotationController::class, 'save'])->name('quotation.save');





});
// Route::prefix('authentication')->group(function () {

//     Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
//     Route::post('login/page', [AuthController::class, 'login'])->name('login');
//     Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
//     Route::post('register/store', [AuthController::class, 'signup'])->name('register');
//     Route::view('forget-password', 'authentication.forget-password')->name('forget-password');
// });

require __DIR__.'/auth.php';
