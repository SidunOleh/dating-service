<template>
    <Form layout="vertical">

        <FormItem label="Amount" >
            <Input
                placeholder="Amount"
                readonly
                :value="record.amount"/>
        </FormItem>

        <FormItem label="Currency" >
            <Input
                placeholder="Currency"
                readonly
                :value="record.concrete.currency"/>
        </FormItem>

        <FormItem label="To" >
            <Input
                placeholder="To"
                readonly
                :value="record.concrete.address_to"/>
        </FormItem>

        <FormItem label="Creator" >
            <Input
                placeholder="Creator"
                readonly
                :value="record.creator.email"/>
        </FormItem>

        <FormItem label="Gateway" >
            <Input
                placeholder="Gateway"
                readonly
                :value="record.gateway"/>
        </FormItem>

        <FormItem label="Status" >
            <Input
                placeholder="Status"
                readonly
                :value="record.status"/>
        </FormItem>

        <FormItem label="Created at" >
            <Input
                placeholder="Created at"
                readonly
                :value="new Date(record.created_at)"/>
        </FormItem>

    </Form>
</template>

<script>
import { Form, FormItem, Input, } from 'ant-design-vue'

export default {
    props: [
        'record',
    ],
    components: {
        Form, FormItem, Input,
    },
}
</script>
