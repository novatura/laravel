import { PageProps } from "@/types/PageProps";
import { usePage } from "@inertiajs/react";
import { ReactNode } from "react";

function AuthenticatedLayout({ children }: AuthenticatedLayoutProps) {

    const pageProps = usePage<PageProps>()

    return (
        <div>
            <pre>
                {JSON.stringify(pageProps, null, 2)}
            </pre>
            {children}
        </div>
    );
}

type AuthenticatedLayoutProps = {
    children?: ReactNode;
}

export default AuthenticatedLayout;
