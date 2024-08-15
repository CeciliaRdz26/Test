<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\FormasdepagoController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CompraController;

Route::resource('productos', ProductoController::class)->except(['show']);

Route::resource('categorias', CategoriaController::class);

Route::resource('clientes', ClienteController::class);

Route::resource('ventas', VentaController::class);

Route::resource('inventarios', InventarioController::class)->except(['show']);

Route::resource('cotizaciones', CotizacionController::class);

Route::resource('formasdepago', FormasdepagoController::class);

Route::resource('vendedor', VendedorController::class);

Route::resource('proveedor', ProveedorController::class);

Route::resource('compras', CompraController::class);

Route::resource('reportes', PDFController::class);

Route::get('/pdf/{id}', [PDFController::class, 'report'])->name('pdf.report');

Route::get('/report/grafica/compras', [PDFController::class, 'showGraficaCompras']);

Route::get('/report/grafica/ventas', [PDFController::class, 'showGraficaVentas']);

Route::post('/cotizaciones', [CotizacionController::class, 'store'])->name('cotizaciones.store');

Route::put('inventarios/{id}/edit', [InventarioController::class, 'update'])->name('inventario.update');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';