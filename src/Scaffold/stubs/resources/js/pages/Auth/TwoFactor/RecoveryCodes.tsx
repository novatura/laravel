import GuestLayout from "@/layouts/GuestLayout";
import { PageProps } from "@/types/PageProps";
import { router } from "@inertiajs/react";
import { Button, Group, SimpleGrid, Stack, Text, Title } from "@mantine/core";

function TwoFactorRecoveryCodesPage(props: PageProps<{
    recovery_codes: string[],
}>) {
    return (
        <GuestLayout>
            <Stack gap="xl" align="center">
                <Stack gap={0} ta="center">
                    <Title>Recovery Codes</Title>
                    <Text maw={384}>
                        These are your two factor recovery codes. Each code can be used once. Do not share these with anyone, and store them securely.
                    </Text>
                </Stack>
                <SimpleGrid cols={{xs: 1, sm: 2, lg: 1, xl: 2}}>
                    {props.recovery_codes.map((code, i) => (
                        <Text key={i} ff="mono" fz="xs" style={{
                            userSelect: 'all',
                            mozUserSelect: 'all',
                            webkitUserSelect: 'all',
                        }}>
                            {code}
                        </Text>
                    ))}
                </SimpleGrid>
                <Group>
                    <Button
                        variant="light"
                        color="blue"
                        onClick={() => router.visit(route("profile.edit"))}
                    >
                        Done
                    </Button>
                    <a href={route("two-factor.recovery_codes.download")}>
                        <Button
                            variant="filled"
                            color="blue"
                        >
                            Download Recovery Codes
                        </Button>
                    </a>
                </Group>
            </Stack>
        </GuestLayout>
    );
}

export default TwoFactorRecoveryCodesPage;
