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

        <FormItem label="Address to">
            <Input
                placeholder="Address to"
                readonly
                :value="record.details.address_to"/>
        </FormItem>

        <FormItem label="Transaction ID">
            <Input
                placeholder="Transaction ID"
                readonly
                :value="record.details.transaction_id"/>
        </FormItem>

        <FormItem label="Transaction hash">
            <Input
                placeholder="Transaction hash"
                readonly
                :value="record.details.txhash"/>
        </FormItem>

        <FormItem label="Confirmations">
            <Input
                placeholder="Confirmations"
                readonly
                :value="record.details.confirmations"/>
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
