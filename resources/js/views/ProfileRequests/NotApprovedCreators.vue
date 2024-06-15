<template>

    <Table
        :approved="false" 
        @show="record => $router.push({name: 'not-approved-creators.profile-requests.show', params: {id: record.id,},})"/>

</template>

<script>
import Table from './Table.vue'

export default {
    components: {
        Table,
    },
}
</script>
