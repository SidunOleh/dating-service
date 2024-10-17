<template>
    <Form layout="vertical">

        <FormItem label="Amount" >
            <Input
                placeholder="Amount"
                readonly
                :value="record.details.amount"/>
        </FormItem>

        <FormItem label="Currency">
            <Input
                placeholder="Currency"
                readonly
                :value="record.details.currency"/>
        </FormItem>

        <FormItem label="Transaction hash">
            <Input
                placeholder="Transaction hash"
                readonly
                :value="record.details.txhash"/>
        </FormItem>

        <FormItem label="Address from">
            <Input
                placeholder="Address from"
                readonly
                :value="record.details.address_from"/>
        </FormItem>

        <FormItem label="Address to">
            <Input
                placeholder="Address to"
                readonly
                :value="record.details.address_to"/>
        </FormItem>

        <FormItem label="Confirmations">
            <Input
                placeholder="Confirmations"
                readonly
                :value="record.details.confirmations"/>
        </FormItem>

        <FormItem label="Destination tag">
            <Input
                placeholder="Destination tag"
                readonly
                :value="record.details.destination_tag"/>
        </FormItem>

    </Form>
</template>

<script>
import { Form, FormItem, Input, Image, } from 'ant-design-vue'

export default {
    props: [
        'record',
    ],
    components: {
        Form, FormItem, Input,
        Image,
    },
}
</script>
