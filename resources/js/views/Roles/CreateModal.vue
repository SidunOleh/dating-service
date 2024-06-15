<template>
    <Modal 
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <Form layout="vertical">

            <FormItem
                label="Role name"
                :required="true">
                <Input
                    placeholder="Enter role name"
                    v-model:value="data.name"/>
            </FormItem>

            <FormItem
                label="Select permissions"
                :required="true">
                <Select
                    mode="multiple"
                    :options="permissionOptions"
                    v-model:value="data.permissions"/>
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
import { Button, Modal, Form, FormItem, Input, Select, message, } from 'ant-design-vue'
import rolesApi from '../../api/roles'

export default {
    props: [
        'open',
        'permissions',
    ],
    components: {
        Button, Modal, Form, 
        FormItem, Input, Select,
    },
    data() {
        return {
            data: {
                name: '',
                permissions: [],
            },
            creating: false,
        }
    },
    computed: {
        permissionOptions() {
            return this.permissions?.data?.map(item => {
                return {
                    label: item.name,
                    value: item.name,
                }
            })
        }
    },
    methods: {
        async create() {
            try {
                this.creating = true
                await rolesApi.create(this.data)
                message.success('Successfully created.')
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
