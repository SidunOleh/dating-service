<template>

    <Modal 
        :open="true"
        :mask="false"
        :closable="false"
        :footer="null">

        <Form layout="vertical">

            <FormItem
                label="Email"
                :required="true">
                <Input
                    placeholder="Enter email"
                    v-model:value="credentials.email"/>
            </FormItem>

            <FormItem
                label="Password"
                :required="true">
                <InputPassword
                    placeholder="Enter password"
                    v-model:value="credentials.password"/>
            </FormItem>

            <Button
                :loading="loading"
                @click="login">
                Login
            </Button>

            <br>
            <br>

            <div style="text-align: center;">
                <router-link :to="{name: 'forgot'}">
                    Forgot password?
                </router-link>
            </div>
            
        </Form>

    </Modal>

</template>

<script>
import { Modal, Form, FormItem, Input, Button, message, InputPassword, } from 'ant-design-vue'
import { mapActions, } from 'vuex'

export default {
    components: {
        Modal, Form, FormItem, 
        Input, Button, InputPassword,
    },
    data() {
        return {
            credentials: {
                email: null,
                password: null,
            },
            loading: false,
        }
    },
    methods: {
        ...mapActions([
            'loginUser',
        ]),
        async login() {
            try {
                this.loading = true
                await this.loginUser(this.credentials)
                location.href = '/cLAhDKeUKrDErLAyUS21'
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
    },
}
</script>