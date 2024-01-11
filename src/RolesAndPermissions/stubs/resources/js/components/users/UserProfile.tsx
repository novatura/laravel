import { PageProps } from "@/types/PageProps";
import { usePage } from "@inertiajs/react";
import { Card, Title, Text, Stack, Group } from "@mantine/core";
import { User } from "@/types/User";
import UserBadge from "./UserBadge";

function UserProfile() {

    const { user } = usePage<PageProps<{ user: User }>>().props

    return (
        <Card withBorder>
            <Stack>
                <Group justify="space-between">
                    <Stack gap={0}>
                        <Title order={2}>User Profile</Title>
                    </Stack>
                </Group>
                <Stack maw={512}>
                    <UserBadge user={user} size="lg" />
                    <Text>
                        <b>Email:</b> {user.email}
                    </Text>
                </Stack>
            </Stack>
        </Card>
    );
}

export default UserProfile;
