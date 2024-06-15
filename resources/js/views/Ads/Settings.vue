<template>
    <Form layout="vertical">

        <Collapse 
            style="margin-bottom: 20px;"
            v-model:activeKey="activeKey">

            <CollapsePanel 
                header="Settings"
                :showArrow="false"
                :key="1">

                <FormItem
                    label="Clicks between popus"
                    :required="true">
                    <InputNumber
                        placeholder="Clicks between popus"
                        style="width: 100%;"
                        v-model:value="settings.clicks_between_popups"
                        :min="1"/>
                </FormItem>

                <FormItem
                    label="Seconds between popus"
                    :required="true">
                    <InputNumber
                        placeholder="Seconds between popus"
                        style="width: 100%;"
                        v-model:value="settings.seconds_between_popups"
                        :min="1"/>
                </FormItem>

                <FormItem
                    label="Close popup seconds"
                    :required="true">
                    <InputNumber
                        placeholder="Close popup seconds"
                        style="width: 100%;"
                        v-model:value="settings.close_popup_seconds"
                        :min="1"/>
                </FormItem>

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
import { message, } from 'ant-design-vue'
import { Button, Form, FormItem, InputNumber, Collapse, CollapsePanel, } from 'ant-design-vue'
import adsApi from '../../api/ads'

export default {
    components: {
        Button, Form, FormItem, 
        InputNumber,  Collapse, CollapsePanel,
    },
    data() {
        return {
            activeKey: [1,],
            settings: {},
            editing: false,
        }
    },
    methods: {
        async edit() {
            try {
                this.editing = true
                await adsApi.editOptions(this.settings)
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
            this.settings = await adsApi.fetchOptions()
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        } finally {
            this.editing = false
        }
    },
}
</script>