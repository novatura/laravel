import PermissionsTableTopToolbar from "@/components/permissions/PermissionsTableTopToolbar";
import PermissionsToggle from "@/components/permissions/PermissionsToggle";
import PermissionsToggleCell from "@/components/permissions/cells/PermissionsToggleCell";
import { Permission } from "@/types/Permissions";
import { Alert, Flex } from "@mantine/core";
import { AlertCircleIcon } from "lucide-react";
import { MRT_ColumnDef, MRT_GlobalFilterTextInput, MRT_ToggleFiltersButton, MantineReactTable } from "mantine-react-table";
import { ComponentProps, createElement, useMemo } from "react";

type RowType = Permission & { isGranted: boolean }

export default function usePermissionsTable(data: RowType[], isDirty: boolean) {

    const columns = useMemo<MRT_ColumnDef<RowType>[]>(() => [
        {
            accessorKey: "isGranted",
            header: "",
            Cell: PermissionsToggleCell
        },
        {
            accessorKey: "name",
            header: "Name",
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
            placeholder: 'Search Permissions',
        },
        autoResetPageIndex: false,
        renderTopToolbar: PermissionsTableTopToolbar(isDirty),
    } as ComponentProps<typeof MantineReactTable>
}
