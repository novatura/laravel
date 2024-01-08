import { PageProps } from "@/types/PageProps";
import { Link, usePage } from "@inertiajs/react";
import { Avatar, Indicator, Menu, UnstyledButton } from "@mantine/core";
import { UserIcon, LogOutIcon, MailWarningIcon } from "lucide-react"
import { notifications } from "@mantine/notifications"

function UserMenu() {

    const user = usePage<PageProps>().props.auth.user

    return (
        <Menu shadow="md" width={200}>
            <Menu.Target>
                <UnstyledButton>
                    <Indicator disabled={!!user.email_verified_at}>
                        <Avatar color="blue" radius="sm" src={user.avatar_url}>
                            {user.full_name.split(" ").map(t => t[0]).join("").toUpperCase()}
                        </Avatar>
                    </Indicator>
                </UnstyledButton>
            </Menu.Target>
            <Menu.Dropdown>
                <Menu.Label>Account</Menu.Label>
                <Link href={route("profile.edit")} style={{ textDecoration: "none" }}>
                    <Menu.Item leftSection={<UserIcon size={16} />}>Profile</Menu.Item>
                </Link>
                <Link
                    href={route("logout")}
                    method="post"
                    style={{ textDecoration: "none" }}
                    onSuccess={() => notifications.show({ title: "Signed out", message: "You have been signed out.", color: "green" })}
                >
                    <Menu.Item leftSection={<LogOutIcon size={16} />}>Sign out</Menu.Item>
                </Link>
                {!user.email_verified_at && (<>
                    <Menu.Divider />
                    <Link
                        href={route("verify.email.send")}
                        style={{ textDecoration: "none" }}
                        method="post"
                    >
                        <Indicator position="middle-start">
                            <Menu.Item leftSection={<MailWarningIcon size={16} />}>Verify Email</Menu.Item>
                        </Indicator>
                    </Link>
                </>)}
            </Menu.Dropdown>
        </Menu>
    );
}

export default UserMenu;
