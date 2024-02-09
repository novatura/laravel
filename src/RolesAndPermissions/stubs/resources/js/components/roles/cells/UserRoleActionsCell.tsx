import UserNavigation from "../../users/UserNavigation";
import RemoveUser from "../RemoveUser";
import { Group } from "@mantine/core";
import { User } from "@/types/User";
import CustomCell from "@/lib/CustomCell";

const UserRoleActionsCell = CustomCell<User>(({ row: { original: { id }}}) => (
    <Group>
        <UserNavigation id={id} />
        <RemoveUser id={id} />
    </Group>
))

export default UserRoleActionsCell;
