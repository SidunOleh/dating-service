<template>
    <Table
        ref="table"
        @transfer="record => confirmPopup(() => transfer(record), `Are you sure you want to transfer ${record.email}?`)"
        @reset="record => confirmPopup(() => reset(record), `Are you sure you want to reset ${record.email}?`)"/>
</template>

<script>
import { message } from 'ant-design-vue'
import Table from './Table.vue'
import transfersApi from '../../api/transfers'
import { confirmPopup, } from '../../helpers/popups'

export default {
    components: {
        Table,
    },
    methods: {
        confirmPopup,
        async transfer(record) {
            try {
                await transfersApi.transfer(record.id)
                message.success('Successfully transfered')
                this.$refs.table.updateData()   
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async reset(record) {
            try {
                await transfersApi.reset(record.id)
                message.success('Successfully reset')
                this.$refs.table.updateData()   
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
}
</script>
