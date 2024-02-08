import { MRT_ColumnDef, MRT_RowData } from "mantine-react-table";

export type UnwrapCell<T extends MRT_RowData, V = unknown> = NonNullable<MRT_ColumnDef<T, V>["Cell"]>
