<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StylistController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\QueueBoardController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\AdminMasterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\MailboxController;

use App\Models\Service;
use App\Models\Product;
use App\Models\Portfolio;

Route::get('/', function () {
    $services = Service::where('is_active', true)->get();
    $products = Product::where('stock', '>', 0)->get();
    $portfolios = Portfolio::with('stylist')->latest()->get();
    return view('index', compact('services', 'products', 'portfolios'));
});

// Webhook Callback (Public Endpoint, CSRF Exempt)
Route::post('/api/payment/notification', [PaymentCallbackController::class, 'handleNotification'])->name('payment.notification');

// Queue Display Board (Public Screen for Waiting Room)
Route::get('/queue-board', [QueueBoardController::class, 'showBoard'])->name('queue.board');
Route::get('/live-queue/{booking?}', [BookingController::class, 'liveQueue'])->name('queue.live');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/login/verify-pin', [LoginController::class, 'showPinVerification'])->name('admin.pin.show');
    Route::post('/login/verify-pin', [LoginController::class, 'verifyPin'])->name('admin.pin.verify');
    Route::post('/login/cancel-pin', [LoginController::class, 'cancelPinVerification'])->name('admin.pin.cancel');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('auth.otp.show');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.otp.verify');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.otp.resend');
});

// Auth Protected Routes
Route::middleware('auth')->group(function () {
    // Shared Auth Routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [BookingController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/pin', [ProfileController::class, 'updatePin'])->name('profile.pin');

    // Customer & General Booking Actions
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{booking}/update', [BookingController::class, 'updateStatus'])->name('bookings.update');
    Route::post('/customer/rebook/{booking}', [BookingController::class, 'rebook'])->name('customer.rebook');
    Route::post('/customer/reviews', [BookingController::class, 'storeReview'])->name('customer.review');

    // Receptionist & Front-Desk Routes
    Route::middleware('role:receptionist,kasir,admin,supervisor,owner')->group(function () {
        Route::post('/receptionist/walkin', [BookingController::class, 'storeWalkin'])->name('receptionist.walkin');
        Route::post('/receptionist/arrival/{booking}', [BookingController::class, 'markArrival'])->name('receptionist.arrival');
    });

    // Hairstylist Dedicated Routes
    Route::middleware('role:hair stylist,admin,owner')->group(function () {
        Route::post('/stylist/work-status', [StylistController::class, 'updateWorkStatus'])->name('stylist.work_status');
        Route::post('/stylist/portfolio', [StylistController::class, 'storePortfolio'])->name('stylist.portfolio.store');
        Route::delete('/stylist/portfolio/{portfolio}', [StylistController::class, 'deletePortfolio'])->name('stylist.portfolio.delete');
        Route::post('/stylist/client-notes', [StylistController::class, 'storeClientNote'])->name('stylist.client_notes');
    });

    // Kasir POS & Payment Dedicated Routes
    Route::middleware('role:kasir,admin,supervisor,owner')->group(function () {
        Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
        Route::post('/pos/qris/generate', [PosController::class, 'generateQris'])->name('pos.qris.generate');
        Route::get('/pos/transactions/{transaction}/check-status', [PosController::class, 'checkStatus'])->name('pos.transaction.status');
        Route::post('/pos/petty-cash', [PosController::class, 'storePettyCash'])->name('pos.petty_cash');
        Route::get('/pos/receipt/{transaction}', [PosController::class, 'receipt'])->name('pos.receipt');
        Route::post('/pos/transactions/{transaction}/void', [PosController::class, 'voidTransaction'])->name('pos.transaction.void');
        Route::get('/pos/transactions/search', [PosController::class, 'searchTransactions'])->name('pos.transactions.search');
    });

    // Supervisor Dedicated Routes
    Route::middleware('role:supervisor,admin,owner')->group(function () {
        Route::post('/supervisor/shifts', [SupervisorController::class, 'storeShift'])->name('supervisor.shifts');
        Route::post('/supervisor/stock/{product}', [SupervisorController::class, 'updateStock'])->name('supervisor.stock');
        Route::post('/supervisor/complaints/{complaint}', [SupervisorController::class, 'resolveComplaint'])->name('supervisor.complaint');
    });

    // Admin & Owner Master Data Management Routes
    Route::middleware('role:admin,owner')->group(function () {
        Route::post('/users', [BookingController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{user}', [BookingController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [BookingController::class, 'deleteUser'])->name('users.delete');

        Route::post('/admin/services', [AdminMasterController::class, 'storeService'])->name('admin.services.store');
        Route::put('/admin/services/{service}', [AdminMasterController::class, 'updateService'])->name('admin.services.update');
        Route::post('/admin/services/{service}/toggle', [AdminMasterController::class, 'toggleService'])->name('admin.services.toggle');
        Route::delete('/admin/services/{service}', [AdminMasterController::class, 'deleteService'])->name('admin.services.delete');

        Route::post('/admin/products', [AdminMasterController::class, 'storeProduct'])->name('admin.products.store');
        Route::put('/admin/products/{product}', [AdminMasterController::class, 'updateProduct'])->name('admin.products.update');
        Route::post('/admin/products/{product}/stock', [AdminMasterController::class, 'updateStock'])->name('admin.products.stock');
        Route::delete('/admin/products/{product}', [AdminMasterController::class, 'deleteProduct'])->name('admin.products.delete');

        Route::post('/admin/vouchers', [AdminMasterController::class, 'storeVoucher'])->name('admin.vouchers.store');
        Route::put('/admin/vouchers/{voucher}', [AdminMasterController::class, 'updateVoucher'])->name('admin.vouchers.update');
        Route::post('/admin/vouchers/{voucher}/toggle', [AdminMasterController::class, 'toggleVoucher'])->name('admin.vouchers.toggle');
        Route::delete('/admin/vouchers/{voucher}', [AdminMasterController::class, 'deleteVoucher'])->name('admin.vouchers.delete');

        Route::post('/admin/shifts', [AdminMasterController::class, 'storeShift'])->name('admin.shifts.store');
        Route::post('/admin/complaints/{complaint}', [AdminMasterController::class, 'resolveComplaint'])->name('admin.complaint.resolve');
        Route::post('/admin/logs/clear', [AdminMasterController::class, 'clearLogs'])->name('admin.logs.clear');
    });

    // ─── Mailbox / In-App Messaging (all authenticated roles) ─────────────────
    Route::prefix('mailbox')->name('mailbox.')->group(function () {
        Route::get('/',                              [MailboxController::class, 'index'])  ->name('index');
        Route::post('/',                             [MailboxController::class, 'store'])  ->name('store');
        Route::get('/{conversation}',                [MailboxController::class, 'show'])   ->name('show');
        Route::post('/{conversation}/reply',         [MailboxController::class, 'reply'])  ->name('reply');
        Route::get('/api/unread-count',              [MailboxController::class, 'unreadCount'])->name('unread');
    });
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Pengalihan rute lama ke section yang relevan
Route::redirect('/service', '/#services');
Route::redirect('/services', '/#services');
Route::redirect('/service-details', '/#services');
Route::redirect('/portfolio', '/about');
Route::redirect('/resume', '/about');
Route::redirect('/starterpage', '/');

