import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Providers from "@/Providers";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title(title) {
        return `${title} | ${appName}`;
    },
    resolve(name) {
        return resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx'))
    },
    setup({ el, App, props }) {
        createRoot(el).render(<>
            <Providers>
                <App {...props} />
            </Providers>
        </>);
    },
    progress: false
})
