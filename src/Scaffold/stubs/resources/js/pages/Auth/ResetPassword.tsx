import GuestLayout from "@/layouts/GuestLayout";
import { Link, useForm } from "@inertiajs/react";
import { Button, Stack, Text, TextInput, Title } from "@mantine/core";
import { FormEventHandler } from "react";

function ResetPasswordPage({ token, email }: { token: string, email: string })  {

    const { post, data, setData, processing, errors } = useForm({
        token: token,
        email: email,
        password: '',
        password_confirmation: '',
    })

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('password.store'));
    };

    return (
        <GuestLayout>
            <Stack>
                <Stack gap={0} ta="center">
                    <Title order={2}>Reset Password</Title>
                    <Text c="dimmed">Please enter the required information.</Text>
                </Stack>
                <form onSubmit={submit}>
                    <Stack gap="xs" miw="300px">
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
                            Reset
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

export default ResetPasswordPage;
