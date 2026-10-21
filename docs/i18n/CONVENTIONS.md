# i18n 規約（ハードコード文字列の置き換え）

Blade / Vue に直接書かれた英語を翻訳キーに置き換えるときのルール。

## 1. 翻訳ファイルの置き場所

| 用途 | ファイル | 参照方法 |
|---|---|---|
| Vue（既存の共通文言） | `lang/*/web.php` | `$t('common.cancel')` |
| Vue: 管理画面 `components/admin/**`, `components/invite/**` | `lang/*/admin.php` | `$t('admin.reports.title')` |
| Vue: グループ機能 `components/groups/**`, `components/Group*.vue` | `lang/*/groups.php` | `$t('groups.settings.title')` |
| Vue: 投稿作成・ストーリー・プレゼンター等 | `lang/*/compose.php` | `$t('compose.modal.title')` |
| Vue: 旧 UI `js/components/**`（上記以外） | `lang/*/classic.php` | `$t('classic.profile.title')` |
| Vue: SPA `components/**`（上記以外） | `lang/*/spa.php` | `$t('spa.sidebar.title')` |
| Blade: 管理画面 `views/admin/**` | `lang/*/admin_panel.php` | `__('admin_panel.users.title')` |
| Blade: 設定 `views/settings/**` | `lang/*/settings.php` | `__('settings.xxx')` |
| Blade: サイト・ヘルプ `views/site/**` | `lang/*/site.php`, `helpcenter.php` | `__('site.xxx')` |
| Blade: その他のページ | `lang/*/pages.php`（既存の `auth.php` 等も可） | `__('pages.xxx')` |
| Blade: メール `views/emails/**` | `lang/*/emails.php` | `__('emails.xxx')` |

- Vue 用グループ（`admin`, `classic`, `compose`, `groups`, `spa`）は `php artisan i18n:export` で `web.php` と一緒にフロント用 JSON に書き出される（`ExportLanguages::FRONTEND_GROUPS`）。
- 新しいキーは **en-US と ja-JP の両方に同じ構造で** 追加する。他の言語は en-US にフォールバックする（Crowdin 経由で翻訳される）。

## 2. キーの命名

- コンポーネント名／ビュー名ごとにネストし、末端キーは camelCase（既存 `web.php` に合わせる）。
  例: `'reports' => ['title' => 'Reports', 'markAsRead' => 'Mark as read']`
- 既存キー（`web.php` の `common.*` など）に同じ意味の文言があれば再利用してよい。

## 3. Vue での書き方

- テンプレート: `{{ $t('spa.sidebar.title') }}`、属性: `:placeholder="$t('...')"`
- スクリプト: `this.$t('...')`（`swal()`, `alert()`, `confirm()` の文言も対象）
- 差し込み: vue-i18n の名前付き形式 `{name}` を使う。`$t('spa.x', { name: user.username })`
- `|` は vue-i18n の複数形区切りなので、文言に含めない（複数形は `$tc` と `'one | many'`）。
- `{` `}` は差し込み記号なので、文字としては使わない。
- HTML を含む文は可能な限り分割する。やむを得ず `v-html` を使う場合は、文言が静的でユーザー入力を含まないこと。
- `data()` 内で作る選択肢ラベルは、言語切替に追従するよう `computed` に移すのが望ましい（`data()` 内の `this.$t` も動作はする）。

## 4. Blade での書き方

- `{{ __('pages.login.title') }}`
- 差し込み: Laravel の `:name` 形式。`__('pages.x', ['name' => $user->username])`
- HTML を含む文は `{!! __('...', ['name' => e($value)]) !!}`。差し込む値は必ず `e()` でエスケープする。
- `<script>` 内: `@json(__('pages.x'))`
- Blade 内の Vue テンプレート（`@{{ }}`）では `$t()` を使う。そのページの Vue ルートには `i18n: App.i18n()` が必要。

## 5. 翻訳しないもの

- ブランド・固有名詞（Pixelfed, Mastodon, ActivityPub, Fediverse）
- サーバーに送る値、CSS クラス、ルート名、ID、`console.log`、コメント
- 技術的な識別子（設定キー名、環境変数名、HTTP ステータスなど）
- 法的文書の本文（`site/privacy`, `site/terms`, `mobile/privacy`, `mobile/terms`）— 翻訳の正確性に法的責任が伴うため対象外

## 6. 日本語訳の用語

既存の ja-JP に合わせる（Mastodon 日本語 UI 準拠）。

| 英語 | 日本語 |
|---|---|
| Post | 投稿 |
| Share / Reblog / Boost | 共有（原文が Reblog の場合はリブログ） |
| Like | いいね |
| Comment / Reply | コメント / 返信 |
| Follow / Unfollow / Followers / Following | フォロー / フォロー解除 / フォロワー / フォロー中 |
| Block / Mute | ブロック / ミュート |
| Report | 報告 |
| Story | ストーリー |
| Collection | コレクション |
| Bookmark | ブックマーク |
| Direct Message | ダイレクトメッセージ |
| Display name / Username | 表示名 / ユーザー名 |
| Bio | 自己紹介 |
| Private / Public / Unlisted | 非公開 / 公開 / 未収載 |
| Sensitive content / Content warning | センシティブなコンテンツ / コンテンツ警告 |
| Instance / Server | インスタンス / サーバー |
| Federation | 連合 |
| Admin / Moderator | 管理者 / モデレーター |
| Settings | 設定 |
| Cancel / Save / Delete / Close | キャンセル / 保存 / 削除 / 閉じる |
| Loading... | 読み込み中... |

文体は「です・ます」調。ボタンなど短いラベルは体言止め（例: 「保存」「フォロー解除」）。

## 7. 検証

```sh
php artisan i18n:coverage ja-JP --details   # 未翻訳とプレースホルダ不一致
```

`vendor/` が無くても使えるチェッカー:

```sh
php scripts/i18n/check-keys.php .                    # 参照キーの存在 / en-ja のキー一致 / プレースホルダ / `|` 禁止
node scripts/i18n/check-vue.js "$PWD" $(git diff --name-only -- '*.vue')        # テンプレートのコンパイル・script の構文
python3 scripts/i18n/check-blade.py $(git diff --name-only -- '*.blade.php')    # Blade 内の式の構文・ディレクティブの対応
```

## 8. 実装上の注意（フェーズ 2 で得た知見）

- リンクや太字を含む文は、vue-i18n v8 の `<i18n path="..." tag="span">` と名前付きスロット（`<template v-slot:username>`）で組み立てる。`v-html` を使わずに語順の違いを吸収できる。
- 複数形は `$tc` を使わず、単数と複数を別キーにして既存の条件分岐で選ぶ（`|` 禁止ルールのため）。
- `function(){}` コールバックの中では `this` がコンポーネントを指さない。`$t` の結果は事前に変数に入れるか、`self.$t` を使う。
- ラベル文字列から DOM の id を作っている箇所（`AdminSettingsCheckbox` など）は、日本語ラベルだと id が衝突する。非 ASCII を含む場合はハッシュを付ける。
- 日付・数値の書式は `'en-US'` を直接書かず、`document.documentElement.lang` を使う。

