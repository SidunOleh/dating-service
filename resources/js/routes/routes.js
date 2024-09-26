import { createRouter, createWebHistory, } from 'vue-router'
import store from '../store/store'
import can from '../helpers/can'
import { message, } from 'ant-design-vue'
import { defineAsyncComponent, } from 'vue'
import Loader from '../views/Loader.vue'

const routes = [{
    path: '/v54vc45xc54v5vc56cxv7657/login',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Login.vue'),
        loadingComponent: Loader,
    }),
    name: 'login',
}, {
    path: '/v54vc45xc54v5vc56cxv7657/forgot',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Forgot.vue'),
        loadingComponent: Loader,
    }),
    name: 'forgot',
}, {
    path: '/v54vc45xc54v5vc56cxv7657/reset',
    component: defineAsyncComponent({
        loader: () =>
            import ('../views/Auth/Reset.vue'),
        loadingComponent: Loader,
    }),
    name: 'reset',
}, {
    path: '/v54vc45xc54v5vc56cxv7657',
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
    path: '/v54vc45xc54v5vc56cxv7657/users',
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
    path: '/v54vc45xc54v5vc56cxv7657/roles',
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
    path: '/v54vc45xc54v5vc56cxv7657/permissions',
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
    path: '/v54vc45xc54v5vc56cxv7657/templates',
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
    path: '/v54vc45xc54v5vc56cxv7657/templates/create',
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
    path: '/v54vc45xc54v5vc56cxv7657/templates/edit/:id',
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
    path: '/v54vc45xc54v5vc56cxv7657/top-ads',
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
    path: '/v54vc45xc54v5vc56cxv7657/block-ads',
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
    path: '/v54vc45xc54v5vc56cxv7657/popup-ads',
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
    path: '/v54vc45xc54v5vc56cxv7657/creators',
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
    path: '/v54vc45xc54v5vc56cxv7657/creators/create',
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
    path: '/v54vc45xc54v5vc56cxv7657/creators/edit/:id',
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
    path: '/v54vc45xc54v5vc56cxv7657/approved-creators/profile-requests',
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
    path: '/v54vc45xc54v5vc56cxv7657/not-approved-creators/profile-requests',
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
    path: '/v54vc45xc54v5vc56cxv7657/not-approved-creators/profile-requests/:id',
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
    path: '/v54vc45xc54v5vc56cxv7657/approved-creators/profile-requests/:id',
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
    path: '/v54vc45xc54v5vc56cxv7657/transactions',
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
    path: '/v54vc45xc54v5vc56cxv7657/withdrawal-requests',
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
    path: '/v54vc45xc54v5vc56cxv7657/settings',
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
    path: '/v54vc45xc54v5vc56cxv7657/content',
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
    path: '/v54vc45xc54v5vc56cxv7657/:pathMatch(.*)*',
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