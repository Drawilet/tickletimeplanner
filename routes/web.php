<?php

use App\Http\Livewire\Dashboard\ShowComponent as DashboardComponent;

use App\Http\Livewire\Tenant\Spaces\ShowComponent as ShowSpacesComponent;

use App\Http\Livewire\Tenant\Customers\ShowComponent as ShowCustomersComponent;
use App\Http\Livewire\Tenant\Products\ShowComponent as ShowProductsComponent;

use App\Http\Livewire\Tenant\Settings\ShowComponent as ShowSettingsComponent;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageControllers;


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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware($middleware)->group(function () {
    Route::get('/dashboard', DashboardComponent::class)->name('dashboard.show');

});

Route::prefix("tenant")->name("tenant.")->middleware($middleware)->group(function () {
    Route::get("settings", ShowSettingsComponent::class)->name("settings.show");

    Route::get('products', ShowProductsComponent::class)->name('products.show');
    Route::get("spaces", ShowSpacesComponent::class)->name("spaces.show");
    Route::get('customers', ShowCustomersComponent::class)->name('customers.show');
});
