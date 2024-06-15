<template>
    
    <Flex :gap="10">

        <Button type="primary">
            <a href="/">
                Go to site
            </a>
        </Button>

        <Button 
            style="display: flex; align-items: center; gap: 5px;"
            type="primary" 
            @click="logout">
            <template #icon>
                <OutIcon/>
            </template>
            Logout
        </Button>

    </Flex>

</template>

<script>
import { Button, message, Flex, } from 'ant-design-vue'
import OutIcon from './icons/Out.vue'
import { mapActions, } from 'vuex'

export default {
    components: {
       Button, Flex, OutIcon,
    }, 
    methods: {
        ...mapActions([
            'logoutUser',
        ]),
        async logout() {
            try {
                await this.logoutUser()
                this.$router.push({name: 'login',})
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    }
}
</script>