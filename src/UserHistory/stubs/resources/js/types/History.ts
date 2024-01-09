import { User } from "./User"


export type History = {
    id : number,
    description: string | null,
    action: string,
    model: string,
    model_id: number,
    old_data: Array<{ [key: string]: any }>,
    new_data: Array<{ [key: string]: any }>,
    user_id: number,
    user: User
}
