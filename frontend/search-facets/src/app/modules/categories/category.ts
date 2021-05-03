export class Category {
    id: number = 0
    label: string = ''
    parent_id: number = 0
    children?: Category[]
}