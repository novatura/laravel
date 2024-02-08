import { User } from "@/types/User";
import { UnwrapCell as U } from "@/types/UnwrapCell";
import UserBadge from "@/components/users/UserBadge";

function UserBadgeCell<T extends User>({ row: { original }}: Parameters<U<T>>[0]): ReturnType<U<T>> {
    return (
        <UserBadge user={original} size="lg" />
    )
}

export default UserBadgeCell;
