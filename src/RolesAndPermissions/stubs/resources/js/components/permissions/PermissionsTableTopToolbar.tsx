import { Flex, Alert } from "@mantine/core";
import { AlertCircleIcon } from "lucide-react";
import { MRT_GlobalFilterTextInput, MRT_ToggleFiltersButton, MantineReactTable } from "mantine-react-table";
import { ComponentProps } from "react";

const PermissionsTableTopToolbar: (isDirty: boolean) => ComponentProps<typeof MantineReactTable>["renderTopToolbar"] = (isDirty) => ({ table }) => (
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
)

export default PermissionsTableTopToolbar
