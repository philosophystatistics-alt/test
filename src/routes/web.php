<?php

use App\Http\Controllers\GreetingController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PersonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 文字列を返すルート
Route::get('/hello', function () {
    return 'Hello World!';
});

// view を返すルート
Route::get('/sample', function () {
    return view('sample', ['name' => 'Laravel']);
});

// 人と挨拶のページ（名前は任意。/greeting または /greeting/太郎）
Route::get('/greeting/{name?}', function (?string $name = null) {
    // 現在時刻から挨拶を出し分け
    $hour = (int) now()->format('H');

    if ($hour < 11) {
        $greeting = 'おはようございます';
        $icon = '🌅';
    } elseif ($hour < 18) {
        $greeting = 'こんにちは';
        $icon = '☀️';
    } else {
        $greeting = 'こんばんは';
        $icon = '🌙';
    }

    // 表示する人の一覧
    $people = [
        ['name' => '田中 太郎', 'role' => 'エンジニア'],
        ['name' => '鈴木 花子', 'role' => 'デザイナー'],
        ['name' => '佐藤 次郎', 'role' => 'マネージャー'],
    ];

    return view('greeting', [
        'name'     => $name,
        'greeting' => $greeting,
        'icon'     => $icon,
        'time'     => now()->format('Y年n月j日 H:i'),
        'people'   => $people,
    ]);
})->name('greeting');

// 名前を入力するフォームの表示
Route::get('/greeting-form', function () {
    return view('greeting-form');
})->name('greeting.form');

// フォームから送信された名前を受け取り挨拶を返す
Route::post('/greeting-form', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:50'],
    ], [
        'name.required' => '名前を入力してください。',
        'name.max'      => '名前は50文字以内で入力してください。',
    ]);

    $hour = (int) now()->format('H');

    if ($hour < 11) {
        $greeting = 'おはようございます';
        $icon = '🌅';
    } elseif ($hour < 18) {
        $greeting = 'こんにちは';
        $icon = '☀️';
    } else {
        $greeting = 'こんばんは';
        $icon = '🌙';
    }

    return view('greeting-form', [
        'name'     => $validated['name'],
        'greeting' => $greeting,
        'icon'     => $icon,
    ]);
})->name('greeting.form.submit');

// greetings テーブルの一覧表示
Route::get('/greetings', [GreetingController::class, 'index'])
    ->name('greetings.index');

// 挨拶の追加
Route::post('/greetings', [GreetingController::class, 'store'])
    ->name('greetings.store');

// 挨拶の削除
Route::delete('/greetings/{greeting}', [GreetingController::class, 'destroy'])
    ->name('greetings.destroy');

// 人の登録画面・一覧
Route::get('/people', [PersonController::class, 'index'])
    ->name('people.index');

// 人の登録
Route::post('/people', [PersonController::class, 'store'])
    ->name('people.store');

// 人の削除
Route::delete('/people/{person}', [PersonController::class, 'destroy'])
    ->name('people.destroy');

// MinIO 画像の一覧表示
Route::get('/images', [ImageController::class, 'index'])
    ->name('images.index');

// MinIO へ画像アップロード
Route::post('/images', [ImageController::class, 'store'])
    ->name('images.store');

// API を叩く学習用プレイグラウンド画面（画面内の JS から /api/* を呼ぶ）
Route::get('/api-playground', function () {
    return view('api-playground.index');
})->name('api.playground');

