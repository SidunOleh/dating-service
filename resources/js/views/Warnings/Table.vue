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

            <template v-if="column.key == 'text'">
                <div v-html="record.text">
                </div>
            </template>

            <template v-if="column.key === 'link'">
                {{ record.link }}
            </template>

            <template v-if="column.key === 'clicks_count'">
                {{ record.clicks_count }}
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
import { Table, Tooltip, Tag, Switch, message, Image, } from 'ant-design-vue'
import EditIcon from '../icons/Edit.vue'
import DeleteIcon from '../icons/Delete.vue'
import warningsApi from '../../api/warnings'

export default {
    components: {
        Table, EditIcon, DeleteIcon, 
        Tooltip, Tag,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Text',
                    key: 'text',
                },
                {
                    title: 'Link',
                    key: 'link',
                },
                {
                    title: 'Clicks count',
                    key: 'clicks_count',
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
                this.data = await warningsApi.fetch(
                    this.query.page, 
                    this.query.perpage
                ) 
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
