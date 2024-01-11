import RolesTable from "@/components/roles/RolesTable";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";

function RolesPage() {

    return (
        <AuthenticatedLayout>
            <RolesTable />
        </AuthenticatedLayout>
    );
}

export default RolesPage;
