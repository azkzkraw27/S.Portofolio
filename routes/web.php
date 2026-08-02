<?php

use App\Models\Chat;
use App\Models\Project;
use App\Models\Post;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Http\Middleware\TrackVisitor;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CustomerChatController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TestimonialController;

// -----------------------------------------------------------------------------
// 1. RUTE HALAMAN UTAMA (PUBLIK)
// -----------------------------------------------------------------------------
Route::get('/', function () {
    $projects = Project::latest()->get();
    $posts = Post::where('is_published', true)->latest()->get();
    $faqs = Faq::where('is_active', true)->latest()->get();
    $testimonials = Testimonial::where('is_active', true)->latest()->get();

    return view('welcome', compact('projects', 'posts', 'faqs', 'testimonials'));
})->middleware(TrackVisitor::class);

// -----------------------------------------------------------------------------
// 2. REDIRECTOR DASHBOARD PINTAR (SESUAI ROLE)
// -----------------------------------------------------------------------------
Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    /** @var \App\Models\User $user */
    $user = $request->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// -----------------------------------------------------------------------------
// 3. FITUR UMUM USER & PROFILE (DAPAT DIAKSES OLEH USER BIASA & ADMIN)
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard User
    Route::get('/user/dashboard', function (\Illuminate\Http\Request $request) {
        /** @var \App\Models\User $user */
        $user = $request->user();

        try {
            $myChats = \App\Models\Chat::where('sender_email', $user->email)
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            $myChats = collect();
        }

        return view('user.dashboard', compact('myChats'));
    })->name('user.dashboard');

    // Halaman Live Chat Khusus Client/User
    Route::get('/user/chat', function (\Illuminate\Http\Request $request) {
        /** @var \App\Models\User $user */
        $user = $request->user();

        try {
            $messages = \App\Models\Chat::where('sender_email', $user->email)
                ->orderBy('created_at', 'asc')
                ->get();
        } catch (\Exception $e) {
            $messages = collect();
        }

        return view('user.chat', compact('messages'));
    })->name('user.chat');

    // Fitur Management Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -----------------------------------------------------------------------------
// 4. DASHBOARD & FITUR MANAJEMEN ADMIN (DIPROTEKSI KETAT ADMINMIDDLEWARE)
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {

    // Overview Dashboard Admin
    Route::get('/admin/dashboard', function () {
        $visitorsToday = Visitor::where('visit_date', now()->toDateString())->count();
        $totalUsers = User::count();
        $totalPosts = Post::where('is_published', true)->count();
        $totalProjects = Project::count();
        $recentProjects = Project::latest()->take(5)->get();
        $recentPosts = Post::latest()->take(8)->get();
        $activities = Chat::latest()->take(8)->get();
        $pesanMasuk = Chat::count();
        $pesanBelumDibaca = Chat::where('is_read', false)->where('sender_type', 'user')->count();

        return view('dashboard', compact(
            'visitorsToday',
            'totalUsers',
            'totalPosts',
            'totalProjects',
            'recentProjects',
            'recentPosts',
            'activities',
            'pesanMasuk',
            'pesanBelumDibaca'
        ));
    })->name('admin.dashboard');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/welcome', [SettingController::class, 'welcome'])->name('settings.welcome');
    Route::get('/settings/navbar', [SettingController::class, 'navbar'])->name('settings.navbar');
    Route::get('/settings/footer', [SettingController::class, 'footer'])->name('settings.footer');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

    // Projects
    Route::resource('projects', ProjectController::class);

    // Customer Chats (Admin Side)
    Route::get('/customer-chats', [CustomerChatController::class, 'index'])->name('chats.index');
    Route::get('/customer-chats/{email}', [CustomerChatController::class, 'show'])->name('chats.show');
    Route::post('/customer-chats/{email}/reply', [CustomerChatController::class, 'reply'])->name('chats.reply');

    Route::get('/admin/chats/unread-count', function () {
        $count = Chat::where('is_read', false)->where('sender_type', 'user')->count();
        return response()->json(['count' => $count]);
    })->name('admin.chats.unread-count');

    // Blog
    Route::resource('posts', PostController::class);

    // FAQs
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
    Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');

    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Di dalam Route::middleware(['auth', 'verified', AdminMiddleware::class])->group(...)
    Route::get('/settings/auth-appearance', [SettingController::class, 'authAppearance'])->name('settings.auth_appearance');
    Route::post('/settings/auth-appearance', [SettingController::class, 'updateAuthAppearance'])->name('settings.update_auth_appearance');
});

// -----------------------------------------------------------------------------
// 5. RUTE PUBLIK CHAT & BLOG
// -----------------------------------------------------------------------------
Route::post('/chat/send', [CustomerChatController::class, 'storePublic'])->name('chat.store');
Route::get('/chat/messages/{email}', [CustomerChatController::class, 'fetchMessages'])->name('chat.fetch');
Route::get('/blog/{slug}', [PostController::class, 'showPublic'])->name('blog.show');

require __DIR__.'/auth.php';
