import { Button } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import CreateRole from "./CreateRole";

function AddRole() {

    const [isOpen, { open, close }] = useDisclosure(false)

    return (
        <>
            <CreateRole
                opened={isOpen}
                onClose={close}
                title="Create Role"
                size="sm"
                centered
            />
            <Button onClick={open} color="blue" type="button">
                Add Role
            </Button>
        </>
    );
}

export default AddRole;