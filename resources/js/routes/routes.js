import { createRouter, createWebHistory, } from 'vue-router'
import store from '../store/store'
import can from '../helpers/can'
import { message, } from 'ant-design-vue'
import { defineAsyncComponent, } from 'vue'
import Loader from '../views/Loader.vue'

const routes = [{
    path: '/admin/login',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Login.vue'),
        loadingComponent: Loader,
    }),
    name: 'login',
}, {
    path: '/admin/forgot',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Forgot.vue'),
        loadingComponent: Loader,
    }),
    name: 'forgot',
}, {
    path: '/admin/reset',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Reset.vue'),
        loadingComponent: Loader,
    }),
    name: 'reset',
}, {
    path: '/admin',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Dashboard.vue'),
        loadingComponent: Loader,
    }),
    name: 'dashboard',
    meta: {
        access: 'private',
        menuKey: 'dashboard',
    },
}, {
    path: '/admin/users',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Users/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'users.index',
    meta: {
        access: 'private',
        permission: 'users.view',
        menuKey: 'users',
    },
}, {
    path: '/admin/roles',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Roles/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'roles.index',
    meta: {
        access: 'private',
        permission: 'users.view',
        menuKey: 'roles',
    },
}, {
    path: '/admin/permissions',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Permissions/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'permissions.index',
    meta: {
        access: 'private',
        permission: 'users.view',
        menuKey: 'permissions',
    },
}, {
    path: '/admin/templates',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Templates/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'templates.index',
    meta: {
        access: 'private',
        permission: 'templates.view',
        menuKey: 'templates',
    },
}, {
    path: '/admin/templates/create',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Templates/Create.vue'),
        loadingComponent: Loader,
    }),
    name: 'templates.create',
    meta: {
        access: 'private',
        permission: 'templates.create',
        menuKey: 'templates',
    },
}, {
    path: '/admin/templates/edit/:id',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Templates/Edit.vue'),
        loadingComponent: Loader,
    }),
    name: 'templates.edit',
    meta: {
        access: 'private',
        permission: 'templates.edit',
        menuKey: 'templates',
    },
}, {
    path: '/admin/ads',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Ads/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'ads.index',
    meta: {
        access: 'private',
        permission: 'ads.view',
        menuKey: 'ads.index',
    },
}, {
    path: '/admin/ads/settings',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Ads/Settings.vue'),
        loadingComponent: Loader,
    }),
    name: 'ads.settings',
    meta: {
        access: 'private',
        permission: 'ads.view',
        menuKey: 'ads.settings',
    },
}, {
    path: '/admin/creators',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Creators/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'creators.index',
    meta: {
        access: 'private',
        permission: 'creators.view',
        menuKey: 'creators',
    },
}, {
    path: '/admin/creators/create',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Creators/Create.vue'),
        loadingComponent: Loader,
    }),
    name: 'creators.create',
    meta: {
        access: 'private',
        permission: 'creators.create',
        menuKey: 'creators',
    },
}, {
    path: '/admin/creators/edit/:id',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Creators/Edit.vue'),
        loadingComponent: Loader,
    }),
    name: 'creators.edit',
    meta: {
        access: 'private',
        permission: 'creators.edit',
        menuKey: 'creators',
    },
}, {
    path: '/admin/approved-creators/profile-requests',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/ProfileRequests/ApprovedCreators.vue'),
        loadingComponent: Loader,
    }),
    name: 'approved-creators.profile-requests',
    meta: {
        access: 'private',
        permission: 'approved-creators.profile-requests.view',
        menuKey: 'approved-creators.profile-requests',
    },
}, {
    path: '/admin/not-approved-creators/profile-requests',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/ProfileRequests/NotApprovedCreators.vue'),
        loadingComponent: Loader,
    }),
    name: 'not-approved-creators.profile-requests',
    meta: {
        access: 'private',
        permission: 'not-approved-creators.profile-requests.view',
        menuKey: 'not-approved-creators.profile-requests',
    },
}, {
    path: '/admin/not-approved-creators/profile-requests/:id',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/ProfileRequests/Show.vue'),
        loadingComponent: Loader,
    }),
    name: 'not-approved-creators.profile-requests.show',
    meta: {
        access: 'private',
        permission: 'profile-requests.show',
        menuKey: 'not-approved-creators.profile-requests',
    },
}, {
    path: '/admin/approved-creators/profile-requests/:id',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/ProfileRequests/Show.vue'),
        loadingComponent: Loader,
    }),
    name: 'approved-creators.profile-requests.show',
    meta: {
        access: 'private',
        permission: 'approved-creators.profile-requests.show',
        menuKey: 'approved-creators.profile-requests.show',
    },
}, {
    path: '/admin/transactions',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Transactions/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'transactions.index',
    meta: {
        access: 'private',
        permission: 'transactions.view',
        menuKey: 'transactions',
    },
}, {
    path: '/admin/withdrawal-requests',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/WithdrawalRequests/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'withdrawal-requests.index',
    meta: {
        access: 'private',
        permission: 'withdrawal-requests.view',
        menuKey: 'withdrawal-requests',
    },
}, {
    path: '/admin/:pathMatch(.*)*',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/NotFound.vue'),
        loadingComponent: Loader,
    }),
    name: 'notfound',
    meta: {
        access: 'private',
    },
}, ]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from) => {
    if (
        to.meta.access == 'private' &&
        !store.getters.logged
    ) {
        router.push({ name: 'login' })
    }

    if (
        to.meta.permission &&
        !can(to.meta.permission)
    ) {
        message.error('Forbidden.')

        return false
    }
})

export default router