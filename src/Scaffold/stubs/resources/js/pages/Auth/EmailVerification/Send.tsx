import GuestLayout from "@/layouts/GuestLayout";
import { Link, useForm } from "@inertiajs/react";
import { Button, Stack, Text, TextInput, Title } from "@mantine/core";
import { FormEventHandler } from "react";

function LoginPage() {

    const { post, data, setData, processing, errors } = useForm({
        email: '',
        password: '',
    })

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('verify.email.send'));
    };

    return (
        <GuestLayout>
            <Stack>
                <Stack gap={0} ta="center">
                    <Title order={2}>Verify Email Address</Title>
                    <Text maw={384}>
                        Press send to start the verification process.
                    </Text>
                </Stack>
                <form onSubmit={submit}>
                    <Stack gap="xs" miw="300px">
                        <Button
                            type="submit"
                            loading={processing}
                            mt="md"
                        >
                            Send
                        </Button>
                    </Stack>
                </form>
            </Stack>
        </GuestLayout>
    );
}

export default LoginPage;
