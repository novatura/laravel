import { Anchor, AnchorProps } from "@mantine/core";
import { MRT_ColumnDef } from "mantine-react-table";
import { createElement, useMemo } from "react";
import { History } from "../../types/History";

export default function useHistoryTable(data: History[]) {
    const columns = useMemo<MRT_ColumnDef<History>[]>(() => [
        {
            accessorKey: "action",
            header: "Action",
        },
        {
            accessorKey: "model",
            header: "Model",
        },
        {
            accessorKey: "description",
            header: "Description",
        },
        {
            accessorKey: "user",
            header: "User",
            Cell: ({row}) => {
                return row.original.user.full_name;
            }
        },
    ], [data])

    return {
        columns,
        data,
        enableDensityToggle: false,
    }
}