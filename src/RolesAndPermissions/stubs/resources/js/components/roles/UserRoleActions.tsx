import { ComponentProps } from "react";
import UserNavigation from "../users/UserNavigation";
import RemoveUser from "./RemoveUser";
import { Group } from "@mantine/core";

function UserRoleActions({ navProps, removeProps }: { 
    navProps: ComponentProps<typeof UserNavigation>, 
    removeProps: ComponentProps<typeof RemoveUser>
 }) {
    return (
        <Group>
            <UserNavigation {...navProps} />
            <RemoveUser {...removeProps} />
        </Group>
    );
}

export default UserRoleActions;