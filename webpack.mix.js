const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

const sassOptions = {
    processCssUrls: false,
    postCss: [require('autoprefixer'), tailwindcss('./tailwind.config.js')],
    implementation: require('sass'),
    sassOptions: { fiber: require('fibers') },
};

let productionSourceMaps = false;

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .webpackConfig(require('./webpack.config'))
    .sourceMaps(productionSourceMaps, 'source-map');

mix.sass(
    'resources/css/app.scss',
    'public/css/test.css'
).options(sassOptions);

mix.copy('resources/images/*', 'public/images');

if (mix.inProduction()) {
    mix.version();
}
