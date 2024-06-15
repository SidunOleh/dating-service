<template>

    <Table
        :approved="true" 
        @show="record => $router.push({name: 'approved-creators.profile-requests.show', params: {id: record.id,},})"/>

</template>

<script>
import Table from './Table.vue'

export default {
    components: {
        Table,
    },
}
</script>
