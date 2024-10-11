let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'dev/plugins/' + directory;
const dist = 'public/vendor/core/plugins/' + directory;

mix.js(source + '/resources/assets/js/vig-ai.js', dist + '/js');

if (mix.inProduction()) {
    mix.copy(dist + '/js/vig-ai.js', source + '/public/js');
}
