import { User } from "@/types/User";
import UserBadge from "@/components/users/UserBadge";
import CustomCell from "@/lib/CustomCell";

const UserBadgeCell = CustomCell<User>(({ row: { original }}) => (
    <UserBadge user={original} size="lg" />
))

export default UserBadgeCell;
