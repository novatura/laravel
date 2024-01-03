import { ReactNode } from "react";
import Theme from "@/Theme";
import { MantineProvider } from "@mantine/core";
import { Notifications } from "@mantine/notifications";
import { NavigationProgress, nprogress } from '@mantine/nprogress';
import { router } from "@inertiajs/react";

import '@mantine/core/styles.css'
import '@mantine/notifications/styles.css';
import '@mantine/nprogress/styles.css';

function Providers({ children }: ProvidersProps) {

    router.on('start', () => nprogress.start())
    router.on('progress', (ev) => {
        if (ev.detail.progress?.percentage) {
            nprogress.set(ev.detail.progress.percentage)
        }
    })
    router.on('finish', (ev) => {
        if (ev.detail.visit.completed) {
            nprogress.complete()
        } else if (ev.detail.visit.interrupted) {
            nprogress.reset()
        } else if (ev.detail.visit.cancelled) {
            nprogress.reset()
        } else {
            nprogress.reset()
        }
    })

    return (
        <MantineProvider theme={Theme}>
            <NavigationProgress />
            <Notifications position="top-center" />
            {children}
        </MantineProvider>
    );
}

type ProvidersProps = {
    children?: ReactNode;
}

export default Providers;
