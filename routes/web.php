<?php

use App\Http\Livewire\Customer\ShowComponent as ShowCustomersComponent;

use App\Http\Livewire\Event\NewComponent as NewEventComponent;
use App\Http\Livewire\Event\ShowComponent as ShowEventsComponent;
use App\Http\Livewire\Iconoscomponent;
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/customers', ShowCustomersComponent::class)->name('customers.show');

    Route::get("/events", ShowEventsComponent::class)->name("events.show");
    Route::get("/events/new", NewEventComponent::class)->name("events.new");
    Route::get("/settings", ShowSettingsComponent::class)->name("settings.show");
});
