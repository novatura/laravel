import { Flex, HoverCard, Stack, UnstyledButton } from "@mantine/core";
import { Role } from "@/types/Role";
import RoleBadge from "../roles/RoleBadge";
import { MoreHorizontal } from 'lucide-react';
import { useMemo } from "react";

const UsersRoles = (roles : Role[]) => {

    // Mapping over the inner objects within the object
    const newArray = useMemo(() => Object.keys(roles).map(key => {
        let originalObject = roles[parseInt(key)];
        return {
        ...originalObject,
        };
    }), [roles]);

    const visibleRoles = newArray.slice(0, 2);

    return (
        <Flex justify="flex-start" gap="xs" align="center">
                {visibleRoles.map(function (role, key) {
                    return <RoleBadge key={key} { ...role } size="lg"/>
                })}
                {newArray.length > 2 && 
                    <HoverCard shadow="md">
                        <HoverCard.Target>
                            <UnstyledButton style={{display: "flex", alignItems: "center"}}>
                                <MoreHorizontal/>
                            </UnstyledButton>
                        </HoverCard.Target>
                        <HoverCard.Dropdown>
                            <Stack align="center">
                                {newArray.map(function (role, key) {
                                    return <RoleBadge key={key} { ...role } size="lg"/>
                                })}
                            </Stack>
                        </HoverCard.Dropdown>
                    </HoverCard>
                }
        </Flex>
    );
}

export default UsersRoles;


