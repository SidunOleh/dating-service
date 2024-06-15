<template>

    <Button 
        type="primary"
        style="margin-bottom: 20px;" 
        @click="$router.push({name: 'creators.create',})">
        Create
    </Button>

    <Table
        ref="table"
        @edit="record => $router.push({name: 'creators.edit', params: {id: record.id,},})"
        @delete="record => confirmPopup(() => deleteRecord(record), `Are you sure you want to delete ${record.email}?`)"/>

</template>

<script>
import { Button, message, } from 'ant-design-vue'
import Table from './Table.vue'
import { confirmPopup, } from '../../helpers/popups'
import creatorsApi from '../../api/creators'

export default {
    components: {
        Button, Table,
    },
    methods: {
        confirmPopup,
        async deleteRecord(record) {
            try {
                await creatorsApi.delete(record.id)
                message.success('Successfully deleted')
                this.$refs.table.updateData()   
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
}
</script>
