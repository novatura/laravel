import GuestLayout from "@/layouts/GuestLayout";
import { Link, router, useForm } from "@inertiajs/react";
import { Button, Stack, Text, TextInput, Title, Group, PinInput} from "@mantine/core";
import { FormEventHandler } from "react";

function Enter()  {

    const { post, processing, errors, data, setData } = useForm({
        code: ''
    })

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
            <Stack>
                <Stack gap={0} ta="center">
                    <Title order={2}>Email Verification Code</Title>
                    <Text maw={384}>
                        Please enter the verification code send to your email.
                    </Text>
                </Stack>
                <form onSubmit={submit}>
                    <Stack justify="center">
                        <Stack align="flex-start" gap='xs'>
                            <PinInput
                                length={6}
                                error={!!errors.code}
                                value={data.code}
                                onChange={(v) => setData('code', v)}
                                autoFocus
                            />
                            <Text c="red" ta="center" size="xs">
                                {errors.code}
                            </Text>
                        </Stack>
                        <Button
                            type="submit"
                            loading={processing}
                        >
                            Verify
                        </Button>
                        <Button
                            onClick={handleResend}
                        >
                            Resend
                        </Button>
                        <Button
                            onClick={handleChangeEmail}
                        >
                            Change Email
                        </Button>
                    </Stack>
                </form>
            </Stack>
        </GuestLayout>
    );
}

export default Enter;