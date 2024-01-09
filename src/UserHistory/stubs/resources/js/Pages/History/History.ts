import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import useHistoryTable from "../../lib/hooks/useHistoryTable";
import { History } from "../../types/History";
import { MantineReactTable } from "mantine-react-table";

function HistoryPage({history} : {history : History[]}) {


    const tableProps = useHistoryTable(history);

    return (
        <AuthenticatedLayout>
            <MantineReactTable {...tableProps} />
        </AuthenticatedLayout>
    );
}

export default HistoryPage;