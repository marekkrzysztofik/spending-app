interface RegisterColumn {
    name: string;
    placeholder: string;
    type: string;
}
export interface Form {
    name: string;
    surname: string;
    email: string;
    password: string;
    c_password: string;
}

export const registerColumns: RegisterColumn[] = [
    { name: "name", type: "text", placeholder: "Name" },
    { name: "surname", type: "text", placeholder: "Surname" },
    { name: "email", type: "email", placeholder: "Email" },
    { name: "password", type: "password", placeholder: "Password" },
    { name: "c_password", type: "password", placeholder: "Confirm Password" }
];