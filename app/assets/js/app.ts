//import Vue ecosystem
import {createApp} from "vue";
import {createRouter, createWebHashHistory} from 'vue-router';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import App from "@/App.vue";

import 'styles/app.scss';
import CreateTransaction from "./pages/transaction/CreateTransaction.vue";
import EditTransaction from "./pages/transaction/EditTransaction.vue";
import ShowTransaction from "./pages/transaction/ShowTransaction.vue";
import Home from "./pages/Home.vue";

import {library} from '@fortawesome/fontawesome-svg-core'
import {faChartArea, faDonate, faPlusCircle, faSortAmountUp, faUserCircle} from '@fortawesome/free-solid-svg-icons'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import Login from "./pages/auth/Login.vue";
import {key, store} from "./store";
import StatisticsPage from "./pages/StatisticsPage.vue";

const routes = [
    {
        path: '/',
        name: "Home",
        component: Home,
    },
    {
        path: '/statistics',
        name: "Statistics",
        component: StatisticsPage,
    },
    {
        path: '/transaction',
        name: "ListTransaction",
        component: ShowTransaction,
    },
    {
        path: '/transaction/create',
        name: "CreateTransaction",
        component: CreateTransaction,
    },
    {
        path: '/transaction/edit/:id',
        name: "EditTransaction",
        component: EditTransaction,
    },
    {
        path: '/login',
        name: "Login",
        component: Login,
    },

]

// Add routes to VueRouter
const router = createRouter({
    history: createWebHashHistory(),
    routes
});

router.beforeEach((to) => {
    if (store.state.user === null && (to.name !== 'Login' && to.name !== 'Home')) {
        return {name: 'Home'}
    }
})

//fontawesome config
library.add(faDonate)
library.add(faUserCircle)
library.add(faPlusCircle)
library.add(faChartArea)
library.add(faSortAmountUp)

createApp(App)
    .component('font-awesome-icon', FontAwesomeIcon)
    .use(router)
    .use(store, key)
    .use(Toast)
    .mount('#app')
