import { useForm } from "@inertiajs/react";
import { Card, Title, Text, Stack, TextInput, Button, Alert } from "@mantine/core";
import { FormEvent } from "react";

function DeleteProfile() {

    const { delete: Delete, data, setData, processing, errors } = useForm({
        password: '',
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        Delete(route('profile.destroy'));
    }

    return (
        <Card withBorder>
            <Stack>
                <Stack gap={0}>
                    <Title order={2}>Delete Profile</Title>
                </Stack>
                <Alert color="red" maw={512}>
                    <Text mb="md">Deleting your profile is permanent and cannot be undone.</Text>
                    <form onSubmit={handleSubmit}>
                        <TextInput
                            label="Confirm Password"
                            type="password"
                            required
                            value={data.password}
                            onChange={(event) => setData('password', event.currentTarget.value)}
                            error={errors.password}
                            autoComplete="current-password"
                            mb="md"
                        />
                        <Button variant="filled" color="red" type="submit" loading={processing}>Delete Profile</Button>
                    </form>
                </Alert>
            </Stack>
        </Card>
    );
}

export default DeleteProfile;
