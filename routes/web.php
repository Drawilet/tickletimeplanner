<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$defaultMiddleware = [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
];


Route::get('/locale/{locale}', [\App\Http\Controllers\LocaleController::class, 'switchLocale'])->name('locale');

Route
    ::get('/', \App\Http\Livewire\HomeComponent::class)
    ->name('home');
Route
    ::get("/spaces", \App\Http\Livewire\SpacesComponent::class)
    ->name("spaces.show");

Route::middleware($defaultMiddleware)->group(function () {
    Route
        ::get('/dashboard', \App\Http\Livewire\Dashboard\DashboardComponent::class)
        ->name('dashboard.show');

    Route
        ::get("settings", \App\Http\Livewire\SettingsComponent::class)
        ->name("settings.show");
});

Route::prefix("tenant")->name("tenant.")->middleware($defaultMiddleware)->group(function () {


    Route
        ::middleware("permission:tenant.customers.show")
        ->get('customers', \App\Http\Livewire\Tenant\ShowCustomers::class)
        ->name('customers.show');

    Route
        ::middleware("permission:tenant.products.show")
        ->get('products', \App\Http\Livewire\Tenant\ShowProducts::class)
        ->name('products.show');
    Route
        ::middleware("permission:tenant.spaces.show")
        ->get("spaces", \App\Http\Livewire\Tenant\ShowSpaces::class)
        ->name("spaces.show");
    Route
        ::middleware("permission:tenant.payments.show")
        ->get("payments", \App\Http\Livewire\Tenant\ShowPayments::class)
        ->name("payments.show");
    Route
        ::middleware("permission:tenant.users.show")
        ->get('users', \App\Http\Livewire\Tenant\ShowUsers::class)
        ->name('users.show');
});

Route
    ::prefix("app")
    ->name("app.")
    ->middleware([...$defaultMiddleware, "role:app.admin", "permission:app.tenants.show"])
    ->group(function () {
        Route
            ::get("tenants", \App\Http\Livewire\App\TenantComponent::class)
            ->name("tenants");

        Route
            ::get("tenants/{id}", \App\Http\Livewire\App\Tenants\ShowComponent::class)
            ->name("tenants.show");
    });
