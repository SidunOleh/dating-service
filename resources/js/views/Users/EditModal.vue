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

            <FormItem label="New password">
                <InputPassword
                    placeholder="Enter new password"
                    style="margin-bottom: 10px;" 
                    :visible="true"
                    v-model:value="data.password"/>
                    <Button @click="generatePassword">
                        Generate password
                    </Button>
            </FormItem>

            <Button
                :loading="editing"
                @click="edit">
                Save
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
        'record',
        'roles',
    ],
    components: {
        Button, Modal, Form, 
        FormItem, Input, Select, 
        InputPassword,
    },
    data() {
        return {
            data: {...this.record},
            editing: false,
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
        async edit() {         
            try {
                this.editing = true
                if (! this.data.password) {
                    delete this.data.password
                }
                await usersApi.edit(this.data.id, this.data)
                message.success('Successfully saved.')
                this.$emit('edited')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.editing = false
            }
        },
    },
}
</script>
