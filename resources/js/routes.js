import Login from "@/Pages/Auth/Login.vue";
import Register from "@/Pages/Auth/Register.vue";
import {default as Orders} from "@/Pages/Orders/Index.vue";
import {default as Quests} from "@/Pages/Quests/Index.vue";
import {default as QuestsCreate} from "@/Pages/Quests/Create.vue";
import {default as QuestsShow} from "@/Pages/Quests/Show.vue";
import {default as Schedules} from "@/Pages/Schedules/Index.vue";

export const routes = [
    {path: '/', name: 'index', component: Login},
    {path: '/login', name: 'login', component: Login},
    {path: '/register', name: 'register', component: Register},
    {path: '/orders', name: 'orders.index', component: Orders},
    {path: '/quests', name: 'quests.index', component: Quests},
    {path: '/quests/create', name: 'quests.create', component: QuestsCreate},
    {path: '/quests/:quest', name: 'quests.show', component: QuestsShow},
    {path: '/schedules', name: 'schedules.show', component: Schedules},
]
