import { Button } from "@mantine/core";
import SelectUsers from "./SelectUsers";
import { useDisclosure } from "@mantine/hooks";

function AddUsers() {

    const [isOpen, { open, close }] = useDisclosure(false)

    return (
        <>
            <SelectUsers
                    opened={isOpen}
                    onClose={close}
                    title="Grant User Role"
                    size="sm"
                    centered
                />
            <Button onClick={open} color="blue" type="button">
                Add User
            </Button>
        </>
    );
}

export default AddUsers;