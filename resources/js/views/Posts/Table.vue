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

            <template v-if="column.key == 'text'">
                {{ record.text }}
            </template>

            <template v-if="column.key == 'status'">
                {{ record.status }}
            </template>

            <template v-if="column.key === 'created_at'">
                {{ new Date(record.created_at).toLocaleDateString('en-US') }}
            </template>

            <Tooltip>
                <template #title>
                    View
                </template>
    
                <template v-if="column.key === 'view'">
                    <span>
                        <ViewIcon 
                            style="cursor: pointer;"
                            @click="$router.push({name: 'posts.show', params: {id: record.id,},})"/>
                    </span>
                </template>
            </Tooltip>

        </template>

    </Table>

</template>

<script>
import { Table, Tooltip, message, } from 'ant-design-vue'
import ViewIcon from '../icons/View.vue'
import postsApi from '../../api/posts'

export default {
    components: {
        Table, ViewIcon, Tooltip,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Creator',
                    key: 'creator',
                },
                {
                    title: 'Text',
                    key: 'text',
                },
                {
                    title: 'Status',
                    key: 'status',
                    filters: [
                        {
                            text: 'pending',
                            value: 'pending',
                        },
                        {
                            text: 'approved',
                            value: 'approved',
                        },
                        {
                            text: 'rejected',
                            value: 'rejected',
                        },
                    ],
                },
                {
                    title: 'Created at',
                    key: 'created_at',
                    sorter: true,
                },
                {
                    key: 'view',
                },
            ],
            data: {},
            query: {
                page: 1,
                perpage: 15,
                orderby: 'created_at',
                order: 'DESC',
                filters: {},
            },
            loading: false,
        }
    },
    methods: {
        async updateData() {
            try {
                this.loading = true
                this.data = await postsApi.fetch(
                    this.query.page, 
                    this.query.perpage, 
                    this.query.orderby,
                    this.query.order,
                    this.query.filters,
                ) 
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        changeQuery(pagination, filters, sorter) {
            this.query.page = pagination.current

            this.query.filters = filters
    
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
