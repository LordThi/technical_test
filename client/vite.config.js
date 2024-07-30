import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import { resolve } from 'path'
import path from 'path'

export default defineConfig({
    plugins: [react()],
    server: {
        proxy: {
            '/api': 'http://technical_test.local:8014',
        },
    },
    build: {
        outDir: '../public/build',
        emptyOutDir: true,
        rollupOptions: {
            input: resolve(path.dirname(''), 'index.html')
        }
    }
})
