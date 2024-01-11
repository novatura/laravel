import { useDisclosure } from '@mantine/hooks';
import { Modal, Button, Group, Stack, Text } from '@mantine/core';
import { User } from '@/types/User';
import { router } from '@inertiajs/react';
import { notifications } from '@mantine/notifications';

const DeleteUser = (user: User) => {
  const [opened, { open, close }] = useDisclosure(false);

    const handleDelete = (e: any) => {
    
        router.delete(route('users.destroy', user.id), {
            onSuccess: () => {
                close();
                notifications.show({
                title: 'User Deleted',
                message: user.full_name + ' has been deleted.',
                color: 'green'});
            
            },
            onError: () => notifications.show({
                title: 'User Delete Failed',
                message: user.full_name + ' failed to delete.',
                color: 'red'
            }),
        });
    }

  return (
    <>
      <Modal opened={opened} onClose={close} title="Are you sure?">
        <Stack>
            <Group grow>
                <Button color="red" onClick={handleDelete}>
                    Confirm Delete
                </Button>
                <Button onClick={close}>
                    Back
                </Button>
            </Group>
        </Stack>

      </Modal>

      <Button color="red" onClick={open}>Delete</Button>
    </>
  );
}

export default DeleteUser;