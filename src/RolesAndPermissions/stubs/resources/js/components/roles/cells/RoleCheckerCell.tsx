import { Switch } from '@mantine/core';
import { Role } from '@/types/Role';
import { ReactNode, useContext } from 'react';
import { RoleContext } from '../../users/EditUserRoles';
import { MRT_ColumnDef, MRT_RowData } from 'mantine-react-table';
import { UnwrapCell as U } from '@/types/UnwrapCell';

function RoleChecker<T extends Role & { isGranted: boolean }>({ row: { original: { id, isGranted } }}: Parameters<U<T>>[0]): ReturnType<U<T>> {
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
