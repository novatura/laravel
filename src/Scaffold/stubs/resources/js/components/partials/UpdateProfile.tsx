import { PageProps } from "@/types/PageProps";
import { router, useForm, usePage } from "@inertiajs/react";
import { Card, Title, Text, Stack, TextInput, Button, Group, Avatar, FileInput, VisuallyHidden } from "@mantine/core";
import { FormEvent } from "react";
import { notifications } from "@mantine/notifications"

function UpdateProfile() {

    const user = usePage<PageProps>().props.auth.user

    const { post, data, setData, processing, errors } = useForm<{
        first_name: string,
        last_name: string,
        avatar: File | null,
    }>({
        first_name: user.first_name,
        last_name: user.last_name,
        avatar: null,
    })

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        console.log(data)

        post(route('profile.update'), {
            onSuccess: () => notifications.show({
                title: 'Profile Updated',
                message: 'Your profile has been updated successfully.',
                color: 'green'
            }),
            onError: () => notifications.show({
                title: 'Profile Update Failed',
                message: 'Your profile could not be updated.',
                color: 'red'
            }),
            forceFormData: true,
        });
    }

    return (
        <Card withBorder>
            <Stack gap="lg">
                <Stack gap={0}>
                    <Title order={2}>Profile</Title>
                    <Text>Update your profile</Text>
                </Stack>
                <form onSubmit={handleSubmit}>
                    <Stack maw={512} gap="xl">
                        <Group>
                            <label htmlFor="avatar">
                                <VisuallyHidden>Current avatar</VisuallyHidden>
                                <Avatar
                                    src={data.avatar ? URL.createObjectURL(data.avatar) : user.avatar_url}
                                    radius="sm"
                                    size="xl"
                                    >
                                    {user.full_name.split(" ").map(t => t[0]).join("").toUpperCase()}
                                </Avatar>
                            </label>
                            <Stack gap="xs">
                                <Title order={4}>Profile Picture</Title>
                                <Group>
                                    <FileInput
                                        accept="image/png,image/jpeg,image/webp"
                                        onChange={(file) => setData('avatar', file)}
                                        value={data.avatar}
                                        placeholder="Select an image to upload"
                                        variant="filled"
                                        id="avatar"
                                        error={errors.avatar}
                                    />
                                    {!user.avatar_url.startsWith("https://www.gravatar.com") && (
                                        <Button
                                            variant="filled"
                                            color="red"
                                            type="button"
                                            onClick={() => router.visit(route("profile.avatar.destroy"), {
                                                method: "delete",
                                                onSuccess: () => notifications.show({
                                                    title: 'Profile Picture Removed',
                                                    message: 'Your profile picture has been removed successfully.',
                                                    color: 'green'
                                                }),
                                                onError: () => notifications.show({
                                                    title: 'Profile Picture Removal Failed',
                                                    message: 'Your profile picture could not be removed.',
                                                    color: 'red'
                                                }),
                                            })}
                                        >
                                            Remove Profile Picture
                                        </Button>
                                    )}
                                </Group>
                            </Stack>
                        </Group>
                        <Stack>
                            <TextInput
                                label="First Name"
                                value={data.first_name}
                                onChange={(event) => setData('first_name', event.currentTarget.value)}
                                error={errors.first_name}
                                required
                                autoComplete="given-name"
                            />
                            <TextInput
                                label="Last Name"
                                value={data.last_name}
                                onChange={(event) => setData('last_name', event.currentTarget.value)}
                                error={errors.last_name}
                                required
                                autoComplete="family-name"
                            />
                            <TextInput
                                label="Email"
                                value={user.email}
                                readOnly
                                disabled
                            />
                        </Stack>
                    </Stack>
                    <Button mt="lg" type="submit" loading={processing}>
                        Update
                    </Button>
                </form>
            </Stack>
        </Card>
    );
}

export default UpdateProfile;
