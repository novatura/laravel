import GuestLayout from "@/layouts/GuestLayout";
import { Link, useForm } from "@inertiajs/react";
import { Button, Stack, Text, TextInput, Title } from "@mantine/core";

function LoginPage() {

    const { post, data, setData, processing, errors } = useForm({
        email: '',
        password: '',
    })

    return (
        <GuestLayout>
            <Stack>
                <Stack gap={0} ta="center">
                    <Title order={2}>Login</Title>
                    <Text c="dimmed">Sign in to your account</Text>
                </Stack>
                <form>
                    <Stack gap="xs" miw="300px">
                        <TextInput
                            label="Email"
                            value={data.email}
                            onChange={(event) => setData('email', event.currentTarget.value)}
                            error={errors.email}
                            required
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
                                <Link href={""}>Forgot your password?</Link>
                            </Text>
                        </Stack>
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
