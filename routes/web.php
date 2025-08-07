<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// Home redirects to contact list
Route::get('/', [ContactController::class, 'index'])->name('contacts.index');

// Contact List
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');

// Add & Edit Contact Form
Route::get('/contacts/form', [ContactController::class, 'form'])->name('contacts.create');
Route::get('/contacts/form/{id}', [ContactController::class, 'form'])->name('contacts.edit');

// Create, Update, Delete
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

// Bulk Delete
Route::post('/contacts/bulk-delete', [ContactController::class, 'bulkDelete'])->name('contacts.bulkDelete');

// XML Import
Route::post('/contacts/import', [ContactController::class, 'importXml'])->name('contacts.import');
