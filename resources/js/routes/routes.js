import { createRouter, createWebHistory, } from 'vue-router'
import store from '../store/store'
import can from '../helpers/can'
import { message, } from 'ant-design-vue'
import { defineAsyncComponent, } from 'vue'
import Loader from '../views/Loader.vue'

const routes = [{
    path: '/cLAhDKeUKrDErLAyUS21/login',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Login.vue'),
        loadingComponent: Loader,
    }),
    name: 'login',
}, {
    path: '/cLAhDKeUKrDErLAyUS21/forgot',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Forgot.vue'),
        loadingComponent: Loader,
    }),
    name: 'forgot',
}, {
    path: '/cLAhDKeUKrDErLAyUS21/reset',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Reset.vue'),
        loadingComponent: Loader,
    }),
    name: 'reset',
}, {
    path: '/cLAhDKeUKrDErLAyUS21',
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
    path: '/cLAhDKeUKrDErLAyUS21/users',
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
    path: '/cLAhDKeUKrDErLAyUS21/roles',
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
    path: '/cLAhDKeUKrDErLAyUS21/permissions',
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
    path: '/cLAhDKeUKrDErLAyUS21/templates',
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
    path: '/cLAhDKeUKrDErLAyUS21/templates/create',
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
    path: '/cLAhDKeUKrDErLAyUS21/templates/edit/:id',
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
    path: '/cLAhDKeUKrDErLAyUS21/top-ads',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/TopAds/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'top-ads.index',
    meta: {
        access: 'private',
        permission: 'ads.view',
        menuKey: 'top-ads',
    },
}, {
    path: '/cLAhDKeUKrDErLAyUS21/block-ads',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/BlockAds/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'block-ads.index',
    meta: {
        access: 'private',
        permission: 'ads.view',
        menuKey: 'block-ads',
    },
}, {
    path: '/cLAhDKeUKrDErLAyUS21/popup-ads',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/PopupAds/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'popup-ads.index',
    meta: {
        access: 'private',
        permission: 'ads.view',
        menuKey: 'popup-ads',
    },
}, {
    path: '/cLAhDKeUKrDErLAyUS21/warnings',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Warnings/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'warnings.index',
    meta: {
        access: 'private',
        permission: 'warnings.view',
        menuKey: 'warnings',
    },
}, {
    path: '/cLAhDKeUKrDErLAyUS21/creators',
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
    path: '/cLAhDKeUKrDErLAyUS21/creators/create',
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
    path: '/cLAhDKeUKrDErLAyUS21/creators/edit/:id',
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
    path: '/cLAhDKeUKrDErLAyUS21/approved-creators/profile-requests',
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
    path: '/cLAhDKeUKrDErLAyUS21/not-approved-creators/profile-requests',
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
    path: '/cLAhDKeUKrDErLAyUS21/not-approved-creators/profile-requests/:id',
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
    path: '/cLAhDKeUKrDErLAyUS21/approved-creators/profile-requests/:id',
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
    path: '/cLAhDKeUKrDErLAyUS21/transactions',
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
    path: '/cLAhDKeUKrDErLAyUS21/withdrawal-requests',
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
    path: '/cLAhDKeUKrDErLAyUS21/settings',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Settings/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'settings.index',
    meta: {
        access: 'private',
        permission: 'settings.view',
        menuKey: 'settings',
    },
}, {
    path: '/cLAhDKeUKrDErLAyUS21/content',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Content/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'content.index',
    meta: {
        access: 'private',
        permission: 'content.view',
        menuKey: 'content',
    },
}, {
    path: '/cLAhDKeUKrDErLAyUS21/:pathMatch(.*)*',
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