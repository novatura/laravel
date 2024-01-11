import { Link } from "@inertiajs/react";
import { Button } from "@mantine/core";

function RoleNavigation({ id }: { id: string }) {
    return (
        <Link href={route('roles.show', id)}>
            <Button>
                Manage
            </Button>
        </Link>
    );
}

export default RoleNavigation;