import { MantineReactTable } from "mantine-react-table";
import { useContext, useMemo } from "react";
import { RoleContext } from "./EditUserRoles";
import useUsersRolesTable from "@/lib/hooks/useUsersRolesTable";

function RoleTable() {

    const { enabled, roles, isDirty } = useContext(RoleContext);

    const values = useMemo(() => roles.map((role) => {
        return {
            ...role,
            isGranted: enabled.includes(role.id),
        }
    
    }), [roles, enabled])

    const tableProps = useUsersRolesTable(values, isDirty)

    return (
        <MantineReactTable {...tableProps} />
    );
}

export default RoleTable;