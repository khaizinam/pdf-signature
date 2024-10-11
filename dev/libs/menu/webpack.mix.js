const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `dev/libs/${directory}`
const dist = `public/vendor/core/libs/${directory}`

mix
    .js(`${source}/resources/js/menu.js`, `${dist}/js`)
    .sass(`${source}/resources/sass/menu.scss`, `${dist}/css`)

if (mix.inProduction()) {
    mix
        .copy(`${dist}/js/menu.js`, `${source}/public/js`)
        .copy(`${dist}/css/menu.css`, `${source}/public/css`)
}
