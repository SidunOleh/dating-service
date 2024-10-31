<template>
    <Form layout="vertical">

        <Collapse 
            style="margin-bottom: 20px;"
            v-model:activeKey="activeKey">

            <CollapsePanel 
                header="Warning settings"
                :showArrow="false"
                :key="1">

                <FormItem
                    label="Show top warning"
                    :required="true">
                    <Switch v-model:checked="settings.show_top_warning"/>
                </FormItem>

            </CollapsePanel>

            <CollapsePanel 
                header="Ad settings"
                :showArrow="false"
                :key="2">

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
                :key="3">

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

            <CollapsePanel 
                header="Roulette settings"
                :showArrow="false"
                :key="4">

                <FormItem
                    label="Repeat time"
                    :required="true">
                    <InputNumber
                        placeholder="Repeat time"
                        style="width: 100%;"
                        v-model:value="settings.repeat_time"
                        :min="1"/>
                </FormItem>

            </CollapsePanel>

            <CollapsePanel 
                header="Subscription settings"
                :showArrow="false"
                :key="4">

                <FormItem
                    label="Subscription price"
                    :required="true">
                    <InputNumber
                        placeholder="Subscription price"
                        style="width: 100%;"
                        v-model:value="settings.subscription_price"
                        :min="0"/>
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
import { Button, Form, FormItem, InputNumber, Collapse, CollapsePanel, Switch, message, } from 'ant-design-vue'
import settingsApi from '../../api/settings'

export default {
    components: {
        Button, Form, FormItem, 
        InputNumber,  Collapse, CollapsePanel,
        Switch,
    },
    data() {
        return {
            activeKey: [1, 2, 3, 4,],
            settings: {
                show_top_warning: false,
                clicks_between_popups: null,
                seconds_between_popups: null,
                close_popup_seconds: null,
                referral_percent: null,
                repeat_time: null,
                subscription_price: null,
            },
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
            this.settings = Object.assign(this.settings, settings)
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        } finally {
            this.editing = false
        }
    },
}
</script>