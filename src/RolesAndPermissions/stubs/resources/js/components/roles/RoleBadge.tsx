import { Role } from "@/types/Role";
import { Badge } from "@mantine/core";

function RoleBadge({ name, colour, size="md"}: Role & { size?: string }) {
    return (
        <Badge style={{backgroundColor: colour}} size={size}>
            {name}
        </Badge>
    );
}

export default RoleBadge;