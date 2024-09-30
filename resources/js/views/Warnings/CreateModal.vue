<template>
    <Modal 
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <Form layout="vertical">

            <FormItem
                label="Text"
                :required="true">
                <Input
                    placeholder="Enter text"
                    v-model:value="data.text"/>
            </FormItem>

            <FormItem
                label="Link"
                :required="true">
                <Input
                    placeholder="Enter link"
                    v-model:value="data.link"/>
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
import warningsApi from '../../api/warnings'

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
                text: '',
                link: '',
            },
            creating: false,
        }
    },
    methods: {
        async create() {
            try {
                this.creating = true
                await warningsApi.create(this.data)
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
