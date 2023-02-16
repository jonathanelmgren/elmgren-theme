import { defineConfig } from "vite";
import autoprefixer from "autoprefixer";
import { readdirSync } from 'fs'

const directories = readdirSync('blocks')

const input = [
    'assets/js/main.js',
    'assets/js/plugins.js',
    'assets/js/gutenberg.js',
    'assets/scss/main.scss',
    'assets/scss/gutenberg.scss',
]

for (const dir of directories) {
    const files = readdirSync(`blocks/${dir}`)
    for (const file of files) {
        if (file === `${dir}.scss` || file === `${dir}.js`) {
            input.push(`blocks/${dir}/${file}`)
        }
    }
}

export default defineConfig({
    base: "./",
    css: {
        postcss: {
            plugins: [autoprefixer()],
        },
    },
    build: {
        rollupOptions: {
            manifest: true,
            input: input,
            output: {
                entryFileNames: "[name].js",
                assetFileNames: "[name].css",
            }
        },
    },
});