import { PageProps } from "@/types/PageProps";
import { router, useForm, usePage } from "@inertiajs/react";
import { Badge, Button, Card, Group, Stack, Text, TextInput, Title } from "@mantine/core";
import { notifications } from "@mantine/notifications";
import { FormEvent } from "react";

function TwoFactor() {

    const { two_factor_enabled } = usePage<PageProps>().props.auth.user

    const { delete: Delete, processing, errors, data, setData } = useForm({
        password: ''
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        Delete(route('two-factor.destroy'), {
            onSuccess: () => notifications.show({
                title: 'Two Factor Authentication Disabled',
                message: 'Two factor authentication has been disabled successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'Two Factor Authentication Failed',
                message: 'Two factor authentication could not be disabled.',
                color: 'red'
            }),
        });
    }

    return (
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
                        <form onSubmit={handleSubmit}>
                            <Stack align="start">
                                <TextInput
                                    label="Your password is required to disable 2FA"
                                    type="password"
                                    placeholder="Current Password"
                                    required
                                    value={data.password}
                                    onChange={(event) => setData('password', event.currentTarget.value)}
                                    error={errors.password}
                                    autoComplete="current-password"
                                    w={512}
                                />
                                <Group>
                                    <Button
                                        onClick={() => router.visit(route("two-factor.recovery_codes"))}
                                    >
                                        View Recovery Codes
                                    </Button>
                                    <Button
                                        variant="filled"
                                        color="red"
                                        loading={processing}
                                        type="submit"
                                    >
                                        Disable Two Factor Authentication
                                    </Button>
                                </Group>
                            </Stack>
                        </form>
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
    );
}

export default TwoFactor;
