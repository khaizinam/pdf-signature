const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `dev/plugins/${directory}`
const dist = `public/vendor/core/plugins/${directory}`

mix
    .sass(`${source}/resources/sass/cookie-consent.scss`, `${dist}/css`)
    .js(`${source}/resources/js/cookie-consent.js`, `${dist}/js`)

if (mix.inProduction()) {
    mix
        .copy(`${dist}/css/cookie-consent.css`, `${source}/public/css`)
        .copy(`${dist}/js/cookie-consent.js`, `${source}/public/js`)
}
