<template>
    <Modal 
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <Form layout="vertical">

            <FormItem
                label="Text"
                :required="true">
                <QuillEditor 
                    style="min-height: 200px;"
                    contentType="html"
                    toolbar="full"
                    v-model:content="data.text"></QuillEditor>
            </FormItem>

            <FormItem
                label="Link"
                :required="true">
                <Input
                    placeholder="Enter link"
                    v-model:value="data.link"/>
            </FormItem>

            <FormItem
                label="Clicks count"
                :required="true">
                <Input
                    placeholder="Clicks count"
                    :disabled="true"
                    :value="data.clicks_count"/>
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
import { Button, Modal, Form, FormItem, Input, message, } from 'ant-design-vue'
import warningsApi from '../../api/warnings'

export default {
    props: [
        'open',
        'record',
    ],
    components: {
        Button, Modal, Form, 
        FormItem, Input,
    },
    data() {
        return {
            data: {...this.record},
            editing: false,
        }
    },
    methods: {
        async edit() {
            try {
                this.editing = true
                await warningsApi.edit(this.data.id, this.data)
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
