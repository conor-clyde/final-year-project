<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Rules\GenreRequiredIfNewTitleProvided;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('genre_required_if_new_title', GenreRequiredIfNewTitleProvided::class);

        Schema::defaultStringLength(191);

        // Add query logging in development
        if (config('app.debug')) {
            DB::listen(function ($query) {
                if ($query->time > 100) { // Log slow queries (>100ms)
                    \Log::warning('Slow query detected', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time' => $query->time,
                    ]);
                }
            });
        }

        // Cache frequently accessed data
        $this->cacheFrequentlyAccessedData();
    }

    /**
     * Cache frequently accessed data for better performance
     */
    private function cacheFrequentlyAccessedData(): void
    {
        // Cache genres for 1 hour
        Cache::remember('genres_active', 3600, function () {
            return \App\Models\Genre::where('archived', false)
                ->orderBy('name')
                ->get();
        });

        // Cache conditions for 1 hour
        Cache::remember('conditions_all', 3600, function () {
            return \App\Models\Condition::all();
        });

        // Cache languages for 1 hour
        Cache::remember('languages_all', 3600, function () {
            return \App\Models\Language::all();
        });

        // Cache formats for 1 hour
        Cache::remember('formats_all', 3600, function () {
            return \App\Models\Format::all();
        });
    }
}
