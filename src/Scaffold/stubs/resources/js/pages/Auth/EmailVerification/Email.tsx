import GuestLayout from "@/layouts/GuestLayout";
import { Link, router, useForm } from "@inertiajs/react";
import { Button, Stack, Text, TextInput, Title, Group, PinInput} from "@mantine/core";
import { FormEventHandler } from "react";

function Email()  {

    const { put, processing, errors, data, setData } = useForm({
        email: ''
    })

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        put(route('verify.email.update'));
    };


    return (
        <GuestLayout>
            <Stack>
                <Stack gap={0} ta="center">
                    <Title order={2}>Change Email</Title>
                    <Text maw={384}>
                        Enter your new email.
                    </Text>
                </Stack>
                <form onSubmit={submit}>
                    <Stack justify="center" miw="300px">
                        <TextInput
                            label="Email"
                            value={data.email}
                            onChange={(event) => setData('email', event.currentTarget.value)}
                            error={errors.email}
                            required
                            autoFocus
                        />
                        <Button
                            type="submit"
                            loading={processing}
                        >
                            Verify
                        </Button>

                    </Stack>
                </form>
            </Stack>
        </GuestLayout>
    );
}

export default Email;


