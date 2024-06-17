<template>

    <Input
        style="display: block; max-width: 400px; margin-bottom: 10px;"
        placeholder="Search"
        v-model:value="query.q"/>

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

            <template v-if="column.key === 'photo'">
                <Image
                    v-if="record.first_photo"
                    :width="100" 
                    :src="record.first_photo?.url"/>
            </template>

            <template v-if="column.key === 'email'">
                {{ record.email }}
            </template>

            <template v-if="column.key === 'name'">
                {{ record.name }}
            </template>

            <template v-if="column.key === 'age'">
                {{ record.age }}
            </template>

            <template v-if="column.key === 'phone'">
                {{ record.phone }}
            </template>

            <template v-if="column.key === 'city'">
                {{ record.city }}
            </template>

            <template v-if="column.key === 'created_at'">
                {{ new Date(record.created_at).toLocaleDateString('en-US') }}
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
import { Table, Tooltip, Tag, message, Input, Image, } from 'ant-design-vue'
import EditIcon from '../icons/Edit.vue'
import DeleteIcon from '../icons/Delete.vue'
import creatorsApi from '../../api/creators'

export default {
    components: {
        Table, Tooltip, Tag,
        EditIcon, DeleteIcon, Input,
        Image,
    },
    data() {
        return {
            columns: [
                {
                    title: 'Photo',
                    key: 'photo',
                },
                {
                    title: 'Email',
                    key: 'email',
                },
                {
                    title: 'Name',
                    key: 'name',
                    sorter: true,
                },
                {
                    title: 'Age',
                    key: 'age',
                    sorter: true,
                },
                {
                    title: 'Phone',
                    key: 'phone',
                },
                {
                    title: 'City',
                    key: 'city',
                },
                {
                    title: 'Registered at',
                    key: 'created_at',
                    sorter: true,
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
                orderby: 'created_at',
                order: 'DESC',
                q: '',
            },
            loading: false,
        }
    },
    methods: {
        async updateData() {
            try {
                this.loading = true
                this.data = await creatorsApi.fetch(
                    this.query.page, 
                    this.query.perpage, 
                    this.query.orderby,
                    this.query.order,
                    this.query.q,
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
