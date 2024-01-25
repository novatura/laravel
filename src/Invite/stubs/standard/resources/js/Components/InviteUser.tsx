import { useForm, usePage } from "@inertiajs/react";
import { Stack, TextInput, Button, Group, ColorPicker, InputLabel, Badge, Modal, ModalProps, MultiSelect, Select, Checkbox, Text } from "@mantine/core";
import { FormEvent } from "react";
import { notifications } from "@mantine/notifications"
import { useDisclosure } from "@mantine/hooks";
import { PageProps } from "@/types/PageProps";
import { Role } from "@/types/Role";

function InviteUser({
    enableRoles,
    defaultRoles = [],
  }: {
    enableRoles?: boolean;
    defaultRoles?: Role[];
  }) {

    const rolesEnabled = enableRoles || false;

    const [opened, { open, close }] = useDisclosure();

    const { roles } = usePage<PageProps<{ roles: Role[]}>>().props
    
    const { post, data, setData, processing, errors, reset } = useForm<{
        email: string,
        roles: string[]
    }>({
        email: "",
        roles: defaultRoles.map(function (role) {return role.id.toString()}),
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route('users.invite'), {
            onSuccess: () => {
                close();
                reset();
                notifications.show({
                    title: 'Invite Send',
                    message: 'An invitation has been sent.',
                    color: 'green'
                })
            },
            onError: () => notifications.show({
                title: 'Invitation Failed',
                message: 'An invitation could not be sent.',
                color: 'red'
            }),
        });
    }

    const rolesData = roles.map(function (role) {
        return {
            label: role.name,
            value: role.id.toString()
        }
    })

    return (
        <>
            <Modal title="Invite User" opened={opened} onClose={close}>
                <form onSubmit={handleSubmit}>
                    <Stack maw={512}>
                        <TextInput
                            label="Email"
                            type="email"
                            value={data.email}
                            onChange={(event) => setData('email', event.currentTarget.value)}
                            error={errors.email}
                            required 
                        />
                        { rolesEnabled &&
                            <MultiSelect
                                label="Roles"
                                value={data.roles}
                                onChange={(e) => setData('roles', e)}
                                data={rolesData}
                            />
                        }
                        <Button mt="lg" type="submit" loading={processing}>
                            Confirm
                        </Button>
                    </Stack>

                </form>
            </Modal>
            <Button onClick={open} color="blue" type="button">
                    Invite User
            </Button>
        </>
    );
}

export default InviteUser;
