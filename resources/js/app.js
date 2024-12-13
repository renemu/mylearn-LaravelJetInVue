import "./bootstrap";
import "../css/app.css";
import "remixicon/fonts/remixicon.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
// import { Head } from "@inertiajs/vue3";
// const appName = import.meta.env.VITE_APP_NAME || "Test";

createInertiaApp({
    // title: (title) => `${title} - ${appName}`,
    title: (title) => `${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props),
            mounted() {
                // Tambahkan favicon
                const link = document.createElement("link");
                link.rel = "icon";
                link.href = "/favicon.ico";
                document.head.appendChild(link);
            },
        });
        return app.use(plugin).use(ZiggyVue).mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
