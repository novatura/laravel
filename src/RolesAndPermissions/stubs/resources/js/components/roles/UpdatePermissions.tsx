import { PageProps } from "@/types/PageProps";
import { Role } from "@/types/Role";
import { useForm, usePage } from "@inertiajs/react";
import { Card, Title, Text, Stack, Button, Group } from "@mantine/core";
import { FormEvent, createContext } from "react";
import { notifications } from "@mantine/notifications"
import { Permission } from "@/types/Permissions";
import PermissionsTable from "../permissions/PermissionsTable";

const PermissionsContext = createContext<{
    enabled: Permission['id'][]
    permissions: Permission[]
    toggle: (permission: Permission['id']) => void
    isDirty: boolean
}>({
    enabled: [],
    permissions: [],
    toggle: () => {},
    isDirty: false,
})

function UpdatePermissions() {

    const { role, permissions } = usePage<PageProps<{ role: Role, permissions: Permission[] }>>().props

    const { patch, data, setData, processing, errors } = useForm({
        permissions: role.permissions.map((permission) => permission.id),
    })
    const isDirty = data.permissions.toSorted().join() !== role.permissions.map((permission) => permission.id).toSorted().join()

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(route('roles.update.permission', role.id), {
            onSuccess: () => notifications.show({
                title: 'Permissions Updated',
                message: 'This role has been updated successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'Permissions Update Failed',
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
                        <Title order={2}>Permissions</Title>
                        <Text>What actions can users take?</Text>
                    </Stack>
                </Group>
                <form onSubmit={handleSubmit}>
                    <Stack maw={512}>
                        <PermissionsContext.Provider value={{
                            enabled: data.permissions,
                            permissions,
                            toggle: (permission) => {
                                if (data.permissions.includes(permission)) {
                                    setData('permissions', data.permissions.filter((id) => id !== permission))
                                } else {
                                    setData('permissions', [...data.permissions, permission])
                                }
                            },
                            isDirty,
                        }}>
                            <PermissionsTable />
                        </PermissionsContext.Provider>
                    </Stack>
                    <Button mt="lg" type="submit" loading={processing}>
                        Update
                    </Button>
                </form>
            </Stack>
        </Card>
    );
}

export default UpdatePermissions;
export { PermissionsContext };