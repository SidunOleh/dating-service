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
                :loading="editing"
                @click="edit">
                Save
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
        'record',
        'permissions',
    ],
    components: {
        Button, Modal, Form, 
        FormItem, Input, Select,
    },
    data() {
        return {
            data: {...this.record},
            editing: false,
        }
    },
    computed: {
        permissionOptions() {
            return this.permissions?.data?.map(permission => {
                return {
                    label: permission.name,
                    value: permission.name,
                }
            })
        }
    },
    methods: {
        async edit() {
            try {
                this.editing = true
                await rolesApi.edit(this.data.id, this.data)
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
