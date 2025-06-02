<?php

use App\Livewire\DashboardComponent;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\TicketComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardComponent::class)->name('dashboard');
Route::get('/ticket', TicketComponent::class)->name('ticket');
