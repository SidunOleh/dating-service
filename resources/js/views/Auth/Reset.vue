<template>

    <Modal 
        :open="true"
        :mask="false"
        :closable="false"
        :footer="null">

        <Form layout="vertical">

            <FormItem
                label="Password"
                :required="true">
                <InputPassword
                    type="password"
                    placeholder="Enter password"
                    v-model:value="credentials.password"/>
            </FormItem>

            <FormItem
                label="Password confirmation"
                :required="true">
                <InputPassword
                    type="password"
                    placeholder="Enter password confirmation"
                    v-model:value="credentials.password_confirmation"/>
            </FormItem>

            <Button
                :loading="loading"
                @click="reset">
                Reset password
            </Button>
            
        </Form>

    </Modal>

</template>

<script>
import { Modal, Form, FormItem, InputPassword, Button, message, } from 'ant-design-vue'
import authApi from '../../api/auth'

export default {
    components: {
        Modal, Form, FormItem, 
        InputPassword, Button,
    },
    data() {
        return {
            credentials: {
                password: null,
                password_confirmation: null,
            },
            loading: false,
        }
    },
    methods: {
        async reset() {
            try {
                this.loading = true
                this.credentials.email = this.$route.query.email
                this.credentials.token = this.$route.query.token
                await authApi.resetPassword(this.credentials)
                message.success('Password was successfully reseted.')
                this.$router.push({name: 'login',})
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
    },
}
</script>
