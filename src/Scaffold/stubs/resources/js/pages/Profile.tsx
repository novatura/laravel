import ChangePassword from "@/components/partials/ChangePassword";
import DeleteProfile from "@/components/partials/DeleteProfile";
import TwoFactor from "@/components/partials/TwoFactor";
import UpdateProfile from "@/components/partials/UpdateProfile";
import ChangeEmail from "@/components/partials/ChangeEmail";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";

function ProfilePage() {
    return (
        <AuthenticatedLayout>
            <UpdateProfile />
            <ChangeEmail />
            <ChangePassword />
            <TwoFactor />
            <DeleteProfile />
        </AuthenticatedLayout>
    );
}

export default ProfilePage;
