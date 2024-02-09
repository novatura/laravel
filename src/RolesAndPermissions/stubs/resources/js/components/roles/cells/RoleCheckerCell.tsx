import { Switch } from '@mantine/core';
import { Role } from '@/types/Role';
import { useContext } from 'react';
import { RoleContext } from '../../users/EditUserRoles';
import CustomCell from '@/lib/CustomCell';

const RoleCheckerCell = CustomCell<Role & { isGranted: boolean }>(({ row: { original: { id, isGranted } }}) => {
    const { toggle } = useContext(RoleContext);

    return (
        <Switch
            checked={isGranted}
            onChange={() => toggle(id)}
            color='green'
        />
    );
})

export default RoleCheckerCell;
