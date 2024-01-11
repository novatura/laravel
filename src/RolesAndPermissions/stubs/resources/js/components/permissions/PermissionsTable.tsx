import usePermissionsTable from "@/lib/hooks/usePermissionsTable";
import { MantineReactTable } from "mantine-react-table";
import { useContext, useMemo } from "react";
import { PermissionsContext } from "../roles/UpdatePermissions";

function PermissionsTable() {

    const { enabled, permissions, isDirty } = useContext(PermissionsContext);

    const values = useMemo(() => permissions.map((permission) => {
        return {
            ...permission,
            isGranted: enabled.includes(permission.id),
        }
    
    }), [permissions, enabled])

    const tableProps = usePermissionsTable(values, isDirty)

    return (
        <MantineReactTable {...tableProps} />
    );
}

export default PermissionsTable;