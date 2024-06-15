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

        <FormItem label="To">
            <Input
                placeholder="To"
                readonly
                :value="record.details.to"/>
        </FormItem>

        <FormItem label="Type">
            <Input
                placeholder="Type"
                readonly
                :value="record.details.type"/>
        </FormItem>

        <FormItem label="Status">
            <Input
                placeholder="Status"
                readonly
                :value="record.details.status"/>
        </FormItem>

        <FormItem label="Source currency">
            <Input
                placeholder="Source currency"
                readonly
                :value="record.details.source_currency"/>
        </FormItem>

        <FormItem label="Source rate">
            <Input
                placeholder="Source rate"
                readonly
                :value="record.details.source_rate"/>
        </FormItem>

        <FormItem label="Fee">
            <Input
                placeholder="Fee"
                readonly
                :value="record.details.fee"/>
        </FormItem>

        <FormItem label="Plisio id">
            <Input
                placeholder="Plisio id"
                readonly
                :value="record.details.plisio_id"/>
        </FormItem>

        <FormItem label="Wallet hash">
            <Input
                placeholder="Wallet hash"
                readonly
                :value="record.details.wallet_hash"/>
        </FormItem>

        <FormItem
            v-if="record.details.sendmany" 
            label="Send many">
            <template v-for="(amount, to) in record.details.sendmany">
                <div style="margin-bottom: 10px;">
                    <Input
                        style="margin-bottom: 5px;"
                        placeholder="To"
                        readonly
                        :value="to"/>
                    <Input
                        placeholder="Amount"
                        readonly
                        :value="amount"/>
                </div>
            </template>
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
