import { ReactNode } from "react";
import Theme from "@/Theme";
import { MantineProvider } from "@mantine/core";
import { Notifications } from "@mantine/notifications";

import '@mantine/core/styles.css'
import '@mantine/notifications/styles.css';

function Providers({ children }: ProvidersProps) {
    return (
        <MantineProvider theme={Theme}>
            <Notifications position="top-center" />
            {children}
        </MantineProvider>
    );
}

type ProvidersProps = {
    children?: ReactNode;
}

export default Providers;
