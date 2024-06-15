<template>

    <Table
        :columns="columns"
        :dataSource="data.data"
        :pagination="{pageSize: data.meta?.per_page, total: data.meta?.total}"
        :loading="loading"
        @change="changeQuery">

        <template #bodyCell="{column, record}">

            <template v-if="column.key === 'creator'">
                <router-link :to="{name: 'creators.edit', params: {id: record.creator_id,},}">
                    {{ record.creator_email }}
                </router-link>
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
import profileRequestsApi from '../../api/profile-requests'

export default {
    props: [
        'approved',
    ],
    components: {
        Table, Tooltip, ViewIcon,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Creator',
                    key: 'creator',
                },
                {
                    title: 'Created at',
                    key: 'created_at',
                    sorter: true,
                },
                {
                    key: 'show',
                },
            ],
            data: {},
            query: {
                approved: this.approved,
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
                this.data = await profileRequestsApi.fetch(
                    this.query.approved,
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
