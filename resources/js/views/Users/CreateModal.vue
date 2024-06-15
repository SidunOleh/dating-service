<template>
    <Modal 
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <Form layout="vertical">

            <FormItem
                label="Email"
                :required="true">
                <Input
                    placeholder="Enter email"
                    v-model:value="data.email"/>
            </FormItem>

            <FormItem 
                label="Select role"
                :required="true">
                <Select
                    v-model:value="data.role"
                    :options="roleOptions"/>
            </FormItem>

            <FormItem
                label="Password"
                :required="true">
                <InputPassword
                    placeholder="Enter password"
                    style="margin-bottom: 10px;" 
                    :visible="true"
                    v-model:value="data.password"/>
                    <Button @click="generatePassword">
                        Generate password
                    </Button>
            </FormItem>

            <Button
                :loading="creating"
                @click="create">
                Create
            </Button>

        </Form>

    </Modal>
</template>

<script>
import { Button, Modal, Form, FormItem, Input, Select, message, InputPassword, } from 'ant-design-vue'
import usersApi from '../../api/users'

export default {
    props: [
        'open',
        'roles',
    ],
    components: {
        Button, Modal, Form, 
        FormItem, Input, Select, 
        InputPassword,
    },
    data() {
        return {
            data: {
                email: '',
                password: '',
                role: '',
            },
            creating: false,
        }
    },
    computed: {
        roleOptions() {
            return this.roles?.data?.map(role => {
                return {
                    label: role.name,
                    value: role.name,
                }
            })
        },
    },
    methods: {
        generatePassword() {
            this.data.password = Math.random().toString(36).substring(2)
        },
        async create() {
            try {
                this.creating = true
                await usersApi.create(this.data)
                message.success(`Successfully created. Email with credentials was sent to ${this.data.email}.`)
                this.$emit('created')
                this.$emit('update:open', false)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.creating = false
            }
        }, 
    }
}
</script>
