import RoleBadge from "@/components/roles/RoleBadge"
import { Role } from "@/types/Role"
import { MRT_ColumnDef, MRT_RowData } from "mantine-react-table"

/**
 * Unwrap `| undefined` to get correct Params and Return Type
 */
type C<T extends MRT_RowData> = NonNullable<MRT_ColumnDef<T>["Cell"]>
function RoleBadgeCell<T extends Role>({ row: { original } }: Parameters<C<T>>[0]): ReturnType<C<T>> {
    return (
        <RoleBadge size="lg" {...original} />
    )
}

export default RoleBadgeCell
