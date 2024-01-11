import { PageProps } from "@/types/PageProps";
import { Role } from "@/types/Role";
import { User } from "@/types/User";
import { useForm, usePage } from "@inertiajs/react";
import { Modal, Stack, Button, Text, ModalProps, useCombobox, Combobox, PillsInput, Group, Pill, Avatar, Flex, Space } from "@mantine/core";
import { notifications } from "@mantine/notifications";
import { CheckIcon } from "lucide-react";
import { FormEvent, useState } from "react";

function SelectUsers(props: ModalProps) {

    const { role, users_without:users } = usePage<PageProps<{ role: Role, users_without: User[] }>>().props

    const { post, data, setData, processing, reset } = useForm<{ users: string[] }>({
        users: [],
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        
        post(route('roles.add.users', role.id), {
            onSuccess: () => notifications.show({
                title: 'Users Associated',
                message: 'This role has been granted successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'User Associations Failed',
                message: 'This role could not be granted.',
                color: 'red'
            }),
        });
        handleClose();
    }

    const handleClose = () => {
        reset();
        props.onClose();
    }

    const combobox = useCombobox({
        onDropdownClose: () => combobox.resetSelectedOption(),
        onDropdownOpen: () => combobox.updateSelectedOptionIndex('active'),
    });

    const [search, setSearch] = useState('');

    const handleUserSelect = (user_id: string) => setData('users', data.users.includes(user_id) ? data.users.filter((id) => id !== user_id) : [...data.users, user_id])
    const handleUserRemove = (user_id: string) => setData('users', data.users.filter((id) => id !== user_id));

    const values = users.filter((u) => data.users.includes(u.id)).map((user) => (
        <Pill key={user.id} withRemoveButton onRemove={() => handleUserRemove(user.id)}>
            <Flex align="center" wrap="nowrap" gap="xs" h="100%">
                <Avatar color="blue" size="xs">
                    {user.full_name.split(" ").map(t => t[0]).join("").toUpperCase()}
                </Avatar>
                <Text size="xs">{user.full_name}</Text>
            </Flex>
        </Pill>
    ));

    const options = users.filter((user) => user.full_name.toLowerCase().includes(search.trim().toLowerCase()))
    .map((user) => (
        <Combobox.Option value={user.id} key={user.id} active={data.users.includes(user.id)}>
            <Group gap="sm">
                {data.users.includes(user.id) ? <CheckIcon size={16} /> : null}
                <Avatar color="blue" size="md">
                    {user.full_name.split(" ").map(t => t[0]).join("").toUpperCase()}
                </Avatar>
                <Text>{user.full_name}</Text>
            </Group>
        </Combobox.Option>
    ));

    return (
        <Modal {...props}>
            <form onSubmit={handleSubmit}>
                <Stack>
                    <Text>Search for users to add to this role.</Text>
                    <Combobox store={combobox} onOptionSubmit={handleUserSelect} withinPortal={false}>
                        <Combobox.DropdownTarget>
                            <PillsInput pointer onClick={() => combobox.toggleDropdown()}>
                            <Pill.Group>
                                {values}

                                <Combobox.EventsTarget>
                                    <PillsInput.Field
                                        onFocus={() => combobox.openDropdown()}
                                        onBlur={() => combobox.closeDropdown()}
                                        value={search}
                                        placeholder="Search values"
                                        onChange={(event) => {
                                            combobox.updateSelectedOptionIndex();
                                            setSearch(event.currentTarget.value);
                                        }}
                                        onKeyDown={(event) => {
                                        if (event.key === 'Backspace' && search.length === 0) {
                                            event.preventDefault();
                                            handleUserRemove(data.users[data.users.length - 1]);
                                        }
                                        }}
                                    />
                                </Combobox.EventsTarget>
                            </Pill.Group>
                            </PillsInput>
                        </Combobox.DropdownTarget>

                        <Combobox.Dropdown>
                            <Combobox.Options>
                            {options.length > 0 ? options : <Combobox.Empty>No users found...</Combobox.Empty>}
                            </Combobox.Options>
                        </Combobox.Dropdown>
                    </Combobox>
                    <Space h="xl" />
                    <Space h="xl" />
                    <Space h="xl" />
                    <Space h="xl" />
                    <Group>
                        <Button onClick={handleClose}>Cancel</Button>
                        <Button type="submit" onClick={() => {}} color="red">Confirm</Button>
                    </Group>
                </Stack>
            </form>
        </Modal>
    );
}

export default SelectUsers;