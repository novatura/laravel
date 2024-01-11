import { useForm } from "@inertiajs/react";
import { Stack, TextInput, Button, Group, ColorPicker, InputLabel, Badge, Modal, ModalProps } from "@mantine/core";
import { FormEvent } from "react";
import { notifications } from "@mantine/notifications"

function CreateRole(props: ModalProps) {

    const { post, data, setData, processing, errors } = useForm({
        name: "Role",
        colour: "#238be6",
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route('roles.store'), {
            onSuccess: () => notifications.show({
                title: 'Role Created',
                message: 'This role has been created successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'Role Creation Failed',
                message: 'This role could not be created.',
                color: 'red'
            }),
        });

        props.onClose();
    }

    return (
        <Modal {...props}>
            <form onSubmit={handleSubmit}>
                <Group align="flex-start">
                    <Stack maw={512}>
                        <TextInput
                            label="Role Name"
                            value={data.name}
                            onChange={(event) => setData('name', event.currentTarget.value)}
                            error={errors.name}
                            required
                        />
                        <div>
                            <InputLabel>Role Color</InputLabel>
                            <ColorPicker
                                value={data.colour}
                                onChange={(event) => setData('colour', event)}
                            />
                        </div>
                    </Stack>
                    <Stack gap="xs">
                        <InputLabel>Preview</InputLabel>
                        <Badge color={data.colour} size="lg">{data.name}</Badge>
                    </Stack>
                </Group>
                <Button mt="lg" type="submit" loading={processing}>
                    Confirm
                </Button>
            </form>
        </Modal>
    );
}

export default CreateRole;
