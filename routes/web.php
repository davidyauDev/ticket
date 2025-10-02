<?php
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Areaticket;
use App\Livewire\CallLogs\Dashboard;
use App\Livewire\CallLogs\Dashboard\MostCalledTechniciansCard;
use App\Livewire\CallLogs\Index;
use App\Livewire\Ticket\Dashboard as DashboardTickets;
use App\Livewire\DetalleTicket;
use App\Livewire\Modelos\ListModelPrioridad;
use App\Livewire\Settings\SettingsMainComponent;
use App\Livewire\Ticket\TicketManager;
use App\Livewire\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('tickets'); // usuario autenticado
    }
    return redirect()->route('login'); // usuario no autenticado
})->name('home');


Route::get('/users', UsersIndex::class)->middleware('auth')->name('users.index');
Route::get('/tickets', TicketManager::class)->middleware('auth')->name('tickets.index');

 Route::prefix('tickets')->name('tickets.')->middleware('auth')->group(function () {
     //Route::get('/estadisticas', DashboardTickets::class)->name('estadisticas');
     Route::get('/dashboard', DashboardTickets::class)->name('dashboard');
     Route::get('/{ticket}', DetalleTicket::class)->name('show');
 });

 Route::prefix('call-logs')->name('call-logs.')->middleware('auth')->group(function () {
     Route::get('/registro-llamadas', Index::class)->name('index');
     Route::get('/dashboard', Dashboard::class)->name('dashboard');
 });

Route::get('/areas/{slug}', Areaticket::class)->name('areas.show');
Route::prefix('settings')->name('settings.')->middleware('auth')->group(function () {
    //Route::redirect('/', '/settings/profile');
   Route::get('/profile', Profile::class)->name('profile');
    Route::get('/password', Password::class)->name('password');
    Route::get('/appearance', Appearance::class)->name('appearance');
    Route::get('/', SettingsMainComponent::class)->name('index'); 
    Route::get('/modelos', ListModelPrioridad::class)->name('modelos');

});
require __DIR__ . '/auth.php';
