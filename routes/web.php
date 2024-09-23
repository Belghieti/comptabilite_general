<?php

use App\Http\Controllers\aboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\access;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\DashboardController;




Route::get('/', function () {
    return view('welcome');
});






use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\EcritureController;
use App\Http\Controllers\BilanController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\CPCController;
use App\Http\Controllers\ProfilController;

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    

    
    Route::resource('entreprises', EntrepriseController::class);
    
    Route::post('/entreprises/select/{id}', [EntrepriseController::class, 'select'])->name('entreprises.select');

    Route::post('/entreprises/select/{id}', [EntrepriseController::class, 'select'])->name('entreprises.select');


    Route::resource('ecritures', EcritureController::class);
    Route::resource('bilans', BilanController::class);
    //Route::resource('balances', BalanceController::class);
    Route::resource('cpcs', CPCController::class);
    Route::resource('entreprises.comptes', CompteController::class)->only(['index']);
    Route::get('comptes', [CompteController::class, 'index'])->name('comptes.index');
    Route::get('comptes/show', [CompteController::class, 'show'])->name('comptes.show');
    
    Route::get('journal', [JournalController::class, 'index'])->name('journaux.index');
    Route::get('journal/show', [JournalController::class, 'show'])->name('journaux.show');
    
    Route::get('ecritures/create', [EcritureController::class, 'create'])->name('ecritures.create');
    
    // Enregistrer l'écriture principale
    Route::post('ecritures/store', [EcritureController::class, 'store'])->name('ecritures.store');
    
    // Affichage du formulaire pour ajouter l'écriture associée
    Route::get('ecritures/create-associe/{reference}', [EcritureController::class, 'createAssocie'])->name('ecritures.createAssocie');
    
    // Enregistrer l'écriture associée
    Route::post('ecritures/store-associe/{reference}', [EcritureController::class, 'storeAssocie'])->name('ecritures.storeAssocie');
    
    Route::get('/bilan', [BilanController::class, 'index'])->name('bilan.index');
    Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');
    
    Route::get('/cpc', [CPCController::class, 'index'])->name('cpc.index');
  //  Route::get('/profile', [ProfilController::class, 'show'])->name('profile.show');
  Route::get('bilan/pdf', [BilanController::class, 'exportPdf'])->name('bilan.pdf');
  Route::get('/balance/export-pdf', [BalanceController::class, 'exportPdf'])->name('balance.exportPdf');
  Route::get('/cpc/export-pdf', [CPCController::class, 'exportPdf'])->name('cpc.export-pdf');
  Route::get('comptes/export-pdf', [CompteController::class, 'exportPDF'])->name('comptes.exportPDF');



});




