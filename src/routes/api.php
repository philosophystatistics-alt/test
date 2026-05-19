<?php

use App\Http\Controllers\Api\PersonApiController;
use App\Http\Controllers\Api\TaskApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API ルート
|--------------------------------------------------------------------------
|
| このファイルのルートはすべて自動で "/api" プレフィックスが付く。
| 例: Route::get('/people') → 実際の URL は /api/people
|
| web.php と違い CSRF トークン不要・セッション無しのステートレス。
| JSON を返すので fetch / axios / curl / Postman から叩く学習に使う。
|
*/

// 動作確認用の一番シンプルな GET。/api/ping で {"message":"pong"} が返る
Route::get('/ping', function () {
    return response()->json([
        'message' => 'pong',
        'time'    => now()->toIso8601String(),
    ]);
});

// people の CRUD を一括登録（apiResource は HTML フォーム用の
// create / edit を除いた index・show・store・update・destroy を生成）
Route::apiResource('people', PersonApiController::class);

// tasks の CRUD を一括登録（people と同じ構成）
Route::apiResource('tasks', TaskApiController::class);
