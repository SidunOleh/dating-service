<template>
    <Flex
        justify="center"
        align="center"
        style="height: 100%;">
        <Result 
            status="404" 
            title="404" 
            sub-title="Sorry, the page you visited does not exist.">
        </Result>
    </Flex>
</template>

<script>
import { Result, Flex, } from 'ant-design-vue'

export default {
    components: {
        Result, Flex,
    },
}
</script>