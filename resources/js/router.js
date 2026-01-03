import { createRouter, createWebHistory } from 'vue-router'
import Movimientos from '../views/movimientos/Movimientos.vue'
import Admin from '../views/movimientos/configuracion/categorias/admin.vue'
import AdminCompanias from '../views/movimientos/configuracion/companias/admin.vue'

const routes = [
    {
        path: '/movimientos/gastos',
        component: Movimientos,
        name: "movimientos-gastos"
    },
    {
        path: '/movimientos/config/categorias',
        component: Admin,
        name: "movimientos-categorias"
    },
    {
        path: '/movimientos/config/companias',
        component: AdminCompanias,
        name: "movimientos-companias"
    }
]

export default createRouter({
    history: createWebHistory(),
    routes
})