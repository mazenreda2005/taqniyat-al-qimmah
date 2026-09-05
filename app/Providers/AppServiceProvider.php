<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Make Str available in Blade templates
        \Blade::directive('str', function ($expression) {
            return "<?php echo \\Illuminate\\Support\\Str::{$expression}; ?>";
        });
    }
}
