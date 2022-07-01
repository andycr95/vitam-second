<template>
    <div style="width:100%;  height: 100%;">
        <gmap-map :center="center" ref="map" :zoom="zoom" style="width:100%;  height: 100%;">
                <directionsRenderer/>
                <gmap-custom-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    alignment="bottomright"
                    :marker="m.position">
                        <img class="marker-img" @click="drawerD(m)" src="/img/marker-icon.png" />
                </gmap-custom-marker>
                <gmap-custom-marker
                    :marker="actual"
                ><img class="marker-img" src="https://lh3.googleusercontent.com/dH8TfrzWLScvsfi8iwkKX9wSznaKFRrCJo1OT-sGWlkTp8keAz1ZvLsoDpI_UkvLyQ" alt=""> </gmap-custom-marker>
        </gmap-map>
    </div>
</template>
<style scoped>
    .marker-img{
        width: 40px;
    }
</style>
<script>
import GmapCustomMarker from 'vue2-gmap-custom-marker';
import { MapElementFactory } from 'vue2-google-maps';
import DirectionRenderer from '../directionRenderer';
export default {
    name: "GoogleMap",
    props: ['markers','onCenter','center',"zoom","drawerD",'actual'],
    components: {
      'gmap-custom-marker': GmapCustomMarker,
      'directionsRenderer': DirectionRenderer
    },
    sockets:{
        connect: function () {
            console.log('socket connected')
        }
    }
};
</script>
