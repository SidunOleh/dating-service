<template>

    <div 
        v-if="['login', 'forgot', 'reset',].includes($route.name)" 
        style="height: 100vh;">
        <router-view/>
    </div>

    <Layout v-else>
        <template v-slot:content>
            <router-view :key="$route.fullPath"/>
        </template>
    </Layout>

</template>

<script>
import Layout from './Layout.vue'

export default {
    components: {
        Layout,
    },
}
</script>