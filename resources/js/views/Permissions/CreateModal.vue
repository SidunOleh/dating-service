<template>
    <Modal 
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <Form layout="vertical">

            <FormItem
                label="Permission"
                :required="true"  >
                <Input
                    placeholder="Enter permission"
                    v-model:value="data.name"/>
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
import { Button, Modal, Form, FormItem, Input, message, } from 'ant-design-vue'
import permissionsApi from '../../api/permissions'

export default {
    props: [
        'open',
    ],
    components: {
        Button, Modal, Form,
        FormItem, Input,
    },
    data() {
        return {
            data: {
                name: '',
            },
            creating: false,
        }
    },
    methods: {
        async create() {
            try {
                this.creating = true
                await permissionsApi.create(this.data)
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
