import UsersRoles from "@/components/users/UsersRoles";
import { Role } from "@/types/Role";
import { UnwrapCell as U } from "@/types/UnwrapCell";
import { User } from "@/types/User";

function UserRolesCell<T extends User & { roles: Role[] }>({ row: { original }}: Parameters<U<T>>[0]): ReturnType<U<T>> {
    return (
        <UsersRoles {...original.roles}/>
    )
}

export default UserRolesCell
