<x-layout title="画像一覧（MinIO）">
    <h1>画像一覧（MinIO）</h1>
    <p class="count">全 {{ $images->count() }} 件</p>

    @if (session('status'))
        <p class="ok">{{ session('status') }}</p>
    @endif

    <h2>画像をアップロード</h2>
    <div class="card">
        <form class="add" action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="image" accept="image/*">
            <button type="submit" class="btn">アップロード</button>
        </form>

        @error('image')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <h2>アップロード済みの画像</h2>
    @forelse ($images as $image)
        @if ($loop->first)
            <div class="card">
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;">
        @endif

                    <figure style="margin:0;">
                        <img
                            src="{{ $image['url'] }}"
                            alt="{{ $image['name'] }}"
                            style="width:100%;height:200px;object-fit:cover;border-radius:12px;display:block;"
                            loading="lazy"
                        >
                        <figcaption style="margin-top:6px;font-size:.8rem;color:var(--muted);word-break:break-all;">
                            {{ $image['name'] }}
                        </figcaption>
                    </figure>

        @if ($loop->last)
                </div>
            </div>
        @endif
    @empty
        <div class="card">
            <p>まだ画像がありません。上のフォームからアップロードしてください。</p>
        </div>
    @endforelse
</x-layout>
