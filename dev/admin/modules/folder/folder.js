import Vue from 'vue';

Vue.component( 'folder-app', require('./folder-app.vue').default );
Vue.component( 'folders', require('./components/folders.vue').default );

jQuery( function( $ ) {

	if ( $('#wp-adminify--folder-app').length ) {

        new Vue({
            el: '#wp-adminify--folder-app',
            template: '<folder-app></folder-app>'
        });
        
    }

});