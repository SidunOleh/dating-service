<template>
    <div>
        <Textarea 
            v-if="status == 'rejected'"
            style="margin-bottom: 10px;"
            placeholder="Comment for creator"
            :value="comment"
            @input="e => $emit('update:comment', e.target.value)"/>

        <Flex :gap="5">
            <Button
                :disabled="status == 'approved'"
                @click="$emit('update:status', 'approved')">
                Approve
            </Button>
            <Button 
                danger
                :disabled="status == 'rejected'"
                @click="$emit('update:status', 'rejected')">
                Reject
            </Button>
        </Flex>
    </div>
</template>

<script>
import { Flex, Button, Textarea, } from 'ant-design-vue'

export default {
    props: [
        'status',
        'comment',
    ],
    components: {
        Flex, Button, Textarea,
    },   
}
</script>