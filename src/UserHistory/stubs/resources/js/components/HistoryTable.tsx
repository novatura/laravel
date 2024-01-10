import { History } from "@/types/History";
import { Button, Code, Drawer, Grid, Stack, Title } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { MRT_ColumnDef, MantineReactTable, useMantineReactTable } from "mantine-react-table";
import { useMemo, useState } from "react";


const HistoryTable = ({ data }: { data: History[] }) => {

    const [opened, { open, close }] = useDisclosure(false);
    const [drawerData, setdrawerData] = useState<History | null>(null);

    const columns = useMemo<MRT_ColumnDef<History>[]>(() => [
        {
            accessorKey: "action",
            header: "Action",
        },
        {
            accessorKey: "model",
            header: "Model",
        },
        {
            accessorKey: "description",
            header: "Description",
        },
        {
            accessorKey: "user",
            header: "User",
            Cell: ({ row }) => {
                return row.original.user.full_name;
            }
        },
        {
            header: "Details",
            Header: <></>,
            enableColumnActions: false,
            Cell: ({ row }) => {
                return (
                    <>
                        <Button onClick={() => { setdrawerData(row.original); open(); }}>Details</Button>
                    </>
                );
            }
        }
    ], [data])

    const table = useMantineReactTable({
        columns,
        data,
        enableBottomToolbar: true,
        enableExpandAll: false,
        enableSorting: false,
        enableSelectAll: false,
        enableFullScreenToggle: false,
        enableTopToolbar: false,
    });
    return (
        <>
            <MantineReactTable table={table} />
            <Drawer opened={opened} onClose={close} size={"lg"}>
                <Stack>
                    <Grid columns={2}>
                        <Grid.Col span={1}>
                            <Title order={3}>ID</Title>
                            {drawerData?.id}
                        </Grid.Col>
                        <Grid.Col span={1}>
                            <Title order={3}>Action</Title>
                            {drawerData?.action}
                        </Grid.Col>
                        <Grid.Col span={1}>
                            <Title order={3}>Model</Title>
                            {drawerData?.model}
                        </Grid.Col>
                        <Grid.Col span={1}>
                            <Title order={3}>Description</Title>
                            {drawerData?.description}
                        </Grid.Col>
                        <Grid.Col span={1}>
                            <Title order={3}>User</Title>
                            {drawerData?.user.full_name}
                        </Grid.Col>
                    </Grid>
                    <Title order={3}>Old Data</Title>
                    <Code block>
                        <pre>
                            {JSON.stringify(drawerData?.old_data || null, null, 2)}
                        </pre>
                    </Code>
                    <Title order={3}>New Data</Title>
                    <Code block>
                        <pre>
                            {JSON.stringify(drawerData?.new_data || null, null, 2)}
                        </pre>
                    </Code>
                </Stack>
            </Drawer>


        </>
    );
}


export default HistoryTable;