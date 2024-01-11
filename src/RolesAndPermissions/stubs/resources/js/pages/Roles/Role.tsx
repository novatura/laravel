import DeleteRole from "@/components/roles/DeleteRole";
import UpdatePermissions from "@/components/roles/UpdatePermissions";
import UpdateRole from "@/components/roles/UpdateRole";
import UpdateUsers from "@/components/roles/UpdateUsers";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { Link } from "@inertiajs/react";
import { Button } from "@mantine/core";

function RolePage() {
    return (
        <AuthenticatedLayout>
            <Link href={route('roles.index')}>
                <Button>
                    Back
                </Button>
            </Link>
            <UpdateRole />
            <UpdateUsers />
            <UpdatePermissions />
            <DeleteRole />
        </AuthenticatedLayout>
    );
}

export default RolePage;
