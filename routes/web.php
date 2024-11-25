<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Livewire\HomeComponent;
use App\Livewire\Questionario;
use App\Livewire\ResultadosComponent;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/questionario', Questionario::class)->name('questionario');


Route::get('/resultados', ResultadosComponent::class)->name('resultados');



