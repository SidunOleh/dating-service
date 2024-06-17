<template>
    <Modal 
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <Form layout="vertical">

            <FormItem
                label="Image"
                :required="true">
                <UploadImg 
                    :disabled="true"
                    :uploaded="[{id: record.image_id, url: record.image_url,},]"/>
            </FormItem>

            <FormItem
                label="Name"
                :required="true">
                <Input
                    placeholder="Enter name"
                    :disabled="true"
                    :value="data.name"/>
            </FormItem>

            <FormItem
                label="Link"
                :required="true">
                <Input
                    placeholder="Enter link"
                    :disabled="true"
                    :value="data.link"/>
            </FormItem>

            <FormItem
                label="Clicks limit"
                :required="true">
                <InputNumber
                    placeholder="Clicks limit"
                    style="width: 100%;"
                    v-model:value="data.clicks_limit"
                    :min="1"/>
            </FormItem>

            <FormItem
                label="Clicks count"
                :required="true">
                <InputNumber
                    placeholder="Clicks count"
                    style="width: 100%;"
                    :value="data.clicks_count"
                    :min="0"
                    :disabled="true"/>
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
import { Button, Modal, Form, FormItem, Input, InputNumber, Switch, message, } from 'ant-design-vue'
import UploadImg from '../components/UploadImg.vue'
import adsApi from '../../api/ads'

export default {
    props: [
        'open',
        'record',
    ],
    components: {
        Button, Modal, Form, 
        FormItem, Input, InputNumber,
        Switch, UploadImg,
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
                await adsApi.edit(this.data.id, this.data)
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
