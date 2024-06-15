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
        :roles="roles"
        @created="$refs.table.updateData();"/>

    <EditModal
        v-if="edit.open"
        v-model:open="edit.open"
        v-model:record="edit.record"
        :roles="roles" 
        @edited="$refs.table.updateData()"/>

    <Table
        ref="table"
        @edit="showEdit"
        @delete="record => confirmPopup(() => deleteRecord(record), `Are you sure you want to delete ${record.email}?`)"/>

</template>

<script>
import { Button, message, } from 'ant-design-vue'
import CreateModal from './CreateModal.vue'
import EditModal from './EditModal.vue'
import Table from './Table.vue'
import { confirmPopup, } from '../../helpers/popups'
import usersApi from '../../api/users'
import rolesApi from '../../api/roles'

export default {
    components: {
        Button, CreateModal, EditModal, 
        Table,
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
            roles: [],
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
                await usersApi.delete(record.id)
                message.success('Successfully deleted')
                this.$refs.table.updateData()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
    },
    async mounted() {
        try {
            this.roles = await rolesApi.fetch(1, 1000)
        } catch (err) {
            message.error(err?.response?.data?.message ?? err.message)
        }
    },
}
</script>
