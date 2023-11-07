
import { createApp } from "vue";
import router from "./router";

import App from "@/Components/App.vue";

import PrimeVue from "primevue/config";

import "primevue/resources/primevue.min.css";
import "primeflex/primeflex.css";
import "primevue/resources/themes/saga-blue/theme.css"; //theme

import "primeicons/primeicons.css"; //icons
import Dialog from "primevue/dialog";
import PanelMenu from "primevue/panelmenu";
import CascadeSelect from "primevue/cascadeselect";
import InputText from "primevue/inputtext";
import Checkbox from "primevue/checkbox";
import Button from "primevue/button";
import TabMenu from "primevue/tabmenu";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup"; //optional for column grouping
import Row from "primevue/row"; //optional for row
import Card from "primevue/card";
import Textarea from "primevue/textarea";
import Toolbar from "primevue/toolbar";
import FileUpload from "primevue/fileupload";
import ToastService from "primevue/toastservice";
import Toast from "primevue/toast";
import ConfirmationService from "primevue/confirmationservice";
import Dropdown from "primevue/dropdown";
import SplitButton from 'primevue/splitbutton';
import Calendar from 'primevue/calendar';
import InputNumber from 'primevue/inputnumber';
import Knob from 'primevue/knob';
import Categories from "@/Modules/Categories/Categories.vue"
import Slider from 'primevue/slider';
import Category from "@/Modules/Categories/Category.vue";
import Chart from 'primevue/chart';
import ScrollPanel from 'primevue/scrollpanel';
import AddExpense from "@/Modules/Transactions/AddExpense.vue";
import AddNewBudget from "@/Modules/Budgets/AddNewBudget.vue";
import ShareBudget from "@/Modules/Budgets/ShareBudget.vue";

const app = createApp(App);
app.use(router);
app.use(PrimeVue);
app.use(ToastService);
app.use(ConfirmationService);
app.component("ShareBudget", ShareBudget);
app.component("AddNewBudget", AddNewBudget);
app.component("AddExpense", AddExpense);
app.component("ScrollPanel", ScrollPanel);
app.component("Chart", Chart);
app.component("Categories", Categories);
app.component("Category", Category);
app.component("Knob", Knob);
app.component("InputNumber", InputNumber);
app.component("Calendar", Calendar);
app.component("PanelMenu", PanelMenu);
app.component("Button", Button);
app.component("SplitButton", SplitButton);
app.component("CascadeSelect", CascadeSelect);
app.component("Dropdown", Dropdown);
app.component("Checkbox", Checkbox);
app.component("Toast", Toast);
app.component("FileUpload", FileUpload);
app.component("DataTable", DataTable);
app.component("Column", Column);
app.component("ColumnGroup", ColumnGroup);
app.component("Row", Row);
app.component("Toolbar", Toolbar);
app.component("TabMenu", TabMenu);
app.component("Dialog", Dialog);
app.component("InputText", InputText);
app.component("Textarea", Textarea);
app.mount("#app");
