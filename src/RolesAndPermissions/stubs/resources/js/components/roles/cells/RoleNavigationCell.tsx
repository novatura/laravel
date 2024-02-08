import { Role } from "@/types/Role";
import { Link } from "@inertiajs/react";
import { Button } from "@mantine/core";
import { MRT_ColumnDef } from "mantine-react-table";
import { UnwrapCell as U } from '@/types/UnwrapCell';

function RoleNavigationCell<T extends Role>({ row: { original: { id }}}: Parameters<U<T>>[0]): ReturnType<U<T>> {
    return (
        <Link href={route('roles.show', id)}>
            <Button>
                Manage
            </Button>
        </Link>
    )
}

export default RoleNavigationCell;
