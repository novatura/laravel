import { Head } from "@inertiajs/react";
import { Card } from "@mantine/core";

function IndexPage() {
    return (
        <>
            <Head title="Home" />
            <div>
                <Card>
                    Hello!
                </Card>
            </div>
        </>
    );
}

export default IndexPage;
