import GuestLayout from "@/layouts/GuestLayout";
import { Link, useForm } from "@inertiajs/react";
import { Button, Stack, Text, TextInput, Title } from "@mantine/core";
import { FormEventHandler } from "react";

function ForgotPasswordPage() {

    const { post, data, setData, processing, errors } = useForm({
        email: '',
    })

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <GuestLayout>
            <Stack>
                <Stack gap={0} ta="center">
                    <Title order={2}>Forgot Password</Title>
                    <Text c="dimmed">Begin Forgot Password Recovery</Text>
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
                        <Button
                            type="submit"
                            loading={processing}
                            mt="md"
                        >
                            Send Email
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

export default ForgotPasswordPage;
