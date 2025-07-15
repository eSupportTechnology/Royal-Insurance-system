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
use App\Http\Controllers\CustomerInsuranceController;
use App\Http\Controllers\CustomerResponseController;
use App\Http\Controllers\ProfitMarginController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\RepAuthController;
use App\Models\ProfitMargin;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::prefix('authentication')->group(function () {

    Route::post('login/page', [AuthController::class, 'login'])->name('login.store');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('register/store', [AuthController::class, 'signup'])->name('register.store');

    Route::middleware('auth:admin')->group(function () {

        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('account', [AuthController::class, 'account'])->name('account');
        Route::put('account/update', [AuthController::class, 'accountUpdate'])->name('account.update');

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
        Route::get('/viewRequest', [MotorsController::class, 'viewRequest'])->name('viewRequest');
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
        Route::get('/company/pin/{id}', [CompanyController::class, 'pin'])->name('company.pin');
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
        Route::post('/categories/store', [InsuranceController::class, 'categoriesstore'])->name('categories.store');
        Route::get('/categories/edit/{id}', [InsuranceController::class, 'categoriesedit'])->name('categories.edit');
        Route::put('/categories/update/{id}', [InsuranceController::class, 'categoriesupdate'])->name('categories.update');
        Route::delete('/categories/delete/{id}', [InsuranceController::class, 'categoriesdelete'])->name('categories.delete');


        //sub categories

        Route::get('/subcategories/index', [InsuranceController::class, 'subcategoriesindex'])->name('subcategories.index');
        Route::get('/subcategories/create', [InsuranceController::class, 'subcategoriescreate'])->name('subcategories.create');
        Route::post('/subcategories/store', [InsuranceController::class, 'subcategoriesstore'])->name('subcategories.store');
        Route::get('/subcategories/edit/{id}', [InsuranceController::class, 'subcategoriesedit'])->name('subcategories.edit');
        Route::put('/subcategories/update/{id}', [InsuranceController::class, 'subcategoriesupdate'])->name('subcategories.update');
        Route::delete('/subcategories/delete/{id}', [InsuranceController::class, 'subcategoriesdelete'])->name('subcategories.delete');

        //form field

        Route::get('/formField/index', [FormController::class, 'index'])->name('formField.index');
        Route::get('/formField/create', [FormController::class, 'create'])->name('formField.create');
        Route::post('/formField/store', [FormController::class, 'store'])->name('formField.store');
        Route::get('/formField/edit/{id}', [FormController::class, 'edit'])->name('formField.edit');
        Route::put('/formField/update/{id}', [FormController::class, 'update'])->name('formField.update');
        Route::delete('/formField/delete/{id}', [FormController::class, 'destroy'])->name('formField.delete');
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
        Route::post('/new-customer/store', [CustomerController::class, 'storeCustomer'])->name('store-customer');
        Route::get('/new-customer/edit/{id}', [CustomerController::class, 'editCustomer'])->name('edit-customer');
        Route::put('/new-customer/update/{id}', [CustomerController::class, 'updateCustomer'])->name('update-customer');
        Route::delete('/new-customer/delete/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete-customer');


        // Agent Routes
        Route::get('/agents', [AgentController::class, 'index'])->name('agents.index');
        Route::get('/agents/create', [AgentController::class, 'create'])->name('agents.create');
        Route::post('/agents/store', [AgentController::class, 'store'])->name('agents.store');
        Route::get('/agents/edit/{id}', [AgentController::class, 'edit'])->name('agents.edit');
        Route::put('/agents/update/{id}', [AgentController::class, 'update'])->name('agents.update');
        Route::delete('/agents/delete/{id}', [AgentController::class, 'destroy'])->name('agents.destroy');
        Route::get('/agents/view/{id}', [AgentController::class, 'show'])->name('agents.show');

        //sub agent

        Route::get('/subagents', [AgentController::class, 'subagentindex'])->name('sub_agents.index');
        Route::get('/subagents/create', [AgentController::class, 'subagentcreate'])->name('sub_agents.create');
        Route::post('/subagents/store', [AgentController::class, 'subagentstore'])->name('sub_agents.store');
        Route::get('/subagents/edit/{id}', [AgentController::class, 'subagentedit'])->name('sub_agents.edit');
        Route::put('/subagents/update/{id}', [AgentController::class, 'subagentupdate'])->name('sub_agents.update');
        Route::delete('/subagents/delete/{id}', [AgentController::class, 'subagentdestroy'])->name('sub_agents.destroy');
        // Route::get('/subagents/view/{id}', [AgentController::class, 'subagentshow'])->name('subagents.show');


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

        //customer insurance

        Route::get('/customer-insurance', [CustomerInsuranceController::class, 'index'])->name('customerinsurance.index');
        Route::get('/customer-insurance/create', [CustomerInsuranceController::class, 'create'])->name('customerinsurance.create');
        Route::post('/customer-insurance', [CustomerInsuranceController::class, 'store'])->name('customerinsurance.store');
        Route::get('/customer-insurance/{id}/show', [CustomerInsuranceController::class, 'show'])->name('customerinsurance.show');
        Route::get('/customer-insurance/{id}/edit', [CustomerInsuranceController::class, 'edit'])->name('customerinsurance.edit');
        Route::put('/customer-insurance/{id}', [CustomerInsuranceController::class, 'update'])->name('customerinsurance.update');
        Route::delete('/customer-insurance/{id}/delete', [CustomerInsuranceController::class, 'destroy'])->name('customerinsurance.destroy');
        Route::get('/customer-insurance/set-cash/{id}', [CustomerInsuranceController::class, 'setCash'])->name('customerinsurance.setCash');

        //profit margin

        Route::get('/profitMargin', [ProfitMarginController::class, 'index'])->name('profitMargin.index');
        Route::get('/profitMargin/create', [ProfitMarginController::class, 'create'])->name('profitMargin.create');
        Route::post('/profitMargin/store', [ProfitMarginController::class, 'store'])->name('profitMargin.store');
        Route::get('/profitMargin/edit/{id}', [ProfitMarginController::class, 'edit'])->name('profitMargin.edit');
        Route::put('/profitMargin/update/{id}', [ProfitMarginController::class, 'update'])->name('profitMargin.update');
        Route::delete('/profitMargin/delete/{id}', [ProfitMarginController::class, 'destroy'])->name('profitMargin.destroy');

        //commission

        Route::get('/rib-commissions', [CommissionController::class, 'ribIndex'])->name('commissions.rib');
        Route::get('/agent-commissions', [CommissionController::class, 'agentIndex'])->name('commissions.agent');
        Route::get('/subagent-commissions', [CommissionController::class, 'subagentIndex'])->name('commissions.subagent');
    });
});

//rep authentication

Route::get('/rep-login', [RepAuthController::class, 'loginForm'])->name('rep.login.form');
Route::post('/rep-login', [RepAuthController::class, 'login'])->name('rep.login');
Route::get('/rep-register', [RepAuthController::class, 'registerForm'])->name('rep.register.form');
Route::post('/rep/check-code', [RepAuthController::class, 'checkCode'])->name('rep.check.code');
Route::post('/rep-register', [RepAuthController::class, 'register'])->name('rep.register');

Route::middleware('auth:rep')->group(function () {
    Route::get('/rep-dashboard', [RepAuthController::class, 'dashboard'])->name('rep.dashboard');
    Route::post('logout', [RepAuthController::class, 'logout'])->name('rep.logout');

    Route::get('/rep-agent-commissions', [CommissionController::class, 'repagentIndex'])->name('rep.commissions.agent');
    Route::get('/rep-subagent-commissions', [CommissionController::class, 'repsubagentIndex'])->name('rep.commissions.subagent');

    Route::get('/rep-customer-insurance/{id}/show', [CommissionController::class, 'show'])->name('rep.commissions.show');

});

require __DIR__ . '/auth.php';
