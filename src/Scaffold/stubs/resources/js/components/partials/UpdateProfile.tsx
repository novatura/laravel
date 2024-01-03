import { PageProps } from "@/types/PageProps";
import { useForm, usePage } from "@inertiajs/react";
import { Card, Title, Text, Stack, TextInput, Button, Group, Avatar } from "@mantine/core";
import { FormEvent } from "react";
import { notifications } from "@mantine/notifications"

function UpdateProfile() {

    const user = usePage<PageProps>().props.auth.user

    const { patch, data, setData, processing, errors } = useForm({
        first_name: user.first_name,
        last_name: user.last_name,
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(route('profile.update'), {
            onSuccess: () => notifications.show({
                title: 'Profile Updated',
                message: 'Your profile has been updated successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'Profile Update Failed',
                message: 'Your profile could not be updated.',
                color: 'red'
            }),
        });
    }

    return (
        <Card withBorder>
            <Stack>
                <Group justify="space-between">
                    <Stack gap={0}>
                        <Title order={2}>Profile</Title>
                        <Text>Update your profile</Text>
                    </Stack>
                    <Avatar color="blue" size="lg">
                        {user.full_name.split(" ").map(t => t[0]).join("")}
                    </Avatar>
                </Group>
                <form onSubmit={handleSubmit}>
                    <Stack maw={512}>
                        <TextInput
                            label="First Name"
                            value={data.first_name}
                            onChange={(event) => setData('first_name', event.currentTarget.value)}
                            error={errors.first_name}
                            required
                            autoComplete="given-name"
                        />
                        <TextInput
                            label="Last Name"
                            value={data.last_name}
                            onChange={(event) => setData('last_name', event.currentTarget.value)}
                            error={errors.last_name}
                            required
                            autoComplete="family-name"
                        />
                    </Stack>
                    <Button mt="lg" type="submit" loading={processing}>
                        Update
                    </Button>
                </form>
            </Stack>
        </Card>
    );
}

export default UpdateProfile;
