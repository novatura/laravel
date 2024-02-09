import PermissionsToggle from "@/components/permissions/PermissionsToggle";
import CustomCell from "@/lib/CustomCell";
import { Permission } from "@/types/Permissions";

const PermissionsToggleCell = CustomCell<Permission & { isGranted: boolean }>(({ row: { original }}) => (
    <PermissionsToggle {...original} />
))

export default PermissionsToggleCell;
