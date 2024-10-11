let mix = require('laravel-mix')

const path = require('path')
let directory = path.basename(path.resolve(__dirname))

const source = 'dev/ui/' + directory
const dist = 'public/ui/' + directory

mix
    .sass(source + '/assets/sass/style.scss', dist + '/css')
    .js(source + '/assets/js/script.js', dist + '/js')
    .copy(source + '/assets/fonts', dist + '/fonts')

if (mix.inProduction()) {
    mix
        .copy(dist + '/css/style.css', source + '/public/css')
        .copy(dist + '/js/script.js', source + '/public/js')
        .copy(source + '/assets/fonts', dist + '/fonts')
}
