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

        <PassimpayDeposit
            v-if="record.gateway == 'crypto' && record.type == 'deposit'"
            :record="record"/>

        <PassimpayWithdrawal
            v-if="record.gateway == 'crypto' && record.type == 'withdrawal'"
            :record="record"/>

    </Modal>
</template>

<script>
import { Modal, } from 'ant-design-vue'
import PlisioInvoice from './PlisioInvoice.vue'
import PlisioWithdrawal from './PlisioWithdrawal.vue'
import PassimpayDeposit from './PassimpayDeposit.vue'
import PassimpayWithdrawal from './PassimpayWithdrawal.vue'

export default {
    props: [
        'open',
        'record',
    ],
    components: {
        Modal, PlisioInvoice, PlisioWithdrawal, 
        PassimpayDeposit, PassimpayWithdrawal,
    },
}
</script>
