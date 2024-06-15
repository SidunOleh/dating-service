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

    <Table
        ref="table"
        @delete="record => confirmPopup(() => deleteRecord(record), `Are you sure you want to delete ${record.name}?`)"/>

</template>

<script>
import { Button, message, } from 'ant-design-vue'
import CreateModal from './CreateModal.vue'
import Table from './Table.vue'
import { confirmPopup, } from '../../helpers/popups'
import permissionsApi from '../../api/permissions'

export default {
    components: {
        Button, CreateModal, Table,
    },
    data() {
        return {
            create: {
                open: false,
            },
        }
    },
    methods: {
        confirmPopup,
        async deleteRecord(record) {
            try {
                await permissionsApi.delete(record.id)
                message.success('Successfully deleted')
                this.$refs.table.updateData()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
}
</script>

