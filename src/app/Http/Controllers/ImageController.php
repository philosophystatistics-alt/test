<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * MinIO に保存された画像を署名付きURLで一覧表示する。
     */
    public function index(): View
    {
        // 一覧取得はコンテナ内エンドポイント(minio:9000)で行う。
        $disk = Storage::disk('s3');
        // 署名付きURLはブラウザ到達可能なエンドポイント(localhost:9000)で生成。
        $publicDisk = Storage::disk('s3_public');

        $images = collect($disk->files('images'))
            ->sortByDesc(fn (string $path) => $disk->lastModified($path))
            ->map(fn (string $path) => [
                'path' => $path,
                'name' => basename($path),
                // 5分間だけ有効な署名付きURL（署名はローカル計算）。
                'url'  => $publicDisk->temporaryUrl($path, now()->addMinutes(5)),
            ])
            ->values();

        return view('images.index', ['images' => $images]);
    }

    /**
     * 画像を MinIO（非公開バケット）にアップロードする。
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ], [
            'image.required' => '画像ファイルを選択してください。',
            'image.image'    => '画像ファイルを指定してください。',
            'image.mimes'    => 'jpg / png / gif / webp 形式のみアップロードできます。',
            'image.max'      => 'ファイルサイズは5MB以内にしてください。',
        ]);

        // images/ 配下に非公開（private）で保存。
        $request->file('image')->store('images', 's3');

        return redirect()
            ->route('images.index')
            ->with('status', '画像をアップロードしました。');
    }
}
