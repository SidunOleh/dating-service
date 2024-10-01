<template>

    <Flex
        :align="'center'"
        :justify="'space-between'"
        :gap="10">
        <Button 
            type="primary"
            style="margin-bottom: 20px;" 
            @click="create.open = true">
            Create
        </Button>

        <FormItem label="Show top warning">
            <Switch 
                v-model:checked="settings.show_top_warning"
                @change="editSettings"/>
        </FormItem>
    </Flex>

    <CreateModal 
        v-if="create.open"
        v-model:open="create.open"
        @created="$refs.table.updateData()"/>

    <EditModal 
        v-if="edit.open"
        v-model:open="edit.open"
        v-model:record="edit.record"
        @edited="$refs.table.updateData()"/>

    <Table
        ref="table"
        @edit="showEdit"
        @delete="record => confirmPopup(() => deleteRecord(record), `Are you sure you want to delete ${record.text}?`)"/>

</template>

<script>
import { Button, message, FormItem, Flex, Switch, } from 'ant-design-vue'
import CreateModal from './CreateModal.vue'
import EditModal from './EditModal.vue'
import Table from './Table.vue'
import { confirmPopup, } from '../../helpers/popups'
import warningsApi from '../../api/warnings'

export default {
    components: {
        Button, CreateModal, Table,
        EditModal, FormItem, Flex, 
        Switch,
    },
    data() {
        return {
            create: {
                open: false,
            },
            edit: {
                open: false,
                record: null,
            },
            settings: {
                show_top_warning: false,
            },
        }
    },
    methods: {
        confirmPopup,
        showEdit(record) {
            this.edit.record = record
            this.edit.open = true
        },
        async deleteRecord(record) {
            try {
                await warningsApi.delete(record.id)
                message.success('Successfully deleted')
                this.$refs.table.updateData()  
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async editSettings() {
            try {
                await warningsApi.editSettings(this.settings)
                message.success('Successfully saved')
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    async mounted() {
        try {
            const settings = await warningsApi.showSettings()
            this.settings.show_top_warning = settings.show_top_warning
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        }
    },
}
</script>
