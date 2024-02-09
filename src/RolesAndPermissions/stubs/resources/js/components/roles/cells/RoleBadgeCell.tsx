import RoleBadge from "@/components/roles/RoleBadge"
import CustomCell from "@/lib/CustomCell"
import { Role } from "@/types/Role"

const RoleBadgeCell = CustomCell<Role & { isGranted: boolean }>(({ row: { original } }) => {
    return (
        <RoleBadge size="lg" {...original} />
    )
})

export default RoleBadgeCell
