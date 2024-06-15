<template>

    <Modal 
        :open="true"
        :mask="false"
        :closable="false"
        :footer="null">

        <Form layout="vertical">

            <FormItem
                :required="true"
                label="Email">
                <Input
                    placeholder="Enter email"
                    v-model:value="credentials.email"/>
            </FormItem>

            <Button
                :loading="loading"
                @click="send">
                Send reset link
            </Button>

            <div style="text-align: center;">
                <router-link :to="{name: 'login'}">
                    Back
                </router-link>
            </div>
            
        </Form>

    </Modal>

</template>

<script>
import { Modal, Form, FormItem, Input, Button, message, } from 'ant-design-vue'
import authApi from '../../api/auth'

export default {
    components: {
        Modal, Form, FormItem, 
        Input, Button,
    },
    data() {
        return {
            credentials: {
                email: null,
            },
            loading: false,
        }
    },
    methods: {
        async send() {
            try {
                this.loading = true
                await authApi.sendResetLink(this.credentials.email)
                message.success(`Reset link was sent to ${this.credentials.email}.`)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        }
    }
}
</script>
