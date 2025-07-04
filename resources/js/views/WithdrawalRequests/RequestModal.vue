<template>
    <Modal 
        :open="open"
        :footer="null"
        @cancel="$emit('update:open', false)">

        <PlisioRequest
            v-if="record.gateway == 'plisio'"
            :record="record"/>

        <PassimpayRequest
            v-if="record.gateway == 'crypto'"
            :record="record"/>

        <Flex :gap="10">
            <Button 
                :loading="loading.withdraw"
                @click="amount">
                Withdraw
            </Button>

            <Button
                danger
                :loading="loading.reject"
                @click="confirmPopup(() => reject(), 'Are you sure you want to reject?')">
                Reject
            </Button>
        </Flex>

    </Modal>
</template>

<script>
import { Modal, Flex, Button, message, } from 'ant-design-vue'
import { confirmPopup, } from '../../helpers/popups'
import withdrawalRequestsApi from '../../api/withdrawal-requests'
import PlisioRequest from './PlisioRequest.vue'
import PassimpayRequest from './PassimpayRequest.vue'
import { h, } from 'vue'

export default {
    props: [
        'open',
        'record',
    ],
    components: {
        Modal, PlisioRequest, Flex, 
        Button, PassimpayRequest,
    },
    data() {
        return {
            loading: {
                withdraw: false,
                reject: false,
            },
        }
    },
    methods: {
        confirmPopup,
        async amount() {
            try {
                this.loading.withdraw = true
                const res = await withdrawalRequestsApi.amount(this.record.id)
                const vnode = h('div', [
                    'Withdraw:',
                    h('br'),
                    res.amount,
                    h('br'),
                    this.record.concrete.currency,
                    h('br'),
                    h('span', {style:{color: 'red'}}, `(${this.record.amount} USD)`),
                    h('br'),
                    this.record.concrete.address_to,
                ])
                confirmPopup(this.withdraw, vnode)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading.withdraw = false
            }
        },
        async withdraw() {
            try {
                this.loading.withdraw = true
                await withdrawalRequestsApi.withdraw(this.record.id)
                message.success('Successfully withdrawn')
                this.$emit('withdrawn')
                this.$emit('update:open', false)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading.withdraw = false
            }
        },
        async reject() {
            try {
                this.loading.reject = true
                await withdrawalRequestsApi.reject(this.record.id)
                message.success('Successfully rejected')
                this.$emit('rejected')
                this.$emit('update:open', false)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading.reject = false
            }
        },
    },
}
</script>
