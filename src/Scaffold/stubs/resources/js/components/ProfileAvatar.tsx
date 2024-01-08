import { Avatar, AvatarProps } from "@mantine/core";
import md5 from "md5";

function ProfileAvatar({ src, email, ...props }: GravatarProps) {

    const url = src ? src : `https://www.gravatar.com/avatar/${md5(email)}?s=160&d=404`;

    return (
        <Avatar src={url} {...props} />
    );
}

type GravatarProps = AvatarProps & {
    email: string;
    src: string | null
}

export default ProfileAvatar;
