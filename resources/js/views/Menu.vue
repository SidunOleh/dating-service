<template>
    
    <Menu 
        theme="dark"
        mode="inline"
        v-model:selectedKeys="keys">

        <MenuItem key="dashboard">
            <template #icon>
                <DashboardIcon/>
            </template>
            <router-link :to="{name: 'dashboard'}">
                Dashboard
            </router-link>
        </MenuItem>

        <SubMenu v-if="can('users.view')">
            <template #icon>
                <UserIcon/>
            </template>
            <template #title>
                Users
            </template>

            <MenuItem key="users">
                <router-link :to="{name: 'users.index'}">
                    Users
                </router-link>
            </MenuItem>

            <MenuItem key="roles"> 
                <router-link :to="{name: 'roles.index'}">
                    Roles
                </router-link>
            </MenuItem>

            <MenuItem key="permissions">
                <router-link :to="{name: 'permissions.index'}">
                    Permissions
                </router-link>
            </MenuItem>
        </SubMenu>

        <MenuItem
            v-if="can('creators.view')" 
            key="creators">
            <template #icon>
                <ProfileIcon />
            </template>
            <router-link :to="{name: 'creators.index'}">
                Creators
            </router-link>
        </MenuItem>

        <MenuItem
            v-if="can('templates.view')" 
            key="templates">
            <template #icon>
                <TemplateIcon />
            </template>
            <router-link :to="{name: 'templates.index'}">
                Templates
            </router-link>
        </MenuItem>

        <SubMenu v-if="can('ads.view')">
            <template #icon>
                <AdIcons />
            </template>
            <template #title>
                Ads
            </template>

            <MenuItem key="ads.index">
                <router-link :to="{name: 'ads.index'}">
                    Ads
                </router-link>
            </MenuItem>

            <MenuItem key="ads.settings">
                <router-link :to="{name: 'ads.settings'}">
                    Settings
                </router-link>
            </MenuItem>
        </SubMenu>

        <SubMenu 
            v-if="can(['approved-creators.profile-requests.view', 'not-approved-creators.profile-requests.view',])"
            key="profile-requests">
            <template #icon>
                <ApproveIcon />
            </template>
            <template #title>
                Profile requests
            </template>

            <MenuItem
                v-if="can('approved-creators.profile-requests.view')" 
                key="approved-creators.profile-requests">
                <router-link :to="{name: 'approved-creators.profile-requests'}">
                    Approved creators
                </router-link>
            </MenuItem>

            <MenuItem
                v-if="can('not-approved-creators.profile-requests.view')"  
                key="not-approved-creators.profile-requests">
                <router-link :to="{name: 'not-approved-creators.profile-requests'}">
                    Not approved creators
                </router-link>
            </MenuItem>
        </SubMenu>

        <MenuItem
            v-if="can('transactions.view')" 
            key="transactions">
            <template #icon>
                <MoneyIcon />
            </template>
            <router-link :to="{name: 'transactions.index'}">
                Transactions
            </router-link>
        </MenuItem>

        <MenuItem
            v-if="can('withdrawal-requests.view')" 
            key="withdrawal-requests">
            <template #icon>
                <WithdrawalIcon />
            </template>
            <router-link :to="{name: 'withdrawal-requests.index'}">
                Withdrawal requests
            </router-link>
        </MenuItem>

    </Menu>

</template>

<script>
import { Menu, MenuItem, SubMenu, } from 'ant-design-vue'
import DashboardIcon from './icons/Dashboard.vue'
import UserIcon from './icons/User.vue'
import TemplateIcon from './icons/Template.vue'
import ProfileIcon from './icons/Profile.vue'
import ApproveIcon from './icons/Approve.vue'
import AdIcons from './icons/Ad.vue'
import MoneyIcon from './icons/Money.vue'
import WithdrawalIcon from './icons/Withdrawal.vue'
import can from '../helpers/can'

export default {
    components: {
        Menu, MenuItem, DashboardIcon, 
        SubMenu, UserIcon, TemplateIcon,
        AdIcons, ProfileIcon, ApproveIcon,
        MoneyIcon, WithdrawalIcon,
    },
    data() {
        return {
            keys: [],
        }
    },
    methods: {
        can,
    },
    async mounted() {
        await this.$router.isReady()
        const currentMenuItemKey = 
            this.$router.currentRoute.value.meta.menuKey
        this.keys.push(currentMenuItemKey)
    },
}
</script>
