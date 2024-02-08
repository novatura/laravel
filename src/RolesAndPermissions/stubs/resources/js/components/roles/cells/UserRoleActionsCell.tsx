import UserNavigation from "../../users/UserNavigation";
import RemoveUser from "../RemoveUser";
import { Group } from "@mantine/core";
import { UnwrapCell as U } from "@/types/UnwrapCell";
import { User } from "@/types/User";

function UserRoleActionsCell<T extends User>({ row: { original: { id }} }: Parameters<U<T>>[0]) {
    return (
        <Group>
            <UserNavigation id={id} />
            <RemoveUser id={id} />
        </Group>
    );
}

export default UserRoleActionsCell;
