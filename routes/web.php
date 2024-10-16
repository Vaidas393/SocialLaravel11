<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLanguage;
use App\Livewire\Blog;
use App\Livewire\SingleBlogPost;
use App\Livewire\EventComponent;
use App\Livewire\SingleEvent;
use App\Livewire\Events;
use App\Livewire\Newsfeed;
use App\Livewire\UsersList;
use App\Livewire\Friends;
use App\Livewire\FriendsRequests;
use App\Livewire\UserProfile;
use App\Livewire\Notifications;
use App\Livewire\Chat;
use App\Livewire\ConversationList;
use App\Http\Controllers\Backend\UserDataTableController;


// Language switching routes
Route::get('/set-language/lt', function () {
    session(['language' => 'lt']);
    return redirect()->back();
})->name('lt');

Route::get('/set-language/en', function () {
    session(['language' => 'en']);
    return redirect()->back();
})->name('en');

// Blog routes accessible to everyone with language setting applied
Route::middleware(SetLanguage::class)->group(function () {
    // Route::get('/', Blog::class)->name('blog');
    // Route::get('/blog/{post}', SingleBlogPost::class)->name('blog.post');
});

// Apply both 'auth', 'verified', and 'SetLanguage' middleware to other routes
Route::middleware(['auth', 'verified', SetLanguage::class])->group(function () {
    Route::get('/', Blog::class)->name('blog');
    Route::get('/blog/{post}', SingleBlogPost::class)->name('blog.post');
    Route::get('/events', Events::class)->name('events');
    Route::get('/event/{event}', SingleEvent::class)->name('event.post');
    Route::get('/newsfeed', Newsfeed::class)->name('newsfeed');
    Route::get('/notifications', Notifications::class)->name('notifications');
    Route::get('/users', UsersList::class)->name('users');
    Route::get('/friends', Friends::class)->name('friends');
    Route::get('/friendsrequests', FriendsRequests::class)->name('friendsrequests');
    Route::get('/userprofile/{user}', UserProfile::class)->name('userprofile');
    Route::get('/conversations', ConversationList::class)->name('conversations');
    Route::get('/chat/{id}', Chat::class)->name('chat.show');
});
Route::view('/account-inactive', 'account-inactive')->name('account.inactive');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/users', [UserDataTableController::class, 'index'])->name('users.index');
    Route::post('/admin/users/status', [UserDataTableController::class, 'toggleStatus'])->name('users.toggleStatus');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include other routes
require __DIR__ . '/admin.php';
require __DIR__.'/auth.php';
