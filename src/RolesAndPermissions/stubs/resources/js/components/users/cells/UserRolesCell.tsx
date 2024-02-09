import UsersRoles from "@/components/users/UsersRoles";
import CustomCell from "@/lib/CustomCell";
import { Role } from "@/types/Role";
import { User } from "@/types/User";

const UserRolesCell = CustomCell<User & { roles: Role[] }>(({ row: { original }}) => (
    <UsersRoles {...original.roles}/>
))

export default UserRolesCell
