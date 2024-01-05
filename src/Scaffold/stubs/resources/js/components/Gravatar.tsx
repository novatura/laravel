import { Avatar, AvatarProps } from "@mantine/core";
import md5 from "md5";

function Gravatar({ src, email, ...props }: GravatarProps) {

    const url = src || `https://www.gravatar.com/avatar/${md5(email)}?s=160&d=404`;

    return (
        <Avatar src={url} {...props} />
    );
}

type GravatarProps = AvatarProps & {
    email: string;
}

export default Gravatar;
