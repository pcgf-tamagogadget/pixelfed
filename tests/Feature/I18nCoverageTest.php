<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class I18nCoverageTest extends TestCase
{
    #[Test]
    public function japanese_translation_is_complete()
    {
        $this->artisan('i18n:coverage', ['locale' => ['ja-JP'], '--min' => 100])
            ->assertExitCode(0);
    }

    #[Test]
    public function browser_language_selects_locale_for_guests()
    {
        $this->withHeaders(['Accept-Language' => 'ja,en-US;q=0.8'])
            ->get('/site/language')
            ->assertSee('lang="ja-JP"', false);
    }

    #[Test]
    public function rtl_locale_sets_html_dir()
    {
        $this->withHeaders(['Accept-Language' => 'ar'])
            ->get('/site/language')
            ->assertSee('dir="rtl"', false);
    }
}
