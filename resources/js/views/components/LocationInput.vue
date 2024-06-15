<template>
    <GMapAutocomplete
        placeholder="Search for a location"
        :value="location.full_address"
        @place_changed="setPlace">
    </GMapAutocomplete>

    <Input
        style="margin: 10px 0px;"
        placeholder="Country"
        v-model:value="location.country"/>
    
    <Input
        style="margin-bottom: 10px;"
        placeholder="Region"
        v-model:value="location.region"/>
    
    <Input 
        style="margin-bottom: 10px;"
        placeholder="City"
        v-model:value="location.city"/>
</template>

<script>
import { Input, InputNumber, FormItem, } from 'ant-design-vue'

export default {
    props: [
        'selected',
    ],
    components: {
        Input, InputNumber, FormItem,
    },
    data() {
        return {
            location: this.selected ? {...this.selected} : {
                full_address: '',
                country: '',
                region: '',
                city: '',
                latitude: null,
                longitude: null,
            },
        }
    },     
    methods: {
        setPlace(place) {
            this.location.full_address = 
                place.formatted_address
            this.location.latitude = 
                place.geometry.location.lat()
            this.location.longitude = 
                place.geometry.location.lng()
            this.location.country = ''
            this.location.region = ''
            this.location.city = ''
            place.address_components.forEach(component => {
                if (component.types.includes('country')) {
                    this.location.country = component.long_name
                }

                if (component.types.includes('administrative_area_level_1')) {
                    this.location.region = component.long_name
                }

                if (component.types.includes('locality')) {
                    this.location.city = component.long_name
                }
            })

            this.$emit('change', this.location)
        },
    },
    watch: {
        selected(selected) {
            this.location = {...selected}
        },
    },
}
</script>

<style scoped>
.pac-target-input {
    box-sizing: border-box;
    margin: 0;
    padding: 4px 11px;
    color: rgba(0, 0, 0, 0.88);
    font-size: 14px;
    line-height: 1.5714285714285714;
    list-style: none;
    font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,'Noto Sans',sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol','Noto Color Emoji';
    position: relative;
    display: inline-block;
    width: 100%;
    min-width: 0;
    background-color: #ffffff;
    background-image: none;
    border-width: 1px;
    border-style: solid;
    border-color: #d9d9d9;
    border-radius: 6px;
}

.pac-target-input:focus, .pac-target-input:hover {
    border-color: #4096ff;
    box-shadow: 0 0 0 2px rgba(5, 145, 255, 0.1);
    border-inline-end-width: 1px;
    outline: 0;
    transition: all 0.2s;
}

.pac-target-input::placeholder {
    color: #bfbfbf;
}
</style>