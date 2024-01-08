import ChangePassword from "@/components/partials/ChangePassword";
import DeleteProfile from "@/components/partials/DeleteProfile";
import TwoFactor from "@/components/partials/TwoFactor";
import UpdateProfile from "@/components/partials/UpdateProfile";
import ChangeEmail from "@/components/partials/ChangeEmail";
import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { Link, usePage } from "@inertiajs/react";
import { PageProps } from "@/types/PageProps";
import { Alert, Button, Stack, Text } from "@mantine/core";

function ProfilePage() {

    const user = usePage<PageProps>().props.auth.user

    return (
        <AuthenticatedLayout>
            {!user.email_verified_at && (
                <Alert
                    color="blue"
                    variant="filled"
                    title="Verify your email address"
                >
                    <Stack>
                        <Text>
                            Please verify your email address.
                            We've sent you an email with a verification link.
                        </Text>
                        <div>
                            <Button
                                component={Link}
                                href={route("verify.email.send")}
                                variant="white"
                                method="post"
                            >
                                Verify Manually
                            </Button>
                        </div>
                    </Stack>
                </Alert>
            )}
            <UpdateProfile />
            <ChangeEmail />
            <ChangePassword />
            <TwoFactor />
            <DeleteProfile />
        </AuthenticatedLayout>
    );
}

export default ProfilePage;
