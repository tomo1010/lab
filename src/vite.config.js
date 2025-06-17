import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: true,           // ✅ Dockerからアクセスできるようにする
        port: 5173,           // ✅ 必要ならポートも明示（省略可）
        strictPort: true,     // ✅ ポート競合時に落ちる（ポートずれ防止）
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
