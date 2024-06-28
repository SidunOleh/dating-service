<template>
    <div id="map">
    </div>
</template>

<script>
import 'leaflet/dist/leaflet.css'
import * as L from 'leaflet'

export default {
    props: [
        'location',
    ],
    data() {
        return {
            map: null,
            marker: null,
        }
    },     
    mounted() {
        this.map = L.map('map')
            .setView(this.location, 17)

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png')
            .addTo(this.map)

        this.marker = L.marker(this.location)
        this.marker.addTo(this.map)
    },
    watch: {
        location(location) {
            this.map.setView(location)
            this.marker.setLatLng(location)
        }, 
    }
}
</script>

<style scoped>
#map {
    height: 400px;
}
</style>