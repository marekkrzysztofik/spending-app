import { Column, FormComponent } from "@/types/column"

export const components: FormComponent[] = [{
    title: 'Login',
    columns: <Column[]>
        [
            { name: "email", type: "email", placeholder: "Email" },
            { name: "password", type: "password", placeholder: "Password" },
            { name: "c_password", type: "password", placeholder: "Confirm Password" }
        ],
        apiName:'login'
},
{
    title: 'Register',
    columns: <Column[]>
        [
            { name: "name", type: "text", placeholder: "Name" },
            { name: "surname", type: "text", placeholder: "Surname" },
            { name: "email", type: "email", placeholder: "Email" },
            { name: "password", type: "password", placeholder: "Password" },
            { name: "c_password", type: "password", placeholder: "Confirm Password" }
        ],
        apiName:'register'
}
]
