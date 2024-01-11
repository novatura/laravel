import { Button, Stack, Card, Group, Title, Text } from '@mantine/core';
import { User } from '@/types/User';
import { Role } from '@/types/Role';
import { useForm, usePage } from '@inertiajs/react';
import { PageProps } from '@/types/PageProps';
import { FormEvent, createContext, useMemo } from 'react';
import RoleTable from './RoleTable';
import { notifications } from "@mantine/notifications"

const RoleContext = createContext<{
    enabled: Role['id'][]
    roles: Role[]
    toggle: (role: Role['id']) => void
    isDirty: boolean
}>({
    enabled: [],
    roles: [],
    toggle: () => {},
    isDirty: false,
})

const EditUserRoles = () => {

    const { user, roles } = usePage<PageProps<{ user: User & { roles: Role[] }, roles: Role[] }>>().props

    const { patch, data, setData, processing, errors } = useForm({
        roles: user.roles.map((role) => role.id),
    })
    const isDirty = useMemo(() => data.roles.toSorted().join() !== user.roles.map((role) => role.id).toSorted().join(), [data.roles, user.roles])

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(route('users.update.roles', user.id), {
            onSuccess: () => {
                close();
                notifications.show({
                title: 'Roles Updated',
                message: user.full_name + ' roles have been updated.',
                color: 'green'});
            
            },
            onError: () => notifications.show({
                title: 'Roles Update Failed',
                message: user.full_name + ' roles have failed to update.',
                color: 'red'
            }),
        });

        console.log(data)

    }

    return (
        <Card withBorder>
            <Stack>
                <Group justify="space-between">
                    <Stack gap={0}>
                        <Title order={2}>Roles</Title>
                        <Text>Manage which roles this user has</Text>
                    </Stack>
                </Group>
                <form onSubmit={handleSubmit}>
                    <Stack maw={512}>
                        <RoleContext.Provider value={{
                            enabled: data.roles,
                            roles,
                            toggle: (role) => {
                                if (data.roles.includes(role)) {
                                    setData('roles', data.roles.filter((id) => id !== role))
                                } else {
                                    setData('roles', [...data.roles, role])
                                }
                            },
                            isDirty,
                        }}>
                            <RoleTable />
                        </RoleContext.Provider>
                    </Stack>
                    <Button mt="lg" type="submit" loading={processing}>
                        Update
                    </Button>
                </form>
            </Stack>
        </Card>
    );
}

export default EditUserRoles;
export { RoleContext };