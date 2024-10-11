const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `dev/plugins/${directory}`
const dist = `public/vendor/core/plugins/${directory}`

mix.js(`${source}/resources/js/request-log.js`, `${dist}/js`)

if (mix.inProduction()) {
    mix.copy(`${dist}/js/request-log.js`, `${source}/public/js`)
}
