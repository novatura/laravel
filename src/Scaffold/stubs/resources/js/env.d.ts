/// <reference types="vite/client" />

import routeFn from "ziggy-js"

declare global {
    var route: typeof routeFn;
}
