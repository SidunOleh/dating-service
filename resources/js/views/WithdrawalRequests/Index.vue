<template>

    <RequestModal 
        v-model:open="modal.open"
        v-model:record="modal.record"
        @withdrawn="$refs.table.updateData();"
        @rejected="$refs.table.updateData();"/>

    <Table 
        ref="table"
        @show="show"
        @delete="record => confirmPopup(() => deleteRecord(record), 'Are you sure you want to delete?')"/>

</template>

<script>
import { message, } from 'ant-design-vue'
import Table from './Table.vue'
import RequestModal from './RequestModal.vue'
import { confirmPopup, } from '../../helpers/popups'
import withdrawalRequestsApi from '../../api/withdrawal-requests'

export default {
    components: {
        Table, RequestModal,
    },
    data() {
        return {
            modal: {
                open: false,
                record: null,
            },
        }
    },
    methods: {
        confirmPopup,
        show(record) {
            this.modal.record = record
            this.modal.open = true
        },
        async deleteRecord(record) {
            try {
                await withdrawalRequestsApi.delete(record.id)
                message.success('Successfully deleted')
                this.$refs.table.updateData()  
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
}
</script>
