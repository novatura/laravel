import PermissionsToggle from "@/components/permissions/PermissionsToggle";
import { Permission } from "@/types/Permissions";
import { UnwrapCell as U } from "@/types/UnwrapCell";

function PermissionsToggleCell<T extends Permission & { isGranted: boolean }>({ row: { original }}: Parameters<U<T>>[0]): ReturnType<U<T>> {
    return (
        <PermissionsToggle {...original} />
    );
}

export default PermissionsToggleCell;
