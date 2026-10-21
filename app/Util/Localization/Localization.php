<?php

namespace App\Util\Localization;

use Illuminate\Support\Arr;

class Localization
{
    /**
     * Legacy two-letter (and legacy region) language codes mapped to the
     * current locale-coded folder names under lang/.
     * Added September 2026 - DELETE AFTER COMMUNICATION WITH ADMINS
     *
     * @var array<string, string>
     */
    const LEGACY_LOCALE_MAP = [
        'af' => 'af-ZA',
        'ar' => 'ar-SA',
        'bn' => 'bn-BD',
        'bs' => 'bs-BA',
        'ca' => 'ca-ES',
        'cs' => 'cs-CZ',
        'cy' => 'cy-GB',
        'da' => 'da-DK',
        'de' => 'de-DE',
        'el' => 'el-GR',
        'en' => 'en-US',
        'eo' => 'eo-UY',
        'es' => 'es-ES',
        'eu' => 'eu-ES',
        'fa' => 'fa-IR',
        'fi' => 'fi-FI',
        'fr' => 'fr-FR',
        'gd' => 'gd-GB',
        'gl' => 'gl-ES',
        'he' => 'he-IL',
        'hi' => 'hi-IN',
        'hr' => 'hr-HR',
        'hu' => 'hu-HU',
        'id' => 'id-ID',
        'it' => 'it-IT',
        'ja' => 'ja-JP',
        'ko' => 'ko-KR',
        'me' => 'me-ME',
        'mk' => 'mk-MK',
        'ms' => 'ms-MY',
        'nl' => 'nl-NL',
        'no' => 'no-NO',
        'oc' => 'oc-FR',
        'pl' => 'pl-PL',
        'pt' => 'pt-PT',
        'ro' => 'ro-RO',
        'ru' => 'ru-RU',
        'sk' => 'sk-SK',
        'sr' => 'sr-CS',
        'sv' => 'sv-SE',
        'th' => 'th-TH',
        'tr' => 'tr-TR',
        'uk' => 'uk-UA',
        'vi' => 'vi-VN',
        'zh-cn' => 'zh-CN',
        'zh-tw' => 'zh-TW',
    ];

    /**
     * Browser language tags that need an explicit mapping because the
     * primary subtag alone is ambiguous (e.g. Traditional vs Simplified
     * Chinese). Keys are lowercase, hyphen-separated.
     *
     * @var array<string, string>
     */
    const BROWSER_LOCALE_ALIASES = [
        'zh' => 'zh-CN',
        'zh-hant' => 'zh-TW',
        'zh-hk' => 'zh-TW',
        'zh-mo' => 'zh-TW',
        'zh-hans' => 'zh-CN',
        'zh-sg' => 'zh-CN',
        'nb' => 'no-NO',
        'nn' => 'no-NO',
    ];

    /**
     * Primary language subtags written right-to-left.
     *
     * @var array<int, string>
     */
    const RTL_LANGUAGES = ['ar', 'ckb', 'dv', 'fa', 'he', 'ps', 'syc', 'ug', 'ur', 'yi'];

    /**
     * Normalize a configured locale to a current locale-coded value.
     *
     * Empty input returns "en-US"; a known legacy short code is mapped;
     * anything else (already-current or custom codes) is returned unchanged so
     * the framework's own fallback_locale still applies. Always returns a
     * plain string, so it is safe to use in config values that get cached.
     */
    public static function normalizeLocale(?string $locale): string
    {
        $locale = is_string($locale) ? trim($locale) : '';

        if ($locale === '') {
            return 'en-US';
        }

        return self::LEGACY_LOCALE_MAP[strtolower($locale)] ?? $locale;
    }

    /**
     * Whether the given locale has a lang/ folder (after normalization).
     */
    public static function isAvailable(?string $locale): bool
    {
        if (! is_string($locale) || trim($locale) === '') {
            return false;
        }

        return in_array(static::normalizeLocale($locale), static::languages(), true);
    }

    /**
     * Pick the best available locale for a list of browser language tags,
     * ordered by preference (as returned by Request::getLanguages(), e.g.
     * ['ja_JP', 'ja', 'en_US', 'en']).
     *
     * Each tag is tried as an exact match, then via the alias and legacy
     * maps, then by its primary subtag against the available locales.
     *
     * @param  array<int, string>  $tags
     * @param  array<int, string>|null  $available  Defaults to languages().
     */
    public static function negotiate(array $tags, ?array $available = null): ?string
    {
        $available = $available ?? static::languages();
        $byLower = [];
        foreach ($available as $code) {
            $byLower[strtolower($code)] = $code;
        }

        foreach ($tags as $tag) {
            if (! is_string($tag) || trim($tag) === '' || $tag === '*') {
                continue;
            }

            $lower = strtolower(str_replace('_', '-', trim($tag)));
            $parts = explode('-', $lower);
            $primary = $parts[0];

            if (isset($byLower[$lower])) {
                return $byLower[$lower];
            }

            $candidates = [];
            foreach ([$lower, $primary.'-'.($parts[1] ?? '')] as $key) {
                if (isset(self::BROWSER_LOCALE_ALIASES[$key])) {
                    $candidates[] = self::BROWSER_LOCALE_ALIASES[$key];
                }
            }
            if ($primary === 'zh' && array_intersect($parts, ['hant', 'tw', 'hk', 'mo'])) {
                $candidates[] = 'zh-TW';
            }
            if (isset(self::BROWSER_LOCALE_ALIASES[$primary])) {
                $candidates[] = self::BROWSER_LOCALE_ALIASES[$primary];
            }
            if (isset(self::LEGACY_LOCALE_MAP[$primary])) {
                $candidates[] = self::LEGACY_LOCALE_MAP[$primary];
            }

            foreach ($candidates as $candidate) {
                if (isset($byLower[strtolower($candidate)])) {
                    return $byLower[strtolower($candidate)];
                }
            }

            foreach ($byLower as $lowerCode => $code) {
                // Skip private-use variants such as en-x-pirate.
                if (str_starts_with($lowerCode, $primary.'-') && ! str_contains($lowerCode, '-x-')) {
                    return $code;
                }
            }
        }

        return null;
    }

    /**
     * Whether the locale is written right-to-left.
     */
    public static function isRtl(?string $locale): bool
    {
        $primary = strtolower(explode('-', str_replace('_', '-', (string) $locale))[0]);

        return in_array($primary, self::RTL_LANGUAGES, true);
    }

    /**
     * The HTML dir attribute value ("rtl" or "ltr") for the locale.
     */
    public static function direction(?string $locale = null): string
    {
        return static::isRtl($locale ?? app()->getLocale()) ? 'rtl' : 'ltr';
    }

    /**
     * List of available UI language codes.
     *
     * Reads the static manifest generated by `php artisan i18n:export`
     * (lang/locales.json) so the list is deterministic and never served from
     * a runtime cache that can go stale. Falls back to scanning the lang/
     * directory if the manifest is missing.
     *
     * @return array<int, string>
     */
    public static function languages()
    {
        return static::localesFromManifest() ?? static::localesFromScan();
    }

    /**
     * Full locale metadata (code, name, nativeName) from the manifest,
     * sorted by display name. Empty array if the manifest is missing.
     *
     * @return array<int, array{code: string, name: string, nativeName: string}>
     */
    public static function locales(): array
    {
        $path = lang_path('locales.json');

        if (! is_file($path)) {
            return [];
        }

        $data = json_decode((string) file_get_contents($path), true);

        return is_array($data) ? $data : [];
    }

    /**
     * @return array<int, string>|null
     */
    protected static function localesFromManifest(): ?array
    {
        $locales = static::locales();

        if ($locales === []) {
            return null;
        }

        return array_values(array_filter(array_map(
            fn ($l) => $l['code'] ?? null,
            $locales
        )));
    }

    /**
     * @return array<int, string>
     */
    protected static function localesFromScan(): array
    {
        $dir = lang_path();

        return Arr::flatten(array_diff(scandir($dir), ['..', '.', 'vendor', '.DS_Store', 'locales.json']));
    }
}
