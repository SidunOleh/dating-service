<template>
    
    <Flex :gap="5">
        <Select
            show-search
            :options="states"
            v-model:value="location.state"/>
        
        <Input 
            placeholder="City"
            v-model:value="location.city"
            @focusout="location.city = formatAddress(location.city)"/>

        <Input 
            placeholder="First Street"
            v-model:value="location.first_street"
            @focusout="location.first_street = formatAddress(location.first_street)"/>

        <Input 
            placeholder="Second Street"
            v-model:value="location.second_street"
            @focusout="location.second_street = formatAddress(location.second_street)"/>

        <Button 
            :loading="loading"
            @click="find">
            Find
        </Button>
    </Flex>

</template>

<script>
import { Flex, Input, FormItem, Button, message, Select, } from 'ant-design-vue'
import states from '../../data/states.json'

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
                state: '',
                city: '',
                first_street: '',
                second_street: '',
                latitude: null,
                longitude: null,
            },
            loading: false,
        }
    },
    computed: {
        states() {
            const options = []
            for (const code in states) {
                options.push({
                    label: states[code],
                    value: code,
                })
            }

            return options
        },
    },  
    methods: {
        formatAddress(address) {
            return address.trim()
                .replace(/\s\s+/g, ' ')
                .toLowerCase()
                .split(' ')
                .map(s => s[0].toUpperCase() + s.slice(1))
                .join(' ')
        },
        async find() {
            if (
                !this.location.state || 
                !this.location.city || 
                !this.location.first_street || 
                !this.location.second_street
            ) {
                message.error('Fill all address fields.')
                return
            }

            try {
                this.loading = true
                const res = await axios.post('https://overpass-api.de/api/interpreter', this.streetsIntersectionQuery())

                if (!res.data.elements.length) {
                    message.error('Not found streets intersection.')
                    return
                }

                const node = res.data.elements[0]

                this.location.latitude = node.lat
                this.location.longitude = node.lon

                this.$emit('change', this.location)
            } catch(err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        streetsIntersectionQuery() {
            return `
            [out:json];
            area["name"="${states[this.location.state]}"]["admin_level"="4"]->.state;
            area["name"="${this.location.city}"](area.state)->.city;

            way["name"="${this.location.first_street}"](area.state)(area.city)->.street1;
            node(w.street1)->.nodes1;

            way["name"="${this.location.second_street}"](area.state)(area.city)->.street2;
            node(w.street2)->.nodes2;

            node.nodes1.nodes2;
            out body;
            `
        },
    },
    watch: {
        data(data) {
            this.location = {...data}
        },
    },
}
</script>