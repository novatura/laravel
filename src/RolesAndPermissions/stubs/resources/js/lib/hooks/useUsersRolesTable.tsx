import RoleBadge from "@/components/roles/RoleBadge";
import RoleChecker from "@/components/users/RoleChecker";
import { Role } from "@/types/Role";
import { Alert, Flex } from "@mantine/core";
import { AlertCircleIcon } from "lucide-react";
import { MRT_ColumnDef, MRT_GlobalFilterTextInput, MRT_ToggleFiltersButton, MantineReactTable } from "mantine-react-table";
import { ComponentProps, createElement, useMemo } from "react";

type RowType = Role & { isGranted: boolean }

export default function useUsersRolesTable(data: RowType[], isDirty: boolean) {

    const columns = useMemo<MRT_ColumnDef<RowType>[]>(() => [
        {
            accessorKey: "id",
            header: "Toggle",
            Cell: ({ cell }) => createElement(RoleChecker, {...cell.row.original})
        },
        {
            accessorKey: "name",
            header: "Name",
            Cell: ({ cell }) => createElement(RoleBadge, { ...cell.row.original, size: "lg" }, cell.row.original.name)
        }
    ], [data])

    return {
        columns,
        data,
        enableColumnOrdering: false,
        enableFacetedValues: false,
        enableGrouping: false,
        enableColumnPinning: false,
        enableRowActions: false,
        enableColumnActions: false,
        initialState: { showColumnFilters: false, showGlobalFilter: true },
        paginationDisplayMode: 'pages',
        positionToolbarAlertBanner: 'bottom',
        mantineSearchTextInputProps: {
            placeholder: 'Search Roles',
        },
        autoResetPageIndex: false,
        renderTopToolbar: ({ table }) => {
            return (
                <Flex p="md" justify="space-between" align="center">
                    <Flex gap="xs">
                        <MRT_GlobalFilterTextInput table={table} />
                        <MRT_ToggleFiltersButton table={table} />
                    </Flex>
                    <Alert
                        color="yellow"
                        mb="md"
                        icon={<AlertCircleIcon />}
                        title="Save Changes"
                        style={{ opacity: isDirty ? 1 : 0, transition: 'opacity 0.1s ease-in-out' }}
                    />
                </Flex>
            );
        },
    } as ComponentProps<typeof MantineReactTable>
}
