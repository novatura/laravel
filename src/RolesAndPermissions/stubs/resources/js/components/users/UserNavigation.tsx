import { Link } from "@inertiajs/react";
import { Button } from "@mantine/core";

function UserNavigation({ id }: { id: string }) {
    return (
        <Link href={route('users.show', id)}>
            <Button>
                Manage
            </Button>
        </Link>
    );
}

export default UserNavigation;