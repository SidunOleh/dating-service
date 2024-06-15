<template>

    <Button 
        type="primary"
        style="margin-bottom: 20px;" 
        @click="create.open = true">
        Create
    </Button>

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
        :editingStatus="editingStatus"
        @edit="showEdit"
        @editStatus="record => editStatus(record)"
        @delete="record => confirmPopup(() => deleteRecord(record), `Are you sure you want to delete ${record.name}?`)"/>

</template>

<script>
import { Button, message, } from 'ant-design-vue'
import CreateModal from './CreateModal.vue'
import EditModal from './EditModal.vue'
import Table from './Table.vue'
import { confirmPopup, } from '../../helpers/popups'
import adsApi from '../../api/ads'

export default {
    components: {
        Button, CreateModal, Table,
        EditModal,
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
            editingStatus: false,
        }
    },
    methods: {
        confirmPopup,
        showEdit(record) {
            this.edit.record = record
            this.edit.open = true
        },
        async editStatus(record) {
            try {
                this.editingStatus = true
                await adsApi.editStatus(record.id, record.status)
                message.success('Successfully saved status.')
            } catch (err) {
                record.status = !record.status
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.editingStatus = false
            }
        },
        async deleteRecord(record) {
            try {
                await adsApi.delete(record.id)
                message.success('Successfully deleted')
                this.$refs.table.updateData()  
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
}
</script>
