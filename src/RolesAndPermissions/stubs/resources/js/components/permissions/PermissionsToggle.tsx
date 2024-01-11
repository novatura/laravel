import { Permission } from "@/types/Permissions";
import { Switch } from "@mantine/core";
import { useContext } from "react";
import { PermissionsContext } from "../roles/UpdatePermissions";

function PermissionsToggle({ id, isGranted }: { id: Permission["id"], isGranted: boolean}) {
    
    const { toggle } = useContext(PermissionsContext);
    
    return (
        <Switch 
            checked={isGranted}
            onChange={() => toggle(id)}
            color="green"
        />
    );
}

export default PermissionsToggle;