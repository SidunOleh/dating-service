<template>
    <Table
        ref="table"
        @approve="record => confirmPopup(() => approve(record), `Are you sure you want to approve ${record.creator.email} request?`)"
        @reject="record => confirmPopup(() => reject(record), `Are you sure you want to reject ${record.creator.email} request?`)"/>
</template>

<script>
import { message } from 'ant-design-vue'
import Table from './Table.vue'
import transferRequestsApi from '../../api/transferRequests'
import { confirmPopup, } from '../../helpers/popups'

export default {
    components: {
        Table,
    },
    methods: {
        confirmPopup,
        async approve(record) {
            try {
                await transferRequestsApi.approve(record.id)
                message.success('Successfully approved')
                this.$refs.table.updateData()   
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async reject(record) {
            try {
                await transferRequestsApi.reject(record.id)
                message.success('Successfully rejected')
                this.$refs.table.updateData()   
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
}
</script>
