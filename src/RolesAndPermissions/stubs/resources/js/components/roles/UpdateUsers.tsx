import { PageProps } from "@/types/PageProps";
import { Role } from "@/types/Role";
import { useForm, usePage } from "@inertiajs/react";
import { Card, Title, Text, Stack, Button, Group, Avatar, Modal } from "@mantine/core";
import { createContext, useState } from "react";
import { notifications } from "@mantine/notifications"
import { User } from "@/types/User";
import { useDisclosure } from "@mantine/hooks";
import RoleUserTable from "./RoleUserTable";

const RoleUsersContext = createContext<{
    users: User[]
    remove: (id: User['id']) => void
}>({
    users: [],
    remove: () => {},
})


function UpdateUsers() {

    const { role, users } = usePage<PageProps<{ role: Role, users: User[] }>>().props

    const { delete:destroy } = useForm()
    const [userToRemove, setUserToRemove] = useState<User['id'] | null>(null)
    const [isOpen, { open, close }] = useDisclosure(false)

    const removeRole = (user_id: string) => {
        destroy(route('users.remove.roles', [user_id, role.id]), {
            onSuccess: () => notifications.show({
                title: 'User Unassociated',
                message: 'This role has been withdrawn successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'User Unassociation Failed',
                message: 'This role could not be withdrawn from the user.',
                color: 'red'
            }),
        });
        close();
    }

    return (
        <>
            <Modal
                opened={isOpen}
                onClose={close}
                title="Confirm Role Withrdrawal"
                size="sm"
                centered
            >
                <Stack>
                    <Text>Are you sure you want to remove this role from this user?</Text>
                    <Group>
                        <Button onClick={close}>Cancel</Button>
                        <Button disabled={!userToRemove} onClick={() => userToRemove && removeRole(userToRemove)} color="red">Remove</Button>
                    </Group>
                </Stack>
            </Modal>
            <Card withBorder>
                <Stack>
                    <Group justify="space-between">
                        <Stack gap={0}>
                            <Title order={2}>Users</Title>
                            <Text>Who has this role?</Text>
                        </Stack>
                    </Group>
                    <Stack maw={512}>
                        <RoleUsersContext.Provider value={{
                            users,
                            remove: (user_id) => {
                                setUserToRemove(user_id)
                                open()
                            },
                        }}>
                            <RoleUserTable />
                        </RoleUsersContext.Provider> 
                    </Stack>
                </Stack>
            </Card>
        </>
    );
}

export default UpdateUsers;
export { RoleUsersContext }
