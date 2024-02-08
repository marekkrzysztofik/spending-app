export interface Column {
    name: string;
    placeholder: string;
    type: string;
}
export interface FormComponent {
    title: string
    columns: Column[]
    apiName: string
}
export interface Form {
    name: string
    surname: string
    email: string
    password: string
    c_password: string
}