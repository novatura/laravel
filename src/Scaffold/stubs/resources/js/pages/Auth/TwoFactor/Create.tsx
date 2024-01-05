import GuestLayout from "@/layouts/GuestLayout";
import { PageProps } from "@/types/PageProps";
import { router, useForm } from "@inertiajs/react";
import { Button, Card, Collapse, CopyButton, Divider, Group, InputLabel, PinInput, Spoiler, Stack, Text, Title } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import { FormEvent } from "react";

function CreateTwoFactorPage({secret, qr_code}: PageProps<{
    secret: string,
    qr_code: string,
}>) {

    const [showSecret, { toggle }] = useDisclosure();

    const { post, processing, errors, data, setData } = useForm({
        code: '',
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route('two-factor.store'), {
            onSuccess: () => notifications.show({
                title: 'Two Factor Authentication Enabled',
                message: 'Two factor authentication has been enabled successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'Two Factor Authentication Failed',
                message: 'Two factor authentication could not be enabled.',
                color: 'red'
            }),
        });
    }

    return (
        <GuestLayout>
            <Stack gap="xl" align="center">
                <Stack gap={0} ta="center">
                    <Title>Two Factor Authentication</Title>
                    <Text maw={384}>
                        To get started, scan the following QR code using your phone's authenticator application.
                    </Text>
                </Stack>
                <Group justify="center">
                    <Card withBorder shadow="md">
                        <img width={192} height={192} src={qr_code} alt="QR Code" />
                    </Card>
                </Group>
                <form onSubmit={handleSubmit}>
                    <Stack gap="xs" align="center" ta="center">
                        <InputLabel>Enter Code</InputLabel>
                        <PinInput
                            length={6}
                            error={!!errors.code}
                            value={data.code}
                            onChange={(v) => setData('code', v)}
                            autoFocus
                        />
                        {errors.code && (
                            <Text c="red">{errors.code}</Text>
                        )}
                    </Stack>
                    <Group justify="center" mt="lg">
                        <Button variant="light" onClick={() => router.visit(route("profile.edit"))}>
                            Cancel
                        </Button>
                        <Button type="submit" loading={processing}>
                            Submit
                        </Button>
                    </Group>
                </form>
                <Stack gap="sm" w={384}>
                    <Divider label="Can't scan the QR code?" w="100%" />
                    <CopyButton value={secret}>
                        {({copy, copied}) => copied ? (
                            <Button variant="transparent" color="dark" onClick={copy}>Copied</Button>
                        ) : (
                            <Button variant="transparent" color="dark" onClick={copy}>Copy Secret</Button>
                        )}
                    </CopyButton>
                </Stack>
            </Stack>
        </GuestLayout>
    );
}

export default CreateTwoFactorPage;
