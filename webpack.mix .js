const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false
    })
    .sourceMaps();

mix.browserSync('your-local-domain.test');

// Adicione estas linhas para importar Bootstrap e jQuery
mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
], 'public/js/app.js');

mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css',
], 'public/css/app.css');
