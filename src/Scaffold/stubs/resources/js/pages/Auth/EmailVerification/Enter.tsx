import GuestLayout from "@/layouts/GuestLayout";
import { Link, router, useForm } from "@inertiajs/react";
import { Button, Stack, Text, TextInput, Title, Group, PinInput} from "@mantine/core";
import { FormEventHandler, useEffect } from "react";

function Enter()  {

    const { post, processing, errors, data, setData } = useForm({
        code: ''
    })

    useEffect(() => {
        if (data.code.length === 6) {
            post(route('verify.email.verify'));
        }
    }, [data.code])

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('verify.email.verify'));
    };

    const handleResend: FormEventHandler = (e) => {
        e.preventDefault();

        router.post(route('verify.email.send'));
    };

    const handleChangeEmail: FormEventHandler = (e) => {
        e.preventDefault();

        router.get(route('verify.email.edit'));
    };


    return (
        <GuestLayout>
            <Stack gap="lg">
                <Stack gap={0} ta="center">
                    <Title order={2}>Email Verification Code</Title>
                    <Text maw={384}>
                        Please enter the verification code send to your email.
                    </Text>
                </Stack>
                <form onSubmit={submit}>
                    <Stack justify="center">
                        <Stack align="center" gap='xs'>
                            <Group>
                                <PinInput
                                    length={6}
                                    error={!!errors.code}
                                    value={data.code}
                                    onChange={(v) => setData('code', v)}
                                    autoFocus
                                />
                                <Button
                                    type="submit"
                                    loading={processing}
                                >
                                    Verify
                                </Button>
                            </Group>
                            <Text c="red" ta="center" size="xs">
                                {errors.code}
                            </Text>
                        </Stack>
                    </Stack>
                </form>
                <Group justify="center">
                    <Button
                        onClick={handleResend}
                        variant="light"
                    >
                        Resend
                    </Button>
                    <Button
                        onClick={handleChangeEmail}
                        variant="light"
                    >
                        Use different email
                    </Button>
                </Group>
            </Stack>
        </GuestLayout>
    );
}

export default Enter;
