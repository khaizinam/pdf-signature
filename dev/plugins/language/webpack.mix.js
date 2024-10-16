const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `dev/plugins/${directory}`
const dist = `public/vendor/core/plugins/${directory}`

mix
    .js(`${source}/resources/js/language.js`, `${dist}/js/language.js`)
    .js(`${source}/resources/js/language-global.js`, `${dist}/js/language-global.js`)
    .js(`${source}/resources/js/language-public.js`, `${dist}/js`)
    .sass(`${source}/resources/sass/language.scss`, `${dist}/css`)
    .sass(`${source}/resources/sass/language-public.scss`, `${dist}/css`)

if (mix.inProduction()) {
    mix
        .copy(`${dist}/js/language.js`, `${source}/public/js`)
        .copy(`${dist}/js/language-global.js`, `${source}/public/js`)
        .copy(`${dist}/js/language-public.js`, `${source}/public/js`)
        .copy(`${dist}/css/language.css`, `${source}/public/css`)
        .copy(`${dist}/css/language-public.css`, `${source}/public/css`)
}
