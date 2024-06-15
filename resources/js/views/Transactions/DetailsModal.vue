<template>
    <Modal 
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <PlisioInvoice
            v-if="record.gateway == 'plisio' && record.type == 'invoice'"
            :record="record"/>

        <PlisioWithdrawal
            v-if="record.gateway == 'plisio' && record.type == 'withdrawal'"
            :record="record"/>

    </Modal>
</template>

<script>
import { Modal, } from 'ant-design-vue'
import PlisioInvoice from './PlisioInvoice.vue'
import PlisioWithdrawal from './PlisioWithdrawal.vue'

export default {
    props: [
        'open',
        'record',
    ],
    components: {
        Modal, PlisioInvoice, PlisioWithdrawal,
    },
}
</script>
