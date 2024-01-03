import { Box, Card, SimpleGrid, Text, Title } from "@mantine/core";
import { ReactNode } from "react";

function AuthLayout({ children }: AuthLayoutProps) {
    return (
        <SimpleGrid
            cols={{
                xs: 1,
                lg: 2
            }}
            style={{
                minHeight: '100vh',
            }}
        >
            <Box
                p="xl"
                display="flex"
                style={{
                    flexDirection: 'column',
                    justifyContent: 'center',
                    alignItems: 'center',
                }}
            >
                {children}
            </Box>
            <Box
                bg="blue.8"
                c="white"
                p="xl"
                display={{
                    xs: 'none',
                    lg: 'flex',
                }}
                style={{
                    flexDirection: 'column',
                    justifyContent: 'center',
                }}
            >
                <Title order={1}>
                    App Name
                </Title>
                <Text>
                    This is the authentication layout.
                </Text>
            </Box>
        </SimpleGrid>
    );
}

type AuthLayoutProps = {
    children?: ReactNode;
}

export default AuthLayout;
