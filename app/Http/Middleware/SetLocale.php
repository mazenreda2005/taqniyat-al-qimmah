<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * تعيين لغة التطبيق من الجلسة (بعد تشغيل StartSession).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locales = config('app.locales', []);
        $locale = session('locale', config('app.locale'));

        if (isset($locales[$locale])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
