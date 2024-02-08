import AddUsers from "@/components/roles/AddUsers";
import UserRoleActions from "@/components/roles/cells/UserRoleActionsCell";
import UserBadge from "@/components/users/UserBadge";
import { User } from "@/types/User";
import { Flex } from "@mantine/core";
import { MRT_ColumnDef, MRT_GlobalFilterTextInput, MRT_ToggleFiltersButton, MantineReactTable } from "mantine-react-table";
import { ComponentProps, createElement, useMemo } from "react";
import { default as renderTopToolbar } from "@/components/roles/RoleUserTableTopToolbar";
import UserBadgeCell from "@/components/users/cells/UserBadgeCell";
import UserRoleActionsCell from "@/components/roles/cells/UserRoleActionsCell";

export default function useRoleUserTable(data: User[]) {

    const columns = useMemo<MRT_ColumnDef<User>[]>(() => [
        {
            accessorKey: "full_name",
            header: "Name",
            Cell: UserBadgeCell
        },
        {
            accessorKey: "id",
            header: "",
            Cell: UserRoleActionsCell
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
        renderTopToolbar,
    } as ComponentProps<typeof MantineReactTable>
}
