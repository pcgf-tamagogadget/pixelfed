<?php

namespace App\Console\Commands\Dev;

use App\Util\Localization\Localization;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class I18nCoverage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'i18n:coverage
        {locale?* : Locales to check (default: every locale under lang/)}
        {--min=0 : Exit with failure if any checked locale is below this percentage}
        {--details : List untranslated keys and placeholder mismatches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report translation coverage of each locale against lang/en-US.';

    /**
     * Matches :placeholders (Laravel), {placeholders} (vue-i18n) and HTML tags.
     */
    protected const TOKEN_PATTERN = '/(:[a-z_]+|\{[a-z_]+\}|<\/?[a-z]+)/';

    protected const SOURCE_LOCALE = 'en-US';

    public function handle(): int
    {
        $locales = $this->argument('locale') ?: array_values(array_diff(Localization::languages(), [self::SOURCE_LOCALE]));
        $min = (float) $this->option('min');
        $groups = $this->groups();
        $failed = false;
        $rows = [];

        foreach ($locales as $locale) {
            $locale = Localization::normalizeLocale($locale);
            $total = 0;
            $translated = 0;
            $untranslated = [];
            $mismatched = [];

            foreach ($groups as $group) {
                $source = Arr::dot($this->load(self::SOURCE_LOCALE, $group));
                $target = Arr::dot($this->load($locale, $group));

                foreach ($source as $key => $value) {
                    if (! is_string($value)) {
                        continue;
                    }

                    $total++;
                    $translation = $target[$key] ?? null;

                    if (! is_string($translation) || trim($translation) === '') {
                        $untranslated[] = "{$group}.{$key}";

                        continue;
                    }

                    $translated++;

                    if ($this->tokens($value) !== $this->tokens($translation)) {
                        $mismatched[] = "{$group}.{$key}";
                    }
                }
            }

            $percent = $total > 0 ? round($translated / $total * 100, 1) : 0.0;
            $failed = $failed || $percent < $min;
            $rows[] = [$locale, "{$translated}/{$total}", "{$percent}%", count($mismatched)];

            if ($this->option('details')) {
                foreach ($untranslated as $key) {
                    $this->line("  [{$locale}] untranslated: {$key}");
                }
                foreach ($mismatched as $key) {
                    $this->line("  [{$locale}] placeholder mismatch: {$key}");
                }
            }
        }

        $this->table(['Locale', 'Translated', 'Coverage', 'Placeholder mismatches'], $rows);

        if ($failed) {
            $this->error("One or more locales are below {$min}% coverage.");

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Translation groups (file names) of the source locale.
     *
     * @return array<int, string>
     */
    protected function groups(): array
    {
        return array_map(
            fn ($path) => basename($path, '.php'),
            glob(lang_path(self::SOURCE_LOCALE.'/*.php')) ?: []
        );
    }

    /**
     * Raw strings for one locale/group, without fallback. The app's loader
     * already drops empty strings, so untranslated keys come back missing.
     */
    protected function load(string $locale, string $group): array
    {
        return app('translation.loader')->load($locale, $group);
    }

    /**
     * @return array<int, string>
     */
    protected function tokens(string $value): array
    {
        preg_match_all(self::TOKEN_PATTERN, $value, $matches);
        $tokens = $matches[0];
        sort($tokens);

        return $tokens;
    }
}
