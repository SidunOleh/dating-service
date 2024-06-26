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

            <template v-if="column.key === 'image'">
                <Image
                    :width="100" 
                    :src="record.image_url"/>
            </template>

            <template v-if="column.key == 'name'">
                {{ record.name }}
            </template>

            <template v-if="column.key === 'link'">
                {{ record.link }}
            </template>

            <template v-if="column.key === 'clicks_limit'">
                {{ record.clicks_limit }}
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
import adsApi from '../../api/ads'

export default {
    components: {
        Table, EditIcon, DeleteIcon, 
        Tooltip, Tag, Switch,
        Image,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Image',
                    key: 'image',
                },
                {
                    title: 'Name',
                    key: 'name',
                },
                {
                    title: 'Link',
                    key: 'link',
                },
                {
                    title: 'Clicks limit',
                    key: 'clicks_limit',
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
                type: 'block',
            },
            loading: false,
        }
    },
    methods: {
        async updateData() {
            try {
                this.loading = true
                this.data = await adsApi.fetch(
                    this.query.page, 
                    this.query.perpage, 
                    this.query.type
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
