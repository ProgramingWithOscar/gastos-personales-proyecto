import { createRouter, createWebHistory } from 'vue-router'
import Movimientos from '../views/movimientos/Movimientos.vue'

const routes = [
    {
        path: '/movimientos',
        component: Movimientos
    }
]

export default createRouter({
    history: createWebHistory(),
    routes
})