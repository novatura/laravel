import { Button } from "@mantine/core";
import { RoleUsersContext } from "./UpdateUsers";
import { useContext } from "react";
import { User } from "@/types/User";

function RemoveUser({ id }: { id: User['id'] }) {

    const { remove } = useContext(RoleUsersContext)

    return (
        <Button onClick={() => remove(id)} color="red" type="button">
            Remove
        </Button>
    );
}

export default RemoveUser;