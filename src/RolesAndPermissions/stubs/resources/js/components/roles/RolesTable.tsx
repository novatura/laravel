import useRolesTable from "@/lib/hooks/useRolesTable";
import { PageProps } from "@/types/PageProps";
import { Role } from "@/types/Role";
import { usePage } from "@inertiajs/react";
import { Card, Group, Stack, Title, Text } from "@mantine/core"
import { MantineReactTable } from "mantine-react-table";

function RolesTable() {
    
    const { roles } = usePage<PageProps<{ roles: (Role & { members: number})[] }>>().props
    const tableProps = useRolesTable(roles)

    return (
        <Card withBorder>
            <Stack>
                <Group justify="space-between">
                    <Stack gap={0}>
                        <Title order={2}>Roles</Title>
                        <Text>Organised user permissions</Text>
                    </Stack>
                </Group>
                <Stack>
                    <MantineReactTable {...tableProps} />
                </Stack>
            </Stack>
        </Card>
    );
}

export default RolesTable;