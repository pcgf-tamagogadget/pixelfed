<?php

namespace Tests\Unit;

use App\Util\Localization\Localization;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LocalizationTest extends TestCase
{
    protected const AVAILABLE = ['en-US', 'en-x-pirate', 'ja-JP', 'zh-CN', 'zh-TW', 'pt-PT', 'no-NO', 'ar-SA', 'de-DE'];

    #[Test]
    public function normalizes_legacy_codes()
    {
        $this->assertEquals('ja-JP', Localization::normalizeLocale('ja'));
        $this->assertEquals('zh-TW', Localization::normalizeLocale('zh-tw'));
        $this->assertEquals('en-US', Localization::normalizeLocale(''));
        $this->assertEquals('ja-JP', Localization::normalizeLocale('ja-JP'));
    }

    #[Test]
    public function negotiates_exact_match_case_insensitively()
    {
        $this->assertEquals('ja-JP', Localization::negotiate(['ja_JP', 'ja'], self::AVAILABLE));
        $this->assertEquals('de-DE', Localization::negotiate(['de-de'], self::AVAILABLE));
    }

    #[Test]
    public function negotiates_primary_subtag()
    {
        $this->assertEquals('ja-JP', Localization::negotiate(['ja'], self::AVAILABLE));
        $this->assertEquals('pt-PT', Localization::negotiate(['pt_BR', 'pt'], self::AVAILABLE));
        $this->assertEquals('en-US', Localization::negotiate(['en_GB', 'en'], self::AVAILABLE));
        $this->assertEquals('no-NO', Localization::negotiate(['nb_NO', 'nb'], self::AVAILABLE));
    }

    #[Test]
    public function negotiates_chinese_scripts_and_regions()
    {
        $this->assertEquals('zh-TW', Localization::negotiate(['zh_HANT_TW'], self::AVAILABLE));
        $this->assertEquals('zh-TW', Localization::negotiate(['zh_HK'], self::AVAILABLE));
        $this->assertEquals('zh-CN', Localization::negotiate(['zh_HANS'], self::AVAILABLE));
        $this->assertEquals('zh-CN', Localization::negotiate(['zh'], self::AVAILABLE));
    }

    #[Test]
    public function negotiation_respects_preference_order_and_skips_unknown()
    {
        $this->assertEquals('de-DE', Localization::negotiate(['xx', '*', 'de', 'ja'], self::AVAILABLE));
        $this->assertNull(Localization::negotiate(['xx', 'yy_ZZ'], self::AVAILABLE));
        $this->assertNull(Localization::negotiate([], self::AVAILABLE));
    }

    #[Test]
    public function never_negotiates_private_use_variants()
    {
        $this->assertNull(Localization::negotiate(['en'], ['en-x-pirate', 'ja-JP']));
    }

    #[Test]
    public function detects_rtl_locales()
    {
        foreach (['ar-SA', 'he-IL', 'fa-IR', 'ckb-IR', 'ug-CN', 'ps-AF', 'syc-SY'] as $locale) {
            $this->assertTrue(Localization::isRtl($locale), $locale);
            $this->assertEquals('rtl', Localization::direction($locale));
        }

        foreach (['en-US', 'ja-JP', 'ku-TR', 'zh-TW'] as $locale) {
            $this->assertFalse(Localization::isRtl($locale), $locale);
            $this->assertEquals('ltr', Localization::direction($locale));
        }
    }
}
