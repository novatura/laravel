import { MantineReactTable } from "mantine-react-table";
import { useContext } from "react";
import { RoleUsersContext } from "./UpdateUsers";
import useRoleUserTable from "@/lib/hooks/useRoleUserTable";

function RoleUserTable() {

    const { users } = useContext(RoleUsersContext);

    const tableProps = useRoleUserTable(users)

    return (
        <MantineReactTable {...tableProps} />
    );
}

export default RoleUserTable;