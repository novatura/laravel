import { Link, usePage } from "@inertiajs/react";
import { AppShellNavbar, Center, Group, Stack, Text, ThemeIcon } from "@mantine/core";
import { ReactNode } from "react";
import { LucideIcon } from "lucide-react"

function Navbar({ children }: { children?: ReactNode}) {
    return (
        <AppShellNavbar p="md">
            <Stack>
                {children}
            </Stack>
        </AppShellNavbar>
    );
}

Navbar.Item = function NavItem({ children, href, icon: Icon }: NavItemProps) {

    const pathname = usePage().url
    const isActive = (href.match(/^https?:\/\//) ? new URL(href).pathname : href).split("/").filter(p => p.length > 0).every((part) => pathname.split("/").includes(part))

    return (
        <Link href={href} style={{
            textDecoration: "none"
        }}>
            <Group>
                {Icon && (
                    <ThemeIcon
                    size={40}
                    variant={isActive ? "filled" : "light"}
                    >
                        <Icon size={20} />
                    </ThemeIcon>
                )}
                <Text c="dark" fw={isActive ? "bold" : "normal"}>
                    {children}
                </Text>
            </Group>
        </Link>
    )
}

type NavItemProps = {
    children: ReactNode;
    href: string;
    icon?: LucideIcon
}

export default Navbar;
