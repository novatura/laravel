import { PageProps } from "@/types/PageProps";
import { Link, usePage } from "@inertiajs/react";
import { Avatar, Menu, UnstyledButton } from "@mantine/core";
import { UserIcon, LogOutIcon } from "lucide-react"
import { notifications } from "@mantine/notifications"

function UserMenu() {

    const user = usePage<PageProps>().props.auth.user

    return (
        <Menu shadow="md" width={200}>
            <Menu.Target>
                <UnstyledButton>
                    <Avatar color="blue">
                        {user.full_name.split(" ").map(t => t[0]).join("").toUpperCase()}
                    </Avatar>
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
            </Menu.Dropdown>
        </Menu>
    );
}

export default UserMenu;
