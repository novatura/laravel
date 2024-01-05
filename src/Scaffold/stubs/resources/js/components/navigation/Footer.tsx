import { AppShellFooter, Group, Text } from "@mantine/core";

function Footer() {
    return (
        <AppShellFooter>
            <Group h="100%" justify="center">
                <Text>
                    Powered by <a href="https://novatura.co/" target="_blank" rel="noreferrer">Novatura</a>
                </Text>
            </Group>
        </AppShellFooter>
    );
}

export default Footer;
