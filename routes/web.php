<?php

use App\Http\Livewire\Dashboard\ShowComponent as DashboardComponent;

use App\Http\Livewire\Tenant\Spaces\ShowComponent as ShowSpacesComponent;
use App\Http\Livewire\Tenant\Customers\ShowComponent as ShowCustomersComponent;
use App\Http\Livewire\Tenant\Products\ShowComponent as ShowProductsComponent;
use App\Http\Livewire\Tenant\Users\ShowComponent as ShowUsersComponent;
use App\Http\Livewire\Tenant\Payments\ShowComponent as ShowPaymentsComponent;

use App\Http\Livewire\Tenant\Settings\ShowComponent as ShowSettingsComponent;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageControllers;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\SpacesComponent;
use App\Http\Livewire\SpAdminComponent;
use Spatie\Permission\Commands\Show;

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

Route::get('lang/{lang}', [LanguageControllers::class, 'switchLeng'])->name('lang');

$middleware = [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
];

Route::get('/', HomeComponent::class)->name('home');
Route::get("/spaces", SpacesComponent::class)->name("spaces.show");

Route::middleware($middleware)->group(function () {
    Route::get('/dashboard', DashboardComponent::class)->name('dashboard.show');
});

Route::prefix("tenant")->name("tenant.")->middleware($middleware)->group(function () {
    Route::get("settings", ShowSettingsComponent::class)->name("settings.show");

    Route::get('customers', ShowCustomersComponent::class)->name('customers.show');
    Route::get('products', ShowProductsComponent::class)->name('products.show');
    Route::get("spaces", ShowSpacesComponent::class)->name("spaces.show");
    Route::get("payments", ShowPaymentsComponent::class)->name("payments.show");
    Route::get('users', ShowUsersComponent::class)->name('users.show');
    Route::get('SpAdmin',SpAdminComponent::class)->name('SpAdmin.show');
});
