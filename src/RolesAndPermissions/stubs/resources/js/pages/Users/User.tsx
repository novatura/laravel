import EditUserRoles from "@/components/users/EditUserRoles";
import UserProfile from "@/components/users/UserProfile";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";

function UserPage() {
    return (
        <AuthenticatedLayout>
            <UserProfile />
            <EditUserRoles />
        </AuthenticatedLayout>
    );
}

export default UserPage;