import { createRouter, createWebHistory, } from 'vue-router'
import store from '../store/store'
import can from '../helpers/can'
import { message, } from 'ant-design-vue'
import { defineAsyncComponent, } from 'vue'
import Loader from '../views/Loader.vue'

const routes = [{
    path: '/u0puffeto4nh7SlHzFn8/login',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Login.vue'),
        loadingComponent: Loader,
    }),
    name: 'login',
}, {
    path: '/u0puffeto4nh7SlHzFn8/forgot',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Forgot.vue'),
        loadingComponent: Loader,
    }),
    name: 'forgot',
}, {
    path: '/u0puffeto4nh7SlHzFn8/reset',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Reset.vue'),
        loadingComponent: Loader,
    }),
    name: 'reset',
}, {
    path: '/u0puffeto4nh7SlHzFn8',
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
    path: '/u0puffeto4nh7SlHzFn8/users',
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
    path: '/u0puffeto4nh7SlHzFn8/roles',
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
    path: '/u0puffeto4nh7SlHzFn8/permissions',
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
    path: '/u0puffeto4nh7SlHzFn8/templates',
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
    path: '/u0puffeto4nh7SlHzFn8/templates/create',
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
    path: '/u0puffeto4nh7SlHzFn8/templates/edit/:id',
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
    path: '/u0puffeto4nh7SlHzFn8/top-ads',
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
    path: '/u0puffeto4nh7SlHzFn8/block-ads',
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
    path: '/u0puffeto4nh7SlHzFn8/popup-ads',
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
    path: '/u0puffeto4nh7SlHzFn8/warnings',
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
    path: '/u0puffeto4nh7SlHzFn8/creators',
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
    path: '/u0puffeto4nh7SlHzFn8/creators/create',
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
    path: '/u0puffeto4nh7SlHzFn8/creators/edit/:id',
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
    path: '/u0puffeto4nh7SlHzFn8/approved-creators/profile-requests',
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
    path: '/u0puffeto4nh7SlHzFn8/not-approved-creators/profile-requests',
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
    path: '/u0puffeto4nh7SlHzFn8/not-approved-creators/profile-requests/:id',
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
    path: '/u0puffeto4nh7SlHzFn8/approved-creators/profile-requests/:id',
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
    path: '/u0puffeto4nh7SlHzFn8/transactions',
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
    path: '/u0puffeto4nh7SlHzFn8/withdrawal-requests',
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
    path: '/u0puffeto4nh7SlHzFn8/settings',
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
    path: '/u0puffeto4nh7SlHzFn8/content',
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
    path: '/u0puffeto4nh7SlHzFn8/transfere',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Transfers/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'transfers.index',
    meta: {
        access: 'private',
        permission: 'transfers.view',
        menuKey: 'transfers',
    },
}, {
    path: '/u0puffeto4nh7SlHzFn8/posts',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Posts/Index.vue'),
        loadingComponent: Loader,
    }),
    name: 'posts.index',
    meta: {
        access: 'private',
        permission: 'posts.view',
        menuKey: 'posts',
    },
}, {
    path: '/u0puffeto4nh7SlHzFn8/posts/:id',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Posts/Show.vue'),
        loadingComponent: Loader,
    }),
    name: 'posts.show',
    meta: {
        access: 'private',
        permission: 'posts.show',
        menuKey: 'posts',
    },
}, {
    path: '/u0puffeto4nh7SlHzFn8/:pathMatch(.*)*',
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
        router.push({ name: 'login' })
        message.error('Forbidden.')

        return false
    }
})

export default router