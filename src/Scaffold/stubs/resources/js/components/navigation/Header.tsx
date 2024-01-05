import UserMenu from "@/components/navigation/UserMenu";
import { AppShellHeader, Burger, Group, Title } from "@mantine/core";

function Header({ opened, handleToggle }: HeaderProps) {
    return (
        <AppShellHeader>
            <Group h="100%" px="md" justify="space-between">
                <Group>
                    <Burger hiddenFrom="sm" size="sm" opened={opened} onClick={handleToggle} />
                    <Title size="24">Novatura</Title>
                </Group>
                <UserMenu />
            </Group>
        </AppShellHeader>
    );
}

type HeaderProps = {
    opened?: boolean;
    handleToggle?: () => void;
}

export default Header;
