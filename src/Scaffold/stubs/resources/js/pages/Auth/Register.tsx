import AuthLayout from "@/layouts/AuthLayout";
import { Link, useForm } from "@inertiajs/react";
import { Button, Stack, Text, TextInput, Title } from "@mantine/core";

function LoginPage() {

    const { post, data, setData, processing, errors } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
    })

    return (
        <AuthLayout>
            <Stack>
                <Stack gap={0} ta="center">
                    <Title order={2}>Register</Title>
                    <Text c="dimmed">Create your account</Text>
                </Stack>
                <form>
                    <Stack gap="xs" miw="300px">
                        <TextInput
                            label="First Name"
                            value={data.first_name}
                            onChange={(event) => setData('first_name', event.currentTarget.value)}
                            error={errors.first_name}
                            required
                        />
                        <TextInput
                            label="Last Name"
                            value={data.last_name}
                            onChange={(event) => setData('last_name', event.currentTarget.value)}
                            error={errors.last_name}
                            required
                        />
                        <TextInput
                            label="Email"
                            value={data.email}
                            onChange={(event) => setData('email', event.currentTarget.value)}
                            error={errors.email}
                            required
                        />
                        <TextInput
                            label="Password"
                            type="password"
                            value={data.password}
                            onChange={(event) => setData('password', event.currentTarget.value)}
                            error={errors.password}
                            required
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
                    Already have an account?&nbsp;
                    <Link href={route("login")}>
                        Login
                    </Link>
                </Text>
            </Stack>
        </AuthLayout>
    );
}

export default LoginPage;
