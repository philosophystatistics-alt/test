# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 概要

PHP 8.3 + nginx + MySQL を使用した Laravel 13 プロジェクト用の Docker 環境。Udemyのフルスタックエンジニア学習用リポジトリ。

## Docker環境の操作

```bash
# 開発環境の起動
docker-compose up -d

# 本番環境の起動（Aurora MySQL使用、ローカルDBなし）
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d

# コンテナの状況確認
docker-compose ps

# ログの確認
docker-compose logs -f

# 環境の停止
docker-compose down

# 環境の完全削除（ボリュームも削除）
docker-compose down -v
```

## Laravelコマンド（コンテナ内で実行）

```bash
# PHPコンテナに入る
docker-compose exec app bash

# 以下はコンテナ内、または docker-compose exec app <command> で実行

# 依存関係のインストール
composer install

# 初期セットアップ（install + .env生成 + key:generate + migrate + npm install + build）
composer run setup

# マイグレーション
php artisan migrate

# テスト実行（SQLite in-memory使用）
php artisan test

# 特定テストの実行
php artisan test --filter=テスト名
php artisan test tests/Unit/ExampleTest.php

# フロントエンドビルド
npm run build

# 開発サーバー一括起動（artisan serve + queue + pail + vite）
composer run dev
```

## アーキテクチャ

### インフラ構成

| サービス | 詳細 |
|---|---|
| `app` | PHP 8.3-fpm + Composer 2.7 + Node.js 24、UID/GID 1000で動作 |
| `web` | nginx 1.25-alpine、ポート80でリクエスト受け付け→app:9000(PHP-FPM)へFastCGI転送 |
| `db` | MySQL 8.0、ポート3306、`db-store`ボリュームで永続化 |

- `./src/` → コンテナ内 `/data/` にマウント（Laravelプロジェクトのルート）
- Vite開発サーバーはポート5173を使用（コンテナ外からアクセス可能）

### 環境変数

ルートの `.env.example` をコピーして `.env` を作成。DB接続情報のみ管理。

本番環境では `docker-compose.prod.yml` でDB接続先を Aurora MySQL に上書き（`DB_HOST`、`DB_PORT` を外部指定）。

### テスト

`phpunit.xml` でテスト環境は `DB_CONNECTION=sqlite`、`DB_DATABASE=:memory:` に設定済み。Dockerなしでもインメモリで高速実行可能。

### フロントエンド

Tailwind CSS v4 + Vite 8 を使用。`src/vite.config.js` でDocker外からのHMRアクセスを許可する設定が必要（READMEのTailwind CSS v4セクション参照）。
