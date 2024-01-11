import { User } from "@/types/User";
import { Avatar, Group, Text } from "@mantine/core";

function UserBadge({ user, size="md" }: { user: User, size?: "xs" | "sm" | "md" | "lg" | "xl" }) {
    return (
        <Group gap="sm">
            <Avatar color="blue" size={size}>
                {user.full_name.split(" ").map(t => t[0]).join("").toUpperCase()}
            </Avatar>
            <Text>{user.full_name}</Text>
        </Group>
    );
}

export default UserBadge;