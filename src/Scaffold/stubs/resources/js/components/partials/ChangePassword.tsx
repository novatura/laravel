import { useForm } from "@inertiajs/react";
import { Card, Title, Stack, TextInput, Button } from "@mantine/core";
import { FormEvent } from "react";

function ChangePassword() {

    const { put, data, setData, processing, errors } = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        put(route('password.update'));
    }

    return (
        <Card withBorder>
            <Stack>
                <Stack gap={0}>
                    <Title order={2}>Change Password</Title>
                </Stack>
                <form onSubmit={handleSubmit}>
                    <Stack maw={512}>
                        <TextInput
                            label="Current Password"
                            type="password"
                            required
                            value={data.current_password}
                            onChange={(event) => setData('current_password', event.currentTarget.value)}
                            error={errors.current_password}
                            autoComplete="current-password"
                        />
                        <TextInput
                            label="New Password"
                            type="password"
                            required
                            value={data.password}
                            onChange={(event) => setData('password', event.currentTarget.value)}
                            error={errors.password}
                            autoComplete="new-password"
                        />
                        <TextInput
                            label="Confirm New Password"
                            type="password"
                            required
                            value={data.password_confirmation}
                            onChange={(event) => setData('password_confirmation', event.currentTarget.value)}
                            error={errors.password_confirmation}
                            autoComplete="new-password"
                        />
                    </Stack>
                    <Button mt="lg" type="submit" loading={processing}>
                        Change Password
                    </Button>
                </form>
            </Stack>
        </Card>
    );
}

export default ChangePassword;
