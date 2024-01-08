import { useForm } from "@inertiajs/react";
import { Card, Title, Stack, TextInput, Button } from "@mantine/core";
import { FormEvent } from "react";

function ChangeEmail() {

    const { put, data, setData, processing, errors } = useForm({
        current_email: '',
        email: '',
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        put(route('email.update'));
    }

    return (
        <Card withBorder>
            <Stack>
                <Stack gap={0}>
                    <Title order={2}>Change Email</Title>
                </Stack>
                <form onSubmit={handleSubmit}>
                    <Stack maw={512}>
                        <TextInput
                            label="Current Email"
                            type="email"
                            required
                            value={data.current_email}
                            onChange={(event) => setData('current_email', event.currentTarget.value)}
                            error={errors.current_email}
                        />
                        <TextInput
                            label="New Email"
                            type="email"
                            required
                            value={data.email}
                            onChange={(event) => setData('email', event.currentTarget.value)}
                            error={errors.email}
                        />
                    </Stack>
                    <Button mt="lg" type="submit" loading={processing}>
                        Change Email
                    </Button>
                </form>
            </Stack>
        </Card>
    );
}

export default ChangeEmail;
function usePage<T>() {
    throw new Error("Function not implemented.");
}

