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
                    :process="false" 
                    @change="imgs => data.image_id = imgs[0]?.id"/>
            </FormItem>

            <FormItem
                label="Name"
                :required="true">
                <Input
                    placeholder="Enter name"
                    v-model:value="data.name"/>
            </FormItem>

            <FormItem
                label="Link"
                :required="true">
                <Input
                    placeholder="Enter link"
                    v-model:value="data.link"/>
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

            <Button
                :loading="creating"
                @click="create">
                Create
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
    ],
    components: {
        Button, Modal, Form, 
        FormItem, Input, InputNumber,
        Switch, UploadImg,
    },
    data() {
        return {
            data: {
                name: '',
                image_id: null,
                link: '',
                clicks_limit: 1,
                type: 'top',
            },
            creating: false,
        }
    },
    methods: {
        async create() {
            try {
                this.creating = true
                await adsApi.create(this.data)
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
