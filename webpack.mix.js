const mix = require('laravel-mix');
const fs = require('fs');
const path = require('path');

// Webpack 4 ignores package.json "exports": map the Tiptap subpaths
// (e.g. @tiptap/pm/state) to their ESM files by hand.
const tiptapAliases = () => {
    const scope = path.join(__dirname, 'node_modules/@tiptap');
    const aliases = {};
    fs.readdirSync(scope).forEach(name => {
        const exports = require(path.join(scope, name, 'package.json')).exports || {};
        Object.keys(exports).filter(key => key.startsWith('./') && key !== './package.json').forEach(key => {
            const target = exports[key].import || exports[key].default;
            if (typeof target === 'string') {
                aliases[`@tiptap/${name}/${key.slice(2)}$`] = path.join(scope, name, target);
            }
        });
    });
    return aliases;
};

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            //'vue$': 'vue/dist/vue.esm.js',
            '@': __dirname + '/resources/js/dashboard/',
            '@events': __dirname + '/resources/js/web/events/',
            ...tiptapAliases(),
        },
    },
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Web
mix.sass('resources/sass/web/app.scss', 'public/assets/css/app.css').options({processCssUrls: false}).version();
mix.js('resources/js/web/events/app.js', 'public/assets/js/events.js').version();
mix.js('resources/js/web/app.js', 'public/assets/js/app.js').version();
      
// Dashboard
mix.js('resources/js/dashboard/app.js', 'public/assets/dashboard/js/bundle.administration.js').version();
mix.sass('resources/sass/dashboard/app.scss', 'public/assets/dashboard/css/app.css').options({processCssUrls: false}).version();