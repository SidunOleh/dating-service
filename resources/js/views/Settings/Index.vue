<template>
    <Form layout="vertical">

        <Collapse 
            style="margin-bottom: 20px;"
            v-model:activeKey="activeKey">

            <CollapsePanel 
                header="Ad settings"
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

            <CollapsePanel 
                header="Referral settings"
                :showArrow="false"
                :key="2">

                <FormItem
                    label="Referral percent"
                    :required="true">
                    <InputNumber
                        placeholder="Referral percent"
                        style="width: 100%;"
                        v-model:value="settings.referral_percent"
                        :min="0"
                        :max="100"/>
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
import settingsApi from '../../api/settings'

export default {
    components: {
        Button, Form, FormItem, 
        InputNumber,  Collapse, CollapsePanel,
    },
    data() {
        return {
            activeKey: [1, 2,],
            settings: {},
            editing: false,
        }
    },
    methods: {
        async edit() {
            try {
                this.editing = true
                await settingsApi.edit(this.settings)
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
            const settings = await settingsApi.fetch()
            if (settings) {
                this.settings = settings
            }
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        } finally {
            this.editing = false
        }
    },
}
</script>