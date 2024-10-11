<template>
    
    <Flex :gap="5">        
        <Input    
            placeholder="Zip"
            v-model:value="location.zip"/>

        <Button 
            :loading="loading"
            @click="find">
            Find
        </Button>
    </Flex>

</template>

<script>
import { Flex, Input, FormItem, Button, message, Select, } from 'ant-design-vue'

export default {
    props: [
        'data',
    ],
    components: {
        Input, FormItem, Flex,
        Button, Select,
    },
    data() {
        return {
            location: this.data ? {...this.data} : {
                zip: null,
                state: '',
                city: '',
                latitude: null,
                longitude: null,
            },
            loading: false,
        }
    },
    methods: {
        async find() {
            if (!this.location.zip) {
                message.error('Fill all address fields.')
                return
            }

            try {
                this.loading = true
                
                const zip = await axios.get(`/api/u0puffeto4nh7SlHzFn8/zips/${this.location.zip}`)

                this.location.city = zip.data.city
                this.location.state = zip.data.state
                this.location.latitude = zip.data.latitude
                this.location.longitude = zip.data.longitude

                this.$emit('change', this.location)
            } catch(err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
    },
    watch: {
        data(data) {
            this.location = {...data}
        },
    },
}
</script>