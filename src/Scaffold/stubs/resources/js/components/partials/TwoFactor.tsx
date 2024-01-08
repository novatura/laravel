import { PageProps } from "@/types/PageProps";
import { router, usePage } from "@inertiajs/react";
import { Badge, Button, Card, Group, Modal, Stack, Text, TextInput, Title } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";

function TwoFactor() {

    const { two_factor_enabled } = usePage<PageProps>().props.auth.user

    const [opened, { open, close }] = useDisclosure();

    return (<>
        <Card withBorder>
            <Stack>
                <Stack gap={0}>
                    <Group align="center">
                        <Title order={2}>Two Factor Authentication</Title>
                        {two_factor_enabled ? (
                            <Badge size="lg" color="green">Enabled</Badge>
                        ) : (
                            <Badge size="lg" color="red">Disabled</Badge>
                        )}
                    </Group>
                    <Text maw={512}>
                        Two factor authentication adds an extra layer of security to your account by requiring more than just a password to log in.
                    </Text>
                </Stack>
                {two_factor_enabled ? (
                    <Group>
                        <Button
                            onClick={() => router.visit(route("two-factor.recovery_codes"))}
                        >
                            View Recovery Codes
                        </Button>
                        <Button
                            variant="filled"
                            color="red"
                            onClick={open}
                        >
                            Disable Two Factor Authentication
                        </Button>
                    </Group>
                ) : (
                    <Group>
                        <Button
                            variant="filled"
                            color="blue"
                            onClick={() => router.visit(route("two-factor.create"))}
                        >
                            Enable Two Factor Authentication
                        </Button>
                    </Group>
                )}
            </Stack>
        </Card>
        <Modal title="Confirm" opened={opened} onClose={close}>
            <Text>Are you sure you want to remove two-factor authentication from your account?</Text>
            <Text c="red">This may make your account less secure.</Text>
            <Group mt="lg" justify="end">
                <Button
                    onClick={close}
                    variant="light"
                >
                    Cancel
                </Button>
                <Button
                    variant="filled"
                    color="red"
                    onClick={() => {
                        router.visit(route("two-factor.destroy"), { method: "delete" });
                    }}
                >
                    Disable
                </Button>
            </Group>
        </Modal>
    </>);
}

export default TwoFactor;
