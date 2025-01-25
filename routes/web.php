<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SubscriptionController;

// Clear Cache of Permissions for the admin
Route::get('/forget-cached-permissions', function () {
    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    return response()->json(['message' => 'Cached permissions cleared.']);
});

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROLES AND PERMISSIONS
    Route::get('/roles', [RolePermissionController::class, 'showAssignPermissionsForm'])->name('roles.index');
    Route::post('/roles/permissions', [RolePermissionController::class, 'assignPermissions'])->name('roles.assignPermissions');
    Route::get('/roles/{roleId}/permissions', [RolePermissionController::class, 'getPermissionsForRole']);

    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/stripe/redirect/{sub_id}', [SubscriptionController::class, 'redirectToStripe'])->name('redirectToStripe');

    Route::get('success', [SubscriptionController::class, 'success'])->name('checkout.success');
    Route::get('cancel', [SubscriptionController::class, 'cancel'])->name('checkout.cancel');
});



require __DIR__.'/auth.php';
