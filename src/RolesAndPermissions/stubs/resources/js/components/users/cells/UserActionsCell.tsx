import DeleteUser from "@/components/users/DeleteUser";
import UserNavigation from "@/components/users/UserNavigation";
import { Role } from "@/types/Role";
import { UnwrapCell as U } from "@/types/UnwrapCell";
import { User } from "@/types/User";
import { Group } from "@mantine/core";

function UserActionsCell<T extends User & { roles: Role[] }>({ row: { original }}: Parameters<U<T>>[0]): ReturnType<U<T>> {
    return (
        <Group justify="flex-start">
            <UserNavigation {...original}/>
            <DeleteUser {...original} />
        </Group>
    )
}

export default UserActionsCell;
