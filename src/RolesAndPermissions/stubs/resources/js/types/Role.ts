import { Permission } from "./Permissions"

export type Role = {
    id: string
    name: string
    colour: string
    permissions: Permission[]
}