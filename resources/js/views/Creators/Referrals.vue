<template>

    <Table
        :columns="columns"
        :dataSource="data"
        :pagination="false">

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'email'">
                <router-link :to="{name: 'creators.edit', params: {id: record.id,},}">
                    {{ record.email }}
                </router-link>
            </template>

            <template v-if="column.key === 'created_at'">
                {{ new Date(record.created_at).toLocaleDateString('en-US') }}
            </template>

            <template v-if="column.key === 'reward'">
                {{ record.reward }}
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
import { Table, Tooltip, Tag, message, } from 'ant-design-vue'
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
                    title: 'Email',
                    key: 'email',
                },
                {
                    title: 'Registered at',
                    key: 'created_at',
                    sorter: {
                        compare: (a, b) => a.created_at.localeCompare(b.created_at),
                    },
                },
                {
                    title: 'Reward',
                    key: 'reward',
                    sorter: {
                        compare: (a, b) => a.reward - b.reward
                    },
                },
                {
                    key: 'show',
                },
            ],
        }
    },
}
</script>
