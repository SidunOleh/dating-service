<template>
    <Form layout="vertical">

        <FormItem label="Amount" >
            <Input
                placeholder="Amount"
                readonly
                :value="record.details.amount"/>
        </FormItem>

        <FormItem label="Received">
            <Input
                placeholder="Received"
                readonly
                :value="record.details.received"/>
        </FormItem>

        <FormItem label="Currency">
            <Input
                placeholder="Currency"
                readonly
                :value="record.details.currency"/>
        </FormItem>

        <FormItem label="Status">
            <Input
                placeholder="Status"
                readonly
                :value="record.details.status"/>
        </FormItem>

        <FormItem label="Wallet hash">
            <Input
                placeholder="Wallet hash"
                readonly
                :value="record.details.wallet_hash"/>
        </FormItem>

        <FormItem label="Source amount">
            <Input
                placeholder="Source amount"
                readonly
                :value="record.details.source_amount"/>
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

        <FormItem label="Invoice sum">
            <Input
                placeholder="Invoice sum"
                readonly
                :value="record.details.invoice_sum"/>
        </FormItem>

        <FormItem label="Invoice commission">
            <Input
                placeholder="Invoice commission"
                readonly
                :value="record.details.invoice_commission"/>
        </FormItem>

        <FormItem label="Invoice total sum">
            <Input
                placeholder="Invoice total sum"
                readonly
                :value="record.details.invoice_total_sum"/>
        </FormItem>

        <FormItem label="Expire at">
            <Input
                placeholder="Expire at"
                readonly
                :value="new Date(record.details.expire_at_utc * 1000)"/>
        </FormItem>

        <FormItem label="QR code">
            <Image :src="record.details.qr_code"/>
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
