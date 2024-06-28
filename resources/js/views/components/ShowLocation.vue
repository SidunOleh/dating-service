<template>
    <div id="map">
    </div>
</template>

<script>
import 'leaflet/dist/leaflet.css'
import * as L from 'leaflet'
import icon from 'leaflet/dist/images/marker-icon.png'
import iconShadow from 'leaflet/dist/images/marker-shadow.png'

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
        let DefaultIcon = L.icon({
            iconUrl: icon,
            shadowUrl: iconShadow
        })

        L.Marker.prototype.options.icon = DefaultIcon

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