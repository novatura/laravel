import AddRole from "@/components/roles/AddRole";
import RoleBadge from "@/components/roles/RoleBadge";
import RoleNavigation from "@/components/roles/RoleNavigation";
import { Role } from "@/types/Role";
import { Flex } from "@mantine/core";
import { MRT_ColumnDef, MRT_GlobalFilterTextInput, MRT_ToggleFiltersButton, MantineReactTable } from "mantine-react-table";
import { createElement, useMemo, ComponentProps } from "react";

type RowType = Role & { members: number }

export default function useRolesTable(data: RowType[]) {

    const columns = useMemo<MRT_ColumnDef<RowType>[]>(() => [
        {
            accessorKey: "name",
            header: "Name",
            Cell: ({ cell }) => createElement(RoleBadge, { ...cell.row.original, size: "lg" }, cell.row.original.name)
        },
        {
            accessorKey: "user_count",
            header: "Members",
        },
        {
            accessorFn: ({ permissions }) => permissions.length,
            header: "Permissions",
        },
        {
            accessorKey: "id",
            header: "",
            Cell: ({ cell }) => createElement(RoleNavigation, { id: cell.row.original.id }, cell.row.original.id)
        }
    ], [data])

    return {
        columns,
        data,
        enableColumnActions: false,
        enableColumnFilters: false,
        enableSorting: false,
        enableDensityToggle: false,
        enableToggleFullScreen: false,
        enableSearch: false,
        enableColumnOrdering: false,
        enableFacetedValues: false,
        enableGrouping: false,
        enableColumnPinning: false,
        enableRowActions: false,
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
                    <AddRole />
                </Flex>
            );
        },
    } as ComponentProps<typeof MantineReactTable>
}
