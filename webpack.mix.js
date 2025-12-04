const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | This project uses Metronic pre-built assets.
 | No compilation needed - all assets are in public/assets/
 |
 */

// Dummy compilation to satisfy Laravel Mix requirement
mix.setPublicPath('public');

// Copy any custom assets if needed
if (mix.inProduction()) {
    mix.version();
}
