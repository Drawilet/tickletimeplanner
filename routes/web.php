<?php

use App\Http\Livewire\Dashboard\ShowComponent as DashboardComponent;

use App\Http\Livewire\Space\ShowComponent as ShowSpacesComponent;

use App\Http\Livewire\Customer\ShowComponent as ShowCustomersComponent;
use App\Http\Livewire\Product\ShowComponent as ShowProductsComponent;

use App\Http\Livewire\Settings\Show as ShowSettingsComponent;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', DashboardComponent::class)->name('dashboard.show');

    Route::get('products', ShowProductsComponent::class)->name('products.show');

    Route::get("/spaces", ShowSpacesComponent::class)->name("spaces.show");

    Route::get('/customers', ShowCustomersComponent::class)->name('customers.show');

    Route::get("/settings", ShowSettingsComponent::class)->name("settings.show");
});
