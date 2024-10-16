const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `dev/libs/${directory}`
const dist = `public/vendor/core/libs/${directory}`

mix
    .js(`${source}/resources/js/seo-helper.js`, `${dist}/js`)
    .sass(`${source}/resources/sass/seo-helper.scss`, `${dist}/css`)

if (mix.inProduction()) {
    mix
        .copy(`${dist}/js/seo-helper.js`, `${source}/public/js`)
        .copy(`${dist}/css/seo-helper.css`, `${source}/public/css`)
}
