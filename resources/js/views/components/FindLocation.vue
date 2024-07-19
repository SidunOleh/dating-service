<template>
    
    <Flex :gap="5">        
        <Input 
            placeholder="Street and house number"
            v-model:value="location.street"/>

        <Input    
            style="width: 300px;"
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
                street: '',
                latitude: null,
                longitude: null,
            },
            loading: false,
        }
    },
    methods: {
        async find() {
            if (
                !this.location.zip || 
                !this.location.street
            ) {
                message.error('Fill all address fields.')
                return
            }

            try {
                this.loading = true
                
                const zip = await axios.get(`/api/zips/${this.location.zip}`)

                this.location.city = zip.data.city
                this.location.state = zip.data.state

                const nominatim = await axios.get(`https://nominatim.openstreetmap.org/search?street=${this.location.street}&postalcode=${this.location.zip}&countrycodes=US&addressdetails=1&format=json`)
                
                nominatim.data = nominatim.data.filter(location => {
                    if (! location.address.postcode) {
                        return true
                    }

                    return location.address.postcode == this.location.zip
                })
                
                if (! nominatim.data.length) {
                    message.error('Not found location.')
                    return
                }

                this.location.latitude = nominatim.data[0].lat
                this.location.longitude = nominatim.data[0].lon

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