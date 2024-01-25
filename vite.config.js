import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: [...refreshPaths, "app/Http/Livewire/**"],
        }),
    ],
    server: {
        host: process.env.LARAVEL_SAIL
            ? Object.values(os.networkInterfaces())
                  .flat()
                  .find((info) => info?.internal === false)?.address
            : undefined,
    },
});
