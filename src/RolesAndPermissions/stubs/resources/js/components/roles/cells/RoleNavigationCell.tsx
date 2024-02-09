import { Role } from "@/types/Role";
import { Link } from "@inertiajs/react";
import { Button } from "@mantine/core";
import CustomCell from "@/lib/CustomCell";

const RoleNavigationCell = CustomCell<Role>(({ row: { original: { id }}}) => (
    <Link href={route('roles.show', id)}>
        <Button>
            Manage
        </Button>
    </Link>
))

export default RoleNavigationCell;
