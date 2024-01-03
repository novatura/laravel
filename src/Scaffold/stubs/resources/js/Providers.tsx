import { ReactNode } from "react";
import Theme from "@/Theme";
import { MantineProvider } from "@mantine/core";

import '@mantine/core/styles.css'

function Providers({ children }: ProvidersProps) {
    return (
        <MantineProvider theme={Theme}>
            {children}
        </MantineProvider>
    );
}

type ProvidersProps = {
    children?: ReactNode;
}

export default Providers;
