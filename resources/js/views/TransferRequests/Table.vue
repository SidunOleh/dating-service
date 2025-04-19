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

            <template v-if="column.key == 'creator'">
                <router-link :to="{name: 'creators.edit', params: {id: record.creator?.id,},}">
                    {{ record.creator?.email }}
                </router-link>
            </template>

            <template v-if="column.key == 'amount'">
                {{ record.amount }}
            </template>

            <template v-if="column.key == 'balance'">
                {{ record.creator.balance }}
            </template>

            <template v-if="column.key == 'balance_2_total'">
                {{ record.creator.balance_2_total }}
            </template>

            <template v-if="column.key === 'created_at'">
                {{ new Date(record.created_at).toLocaleDateString('en-US') }}
            </template>

            <template v-if="column.key === 'actions'">
                <Flex :gap="10">
                    <Tooltip>
                        <template #title>
                            Approve
                        </template>

                        <Button @click="$emit('approve', record)">
                            Approve
                        </Button>
                    </Tooltip>

                    <Tooltip>
                        <template #title>
                            Reject
                        </template>
            
                        <Button
                            danger
                            @click="$emit('reject', record)">
                            Reject
                        </Button>
                    </Tooltip>
                </Flex>
            </template>

        </template>

    </Table>

</template>

<script>
import { Table, Tooltip, message, Button, Flex, } from 'ant-design-vue'
import transferRequestsApi from '../../api/transferRequests'

export default {
    components: {
        Table, Tooltip, Button,
        Flex,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Creator',
                    key: 'creator',
                },
                {
                    title: 'Amount',
                    key: 'amount',
                    sorter: true,
                },
                {
                    title: 'Balance №2',
                    key: 'balance_2_total',
                },
                {
                    title: 'Balance',
                    key: 'balance',
                },
                {
                    title: 'Created at',
                    key: 'created_at',
                    sorter: true,
                },
                {
                    key: 'actions',
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
                this.data = await transferRequestsApi.fetch(
                    this.query.page, 
                    this.query.perpage, 
                    this.query.orderby,
                    this.query.order,
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
