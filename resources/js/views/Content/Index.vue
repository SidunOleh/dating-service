<template>

    <Form layout="vertical">

        <Collapse 
            style="margin-bottom: 20px;"
            v-model:activeKey="activeKey">

            <CollapsePanel 
                header="FAQ"
                :showArrow="false"
                :key="1">

                <FAQList :list="data.faq" :level="1"/>

            </CollapsePanel>

        </Collapse>

        <Button
            :loading="editing"
            @click="edit">
            Save
        </Button>

    </Form>

</template>

<script>
import { Button, Input, Textarea, message, Collapse, CollapsePanel, Form, } from 'ant-design-vue'
import contentApi from '../../api/content'
import FAQList from './FAQList.vue'

export default {
    components: {
        Button, Input, Textarea,
        Collapse, CollapsePanel, Form,
        FAQList,
    },
    data() {
        return {
            data: {
                faq: [],
            },
            activeKey: [1,],
            editing: false,
        }
    },
    methods: {
        async edit() {
            try {
                this.editing = true
                await contentApi.edit(this.data)
                message.success('Successfully saved.')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.editing = false
            }
        },
    },
    async mounted() {
        try {
            this.editing = true
            const data = await contentApi.fetch()
            this.data = Object.assign(this.data, data)
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        } finally {
            this.editing = false
        }
    },
}
</script>