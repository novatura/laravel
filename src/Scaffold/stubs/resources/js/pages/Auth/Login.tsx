import GuestLayout from "@/layouts/GuestLayout";
import { Link, useForm } from "@inertiajs/react";
import { Button, Checkbox, Stack, Text, TextInput, Title, Group } from "@mantine/core";
import { FormEventHandler } from "react";

function LoginPage() {

    const { post, data, setData, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    })

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('login'));
    };

    return (
        <GuestLayout>
            <Stack>
                <Stack gap={0} ta="center">
                    <Title order={2}>Login</Title>
                    <Text c="dimmed">Sign in to your account</Text>
                </Stack>
                <form onSubmit={submit}>
                    <Stack gap="xs" miw="300px">
                        <TextInput
                            label="Email"
                            value={data.email}
                            onChange={(event) => setData('email', event.currentTarget.value)}
                            error={errors.email}
                            required
                            autoFocus
                        />
                        <Stack gap={0}>
                            <TextInput
                                label="Password"
                                type="password"
                                value={data.password}
                                onChange={(event) => setData('password', event.currentTarget.value)}
                                error={errors.password}
                                required
                            />
                            <Text fz="xs">
                                <Link href={route('password.request')}>Forgot your password?</Link>
                            </Text>
                        </Stack>
                        <Checkbox
                            label="Remember me?"
                            checked={data.remember}
                            onChange={(event) => setData('remember', event.currentTarget.checked)}
                            mt="md"
                        />
                        <Button
                            type="submit"
                            loading={processing}
                            mt="md"
                        >
                            Login
                        </Button>
                    </Stack>
                </form>
                <Text c="dimmed" fz="sm" ta="center">
                    Don't have an account?&nbsp;
                    <Link href={route("register")}>
                        Register
                    </Link>
                </Text>
            </Stack>
        </GuestLayout>
    );
}

export default LoginPage;
