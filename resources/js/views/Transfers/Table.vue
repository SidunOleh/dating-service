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
                <router-link :to="{name: 'creators.edit', params: {id: record.id,},}">
                    {{ record.email }}
                </router-link>
            </template>

            <template v-if="column.key == 'balance_earn'">
                {{ record.balance_earn }}
            </template>

            <template v-if="column.key == 'balance'">
                {{ record.balance }}
            </template>

            <template v-if="column.key == 'balance_2'">
                {{ record.balance_2 }}
            </template>

            <template v-if="column.key === 'actions'">
                <Flex :gap="10">
                    <Tooltip>
                        <template #title>
                            Transfer
                        </template>

                        <Button @click="$emit('transfer', record)">
                            Transfer
                        </Button>
                    </Tooltip>

                    <Tooltip>
                        <template #title>
                            Reset
                        </template>
            
                        <Button
                            danger
                            @click="$emit('reset', record)">
                            Reset
                        </Button>
                    </Tooltip>
                </Flex>
            </template>

        </template>

    </Table>

</template>

<script>
import { Table, Tooltip, message, Button, Flex, } from 'ant-design-vue'
import transfersApi from '../../api/transfers'

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
                    title: 'Amount to transfer',
                    key: 'balance_earn',
                    sorter: true,
                },
                {
                    title: 'Balance',
                    key: 'balance',
                },
                {
                    title: 'Balance №2',
                    key: 'balance_2',
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
                this.data = await transfersApi.fetch(
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
