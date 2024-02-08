import { Role } from "@/types/Role";
import { MRT_ColumnDef, MantineReactTable } from "mantine-react-table";
import { useMemo, ComponentProps } from "react";
import { default as renderTopToolbar } from "@/components/roles/RolesTableTopToolbar";
import RoleBadgeCell from "@/components/roles/cells/RoleBadgeCell";
import RoleNavigationCell from "@/components/roles/cells/RoleNavigationCell";

type RowType = Role & { members: number }

export default function useRolesTable(data: RowType[]) {

    const columns = useMemo<MRT_ColumnDef<RowType>[]>(() => [
        {
            accessorKey: "name",
            header: "Name",
            Cell: RoleBadgeCell
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
            Cell: RoleNavigationCell
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
        renderTopToolbar
    } as ComponentProps<typeof MantineReactTable>
}
