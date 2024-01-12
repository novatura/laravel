import AuthenticatedLayout from "@/layouts/AuthenticatedLayout";
import { History } from '../../types/History';
import HistoryTable from "@/components/HistoryTable";

function HistoryPage({history} : {history : History[]}) {

    return (
        <AuthenticatedLayout>
            <HistoryTable data={history} />
        </AuthenticatedLayout>
    );
}

export default HistoryPage;