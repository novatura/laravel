import { PageProps } from "@/types/PageProps";
import { User } from "@/types/User";
import { MantineReactTable } from "mantine-react-table";
import { usePage } from "@inertiajs/react";
import useUsersTable from "@/lib/hooks/useUsersTable";
import { Card, Group, Stack, Title } from "@mantine/core";
import { Role } from "@/types/Role";

const UsersTable = () => {
    const { users } = usePage<PageProps<{ users: (User & { roles: Role[] })[] }>>().props
    const tableProps = useUsersTable(users)

    return (
        <Card withBorder>
            <Stack>
                <Group justify="space-between">
                    <Stack gap={0}>
                        <Title order={2}>Users</Title>
                    </Stack>
                </Group>
                <MantineReactTable {...tableProps} />
            </Stack>
        </Card>
    );
}

export default UsersTable;
