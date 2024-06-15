<template>

    <Table
        :columns="columns"
        :dataSource="data.data"
        :pagination="{pageSize: data.meta?.per_page, total: data.meta?.total}"
        :loading="loading"
        @change="changeQuery">

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'id'">
                {{ `Template ${record.id}` }}
            </template>

            <Tooltip>
                <template #title>
                    Edit
                </template>

                <template v-if="column.key === 'edit'">
                    <span
                        style="cursor: pointer;"
                        @click="$emit('edit', record)">
                        <EditIcon/>
                    </span>
                </template>
            </Tooltip>

            <Tooltip>
                <template #title>
                    Delete
                </template>
    
                <template v-if="column.key === 'delete'">
                    <span
                        style="cursor: pointer;"
                        @click="$emit('delete', record)">
                        <DeleteIcon/>
                    </span>
                </template>
            </Tooltip>

        </template>

    </Table>

</template>

<script>
import { Table, Tooltip, Tag, message, } from 'ant-design-vue'
import EditIcon from '../icons/Edit.vue'
import DeleteIcon from '../icons/Delete.vue'
import templatesApi from '../../api/templates'

export default {
    components: {
        Table, EditIcon, DeleteIcon, 
        Tooltip, Tag,
    },
    data() {
        return {
            columns: [
                {
                    title: 'ID',
                    key: 'id',
                },
                {
                    key: 'edit',
                },
                {
                    key: 'delete',
                },
            ],
            data: {},
            query: {
                page: 1,
                perpage: 15,
            },
            loading: false,
        }
    },
    methods: {
        async updateData() {
            try {
                this.loading = true
                this.data = await templatesApi.fetch(
                    this.query.page, 
                    this.query.perpage
                ) 
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        changeQuery(pagination, filters, sorter) {
            this.query.page = pagination.current
        },
    },
    watch: {
        query: {
            handler() {
               this.updateData()
            },
            deep: true,
        },
    },
    mounted() {
        this.updateData()
    },
}
</script>
