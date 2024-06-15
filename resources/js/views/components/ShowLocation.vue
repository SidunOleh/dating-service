<template>
    <div id="map">
    </div>
</template>

<script>
import 'leaflet/dist/leaflet.css'
import * as L from 'leaflet'

export default {
    props: [
        'center',
    ],
    data() {
        return {
            map: null,
            zoom: 15,
            circle: null,
        }
    },     
    mounted() {
        this.map = L.map('map')
            .setView(this.center, this.zoom)

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png')
            .addTo(this.map)

        this.circle = L.circle(this.center, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 500,
        })
        this.circle.addTo(this.map)
    },
    watch: {
        center(center) {
            this.map.setView(center)
            this.circle.setLatLng(center)
        }, 
    }
}
</script>

<style scoped>
#map {
    height: 400px;
}
</style>