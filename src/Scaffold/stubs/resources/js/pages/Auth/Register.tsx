import GuestLayout from "@/layouts/GuestLayout";
import { Link, useForm } from "@inertiajs/react";
import { Button, Stack, Text, TextInput, Title } from "@mantine/core";
import { FormEventHandler } from "react";

function LoginPage() {

    const { post, data, setData, processing, errors } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
    })


    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('register'));
    };

    return (
        <GuestLayout>
            <Stack>
                <Stack gap={0} ta="center">
                    <Title order={2}>Register</Title>
                    <Text c="dimmed">Create your account</Text>
                </Stack>
                <form onSubmit={submit}>
                    <Stack gap="xs" miw="300px">
                        <TextInput
                            label="First Name"
                            value={data.first_name}
                            onChange={(event) => setData('first_name', event.currentTarget.value)}
                            error={errors.first_name}
                            required
                            autoFocus
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
                            autoComplete="new-password"
                            onChange={(event) => setData('password', event.currentTarget.value)}
                            error={errors.password}
                            required
                        />
                        <TextInput
                            label="Confirm Password"
                            type="password"
                            value={data.password_confirmation}
                            autoComplete="new-password"
                            onChange={(event) => setData('password_confirmation', event.currentTarget.value)}
                            error={errors.password}
                            required
                        />
                        <Button
                            type="submit"
                            loading={processing}
                            mt="md"
                        >
                            Register
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
        </GuestLayout>
    );
}

export default LoginPage;
