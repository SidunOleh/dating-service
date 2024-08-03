<template>

    <Table
        :columns="columns"
        :dataSource="data.data"
        :pagination="{
            pageSize: query.perpage, 
            total: data.meta?.total, 
            onChange: (page, size) => query.perpage = size
        }"
        :loading="loading"
        @change="changeQuery">

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'creator'">
                <router-link :to="{name: 'creators.edit', params: {id: record.creator?.id,},}">
                    {{ record.creator?.email }}
                </router-link>
            </template>

            <template v-if="column.key === 'gateway'">
                {{ record.gateway }}
            </template>

            <template v-if="column.key === 'type'">
                {{ record.type }}
            </template>

            <template v-if="column.key === 'amount'">
                {{ record.amount }}
            </template>

            <template v-if="column.key === 'status'">
                {{ record.status }}
            </template>

            <template v-if="column.key === 'created_at'">
                {{ new Date(record.created_at).toLocaleDateString('en-US') }}
            </template>

            <Tooltip>
                <template #title>
                    View
                </template>

                <template v-if="column.key === 'show'">
                    <span
                        style="cursor: pointer;"
                        @click="$emit('show', record)">
                        <ViewIcon/>
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
import { Table, Tooltip, message, } from 'ant-design-vue'
import ViewIcon from '../icons/View.vue'
import DeleteIcon from '../icons/Delete.vue'
import transactionsApi from '../../api/transactions'

export default {
    components: {
        Table, Tooltip, ViewIcon,
        DeleteIcon,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Creator',
                    key: 'creator',
                },
                {
                    title: 'Gateway',
                    key: 'gateway',
                },
                {
                    title: 'Type',
                    key: 'type',
                },
                {
                    title: 'Amount',
                    key: 'amount',
                    sorter: true,
                },
                {
                    title: 'Status',
                    key: 'status',
                },
                {
                    title: 'Created at',
                    key: 'created_at',
                    sorter: true,
                },
                {
                    key: 'show',
                },
                {
                    key: 'delete',
                },
            ],
            data: {},
            query: {
                page: 1,
                perpage: 15,
                orderby: 'created_at',
                order: 'DESC',
            },
            loading: false,
        }
    },
    methods: {
        async updateData() {
            try {
                this.loading = true
                this.data = await transactionsApi.fetch(
                    this.query.page, 
                    this.query.perpage, 
                    this.query.orderby,
                    this.query.order
                ) 
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        changeQuery(pagination, filters, sorter) {
            this.query.page = pagination.current
    
            if (sorter.columnKey) {
                this.query.orderby = sorter.columnKey
            }
            
            if (sorter.order) {
                this.query.order = sorter.order
                    .replace('ascend', 'ASC')
                    .replace('descend', 'DESC')
            }
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
