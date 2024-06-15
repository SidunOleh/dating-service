<template>
    
    <Layout style="min-height: 100vh;">
        <LayoutSider collapsible>
            <Menu/>
        </LayoutSider>

        <LayoutContent style="padding: 20px;">
            <slot name="content"></slot>
        </LayoutContent>
    </Layout>

</template>

<script>
import { Layout, LayoutSider, LayoutContent, } from 'ant-design-vue'
import Menu from './Menu.vue'

export default {
    components: {
        Layout, LayoutSider, LayoutContent,
        Menu, 
    },
}
</script>
