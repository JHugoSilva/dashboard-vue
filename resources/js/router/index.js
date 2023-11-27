import { createRouter, createWebHistory } from 'vue-router'
import { isUserLoggedIn } from './utils'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/register',
            name: 'Register',
            component: () => import('../pages/Register.vue')
        },
        {
            path: '/login',
            name: 'Login',
            component: () => import('../pages/Login.vue')
        },
        {
            path: '/admin',
            name: 'Admin',
            component: () => import('../pages/Admin.vue')
        },
        {
            path: '/forgot-password',
            name: 'ForgotPassword',
            component: () => import('../pages/ForgotPassword.vue')
        },
        {
            path: '/reset-passwordForm',
            name: 'ResetPasswordForm',
            component: () => import('../pages/ResetPasswordForm.vue')
        },
        {
            path: '/:patchMatch(.*)*',
            component: () => import('../pages/notFound.vue')
        }
    ]
})//24:00 AULA 07

router.beforeEach((to, from, next) => {
    if ((to.name === 'Register' || to.name === 'ForgotPassword' || to.name === 'ResetPasswordForm') && !isUserLoggedIn()) {
        next()
    } else if (to.name !== 'Login' && !isUserLoggedIn()) {
        next({ name: 'Login'})
    } else if ((to.name === 'Login' || to.name === 'Register') && isUserLoggedIn()) {
        next({ name: 'Admin'})
    } else {
        next()
    }
})

export default router