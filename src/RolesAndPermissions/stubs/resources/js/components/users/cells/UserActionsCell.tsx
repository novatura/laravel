import DeleteUser from "@/components/users/DeleteUser";
import UserNavigation from "@/components/users/UserNavigation";
import CustomCell from "@/lib/CustomCell";
import { Role } from "@/types/Role";
import { User } from "@/types/User";
import { Group } from "@mantine/core";

const UserActionsCell = CustomCell<User & { roles: Role[] }>(({ row: { original }}) => (
    <Group justify="flex-start">
        <UserNavigation {...original}/>
        <DeleteUser {...original} />
    </Group>
))

export default UserActionsCell;
