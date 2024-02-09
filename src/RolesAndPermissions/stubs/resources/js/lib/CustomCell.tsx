import { MRT_RowData } from "mantine-react-table"
import { UnwrapCell as U } from "@/types/UnwrapCell"

function CustomCell<T extends MRT_RowData, V = unknown>(fn: (props: Parameters<U<T,V>>[0]) => ReturnType<U<T,V>>): (props: Parameters<U<T,V>>[0]) => ReturnType<U<T,V>> {
    return fn
}

export default CustomCell
