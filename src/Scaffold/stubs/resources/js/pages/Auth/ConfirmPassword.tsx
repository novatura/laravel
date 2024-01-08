import GuestLayout from "@/layouts/GuestLayout";
import { useForm, Link } from "@inertiajs/react";
import { Stack, Title, PinInput, Button, Group, Text, TextInput } from "@mantine/core";

function ConfirmPasswordPage() {

    const { post, data, setData, processing, errors } = useForm({
        password: "",
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route("password.confirm"));
    };

    return (
        <GuestLayout>
            <Stack gap="xl">
                <Stack gap={0} ta="center">
                    <Title>Confirm Password</Title>
                    <Text maw={384}>
                        Please confirm your password before continuing.
                    </Text>
                </Stack>
                <form onSubmit={handleSubmit}>
                    <Stack justify="center">
                        <TextInput
                            label="Password"
                            type="password"
                            value={data.password}
                            onChange={(event) => setData("password", event.currentTarget.value)}
                            error={errors.password}
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
                    <Text c="red" ta="center">
                        {errors.password}
                    </Text>
                </form>
            </Stack>
        </GuestLayout>
    );
}

export default ConfirmPasswordPage;
