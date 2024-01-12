import UserActions from "@/components/users/UserActions";
import UsersRoles from "@/components/users/UsersRoles";
import { Role } from "@/types/Role";
import { User } from "@/types/User";
import { Flex } from "@mantine/core";
import { MRT_ColumnDef, MRT_GlobalFilterTextInput, MRT_ToggleFiltersButton, MantineReactTable } from "mantine-react-table";
import { ComponentProps, createElement, useMemo } from "react";

type UserWithRole = User & { roles: Role[] }


export default function useUsersTable(data: UserWithRole[]) {

    const columns = useMemo<MRT_ColumnDef<UserWithRole>[]>(() => [
        {
            accessorKey: "full_name",
            header: "Name",
        },
        {
            accessorKey: "email",
            header: "Email",
        },
        {
            header: "Roles",
            Cell: ({ cell }) => createElement(UsersRoles, cell.row.original.roles)
        },
        {
            header: "Actions",
            Cell: ({ cell }) => createElement(UserActions, cell.row.original)
        }
    ], [data])

    return {
        columns,
        data,
        enableColumnActions: true,
        enableColumnFilters: true,
        enableSorting: true,
        enableDensityToggle: false,
        enableToggleFullScreen: false,
        enableColumnOrdering: false,
        enableFacetedValues: false,
        enableGrouping: false,
        enableColumnPinning: false,
        enableRowActions: true,
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
                </Flex>
            );
        },
    } as ComponentProps<typeof MantineReactTable>
}
