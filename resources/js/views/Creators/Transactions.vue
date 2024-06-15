<template>

    <Table
        :columns="columns"
        :dataSource="data"
        :pagination="false">

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'gateway'">
                {{ record.gateway }}
            </template>

            <template v-if="column.key === 'type'">
                {{ record.type }}
            </template>

            <template v-if="column.key === 'usd_amount'">
                {{ record.usd_amount }}
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

        </template>

    </Table>

</template>

<script>
import { Table, Tooltip, message, } from 'ant-design-vue'
import ViewIcon from '../icons/View.vue'

export default {
    props: [
        'data',
    ],
    components: {
        Table, Tooltip, ViewIcon,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Gateway',
                    key: 'gateway',
                },
                {
                    title: 'Type',
                    key: 'type',
                },
                {
                    title: 'USD amount',
                    key: 'usd_amount',
                    sorter: {
                        compare: (a, b) => a.usd_amount - b.usd_amount
                    },
                },

                {
                    title: 'Status',
                    key: 'status',
                },
                {
                    title: 'Created at',
                    key: 'created_at',
                    sorter: {
                        compare: (a, b) => a.created_at.localeCompare(b.created_at),
                    },
                },
                {
                    key: 'show',
                },
                {
                    key: 'delete',
                },
            ],
        }
    },
}
</script>
