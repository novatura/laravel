import Footer from "@/components/navigation/Footer";
import Header from "@/components/navigation/Header";
import Navbar from "@/components/navigation/Navbar";
import { PageProps } from "@/types/PageProps";
import { usePage } from "@inertiajs/react";
import { AppShell, Stack } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { ReactNode, useState } from "react";
import { HomeIcon } from "lucide-react"

function AuthenticatedLayout({ children }: AuthenticatedLayoutProps) {

    const [opened, { toggle }] = useDisclosure()
    const pageProps = usePage<PageProps>()

    return (
        <AppShell
            header={{ height: 60 }}
            footer={{ height: 60 }}
            navbar={{ width: 300, breakpoint: 'sm', collapsed: { mobile: !opened }}}
            padding="md"
        >
            <Header opened={opened} handleToggle={toggle} />
            <Navbar>
                <Navbar.Item href={route("dashboard")} icon={HomeIcon}>Dashboard</Navbar.Item>
            </Navbar>
            <AppShell.Main>
                <Stack>
                    {children}
                </Stack>
            </AppShell.Main>
            <Footer />
        </AppShell>
    );
}

type AuthenticatedLayoutProps = {
    children?: ReactNode;
}

export default AuthenticatedLayout;
