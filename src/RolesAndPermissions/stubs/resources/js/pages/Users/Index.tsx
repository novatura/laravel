import UsersTable from "@/components/users/UsersTable";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";

function UsersPage() {
    return (
        <AuthenticatedLayout>
            <UsersTable />
        </AuthenticatedLayout>
    );
}

export default UsersPage;
