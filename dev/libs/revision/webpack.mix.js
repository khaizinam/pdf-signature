const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `dev/libs/${directory}`
const dist = `public/vendor/core/libs/${directory}`

mix
    .sass(`${source}/resources/sass/revision.scss`, `${dist}/css`)
    .js(`${source}/resources/js/revision.js`, `${dist}/js`)

if (mix.inProduction()) {
    mix
        .copy(`${dist}/css/revision.css`, `${source}/public/css`)
        .copy(`${dist}/js/revision.js`, `${source}/public/js`)
}
