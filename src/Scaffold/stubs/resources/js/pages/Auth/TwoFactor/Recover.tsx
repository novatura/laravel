import GuestLayout from "@/layouts/GuestLayout";
import { Link, useForm } from "@inertiajs/react";
import { Button, Group, PinInput, Stack, Text, TextInput, Title } from "@mantine/core";
import { notifications } from "@mantine/notifications";
import { FormEvent } from "react";

function TwoFactorRecoverPage() {

    const { post, processing, errors, data, setData } = useForm({
        code: ''
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route('two-factor.recover_store'));
    }

    return (
        <GuestLayout>
            <Stack gap="xl">
                <Stack gap={0} ta="center">
                    <Title>Two Factor Recovery</Title>
                    <Text maw={384}>
                        Enter a recovery code to continue.
                    </Text>
                </Stack>
                <form onSubmit={handleSubmit}>
                    <Stack>
                        <TextInput
                            error={errors.code}
                            value={data.code}
                            onChange={(ev) => setData('code', ev.currentTarget.value)}
                            label="Recovery Code"
                            required
                            autoFocus
                        />
                        <Button
                            type="submit"
                            loading={processing}
                        >
                            Recover
                        </Button>
                    </Stack>
                </form>
                <Text c="dimmed" size="sm" ta="center">
                    Found your device? <Link href={route("two-factor.verify")}>Back to verification</Link>.
                </Text>
            </Stack>
        </GuestLayout>
    );
}

export default TwoFactorRecoverPage;
