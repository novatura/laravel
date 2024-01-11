import { PageProps } from "@/types/PageProps";
import { Role } from "@/types/Role";
import { useForm, usePage } from "@inertiajs/react";
import { Card, Title, Text, Stack, TextInput, Button, Group, ColorPicker, InputLabel, Badge, Alert } from "@mantine/core";
import { FormEvent } from "react";
import { notifications } from "@mantine/notifications"
import { AlertCircleIcon } from "lucide-react";

function UpdateRole() {

    const { role } = usePage<PageProps<{ role: Role }>>().props

    const { patch, data, setData, processing, errors } = useForm({
        name: role.name,
        colour: role.colour,
    })
    const isDirty = data.name !== role.name || data.colour !== role.colour

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(route('roles.update', role.id), {
            onSuccess: () => notifications.show({
                title: 'Role Updated',
                message: 'This role has been updated successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'Role Update Failed',
                message: 'This role could not be updated.',
                color: 'red'
            }),
        });
    }

    return (
        <Card withBorder>
            <Stack>
                <Group justify="space-between">
                    <Stack gap={0}>
                        <Title order={2}>Role</Title>
                        <Text>Manage role info, like permissions and users</Text>
                    </Stack>
                </Group>
                {isDirty && <Alert
                    color="yellow"
                    mb="md"
                    icon={<AlertCircleIcon />}
                    title="You have unsaved changes."
                />}
                <form onSubmit={handleSubmit}>
                    <Group align="flex-start">
                        <Stack maw={512}>
                            <TextInput
                                label="Role Name"
                                value={data.name}
                                onChange={(event) => setData('name', event.currentTarget.value)}
                                error={errors.name}
                                required
                            />
                            <div>
                                <InputLabel>Role Color</InputLabel>
                                <ColorPicker
                                    value={data.colour}
                                    onChange={(event) => setData('colour', event)}
                                />
                            </div>
                        </Stack>
                        <Stack gap="xs">
                            <InputLabel>Preview</InputLabel>
                            <Badge color={data.colour} size="lg">{data.name}</Badge>
                        </Stack>
                    </Group>
                    <Button mt="lg" type="submit" loading={processing}>
                        Update
                    </Button>
                </form>
            </Stack>
        </Card>
    );
}

export default UpdateRole;
