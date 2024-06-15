<template>
    <Table
        :columns="columns"
        :dataSource="data.data"
        :pagination="{pageSize: data.meta?.per_page, total: data.meta?.total,}"
        :loading="loading"
        @change="changeQuery">

        <template #bodyCell="{column, record,}">

            <template v-if="column.key == 'name'">
                {{ record.name }}
            </template>

            <Tooltip>
                <template #title>
                    Delete
                </template>
    
                <template v-if="column.key == 'delete'">
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
import { Table, Tooltip, message, } from 'ant-design-vue'
import DeleteIcon from '../icons/Delete.vue'
import { mapState, } from 'vuex'
import permissionsApi from '../../api/permissions'

export default {
    components: {
        Table, Tooltip, DeleteIcon,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Name',
                    key: 'name',
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
                this.data = await permissionsApi.fetch(this.query.page, this.query.perpage) 
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        changeQuery(pagination) {
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
