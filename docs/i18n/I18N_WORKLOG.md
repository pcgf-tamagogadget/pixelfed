# i18n 改善 作業計画・作業記録

- 作業日: 2026-10-21
- 対象: Laravel 側の翻訳基盤（`lang/`, `app/Util/Localization`, ミドルウェア, Blade レイアウト）と Vue フロントエンド（`resources/assets/js/i18n`, `vue-i18n`）
- 目標
  1. **日本語（ja-JP）の翻訳カバレッジを 100% にする**
  2. **どの言語でも正しく動くように i18n コードを修正する**（ロケール正規化・言語自動判定・RTL・キー参照ミス等）
  3. カバレッジを機械的に検証できる仕組みを用意し、今後退行しないようにする

> 新しい Deno バックエンド（`apps/backend`）には現時点で i18n 機構が存在しないため対象外。

---

## 1. 現状調査（作業前）

### 1.1 i18n の構成

| レイヤ | 実体 | 役割 |
|---|---|---|
| 翻訳ソース | `lang/en-US/*.php`（13 ファイル） | 原文。Crowdin のソース |
| 各言語 | `lang/<locale>/*.php`（74 ロケール） | Crowdin から同期（`crowdin.yml`）。`validation.php`, `pagination.php` は同期対象外 |
| ロケール一覧 | `lang/locales.json` | `php artisan i18n:export` が生成するマニフェスト |
| 正規化 | `App\Util\Localization\Localization::normalizeLocale()` | 旧 2 文字コード（`ja` 等）→ `ja-JP` |
| 空文字対策 | `EmptyStrippingFileLoader` | Crowdin の未翻訳 `''` を除去し en-US へフォールバックさせる |
| ロケール適用 | `App\Http\Middleware\Localization` | セッションの `locale` を `app()->setLocale()` |
| フロント | `resources/assets/js/i18n/<locale>.json`（`web.php` のみ書き出し） | `vue-i18n`、`<html lang>` からロケール決定、`fallbackLocale: en-US` |

### 1.2 ja-JP カバレッジ（作業前）

計測方法: en-US の全リーフキーに対し、ja-JP に「存在し、かつ空文字でない」値があるかを数える。

| ファイル | 翻訳済み / 全キー | 内訳 |
|---|---|---|
| auth | 20 / 22 | 空文字 2（`email`, `forgotEmail`） |
| validation | 68 / 136 | 欠落 68（Laravel 新バージョンで追加されたルール群） |
| web | 293 / 328 | 空文字 35（`landing.*` 全体、`common.javascript` 等） |
| その他 10 ファイル | 全件翻訳済み | — |
| **合計** | **672 / 777 = 86.5%** | |

### 1.3 コード上の問題点

| # | 問題 | 影響 |
|---|---|---|
| C1 | Vue で存在しないキーを参照: `notifications.wasApproved`, `notifications.wasRejected`, `story.viewdBy` | **全言語**でキー名がそのまま画面に表示される |
| C2 | `SpaController::updateLanguage` / `HomeSettings` が言語コードを正規化しない | 旧コード `ja` 等を送ると 400 / 無視される |
| C3 | ミドルウェアが未ログイン・未設定のユーザーに対して `Accept-Language` を見ない | 日本語ブラウザでも初回は常に英語表示 |
| C4 | セッションのロケールが実在するか検証していない | 不正値がそのまま `<html lang>` に出力される |
| C5 | `<html>` に `dir` 属性がない | アラビア語・ヘブライ語・ペルシア語等の RTL 言語で文字方向が誤る |
| C6 | `vue-timeago` のロケールが `'en'` 固定 | 相対時刻が常に英語（本作業ではレイアウトへの影響が大きいため記録のみ） |
| C7 | カバレッジを検証する手段がない | 翻訳漏れが検知されない |

---

## 2. 作業計画

| Step | 内容 | 対象ファイル |
|---|---|---|
| 1 | Vue のキー参照ミス修正（C1） | `Notifications.vue`, `StoryCompose.vue` |
| 2 | `Localization` ユーティリティ拡張: `isAvailable()`, `negotiate()`（Accept-Language 判定）, `isRtl()` / `direction()` | `app/Util/Localization/Localization.php` |
| 3 | ミドルウェア改修: セッション値の検証、未設定時は Accept-Language から決定（C3, C4） | `app/Http/Middleware/Localization.php` |
| 4 | 言語変更 API で正規化（C2） | `SpaController.php`, `HomeSettings.php` |
| 5 | 全レイアウトに `dir` 属性を付与（C5） | `resources/views/layouts/*.blade.php` 等 |
| 6 | ja-JP 翻訳の補完（auth 2 / validation 68 / web 35）＋既存訳の誤訳修正 | `lang/ja-JP/*.php` |
| 7 | フロント用 JSON の再生成 | `resources/assets/js/i18n/ja-JP.json`, `public/_lang/ja-JP.json` |
| 8 | カバレッジ検証コマンド `php artisan i18n:coverage` とテストの追加（C7） | `app/Console/Commands/Dev/I18nCoverage.php`, `tests/Unit/LocalizationTest.php` |
| 9 | 結果の計測と本ドキュメントへの記録 | 本ファイル |

---

## 3. 作業記録

### Step 1: Vue のキー参照ミス修正 ✅

`$t()` で参照している全キー（309 件）を en-US `web.php`（328 キー）と突き合わせ、存在しないキーを 3 件検出して修正。Blade/PHP 側（`__()`, `@lang`, `trans()` の 264 キー）は全て存在していた。

| ファイル | 修正前 | 修正後 |
|---|---|---|
| `resources/assets/components/sections/Notifications.vue` | `notifications.wasApproved` | `notifications.applicationApproved` |
| 同上 | `notifications.wasRejected` | `notifications.applicationRejected` |
| `resources/assets/js/components/StoryCompose.vue` | `story.viewdBy` | `story.viewedBy` |

### Step 2: `Localization` ユーティリティ拡張 ✅

`app/Util/Localization/Localization.php` に以下を追加。

- `isAvailable($locale)` — 正規化後に `lang/` に存在するか
- `negotiate(array $tags, ?array $available)` — ブラウザの言語タグ列から最適なロケールを選ぶ
  1. 完全一致（大文字小文字・`_`/`-` を無視）: `ja_JP` → `ja-JP`
  2. エイリアス: `zh-Hant` / `zh-HK` / `zh-MO` → `zh-TW`、`zh-Hans` / `zh-SG` / `zh` → `zh-CN`、`nb` / `nn` → `no-NO`
  3. 既存の旧コード表 `LEGACY_LOCALE_MAP`: `pt` → `pt-PT`、`en` → `en-US` 等
  4. 主言語サブタグの前方一致（`en-x-pirate` のような私用サブタグは除外）
- `isRtl($locale)` / `direction($locale)` — `ar`, `ckb`, `dv`, `fa`, `he`, `ps`, `syc`, `ug`, `ur`, `yi` を RTL と判定

### Step 3: ミドルウェア改修 ✅

`app/Http/Middleware/Localization.php` のロケール決定順を次のように変更。

1. セッションの `locale`（ユーザーが明示的に選択）※ 実在しない値は無視
2. ログインユーザーの `users.language`
3. `Accept-Language` ヘッダからのネゴシエーション（新設定 `app.locale_negotiation` / 環境変数 `APP_LOCALE_NEGOTIATION`、既定 `true`）
4. どれにも当てはまらなければ `app.locale`

ネゴシエーション結果はセッションに保存しないため、ブラウザの言語設定を変えれば次のリクエストから反映される。

### Step 4: 言語変更 API の正規化 ✅

旧 2 文字コード（`ja` 等）を受け取っても `ja-JP` に正規化してから検証するよう修正。

- `SpaController::updateLanguage`（以前は `ja` を送ると 400）
- `Settings\HomeSettings`（未入力時に `en-US` で上書きしないよう `filled()` で判定）
- `ApiV1Controller` の `source.language`（同上）

### Step 5: RTL 対応 ✅

`<html lang="{{ app()->getLocale() }}">` を持つ全 10 テンプレートに `dir="{{ \App\Util\Localization\Localization::direction() }}"` を付与。

> 補足: Bootstrap 4 は RTL 用 CSS を持たないため、`dir="rtl"` で文字方向・flex の並び順は正しくなるが、`ml-*`/`mr-*` 等の余白ユーティリティは反転しない。完全な RTL レイアウトには RTL 版 CSS（rtlcss 等）の導入が別途必要。
>
> `lang="en"` 固定のテンプレート（OAuth 認可画面、埋め込み表示、インストーラ）は翻訳関数を一切使っていない英語固定画面のため変更していない。

### Step 6: ja-JP 翻訳の補完 ✅

| ファイル | 作業内容 |
|---|---|
| `lang/ja-JP/validation.php` | en-US と同じキー順で全面書き直し。欠落 68 件を追加。既存訳の誤りも修正（例: `alpha` 「文字を含めることが出来ます」→「英字のみ使用できます」、`digits` に「桁」を補う、`max.array` の「以上…持つことは出来ません」を「以下である必要があります」に、`timezone` 「有効なゾーン」→「有効なタイムゾーン」、`url` を「有効なURL」に） |
| `lang/ja-JP/web.php` | 空文字 35 件を翻訳（`landing.*` 一式、`common.javascript`, `navmenu.mobileApps`, `settings.filters.hide_media_blur`, `powered_by_pixelfed`） |
| `lang/ja-JP/auth.php` | 空文字 2 件（`email`, `forgotEmail`）を翻訳 |
| `lang/ja-JP/helpcenter.php` | 英語のまま残っていた `whatsnew` を「新着情報」に |

翻訳時のルール:
- `:attribute` などの Laravel プレースホルダ、`{num_photos}` などの vue-i18n プレースホルダ、HTML タグは原文と完全に一致させる（機械チェックで不一致 0 件を確認）
- 「Fediverse」「Powered by Pixelfed」は固有名詞・ブランド表記としてそのまま残す

### Step 6b: 既存 ja-JP 訳の品質修正 ✅

カバレッジ（キーが埋まっているか）とは別に、既存訳を en-US 原文・使用箇所のテンプレートと照合してレビューし、40 件を修正した。主なもの:

| 分類 | 例 |
|---|---|
| 意味が逆 | `settings.privacy.disable_search_engine_indexing`「検索エンジンからのアクセスを許可する」→「検索エンジンによるインデックスを無効にする」（チェック＝無効化なので誤訳だと逆の操作になる） |
| 意味が違う | `passwords.user` / `sent` を原文どおりの「登録されていれば届きます」に（アカウント存在の推測を防ぐ意図の文言）、`web.menu.abusive`「児童虐待…」→「攻撃的または有害なコンテンツ」 |
| 文が欠落 | `auth.age` が数字だけ表示されていた →「16歳以上です」 |
| 用語の統一（Mastodon 日本語 UI に準拠） | `name`=表示名 / `username`=ユーザー名、リムーブ→フォロー解除、ストーリーズ→ストーリー、プライベート→非公開、コメント→返信（ストーリー）、切り取り→トリミング、bio=自己紹介 |
| 誤字 | ハッシュダグ → ハッシュタグ |

全件の内訳は `git diff lang/ja-JP` で確認できる。

### Step 7: フロント用 JSON の再生成 ✅

`resources/assets/js/i18n/ja-JP.json` と `public/_lang/ja-JP.json` を更新。開発環境に `vendor/` が無く `php artisan i18n:export` を実行できないため、同コマンドと同じ処理（`web.php` 読み込み → 空文字除去 → `JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES`）を行う一時スクリプトで生成した。同スクリプトで en-US を再生成するとコミット済みファイルとバイト単位で一致することを確認済み。

### Step 8: カバレッジ検証の仕組み ✅

- 新コマンド `php artisan i18n:coverage`（`app/Console/Commands/Dev/I18nCoverage.php`）

  ```sh
  php artisan i18n:coverage                 # 全ロケールの一覧
  php artisan i18n:coverage ja-JP --details # 未翻訳キーとプレースホルダ不一致を表示
  php artisan i18n:coverage ja-JP --min=100 # 100% 未満なら終了コード 1（CI 用）
  ```

- テスト
  - `tests/Unit/LocalizationTest.php` — 正規化・ネゴシエーション・RTL 判定（7 テスト / 40 アサーション）
  - `tests/Feature/I18nCoverageTest.php` — ja-JP 100% の保証、`Accept-Language: ja` で `lang="ja-JP"`、`Accept-Language: ar` で `dir="rtl"` になること

---

## 4. 結果

### 4.1 ja-JP カバレッジ（作業後）

| ファイル | 作業前 | 作業後 |
|---|---|---|
| auth | 20 / 22 | 22 / 22 |
| validation | 68 / 136 | 136 / 136 |
| web | 293 / 328 | 328 / 328 |
| その他 10 ファイル | 291 / 291 | 291 / 291 |
| **合計** | **672 / 777（86.5%）** | **777 / 777（100%）** |

- プレースホルダ / HTML タグの不一致: 0 件
- コードから参照されている翻訳キーのうち en-US に存在しないもの: 0 件（Vue 3 件を修正済み）

### 4.2 検証内容

| 検証 | 結果 |
|---|---|
| `php -l`（変更した PHP 全ファイル） | エラーなし |
| `LocalizationTest`（vendor が無いため最小限の PHPUnit 互換シムで実行） | 7 テスト / 40 アサーション 全て成功 |
| カバレッジ・プレースホルダ照合スクリプト | 100% / 不一致 0 |
| en-US JSON 再生成の一致確認 | バイト単位で一致 |
| `I18nCoverageTest`（Feature） | **未実行**: DB を含む Laravel 環境が必要。`composer install` 後に `php artisan test --filter=I18n` で実行すること |

---

## 5. 残作業・注意点

1. **フロントのビルドが必要**: Vue のキー修正と `ja-JP.json` の更新はコンパイル済みバンドル（`public/js/*`）にまだ反映されていない。`npm run production` で再ビルドすること。
2. **Crowdin との同期**: `auth.php`, `web.php` などは Crowdin 管理下にある（`crowdin.yml`）。今回の訳を Crowdin 側にもアップロードしないと、次回の「Localization update」で空文字や旧訳に戻る。`validation.php` と `pagination.php` は同期対象外なので上書きされない。
3. **RTL の CSS**: Step 5 の補足のとおり、余白ユーティリティなどは RTL 版 CSS を入れるまで反転しない。
4. **相対時刻の言語（C6）**: `vue-timeago` が `locale: 'en'` 固定のため、「3 minutes ago」などは英語のまま。ロケールデータの読み込みが必要で、バンドルサイズに影響するため今回は見送った。
5. **ハードコードされた英語**: カバレッジは「翻訳カタログ（`lang/`）に対する割合」。Blade/Vue に `__()` / `$t()` を通さず直接書かれた英語（管理画面、OAuth 認可画面、埋め込み表示など）は計測対象外で、日本語化するには文字列の抽出から必要。
6. **Deno バックエンド（`apps/backend`）**: i18n 機構はまだ無い。API のエラーメッセージ等を多言語化する場合は、`lang/` と同じキー体系を共有する方針を推奨。

---

# フェーズ 2: ハードコードされた英語の置き換え（2026-10-21 開始）

## 6. 現状調査

Blade / Vue のテンプレートにある、`__()` / `$t()` を経由しない英語文字列を簡易スキャンで数えた（テキストノード、`placeholder`/`title`/`alt`/`aria-label` 属性、`swal`/`alert`/`confirm` の引数）。スキャンは誤検出も含むおおよその値。

| 範囲 | ファイル数 | 推定箇所数 |
|---|---|---|
| Vue コンポーネント（全 203 ファイル） | 約 180 | 約 3,100 |
| Blade: `admin/` | 78 | 約 1,250 |
| Blade: `site/`（ヘルプセンター含む） | 55 | 約 700 |
| Blade: `settings/` | 56 | 約 390 |
| Blade: その他（auth, account, emails, report 等） | 約 180 | 約 750 |
| **合計** | **449** | **約 6,200** |

### 事前に見つかった基盤の問題

| # | 問題 | 対応 |
|---|---|---|
| D1 | Blade 側で `new Vue({ el: '#panel' })` のように独自にルートを作る 14 ページ（管理画面の大半、コレクション作成、ストーリーなど）では、VueI18n が設定されていない。このため、子コンポーネントで `$t()` を使うと実行時エラーになる | `app.js` に共有インスタンス `App.i18n()` を追加した。`App.boot()` と 14 か所の `new Vue()` の両方からこれを使う |
| D2 | フロント用 JSON には `web.php` しか書き出されず、文言を追加できる場所が 1 ファイルに集中していた | Vue 用の新グループ（`admin`, `classic`, `compose`, `groups`, `spa`）を追加した。`ExportLanguages::FRONTEND_GROUPS` で JSON に入れ子で書き出す。未翻訳の言語に英語のコピーが入らないよう、フォールバックなしで読み込む |
| D3 | 新しい翻訳ファイルが Crowdin の同期対象に入っていない | `crowdin.yml` に 8 ファイルを追加 |

## 7. 方針

- 規約は [CONVENTIONS.md](CONVENTIONS.md) にまとめた（ファイルの置き場所、キー命名、Vue/Blade での書き方、エスケープ、翻訳しないもの、日本語用語集）。
- **対象外**
  - 法的文書（`site/privacy`, `site/terms`, `mobile/privacy`, `mobile/terms`）。訳の正確性に法的責任が伴うため
  - インストーラ
  - パッケージ内部のビュー（`vendor/mail`, `vendor/pulse`, `vendor/pagination`）
  - 廃止済みの `My2020.vue`
- 9 つの担当範囲に分けて並列で作業する。担当範囲と担当する翻訳ファイルが重ならないようにし、同じファイルを同時に編集しない。

| 担当 | 対象 | 翻訳ファイル |
|---|---|---|
| A1 | Vue `components/admin/**`, `components/invite/**` | `admin.php` |
| A2 | Vue `components/groups/**`, `components/Group*.vue` | `groups.php` |
| A3 | Vue 投稿作成・ストーリー・プレゼンター・フィルター・ポートフォリオ | `compose.php` |
| A4 | Vue `js/components/**`（A3 以外） | `classic.php` |
| A5 | Vue `components/**`（A1・A2・A3 以外） | `spa.php` |
| B1 | Blade `admin/**` | `admin_panel.php` |
| B2 | Blade `settings/**` | `settings.php`（追記） |
| B3 | Blade `site/**`（法的文書を除く） | `site.php`, `helpcenter.php`（追記） |
| B4 | Blade その他すべて（メール、認証、エラーページ等） | `pages.php`, `emails.php`, `auth.php` 等（追記） |

- 検証: 簡易チェッカー（vendor 不要）で次の 4 点を機械的に確認する。
  1. コードが参照する全キーが en-US に存在する
  2. en-US と ja-JP のキーが一致している
  3. プレースホルダと HTML タグが一致している
  4. vue-i18n で問題になる `|` を含まない

## 8. 作業記録（フェーズ 2）

- [x] D1〜D3 の基盤対応
- [x] 規約ドキュメント作成、チェッカー作成（作業前の時点でエラー 0）
- [x] A1〜A5, B1〜B4 の置き換え
- [x] 統合検証・JSON 再生成・結果記録

### 8.1 並列作業の進め方と、途中で起きたこと

- 規模が大きい担当（A2 groups、A5 spa、B1 admin）は、さらに 5〜7 の補助エージェントに分けた。補助エージェントは翻訳ファイルを直接編集せず、担当ごとの断片ファイルに書き出す。最後に結合スクリプトで `groups.php` / `spa.php` / `admin_panel.php` を生成した。コンポーネント単位のトップレベルキーを事前に割り当て、結合時の衝突は 0 件だった。
- A4 が、共有スクラッチ領域にあった A3 の生成スクリプトを誤って実行し、`compose.php` が A3 自身のデータから再生成される事故があった。確認したところ、キー数は A3 の報告どおり 368 件で、コードから参照される `compose.*` キー（`<i18n path>` を含む）もすべて存在した。欠落なしと判断した。

### 8.2 担当ごとの結果

| 担当 | 変更ファイル | 追加キー | 主な補足 |
|---|---|---|---|
| A1 Vue 管理画面 | 13 | 648 | ラベルから id を作る部品（`AdminSettingsCheckbox` / `Input`）で、日本語ラベルだと id が衝突する問題を修正 |
| A2 Vue グループ | 約 50 | 610 | 5 分割で実施 |
| A3 Vue 投稿作成など | 26 | 368 | FilterModal の「カスタム期間」が「1週間」と表示されていた不具合を修正 |
| A4 Vue 旧 UI | 23 | 488 | `<i18n>` コンポーネントを 52 か所で使用 |
| A5 Vue SPA | 約 60 | 541 | 7 分割で実施。Changelog も翻訳 |
| B1 Blade 管理画面 | 約 75 | 819 | 6 分割で実施。診断ページは設定名・値を英語のまま残した |
| B2 Blade 設定 | 41 | 275 | 既存の `'{{__()}}'` を JS に埋め込むと `&#039;` が表示される問題を `@json` で解消 |
| B3 Blade サイト・ヘルプ | 48 | 413 | `contact` で接頭辞が抜けてキー名がそのまま表示されていた不具合を修正 |
| B4 Blade その他・メール | 約 110 | 484 | `lang="en"` 固定だった 6 テンプレートをロケール対応に。`__('Verify')` のような JSON 翻訳前提の呼び出し（翻訳ファイルが存在せず常に英語だった）もキー化 |

### 8.3 統合後に行った修正

- 用語の統一: Curated Onboarding →「審査制登録」、Autospam →「自動スパム検出」、グループの `from` 表記
- 日付・数値の書式で `'en-US'` / `'en-GB'` が直接書かれていた 9 ファイルを、ページの言語（`<html lang>`）を使うよう修正。例: プロフィールの登録日が「参加 October 2026」→「2026年10月」になる
- もともとあった不具合の修正
  - `admin/users/invites/create.blade.php` に余分な `}}`
  - `StoryCompose.vue` でユーザー名ではなく文字列 `viewer.username` が表示されていた
- 取りこぼし 3 件（ブックマークの確認文とエラー、管理画面ナビの aria-label）をキー化
- チェッカー 3 種を `scripts/i18n/` に追加した（規約ドキュメントを参照）

## 9. 結果（フェーズ 2）

### 9.1 数値

| 項目 | 作業前 | 作業後 |
|---|---|---|
| 翻訳キー数（en-US） | 777 | 5,423 |
| ja-JP カバレッジ | 100%（777 件） | **100%（5,423 件）** |
| 簡易スキャンのハードコード英語 | 約 6,200 | 約 1,060（後述のとおり大半は誤検出・対象外） |
| 変更ファイル | — | 約 490（Vue 171、Blade 285、翻訳ファイルなど） |

スキャンに残る約 1,060 件の内訳:
- 対象外としたページ: 法的文書 4 ファイル、診断ページの設定名、My2020
- 変数式、設定キー名、ブランド名（hCaptcha、Google Authenticator など）といった誤検出

「先頭が大文字の英文」に絞った厳密スキャンでは、残りは以下の 9 件で、いずれも意図的に残したもの。
- ブランド名 6 件
- 使われていない `data-title` 属性 1 件
- `onbeforeunload` 内の alert 1 件（ブラウザが表示しない）
- `Toggle navigation` 1 件（修正済み）

### 9.2 検証

| 検証 | 結果 |
|---|---|
| `check-keys.php`（参照キー 7,374 件の存在、en/ja のキー一致、プレースホルダ一致、`\|` 禁止） | エラー 0 |
| `check-vue.js`（変更した Vue 171 ファイルのテンプレートのコンパイルと script の構文解析） | エラー 0 |
| `check-blade.py`（変更した Blade 285 ファイルの式の `php -l` と、HEAD からのディレクティブ対応の変化） | エラー 0 |
| 全翻訳ファイルの `php -l` | エラー 0 |
| `LocalizationTest` | 40 アサーション成功 |
| ブラウザでの表示確認 | **未実施**（`vendor/` が無く、ビルドもしていないため） |

## 10. 残作業・注意点（フェーズ 2）

1. **ビルドと表示確認**
   - `composer install` → `php artisan i18n:export` → `npm run production` の順に実行し、ブラウザで主要画面を確認すること。
   - `i18n:export` は今回作った JSON と同じ内容を出力する。en-US / ja-JP 以外の言語には新しいグループが無いため、実行時は英語にフォールバックする。
2. **バンドルサイズ**
   - 全言語の JSON を各エントリ（app / spa / landing / settings）に同梱する既存の方式のため、en-US と ja-JP の分だけ増える（JSON の生データで約 16KB → 179KB と 337KB）。
   - ja-JP が大きいのは、エクスポーターが日本語を `\uXXXX` でエスケープするため。
   - 対策の候補: `JSON_UNESCAPED_UNICODE` の採用、ロケール JSON の遅延読み込み（`public/_lang/*.json` を取得する方式）。
3. **メールの言語**
   - キュー経由で送るメールは、送信時のアプリのロケール（通常は既定言語）で描画される。受信者の言語で送るには、各 Mailable に `->locale($user->language)` を付ける改修が必要。
4. **サーバー側で生成される文言**
   - 次のものは Blade / Vue の外にあり、英語のまま。
     - コントローラの JSON エラーメッセージ
     - OAuth スコープの説明
     - メールの件名（PHP クラス内）
     - `config/instance.php` の既定文言（エラーページは、既定値のときだけ翻訳を表示するようにした）
5. **原文の誤り**
   - en-US は「原文を変えない」方針で、typo（occured, recieve など）や内容の誤りをそのまま残した。
   - 例: ヘルプの「確認メールが届かない」の回答が、ユーザー名重複の説明になっている。
   - 修正する場合は en-US を直し、Crowdin 側の原文も更新する。
6. **相対時刻**
   - SPA の `timeAgo` は「3h」のような短い単位表記で、日本語でも「3h前」と表示される。`Intl.RelativeTimeFormat` への置き換えは、表示幅が変わるため見送った。
7. **日本語訳のレビュー**
   - 機械的なチェックは通っているが、約 4,600 件の新しい訳は母語話者によるレビューを推奨する。特にメールの挨拶文、ヘルプセンターの長文、管理画面の専門用語。
