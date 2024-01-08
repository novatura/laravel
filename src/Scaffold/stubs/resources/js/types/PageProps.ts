import { User } from "@/types/User"

export type PageProps<T = {}> = {
    auth: {
        user: User
    }
} & T
