import { useForm, usePage } from "@inertiajs/react";
import { Card, Title, Text, Stack, TextInput, Button, Alert } from "@mantine/core";
import { FormEvent } from "react";
import { notifications } from "@mantine/notifications"
import { PageProps } from "@/types/PageProps";
import { Role } from "@/types/Role";

function DeleteRole() {

    const { role: { id } } = usePage<PageProps<{ role: Role }>>().props

    const { delete:destroy, data, setData, processing, errors } = useForm({
        password: '',
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        destroy(route('roles.destroy', id), {
            onSuccess: () => notifications.show({
                title: 'Role Deleted',
                message: 'Role has been deleted successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'Role Deletion Failed',
                message: 'Role could not be deleted.',
                color: 'red'
            }),
        });
    }

    return (
        <Card withBorder>
            <Stack>
                <Stack gap={0}>
                    <Title order={2}>Delete Role</Title>
                </Stack>
                <Alert color="red" maw={512}>
                    <Text mb="md">Deleting a role is permanent and cannot be undone.</Text>
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
                        <Button variant="filled" color="red" type="submit" loading={processing}>Delete Role</Button>
                    </form>
                </Alert>
            </Stack>
        </Card>
    );
}

export default DeleteRole;
