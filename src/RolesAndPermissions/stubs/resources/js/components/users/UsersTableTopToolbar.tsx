import { Flex } from "@mantine/core";
import { MRT_GlobalFilterTextInput, MRT_ToggleFiltersButton, MantineReactTable } from "mantine-react-table";
import { ComponentProps } from "react";

const UsersTableTopToolbar: ComponentProps<typeof MantineReactTable>["renderTopToolbar"] = ({ table }) => (
    <Flex p="md" justify="space-between" align="center">
        <Flex gap="xs">
            <MRT_GlobalFilterTextInput table={table} />
            <MRT_ToggleFiltersButton table={table} />
        </Flex>
    </Flex>
)

export default UsersTableTopToolbar;
