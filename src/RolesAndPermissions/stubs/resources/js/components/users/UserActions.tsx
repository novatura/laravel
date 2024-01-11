import { User } from "@/types/User";
import { Group } from "@mantine/core";
import DeleteUser from "./DeleteUser";
import { Role } from "@/types/Role";
import UserNavigation from "./UserNavigation";


const UserActions = (user : (User & { roles: Role[] })) => {

    return (
        <Group justify="flex-start">
            <UserNavigation {...user}/>
            <DeleteUser {...user} />
        </Group>

    );
}

export default UserActions;


