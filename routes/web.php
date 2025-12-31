<?php

use App\Http\Controllers\SadakaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\PastoralServiceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MapatoMatumiziController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\QuickEntryController;
use App\Http\Controllers\MemberPortalController;
use App\Http\Controllers\JumuiyaController;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Member Self-Registration
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Quick Entry Routes (Public Login, Protected Scanner and Forms)
Route::get('/quick-entry', [QuickEntryController::class, 'showLogin'])->name('quick-entry.login');
Route::post('/quick-entry/login', [QuickEntryController::class, 'login'])->name('quick-entry.login.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/quick-entry/scanner', [QuickEntryController::class, 'scanner'])->name('quick-entry.scanner');
    Route::get('/quick-entry/member/{member_number}', [QuickEntryController::class, 'getMemberInfo'])->name('quick-entry.member');
    Route::get('/quick-entry/contribution/{member_number}', [QuickEntryController::class, 'showContributionForm'])->name('quick-entry.contribution.form');
    Route::post('/quick-entry/contribution/{member_number}', [QuickEntryController::class, 'storeContribution'])->name('quick-entry.contribution.store');
    Route::post('/quick-entry/logout', [QuickEntryController::class, 'logout'])->name('quick-entry.logout');
});

// Protected Routes - Require Authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::prefix('panel')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Session check endpoint for AJAX calls
        Route::get('/check-session', function () {
            return response()->json(['authenticated' => true]);
        })->name('check.session');

        // Notifications endpoint for real-time updates
        Route::get('/notifications', function () {
            $user = auth()->user();
            $pendingRequests = \App\Models\Request::where('status', 'Inasubiri')->count();
            $pendingPastoral = \App\Models\PastoralService::where('status', 'Inasubiri')->count();

            $pendingMembers = 0;
            if ($user->isMchungaji() || $user->isMhasibu()) {
                $pendingMembers = \App\Models\User::where('is_active', false)->count();
            }

            return response()->json([
                'pending_requests' => $pendingRequests,
                'pending_pastoral' => $pendingPastoral,
                'pending_members' => $pendingMembers,
                'total' => $pendingRequests + $pendingPastoral + $pendingMembers
            ]);
        })->name('notifications.count');
    });

    // Member Portal Routes
    Route::prefix('member')->group(function () {
        Route::get('/portal', [MemberPortalController::class, 'dashboard'])->name('member.portal');
        Route::get('/contributions', [MemberPortalController::class, 'contributions'])->name('member.contributions');
        Route::get('/pledges', [MemberPortalController::class, 'pledges'])->name('member.pledges');
        Route::get('/receipts', [MemberPortalController::class, 'receipts'])->name('member.receipts');
        Route::get('/receipt/{payment}/view', [MemberPortalController::class, 'viewReceipt'])->name('member.receipt.view');
        Route::get('/receipt/{payment}/download', [MemberPortalController::class, 'downloadReceipt'])->name('member.receipt.download');

        // Member Profile Edit
        Route::get('/profile/edit', [MemberPortalController::class, 'editProfile'])->name('member.profile.edit');
        Route::put('/profile/update', [MemberPortalController::class, 'updateProfile'])->name('member.profile.update');
    });

    // Mapato na Matumizi (New Section)
    Route::prefix('panel')->group(function () {
        Route::get('/mapato-matumizi', [MapatoMatumiziController::class, 'index'])->name('mapato.matumizi');

        // Store routes
        Route::post('/mapato-matumizi/sadaka', [MapatoMatumiziController::class, 'storeSadaka'])->name('sadaka.store');
        Route::post('/mapato-matumizi/ahadi', [MapatoMatumiziController::class, 'storeAhadi'])->name('ahadi.store');
        Route::post('/mapato-matumizi/malipo', [MapatoMatumiziController::class, 'storeMalipo'])->name('malipo.store');
        Route::post('/mapato-matumizi/matumizi', [MapatoMatumiziController::class, 'storeMatumizi'])->name('matumizi.store');

        // Export routes (from MapatoMatumiziController - legacy)
        Route::get('/mapato-matumizi/export/mapato-old', [MapatoMatumiziController::class, 'exportMapato'])->name('export.mapato.old');
        Route::get('/mapato-matumizi/export/kiwanja', [MapatoMatumiziController::class, 'exportKiwanja'])->name('export.kiwanja');
        Route::get('/mapato-matumizi/export/matumizi-old', [MapatoMatumiziController::class, 'exportMatumizi'])->name('export.matumizi.old');

        // New Export routes (using ExportExcelController)
        Route::get('/export/mapato', [ExportExcelController::class, 'exportMapato'])->name('export.mapato');
        Route::get('/export/matumizi', [ExportExcelController::class, 'exportMatumizi'])->name('export.matumizi');

        // Detail routes
        Route::get('/mapato-matumizi/sadaka/{id}', [MapatoMatumiziController::class, 'showSadaka'])->name('sadaka.show');
        Route::get('/mapato-matumizi/ahadi/{id}', [MapatoMatumiziController::class, 'showAhadi'])->name('ahadi.show');
        Route::get('/mapato-matumizi/matumizi/{id}', [MapatoMatumiziController::class, 'showMatumizi'])->name('matumizi.show');
    });

    // NEW EXPORT EXCEL SECTION - ADD THIS BLOCK
    Route::prefix('panel')->group(function () {
        Route::get('/export-excel', [ExportExcelController::class, 'index'])->name('export.excel');
        Route::post('/export-excel/mapato', [ExportExcelController::class, 'exportMapato'])->name('export.excel.mapato');
        Route::get('/export-excel/kiwanja', [ExportExcelController::class, 'exportKiwanja'])->name('export.excel.kiwanja');
        Route::post('/export-excel/matumizi', [ExportExcelController::class, 'exportMatumizi'])->name('export.excel.matumizi');
        // Add this route for bulk delete
        Route::delete('/export-excel/bulk-delete', [ExportExcelController::class, 'bulkDelete'])->name('export.excel.bulk-delete');
        Route::delete('/export-excel/delete/{id}', [ExportExcelController::class, 'deleteExport'])->name('export.excel.delete');
        Route::post('/export-excel/custom', [ExportExcelController::class, 'customExport'])->name('export.excel.custom');
    });

    // Members Management
    Route::prefix('panel')->group(function () {
        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
        Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');
        Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('members.edit');
        Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');

        // Member Bulk Import
        Route::get('/members/import/form', [MemberController::class, 'importForm'])->name('members.import.form');
        Route::post('/members/import', [MemberController::class, 'import'])->name('members.import');
        Route::get('/members/import/template', [MemberController::class, 'downloadTemplate'])->name('members.import.template');

        // Member Additional Routes
        Route::get('/members/{id}/contributions', [MemberController::class, 'contributions'])->name('members.contributions');
        Route::get('/members/{id}/attendance', [MemberController::class, 'attendance'])->name('members.attendance');

        // QR Code Routes
        Route::get('/members/{id}/qrcode', [MemberController::class, 'generateQrCode'])->name('members.qrcode');
        Route::get('/members/scanner', [MemberController::class, 'scanner'])->name('members.scanner');
        Route::get('/members/scan/{member_number}', [MemberController::class, 'getMemberByNumber'])->name('members.scan.show');

        // Departments CRUD
        Route::get('/departments', [\App\Http\Controllers\DepartmentController::class, 'index'])->name('departments.index');
        Route::get('/departments/create', [\App\Http\Controllers\DepartmentController::class, 'create'])->name('departments.create');
        Route::post('/departments', [\App\Http\Controllers\DepartmentController::class, 'store'])->name('departments.store');
        Route::get('/departments/{id}', [\App\Http\Controllers\DepartmentController::class, 'show'])->name('departments.show');
        Route::get('/departments/{id}/edit', [\App\Http\Controllers\DepartmentController::class, 'edit'])->name('departments.edit');
        Route::put('/departments/{id}', [\App\Http\Controllers\DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{id}', [\App\Http\Controllers\DepartmentController::class, 'destroy'])->name('departments.destroy');

        // Jumuiya CRUD
        Route::get('/jumuiyas', [JumuiyaController::class, 'index'])->name('jumuiyas.index');
        Route::get('/jumuiyas/create', [JumuiyaController::class, 'create'])->name('jumuiyas.create');
        Route::post('/jumuiyas', [JumuiyaController::class, 'store'])->name('jumuiyas.store');
        Route::get('/jumuiyas/{id}', [JumuiyaController::class, 'show'])->name('jumuiyas.show');
        Route::get('/jumuiyas/{id}/edit', [JumuiyaController::class, 'edit'])->name('jumuiyas.edit');
        Route::put('/jumuiyas/{id}', [JumuiyaController::class, 'update'])->name('jumuiyas.update');
        Route::delete('/jumuiyas/{id}', [JumuiyaController::class, 'destroy'])->name('jumuiyas.destroy');
        Route::post('/jumuiyas/{id}/assign-members', [JumuiyaController::class, 'assignMembers'])->name('jumuiyas.assign-members');
        Route::delete('/jumuiyas/{id}/members/{memberId}', [JumuiyaController::class, 'removeMember'])->name('jumuiyas.remove-member');

        // Member Activation Routes
        Route::post('/members/{id}/activate', [MemberController::class, 'activate'])->name('members.activate');
        Route::post('/members/{id}/deactivate', [MemberController::class, 'deactivate'])->name('members.deactivate');
        Route::post('/members/bulk-activate', [MemberController::class, 'bulkActivate'])->name('members.bulk-activate');
    });

    // Income Management
    Route::prefix('panel')->group(function () {
        Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
        Route::get('/income/create', [IncomeController::class, 'create'])->name('income.create');
        Route::get('/income/bulk-entry', [IncomeController::class, 'bulkEntry'])->name('income.bulk-entry');
        Route::post('/income', [IncomeController::class, 'store'])->name('income.store');
        Route::post('/income/bulk-store', [IncomeController::class, 'bulkStore'])->name('income.bulk-store');
        Route::get('/income/{id}', [IncomeController::class, 'show'])->name('income.show');
        Route::get('/income/{id}/edit', [IncomeController::class, 'edit'])->name('income.edit');
        Route::put('/income/{id}', [IncomeController::class, 'update'])->name('income.update');
        Route::delete('/income/{id}', [IncomeController::class, 'destroy'])->name('income.destroy');

        // Income Categories
        Route::get('/income-categories', [IncomeController::class, 'categories'])->name('income.categories');
        Route::post('/income-categories', [IncomeController::class, 'storeCategory'])->name('income.categories.store');
    });

    // Expenses Management
    Route::prefix('panel')->group(function () {
        Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::get('/expenses/monthly/{year}/{month}', [ExpenseController::class, 'monthlyExpenses'])->name('expenses.monthly');
        Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::get('/expenses/{id}', [ExpenseController::class, 'show'])->name('expenses.show');
        Route::get('/expenses/{id}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::put('/expenses/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

        // Expense Categories
        Route::get('/expense-categories', [ExpenseController::class, 'categories'])->name('expenses.categories');
        Route::post('/expense-categories', [ExpenseController::class, 'storeCategory'])->name('expenses.categories.store');
    });

    // Offerings Management
    Route::prefix('panel')->group(function () {
        Route::get('/offerings', [SadakaController::class, 'index'])->name('offerings.index');
        Route::get('/offerings/create', [SadakaController::class, 'create'])->name('offerings.create');
        Route::post('/offerings', [SadakaController::class, 'store'])->name('offerings.store');
        Route::get('/offerings/{id}', [SadakaController::class, 'show'])->name('offerings.show');
        Route::get('/offerings/{id}/edit', [SadakaController::class, 'edit'])->name('offerings.edit');
        Route::put('/offerings/{id}', [SadakaController::class, 'update'])->name('offerings.update');
        Route::delete('/offerings/{id}', [SadakaController::class, 'destroy'])->name('offerings.destroy');

        // Offering Types
        Route::get('/offering-types', [SadakaController::class, 'types'])->name('offerings.types');
        Route::post('/offering-types', [SadakaController::class, 'storeType'])->name('offerings.types.store');

        // Calculator & Jimbo
        Route::post('/sadaka/store', [SadakaController::class, 'store'])->name('sadaka.calculator.store');
        Route::post('/sadaka/store-jimbo', [SadakaController::class, 'storeJimbo'])->name('sadaka.jimbo.store');
    });

    // Financial Requests Management
    Route::prefix('panel')->group(function () {
        Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
        Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
        Route::get('/requests/{id}', [RequestController::class, 'show'])->name('requests.show');
        Route::get('/requests/{id}/edit', [RequestController::class, 'edit'])->name('requests.edit');
        Route::put('/requests/{id}', [RequestController::class, 'update'])->name('requests.update');
        Route::delete('/requests/{id}', [RequestController::class, 'destroy'])->name('requests.destroy');

        // Request Approval
        Route::post('/requests/{id}/approve', [RequestController::class, 'approve'])->name('requests.approve');
        Route::post('/requests/{id}/reject', [RequestController::class, 'reject'])->name('requests.reject');
        Route::post('/requests/{id}/pending', [RequestController::class, 'pending'])->name('requests.pending');

        // Request Categories
        Route::get('/request-categories', [RequestController::class, 'categories'])->name('requests.categories');
        Route::post('/request-categories', [RequestController::class, 'storeCategory'])->name('requests.categories.store');
    });

    // Pastoral Services Management
    Route::prefix('panel')->group(function () {
        Route::get('/pastoral-services', [PastoralServiceController::class, 'index'])->name('pastoral-services.index');
        Route::get('/pastoral-services/create', [PastoralServiceController::class, 'create'])->name('pastoral-services.create');
        Route::get('/pastoral-services/report', [PastoralServiceController::class, 'report'])->name('pastoral-services.report');
        Route::get('/pastoral-services/export', [PastoralServiceController::class, 'export'])->name('pastoral-services.export');
        Route::post('/pastoral-services', [PastoralServiceController::class, 'store'])->name('pastoral-services.store');
        Route::get('/pastoral-services/{id}', [PastoralServiceController::class, 'show'])->name('pastoral-services.show');
        Route::get('/pastoral-services/{id}/edit', [PastoralServiceController::class, 'edit'])->name('pastoral-services.edit');
        Route::put('/pastoral-services/{id}', [PastoralServiceController::class, 'update'])->name('pastoral-services.update');
        Route::delete('/pastoral-services/{id}', [PastoralServiceController::class, 'destroy'])->name('pastoral-services.destroy');

        // Service Approval (Admin/Pastor only)
        Route::post('/pastoral-services/{id}/approve', [PastoralServiceController::class, 'approve'])->name('pastoral-services.approve');
        Route::post('/pastoral-services/{id}/reject', [PastoralServiceController::class, 'reject'])->name('pastoral-services.reject');
        Route::post('/pastoral-services/{id}/complete', [PastoralServiceController::class, 'complete'])->name('pastoral-services.complete');
    });

    // Events Management
    Route::prefix('panel')->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
        Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

        // Event Attendance
        Route::get('/events/{id}/attendance', [EventController::class, 'attendance'])->name('events.attendance');
        Route::post('/events/{id}/attendance', [EventController::class, 'storeAttendance'])->name('events.attendance.store');

        // Event Categories
        Route::get('/event-categories', [EventController::class, 'categories'])->name('events.categories');
        Route::post('/event-categories', [EventController::class, 'storeCategory'])->name('events.categories.store');
    });

    // Reports
    Route::prefix('panel')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
        Route::get('/reports/members', [ReportController::class, 'members'])->name('reports.members');
        Route::get('/reports/offerings', [ReportController::class, 'offerings'])->name('reports.offerings');
        Route::get('/reports/events', [ReportController::class, 'events'])->name('reports.events');
        Route::get('/reports/requests', [ReportController::class, 'requests'])->name('reports.requests');

        // Export Reports
        Route::get('/reports/export/financial', [ReportController::class, 'exportFinancial'])->name('reports.export.financial');
        Route::get('/reports/export/members', [ReportController::class, 'exportMembers'])->name('reports.export.members');
        Route::get('/reports/export/offerings', [ReportController::class, 'exportOfferings'])->name('reports.export.offerings');

        // New Report Generation Routes
        Route::post('/reports/quick-export', [ReportController::class, 'quickExport'])->name('reports.quick-export');
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
        Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
        Route::get('/reports/preview', [ReportController::class, 'preview'])->name('reports.preview');
    });

    // Settings
    Route::prefix('panel')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings/general', [SettingController::class, 'updateGeneral'])->name('settings.general.update');
        Route::put('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile.update');
        Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.password.update');

        // Church Settings
        Route::get('/settings/church', [SettingController::class, 'church'])->name('settings.church');
        Route::put('/settings/church', [SettingController::class, 'updateChurch'])->name('settings.church.update');

        // System Settings
        Route::get('/settings/system', [SettingController::class, 'system'])->name('settings.system');
        Route::put('/settings/system', [SettingController::class, 'updateSystem'])->name('settings.system.update');
    });

});

// API Routes for AJAX calls
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('/dashboard-stats', [DashboardController::class, 'getStats'])->name('api.dashboard.stats');
    Route::get('/monthly-income', [DashboardController::class, 'getMonthlyIncome'])->name('api.dashboard.monthly-income');
    Route::get('/filtered-income', [DashboardController::class, 'getFilteredIncome'])->name('api.dashboard.filtered-income');
    Route::get('/recent-activities', [DashboardController::class, 'getRecentActivities'])->name('api.dashboard.recent-activities');

    // Members API
    Route::get('/members/search', [MemberController::class, 'search'])->name('api.members.search');

    // Financial API
    Route::get('/financial/summary', [IncomeController::class, 'getFinancialSummary'])->name('api.financial.summary');

    // Mapato na Matumizi API
    Route::get('/mapato-matumizi/stats', [MapatoMatumiziController::class, 'getStats'])->name('api.mapato-matumizi.stats');

    // Jumuiya API
    Route::get('/jumuiyas', [JumuiyaController::class, 'getJumuiyasApi'])->name('api.jumuiyas');

    // NEW EXPORT EXCEL API ROUTES - ADD THESE
    Route::get('/export-excel/recent', [ExportExcelController::class, 'getRecentExports'])->name('api.export-excel.recent');
    Route::post('/export-excel/quick-export', [ExportExcelController::class, 'quickExport'])->name('api.export-excel.quick-export');
});

// Fallback Route
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
