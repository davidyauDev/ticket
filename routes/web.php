<?php

use App\Livewire\IndexTic;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Areaticket;
use App\Livewire\CallLogs\Dashboard;
use App\Livewire\CallLogs\Index;
use App\Livewire\DashboardTickets;
use App\Livewire\DetalleTicket;
use App\Livewire\Ticket\TicketManager;
use App\Livewire\Users\Index as UsersIndex;

Route::redirect('/', '/login')->name('home');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/users', UsersIndex::class)->middleware('auth')->name('users.index');
Route::get('/tickets', TicketManager::class)->middleware('auth')->name('tickets.index');


 Route::prefix('tickets')->name('tickets.')->middleware('auth')->group(function () {
     //Route::get('/', IndexTic::class)->name('index');
     Route::get('/estadisticas', DashboardTickets::class)->name('estadisticas');
     Route::get('/{ticket}', DetalleTicket::class)->name('show');
 });

 Route::prefix('call-logs')->name('call-logs.')->middleware('auth')->group(function () {
     Route::get('/registro-llamadas', Index::class)->name('index');
     Route::get('/dashboard', Dashboard::class)->name('dashboard');
 });


Route::get('/areas/{slug}', Areaticket::class)->name('areas.show');
Route::prefix('settings')->name('settings.')->middleware('auth')->group(function () {
    Route::redirect('/', '/settings/profile');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/password', Password::class)->name('password');
    Route::get('/appearance', Appearance::class)->name('appearance');
});

require __DIR__ . '/auth.php';
