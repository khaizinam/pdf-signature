const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `dev/libs/${directory}`
const dist = `public/vendor/core/libs/${directory}`

mix
    .js(`${source}/resources/js/slug.js`, `${dist}/js`)
    .sass(`${source}/resources/sass/slug.scss`, `${dist}/css`)

if (mix.inProduction()) {
    mix
        .copy(`${dist}/js/slug.js`, `${source}/public/js`)
        .copy(`${dist}/css/slug.css`, `${source}/public/css`)
}
