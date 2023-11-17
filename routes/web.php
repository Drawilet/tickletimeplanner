<?php

use App\Http\Livewire\Event\NewComponent as EventNewComponent;
use App\Http\Livewire\Event\ShowComponent as EventShowComponent;

use App\Http\Livewire\Settings\Show as SettingsShowComponent;

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Clientcomponent;
use App\Http\Livewire\Customercomponent;
use App\Http\Livewire\CustomerModelscomponent;

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
    return view('welcome');});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
  
  
    Route::get('/customers', Customercomponent::class)->name('customers.show');

    Route::get("/events", EventShowComponent::class)->name("events.show");
    Route::get("/events/new", EventNewComponent::class)->name("events.new");

    Route::get("/settings", SettingsShowComponent::class)->name("settings.show");

});

