const mix = require('laravel-mix')
const path = require('path')

const directory = path.basename(path.resolve(__dirname))
const source = `dev/libs/${directory}`
const dist = `public/vendor/core/libs/${directory}`

mix.sass(`${source}/resources/sass/style.scss`, `${dist}/css`)

if (mix.inProduction()) {
    mix.copy(`${dist}/css/style.css`, `${source}/public/css`)
}
