import AddUsers from "@/components/roles/AddUsers";
import UserRoleActions from "@/components/roles/UserRoleActions";
import UserBadge from "@/components/users/UserBadge";
import { User } from "@/types/User";
import { Flex } from "@mantine/core";
import { MRT_ColumnDef, MRT_GlobalFilterTextInput, MRT_ToggleFiltersButton, MantineReactTable } from "mantine-react-table";
import { ComponentProps, createElement, useMemo } from "react";

type RowType = User

export default function useRoleUserTable(data: RowType[]) {

    const columns = useMemo<MRT_ColumnDef<RowType>[]>(() => [
        {
            accessorKey: "full_name",
            header: "Name",
            Cell: ({ cell }) => createElement(UserBadge, { user: cell.row.original }, cell.row.original.full_name)
        },
        {
            accessorKey: "id",
            header: "",
            Cell: ({ cell }) => createElement(UserRoleActions, { navProps: { id: cell.row.original.id }, removeProps: { id: cell.row.original.id } })
        },
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
            placeholder: 'Search Users',
        },
        autoResetPageIndex: false,
        renderTopToolbar: ({ table }) => {
            return (
                <Flex p="md" justify="space-between" align="center">
                    <Flex gap="xs">
                        <MRT_GlobalFilterTextInput table={table} />
                        <MRT_ToggleFiltersButton table={table} />
                    </Flex>
                    <AddUsers />
                </Flex>
            );
        },
    } as ComponentProps<typeof MantineReactTable>
}
