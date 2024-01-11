import { Switch } from '@mantine/core';
import { Role } from '@/types/Role';
import { useContext } from 'react';
import { RoleContext } from './EditUserRoles';

const RoleChecker = ({ id, isGranted }: { id: Role["id"], isGranted: boolean}) => {
    
    const { toggle } = useContext(RoleContext);


    return (
        <Switch
            checked={isGranted}
            onChange={() => toggle(id)}
            color='green'
        />
    );
}

export default RoleChecker;