<?php

use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MedicineBatchController;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function (Request $request) {
    $search = $request->input('search');
    $medicines = Medicine::with('category')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('brand', 'like', "%{$search}%")
                ->orWhere('active_ingredients', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(6)
        ->withQueryString();
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'medicines' => $medicines,
        'filters' => $request->only(['search']),
    ]);
})->name('welcome');

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/obat', [MedicineController::class, 'index'])->name('obat.index');
    Route::post('/obat', [MedicineController::class, 'store'])->name('obat.store');
    Route::post('/obat/{id}', [MedicineController::class, 'update'])->name('obat.update');
    Route::delete('/obat/{id}', [MedicineController::class, 'destroy'])->name('obat.delete');


    Route::get('/obat-batches', [MedicineBatchController::class, 'index'])->name('obat.batches.index');
    Route::post('/obat-batches', [MedicineBatchController::class, 'store'])->name('obat.batches.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
