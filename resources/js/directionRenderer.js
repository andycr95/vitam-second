import {MapElementFactory} from 'vue2-google-maps'

    export default MapElementFactory({
        name: 'directionsRenderer',
        ctr: () => google.maps.DirectionsRenderer,
        events: ['directions_changed'],
        mappedProps: {
            routeIndex: { type: Number },
            options: { type: Object },
            panel: { },
            directions: { type: Object },
            //// If you have a property that comes with a `_changed` event,
            //// you can specify `twoWay` to automatically bind the event, e.g. Map's `zoom`:
            // zoom: {type: Number, twoWay: true}
        },
        // Any other properties you want to bind. Note: Must be in Object notation
        props: {},
        beforeCreate (options) {},
        // Actions to perform after creating the object instance.
        afterCreate (directionsRendererInstance) {},
    })
