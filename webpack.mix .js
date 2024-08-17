const mix = require('laravel-mix');




mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false
    })
    .sourceMaps();

// BrowserSync configuração
mix.browserSync({
    proxy: 'localhost:8000', // Substitua pelo seu domínio local
    files: [
        'app/**/*',
        'resources/views/**/*',
        'resources/js/**/*',
        'resources/sass/**/*',
        'public/**/*'
    ],
    open: false
});

// Adicione estas linhas para importar Bootstrap e jQuery
mix.scripts([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
], 'public/js/vendor.js');

mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css',
], 'public/css/vendor.css');
