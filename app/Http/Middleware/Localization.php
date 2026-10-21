<?php

namespace App\Http\Middleware;

use App\Util\Localization\Localization as LocalizationUtil;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * Locale precedence: session (explicit choice) → the signed-in user's
     * saved language → the browser's Accept-Language header → app.locale.
     * Only locales that exist under lang/ are applied.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $this->resolveLocale($request);

        if ($locale !== null) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    protected function resolveLocale(Request $request): ?string
    {
        if (Session::has('locale')) {
            $locale = LocalizationUtil::normalizeLocale(Session::get('locale'));
            if (LocalizationUtil::isAvailable($locale)) {
                return $locale;
            }
        }

        $user = $request->user();
        if ($user && $user->language) {
            $locale = LocalizationUtil::normalizeLocale($user->language);
            if (LocalizationUtil::isAvailable($locale)) {
                return $locale;
            }
        }

        if (config('app.locale_negotiation', true)) {
            return LocalizationUtil::negotiate($request->getLanguages());
        }

        return null;
    }
}
