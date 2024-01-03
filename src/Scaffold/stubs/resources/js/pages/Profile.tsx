import ChangePassword from "@/components/partials/ChangePassword";
import DeleteProfile from "@/components/partials/DeleteProfile";
import UpdateProfile from "@/components/partials/UpdateProfile";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";

function ProfilePage() {
    return (
        <AuthenticatedLayout>
            <UpdateProfile />
            <ChangePassword />
            <DeleteProfile />
        </AuthenticatedLayout>
    );
}

export default ProfilePage;
