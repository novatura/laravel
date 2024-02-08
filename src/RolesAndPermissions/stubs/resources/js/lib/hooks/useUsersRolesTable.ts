import RoleBadgeCell from "@/components/roles/cells/RoleBadgeCell";
import UserRolesTableTopToolbar from "@/components/roles/UsersRolesTableTopToolbar";
import RoleCheckerCell from "@/components/roles/cells/RoleCheckerCell";
import { Role } from "@/types/Role";
import { MRT_ColumnDef, MantineReactTable } from "mantine-react-table";
import { ComponentProps, useMemo } from "react";

type RowType = Role & { isGranted: boolean }

export default function useUsersRolesTable(data: RowType[], isDirty: boolean) {

    const columns = useMemo<MRT_ColumnDef<RowType>[]>(() => [
        {
            accessorKey: "id",
            header: "Toggle",
            Cell: RoleCheckerCell
        },
        {
            accessorKey: "name",
            header: "Name",
            Cell: RoleBadgeCell
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
        renderTopToolbar: UserRolesTableTopToolbar(isDirty)
    } as ComponentProps<typeof MantineReactTable>
}
