import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        connect: false,
        gps_gata: null,
        devices:[],
        device:null,
        dbAcc:null
    },
    mutations:{
        SOCKET_CONNECT: (state,  status ) => {
            state.connect = true;
        },
        SOCKET_GPS_DATA: (state,  gps_gata) => {
            state.gps_gata = gps_gata;
        },
        SOCKET_DEVICES: (state,  devices) => {
            state.devices = devices;
        },
        SOCKET_DEVICE_SAVED: (state,  device) => {
            state.device = device;
        },
        SOCKET_SET_ACC: (state,  device) => {
            state.dbAcc = device;
        }
    },
})
